<?php 

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use Validator;

class Authenticate {

    public function getOTP(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $this->validateMobile($requestBody);
            $mobileNumber = $requestBody->payload['customer']['mobile'];
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
            $this->validateMobile($requestBody);
            //todo :: find user by received mobile number
            $mobileNumber = $requestBody->payload['customer']['mobile'];
            $receivedOTP = $requestBody->payload['customer']['otp'];
            if($otp == $receivedOTP)
            {
                $responseBody->setFlash("Your account has been verified successfully !!")
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

    public function validateMobile(RequestBody $requestBody){
        $validator = Validator::make($requestBody->payload['customer'],[
            'mobile' => 'required | numeric | digits:10'
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
}