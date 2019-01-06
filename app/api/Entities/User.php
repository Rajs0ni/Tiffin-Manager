<?php

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use App\User as UserModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User{

    public function list($data, ResponseBody $responseBody)
    {
        !$data->isEmpty() ? 
        $responseBody->setData($data)->setStatus(200) :
        $responseBody->setError('Data Not Found')->setStatus(500);
    }

    public function listProviders(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $providers = UserModel::where('is_provider',true)->get();
            $this->list($providers, $responseBody);
        }
        catch(\Exception $e)
        {
            $responseBody->setData($e->getMessage())->setStatus(500);
        }
    }

    public function listCustomers(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider_id = $requestBody->payload['provider_id'];
            $customers = UserModel::where('assoc_provider',$provider_id)->get();
            $this->list($customers, $responseBody);
        }
        catch(\Exception $e)
        {
            $responseBody->setData($e->getMessage())->setStatus(500);
        }
    }
   
    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider_id = $requestBody->payload['provider_id'];
            $provider = UserModel::where('is_provider',true)->findOrFail($provider_id);
            $responseBody->setData($provider)->setStatus(200);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError('Provider Not Found')->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())->setStatus(500);
        }
    }
}