<?php 

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;

class Authenticate {

    public function getOTP(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $this->validateMobile($requestBody);
            $otp =1234;
            $mobileNumber = $requestBody->payload['customer']['mobile'];
            $customer = User::firstOrNew(array('mobile' => $mobileNumber));
            $customer->otp = $otp;
            $customer->save();                                                
            $responseBody->setStatus(200);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash($e->getMessage())
                         ->setStatus(500);
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
            $mobileNumber = $requestBody->payload['customer']['mobile'];
            $customer = User::where('mobile', $mobileNumber)->firstOrFail();
            $receivedOTP = $requestBody->payload['customer']['otp'];
            if($customer->otp == $receivedOTP)
            {
                $token = bcrypt(str_random(100));
                $customer->remember_token = $token;
                $customer->otp = null;
                $customer->save();
                $responseBody->setFlash("Your account has been verified successfully !!")
                             ->setData($customer)
                             ->setStatus(200);
            }
            else
            {
                $responseBody->setFlash("Please enter valid OTP")
                             ->setStatus(500);
            }
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash($e->getMessage())
                         ->setStatus(500);
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