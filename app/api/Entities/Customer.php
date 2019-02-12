<?php 

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

class Customer {

    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $providerId = $requestBody->payload['provider_id'];
            $customers = User::where('assoc_provider',$providerId)->get();
            !$customers->isEmpty() ? $responseBody->setData($customers)
                                                  ->setStatus(200)
                                   : $responseBody->setError('Customers Not Found')
                                                  ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash('Customers Not Found')                
                         ->setStatus(500);
        }
    }

    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $customer = User::findOrFail($requestBody->payload['customer']['id']);
            $customerSecret = $requestBody->payload['customer']['remember_token'];
            if(strcmp($customer->remember_token,$customerSecret) == 0)
            {
                $responseBody->setData($customer)
                             ->setStatus(200); 
            }
            else
                throw new \Exception('Authentication Failed');
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Model Not Found")
                         ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash($e->getMessage())                
                         ->setStatus(500);
        }
    }

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $this->validateCustomer($requestBody);
            $customer = User::findOrFail($requestBody->payload['customer']['id']);
            $customerSecret = $requestBody->payload['customer']['remember_token'];
            if(strcmp($customer->remember_token,$customerSecret) == 0)
            {
                $customer->name = $requestBody->payload['customer']['name'];
                $customer->location = $requestBody->payload['customer']['location'];
                $customer->tiffin_plan = $requestBody->payload['customer']['tiffin_plan'];
                $customer->assoc_provider = $requestBody->payload['customer']['assoc_provider'];
                $customer->save();
                $responseBody->setData($customer)
                             ->setFlash('You are registered successfully !!')
                             ->setStatus(200);
            }
            else
                throw new \Exception('Your Session has been expired. Try to log in');
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Model Not Found")
                         ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash($e->getMessage())                
                         ->setStatus(500);
        }
    }

    public function validateCustomer(RequestBody $requestBody){

        $validator = Validator::make($requestBody->payload['customer'],[
            'name' => 'required | string |regex:/[^0-9]+/',
            'location' => 'required | string'
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
    
}