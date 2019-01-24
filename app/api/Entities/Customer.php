<?php 

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

}