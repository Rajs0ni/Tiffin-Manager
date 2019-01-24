<?php

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Provider {
    
    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $providers = User::where('is_provider',true)->get();
            !$providers->isEmpty() ? $responseBody->setData($providers)
                                                  ->setStatus(200)
                                   : $responseBody->setError('Providers Not Found')
                                                  ->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash('Providers Not Found')
                         ->setStatus(500);
        }
    }

    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $providerId = $requestBody->payload['provider_id'];
            $provider = User::where('is_provider',true)
                            ->findOrFail($providerId);
            $responseBody->setData($provider)
                         ->setStatus(200);
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash('Provider Not Found')                
                         ->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash('Provider Not Found')                
                         ->setStatus(500);
        }
    }

    
}