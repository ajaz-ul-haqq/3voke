<?php

namespace App;

use App\Models\Model;

class AdminApiHandler {

    public static function saveSettings(Request $request)
    {
        try {
            $column = $request->get('attr');
            $value = $request->get('value');
            $oldValue = systemConfig($column);
            systemConfigStore($column, $value);

            $config = match ($column) {
                'keywords' => 'Meta Keywords',
                'color' => 'Theme Colour',
                'title' => 'App Title',
                'minimum_withdrawl' => 'Minimum Withdrawl',
                'minimum_deposit' => 'Minimum Deposit',
                's_m_handler' => 'Social Handler',
                default => ucfirst($column)
            };

            createLog('updated_setting', 'Set <b>'.$config.'</b> as <b>'.$value.'</b> from <b>'.$oldValue.'</b>');

            self::successResponse('Setting Saved Successfully');
        } catch (\Exception $e){
            self::errorResponse('oops', 500);
        }
    }

    public static function updateUserData(Request $request)
    {
        $id = $request->get('id');

        $admin = model('admins')->find($id);

        foreach ($admin as $item => $value) {
            if(isset($_POST[$item]) && ( $_POST[$item] != $value)){
                if ($item == 'password' && empty($_POST['password'])) {
                    continue;
                }else{
                    $valuesToUpdate[$item] = $_POST[$item];
                }
            }
        }

        if(!empty($valuesToUpdate['password'])){
            $valuesToUpdate['password'] = password_hash($valuesToUpdate['password'], PASSWORD_BCRYPT);
        }

        if(!empty($valuesToUpdate)) {
            model('admins')->where('id', $id)->update($valuesToUpdate);
            foreach ($valuesToUpdate as $key => $value) {
                ($key == 'password') ?: createLog('admin_updated', 'Updated Admin <b>'.$admin['phone'].'</b>, Set <b>'.$key.'</b> as <b>'.$value.'</b> from <b>'.$admin[$key].'</b>');
            }
        }

        self::successResponse('User Updated Successfully');
    }


    public static function saveMerchantData(Request $request): void
    {
        try {
            if ($request->method() != 'POST') {
                throw new \Exception($request->method(). ' method not supported');
            }

            $preparedData = [
                'secret' => $request->get('secret'),
                'token' => $request->get('token'),
                'upi' => $request->get('upi'),
                'status' => $request->get('mStatus')
            ];
            $merchant = model('merchant')->where('merchant_id', $request->get('merchant_id'));
            if ($merchant->count()) {
                $old = $merchant->first();
                model('merchant')->where('merchant_id', $request->get('merchant_id'))
                    ->update($preparedData);
                foreach ($preparedData as $key => $value) {
                    createLog('merchant_updated', 'Updated Merchant <b>'.$merchant['name'].'</b>, Set <b>'.ucfirst($key).'</b> as <b>'.$value.'</b> from <b>'.$merchant[$key].'</b>');
                }
            } else {
                $preparedData['name'] = $request->get('name');
                $preparedData['merchant_id'] = $request->get('merchant_id');
                model('merchant')->insert($preparedData);
            }

        } catch (\Exception $e) {
            self::errorResponse($e->getMessage());
        }

        self::successResponse('Merchant Saved Successfully');
    }

    public static function createVoucher($amount): void
    {
        $id = @$_SESSION['admin']['id'];
        model('vouchers')->insert([
            'value' => $voucher = self::generateVoucher(),
            'amount' => $amount,
            'active' => 1,
            'created_by' => $id
        ]);

        $context = 'Created a voucher of <b>'.$amount.'</b> i.e. <b>'. $voucher.'</b>';

        createLog('created_voucher', $context);

        self::successResponse('added successfully');
    }

    public static function generateVoucher()
    {
        $voucher = generateRandomString();

        if (model('vouchers')->where('value', $voucher)->count() > 0) {
            $voucher = self::generateVoucher();
        }

        return $voucher;
    }

    public static function customizeNumber(Request $request): void
    {
        $oldOne = (bool) (new Model('manual'))
            ->where('type', $request->get('category'))
            ->where('number', $request->get('number'))
            ->value('status');

        (new Model('manual'))
            ->where('type', $request->get('category'))
            ->where('number', $request->get('number'))
            ->update(['status' => (int)!$oldOne]);

        $context = ( $oldOne ? 'Disabled ' : 'Enabled ' ). '<b>'. $request->get('number') .'</b> in <b>'.$request->get('category').'</b> for game <b>'.currentGameId().'</b>.';

        createLog('customizeNumber', $context);

        self::successResponse('done successfully');
    }

    public static function customizeStrategy(Request $request): void
    {
        $oldOne = (bool) model('strategies')
            ->where('id', $request->get('s_id'))->value('active');

        (new Model('strategies'))
            ->where('active', 1)->where('id', '!=', $request->get('s_id'))
            ->update(['active' => 0]);

        (new Model('strategies'))
            ->where('id', $request->get('s_id'))
            ->update(['active' => (int)!$oldOne]);

        $strategyName = model('strategies')
            ->where('id', $request->get('s_id'))->value('name');

        $context =( $oldOne ? 'Disabled ' : 'Enabled ' ).'<b>'.$strategyName .'</b> for system.';

        createLog('customizeStrategy', $context);

        self::successResponse('done successfully');
    }

