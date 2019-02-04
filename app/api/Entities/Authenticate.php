<?php 

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\User;

class Authenticate {

    public function getOTP(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $this->validateMobile($requestBody);
            $customer = $requestBody->payload['customer'];
            $mobileNumber = $customer['mobile'];
            //todo :: save and find mobile number
            //todo :: save OTP for received mobile num in DB 
            $responseBody->setStatus(200);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash($e->getMessage())                
                         ->setStatus(500);
        }
    }

    public function verifyOTP(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $otp = 1234;
         
            //todo :: find user by received mobile number
            $customer = $requestBody->payload['customer'];
            $mobileNumber = $customer['mobile'];
            $customer = User::findOrFail($mobileNumber);
            $receivedOTP = $requestBody->payload['customer']['otp'];
            if($otp == $receivedOTP)
            {
                $token = Hash::make(str_random(8));
                $customer['access_token'] = $token;
                $customer['otp'] = null;
                $responseBody->setFlash("Your account has been verified successfully !!")
                             ->setData($token)
                             ->setStatus(200);
            }
            else
            {
                $responseBody->setFlash("Please enter valid OTP")
                             ->setStatus(500);
            }
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash($e->getMessage())                
                         ->setStatus(500);
        }
    }

    public function validateMobile(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload['customer'],[
            'mobile' => 'required | numeric | digits:10 |regex:/^[6-9][0-9]{1,10}[0-9]+/'     
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
}