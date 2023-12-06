<?php

namespace App;
use App\Models\Model;

class ApiHandler {
    public function __construct()
    {
        /** Nothing to do here */
    }

    public static function handleUserRegistration(Request $request): void
    {
        $user = new Model('users');
        $request = $request->all();
        $user->insert([
            'phone' => $request['mobile'],
            'email' => $request['email'],
            'name' => $request['email'],
            'is_agent' => 0,
            'active' => 1,
            'password' => password_hash($request['password'], PASSWORD_BCRYPT),
            'referred_by' => (int) self::getUserByUid($request['rcode'])
        ]);

        self::successResponse('Account created successfully.. !!');
    }

    public static function sendOneTimePassword(Request $request, $recoveryMode = false): void
    {
        $mobile = $request->get('mobile');
        $otp = rand(111111,999999);

        $userAlreadyExists = (new Models\Model('users'))->where('phone', $mobile)->count('id');

        if ($userAlreadyExists && !$recoveryMode) {
            self::errorResponse('Mobile number already registered');
        }

        unset($_SESSION["signup_mobile"]);
        unset($_SESSION["signup_otp"]);
        $_SESSION["signup_mobile"] = $mobile;
        $_SESSION["signup_otp"] = $otp;

        $fields = array(
            "sender_id" => "Evoke X",
            "message" => "Your verification code is : $otp",
            "language" => "english",
            "route" => "p",
            "numbers" => $mobile,
            "flash" => "1"
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: 57JxwAmYVEnug9lh3NFR2ZULCvDBpqKzTMdj6H8kbcQtSIf0seFoqejagHvYLOpwszt4uVhnWG2KMS9Q",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        curl_exec($curl);
        curl_close($curl);

        if ($err = curl_error($curl)) {
            self::errorResponse('Failed to send otp : '. $err);
        } else {
            self::successResponse('OTP sent successfully.');
        }
    }


    public static function verifyOneTimePassword(Request $request): void
    {
        if ((int) $request->get('otp') === $_SESSION['signup_otp']) {
            if (isset($_SESSION['readyToChangePassword'])) {
                $_SESSION['readyToChangePassword'] = true;
            }
            self::successResponse('OTP verified successfully');
        } else {
            self::errorResponse('Invalid OTP');
        }
    }

    public static function errorResponse($message, $code = 500)
    {
        self::response(['message' => $message], $code);
    }

    public static function successResponse($message, $data = [], $code = 200)
    {
        $response['message'] = $message;
        $response['data'] = $data;
        self::response($response, $code);
    }

    private static function response($data, $statusCode)
    {
        // Set the HTTP headers to indicate that you're sending JSON
        header('Content-Type: application/json');
        echo json_encode($data);
        exit(http_response_code($statusCode));
    }

    private static function getUserByUid($uid): ?string
    {
        return (int) ( str_replace('EVX9RD', '', $uid));
    }

    public static function postAuthLogin($request)
    {
        $phone = filter_var($_POST['login_mobile'], FILTER_VALIDATE_INT);
        $pass = filter_var($_POST['login_password']);

        self::isValidCredentialsForUser($phone, $pass, $message);

        if ( !empty($message) ) { self::errorResponse($message, 401); }

        $_SESSION['user'] = (new \App\Models\Model('users'))->where('phone', $phone)
            ->select(['id', 'name', 'phone', 'active'])->first();

        self::successResponse('Logged in successfully', $_SESSION['user']);
    }

    private static function isValidCredentialsForUser(mixed $phone, mixed $pass, &$message): void
    {
        if (!is_numeric($phone) || strlen($phone) < 10) {
            $message = 'Oops... Invalid Phone number';
            return;
        }

        if (!(new Model('users'))->where('phone', $phone)->count() ) {
            $message = 'This phone is not registered with us..';
            return;
        }

        if (password_verify($pass, (new Model('users'))->where('phone', $phone)->value('password')) == 1 ) {
            $message = '' ; return;
        }

        $message = 'Oops.. Invalid Password';
    }

    public static function postAuthLogout()
    {
        session_destroy();

        header('Location:login.php');
    }

    public static function recoverAuthPassword(Request $request): void
    {
        if (strlen($phone = $request->get('mobile')) < 10) {
            self::errorResponse('Invalid phone number');
        }

        $user = (new Model('users'))->where('phone', $phone)->first();

        if (empty($user)) { self::errorResponse('This number is not registered with us'); }

        $_SESSION['readyToChangePassword'] = false;
        self::sendOneTimePassword($request, true);
    }

    public static function changeAuthPassword(Request $request): void
    {
        if (!isset($_SESSION['readyToChangePassword']) || !$_SESSION['readyToChangePassword']) {
            self::errorResponse('OTP is not verified', 401);
        }

        $user = (isset($_SESSION['user'])) ? model()->where('id', $_SESSION['user']['id'])->first()
            : model()->where('phone', $_SESSION['signup_mobile'])->first();

        if (empty($user)) { self::errorResponse('Oops... Something went wrong'); }

        (new Model('users'))->where('id', $user['id'])->update([
            'password' => password_hash($request->get('password'), PASSWORD_BCRYPT)
        ]);

        session_destroy();

        self::successResponse('Password changed successfully');
    }

    public static function redeemGiftCard(Request $request)
    {
        $voucher = $request->get('voucher');

        if (!self::isValidVoucher($voucher)) {
            self::errorResponse('Invalid gift card');
        }

        if (!isLoggedIn()) {
            self::errorResponse('Please login first', 401);
        }

        $userId = $_SESSION['user']['id'];

        $balance = (new Model('users'))->where('id', $userId)->value('balance');

        (new Model('users'))->where('id', $userId)
            ->update(['balance'=> $balance + $voucher['amount']]);

        (new Model('vouchers'))->where('id', $voucher['id'])
            ->update(['used_by' => $userId, 'active' => 0]);

        (new Model('deposits'))->insert(['user_id' => $userId,
            'amount' => $voucher['amount'], 'status' => 'SUCCESS', 'utr' => 'viaGiftCard']);

        self::successResponse('Gift card redeemed successfully');
    }

    public static function isValidVoucher(&$voucher): bool
    {
        $instance = new Model('vouchers');

        $voucher = $instance->where('value', $voucher)->first();

        return (!empty($voucher) && !$voucher['used_by'] && $voucher['active']);

    }

    public static function savePaymentSession(Request $request)
    {
        @$_SESSION['name'] = $request->get('name');
        @$_SESSION['mobile'] = $request->get('mobile');
        @$_SESSION['email'] = $request->get('email');
        @$_SESSION['finalamount'] = $request->get('amount');

        model()->where('id', $_SESSION['user']['id'])->update([
            'name' => $request->get('name')
        ]);

        self::successResponse('saved');
    }

    public static function createWithdrawlForUser(Request $request): void
    {
        if(!isset($_SESSION['user']['id'])){
            self::errorResponse('unauthorized',401);
        }

        $user = \model()->find(@$_SESSION['user']['id']);
        $balance = \model()->where('id',@$_SESSION['user']['id'])->value('balance');

        if (!self::isValidWithdrawl($amount = $request->get('amount'), $user, $balance, $message)) {
            self::errorResponse($message,412);
        }

        \model('withdrawls')->insert([
            'amount' => $amount,
            'user_id' => $user['id'],
            'status' => $user['is_agent'] ? 'COMPLETED' : 'INITIATED'
        ]);

        \model()->where('id',@$_SESSION['user']['id'])->update([
            'balance' => ($balance - $amount),
            'name' => $request->get('name'),
            'upi'=> $request->get('upi')
        ]);

        self::successResponse('Withdrawal Requested Successfully');
    }

    private static function isValidWithdrawl($amount, $user, $balance, &$message): bool
    {
        if ($amount < $m = minimumWithdrawl()) {
            $message = 'Amount must be greater than '.$m;
            return false;
        }

        if ($amount > $balance) {
            $message = 'Amount must be less than '.$balance;
            return false;
        }

        if (!$user['active']) {
            $message = 'Withdrawals not allowed';
            return false;
        }

        if (!$user['is_agent'] && model('withdrawls')->where('user_id', $user['id'])->where('status', 'IN', '("INITIATED", "APPROVED")')->count()) {
            $message = 'Multiple withdrawals are not allowed';
            return false;
        }

        return true;
    }

    public static function redeemBonus(Request $request)
    {
        $requestedAmount = $request->get('amount');

        try {
            $userId = $_SESSION['user']['id'];

            $refs = model()->where('referred_by', $userId)->get();

            $applicableAmount  = 0;

            foreach ($refs as $ref) {
                $deposit = model('deposits')->where('user_id', $ref['id'])
                    ->where('status', 'SUCCESS')->first();
                $amount = !empty($deposit) ? $deposit['amount'] : 0 ;

                if ($amount) {
                    $x = model('orders')->where('user_id', $ref['id'])->sum('amount');
                    !($x >= 2 * $amount) ? : $applicableAmount = $applicableAmount + ( $amount * 0.4 );
                }
            }

            $applicableAmount = $applicableAmount - ( model('redemption')->where('user_id', $userId)->value('amount'));

            if ($requestedAmount > $applicableAmount) {
                self::errorResponse('Amount must be less than '.$applicableAmount);
            }

            $old = model()->where('id', $userId)->value('balance');

            if(model('redemption')->where('user_id', $userId)->count()) {
                $oldAmount = \model('redemption')->where('user_id', $userId)->value('amount');
                model('redemption')->where('user_id', $userId)->update([
                    'amount' => $requestedAmount + $oldAmount,
                ]);
            } else {
                model('redemption')->insert([
                    'user_id' => $userId,
                    'amount' => $requestedAmount,
                ]);
            }

            model()->where('id', $userId)->update(['balance' => $old + $requestedAmount]);
            model('deposits')->insert([
                'user_id' => $userId, 'amount' => $requestedAmount, 'status' => 'SUCCESS',
                'utr' => 'null', 'unique_id' => uniqid().time()
            ]);

        } catch (\Exception $e){
            self::errorResponse($e->getMessage());
        }

        self::successResponse('Bonus Redeemed Successfully !');
    }
}