    public static function getInvestments(Request $request, $getNumbersOnly = false)
    {
        $gameId = currentGameId();
        $red = (new Model('orders'))->where('game_id', $gameId)->where('selection', 'red')
            ->where('type', $request->get('category'))->sum('amount');
        $green = (new Model('orders'))->where('game_id', $gameId)->where('selection', 'green')
            ->where('type', $request->get('category'))->sum('amount');
        $violet = (new Model('orders'))->where('game_id', $gameId)->where('selection', 'violet')
            ->where('type', $request->get('category'))->sum('amount');


        for ($i = 0; $i < 10; $i++) {

           $amount = self::getReturnsForNumbers($i, $red, $violet, $green,
               (new Model('orders'))->where('game_id', $gameId)->where('type', $request->get('category'))->where('selection', $i)->sum('amount') * 8.55);

            $result[] = [
                'active' => (bool) (new Model('manual'))->where('type', $request->get('category'))->where('number', $i)->value('status'),
                'number' => $i, 'returns' => $amount,
            ];
        }

        if ($getNumbersOnly) { return $result; }

        $res['gameId'] = $gameId;
        $res['data'] = $result;
        $res['suggestion'] = self::getOutputNumberForStrategy('nls', $request->get('category'), $gameId);

        self::successResponse('', $res);
    }

    private static function getReturnsForNumbers($number, $red, $violet, $green, $amount)
    {
        if (in_array($number, [2,4,6,8])) {
            $amount = $amount + ($red * 1.9);
        }

        if (in_array($number, [1,3,7,9])) {
            $amount = $amount + ($green * 1.9);
        }

        if ($number == 0) {
            $amount = $amount + $red * 1.45;
            $amount = $amount + $violet * 1.45;
        }

        if ($number == 5) {
            $amount = $amount + $green * 1.45;
            $amount = $amount + $violet * 1.45;
        }

        return $amount;
    }

    public static function getOutputNumberForStrategy($uid, $category, $gameId)
    {
        $red = (new Model('orders'))->where('game_id', $gameId)->where('selection', 'red')
            ->where('type', $category)->sum('amount');
        $green = (new Model('orders'))->where('game_id', $gameId)->where('selection', 'green')
            ->where('type', $category)->sum('amount');
        $violet = (new Model('orders'))->where('game_id', $gameId)->where('selection', 'violet')
            ->where('type', $category)->sum('amount');

        for ($i = 1; $i < 10; $i++) {

            if($i != 5) {
                $amount = (new Model('orders'))->where('game_id', $gameId)->where('type', $category)->where('selection', $i)->sum('amount') * 8.55;

                $result1[$i] = self::getReturnsForNumbers($i, $red, $violet, $green, $amount);
            }

        }

        $min1 = min($result1);

        if ($red + $green > 0) {

            $diff = max($red, $green) - min($red, $green);
            $percentage = (int) (($diff) / ($average = (($red + $green) / 2)) * 100);

            if ($percentage < 10) {
                $zero = (new Model('orders'))->where('game_id', $gameId)->where('type', $category)->where('selection', 0)->sum('amount') * 8.55;
                $five = (new Model('orders'))->where('game_id', $gameId)->where('type', $category)->where('selection', 5)->sum('amount') * 8.55;

                $min2 = min($result2 = [
                    0 => self::getReturnsForNumbers(0, $red, $violet, $green, $zero),
                    5 => self::getReturnsForNumbers(5, $red, $violet, $green, $five)
                ]);

                $final = min($min1, $min2);

                $result = ($final == $min1) ? $result1 : $result2;
            }
        }

        $finalN = $final ?? $min1;
        $finalR = $result ?? $result1;

        foreach ( $finalR as $index => $value) {
            if( $finalN == $value) {
                $number[] = $index;
            }
        }

        return $number[rand(0, count($number) - 1)];
    }

    public static function errorResponse($message, $code = 500): void
    {
        self::response(['message' => $message], $code);
    }

    public static function successResponse($message, $data = [], $code = 200): void
    {
        $response['message'] = $message;
        $response['data'] = $data;
        self::response($response, $code);
    }

    private static function response($data, $statusCode) : void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit(http_response_code($statusCode));
    }

    public static function approveWithdrawal(Request $request, $action = 'APPROVED')
    {
        $id = $request->get('withdrawlId');

        model('withdrawls')->where('id', $id)->update(['status' => $action]);
        $withdrawl = model('withdrawls')->find($id);

        if ($action == 'REJECTED') {
            $old = model()->find($withdrawl['user_id'])['balance'];
            model()->where('id', $withdrawl['user_id'])->update(['balance' => $old + $withdrawl['amount']]);
        }

        $context = '<b>'.ucfirst($action = strtolower($action)).'</b> withdrawal of <b>'.$withdrawl['amount'].'</b> for user <b>'. \model()->where('id', $withdrawl['user_id'])->value('phone').'</b>';

        createLog($action.'_withdrawal', $context);

        self::successResponse($action.' Successfully');
    }
}



