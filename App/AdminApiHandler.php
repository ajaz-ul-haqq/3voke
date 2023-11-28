<?php

namespace App;
use App\Models\Model;

class AdminApiHandler {

    public static function createVoucher($amount): void
    {
        $id = @$_SESSION['admin']['id'];
        model('vouchers')->insert([
            'value' => self::generateVoucher(),
            'amount' => $amount,
            'active' => 1,
            'created_by' => $id
        ]);

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

                $result[$i] = self::getReturnsForNumbers($i, $red, $violet, $green, $amount);
            }

        }

        $min = min($result);
        $xeox = [array_search($min, $result)];

        foreach ( $result as $index => $value) {
            if( $min == $value) {
                $xeox[] = $index;
            }
        }

        return $xeox[rand(0,count($xeox)-1)];
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

        if ($action == 'REJECTED') {
            $withdrawl = model('withdrawls')->find($id);
            $old = model()->find($withdrawl['user_id'])['balance'];
            model()->where('id', $withdrawl['user_id'])->update(['balance' => $old + $withdrawl['amount']]);
        }

        self::successResponse($action.' Successfully');
    }
}



