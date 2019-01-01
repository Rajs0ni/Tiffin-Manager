<?php 

namespace App\Api\Entities;

use App\api\RequestBody;
use App\api\ResponseBody;
use App\Tiffin as TiffinModel;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;

class Tiffin{

    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider_id = $requestBody->payload['provider_id'];

            if($provider_id)
            {
                $provider = User::findOrFail($provider_id);
         
                if($provider)
                {
                    $tiffins = $provider->tiffins;
                
                    if($tiffins)
                    {
                        $responseBody->setData($tiffins);
                        $responseBody->setStatus(200);
                    }
                }
            }
            else
                throw new \Exception("Provider Identification Not Found");
            
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found");
            $responseBody->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage());
            $responseBody->setStatus(500);
        }
        
    }

    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider_id = $requestBody->payload['provider_id'];

            if($provider_id)
            {
                $provider = User::findOrFail($provider_id);

                if($provider)
                {
                    $tiffin_id = $requestBody->payload['tiffin_id'];

                    if($tiffin_id)
                    {
                        $tiffin = $provider->tiffin($tiffin_id);

                        if($tiffin)
                        {
                            $responseBody->setData($tiffin);
                            $responseBody->setStatus(200);
                        }
                    }
                    else
                        throw new \Exception("Tiffin Identification Not Found");
                }
            }
            else
                throw new \Exception("Provider Identification Not Found");
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found");
            $responseBody->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage());
            $responseBody->setStatus(500);
        }
       
    }

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider_id = $requestBody->payload['provider_id'];
            
            if($provider_id)
            {
                $provider = User::findOrFail($provider_id);

                if($provider)
                {
                    $this->validator($requestBody);

                    $tiffin_id = $requestBody->payload['id'];
                    $tiffin = TiffinModel::findOrNew($tiffin_id);

                    $tiffin->name = $requestBody->payload['name'];
                    $tiffin->detail = $requestBody->payload['detail'];
                    $tiffin->price = $requestBody->payload['price'];

                    $provider->tiffins()->save($tiffin);

                    if($tiffin)
                    {
                        $responseBody->setData($tiffin);
                        $responseBody->setStatus(200);
                        $responseBody->setFlash("Tiffin Created Successfully !!");
                    }
                    
                }
            }
            else
                throw new \Exception("Provider Identification Not Found");
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found");
            $responseBody->setFlash("Tiffin can't be created");
            $responseBody->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage());
            $responseBody->setFlash("Tiffin can't be created");
            $responseBody->setStatus(500);
        }

    }

    public function delete(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider_id = $requestBody->payload['provider_id'];

            if($provider_id)
            {
                $provider = User::findOrFail($provider_id);

                if($provider)
                {
                    $tiffin_id = $requestBody->payload['tiffin_id'];

                    if($tiffin_id)
                    {
                        $tiffin = $provider->tiffin($tiffin_id);

                        if($tiffin)
                        {
                            $tiffin->delete();
                            $responseBody->setStatus(200);
                            $responseBody->setFlash("Tiffin Deleted Successfully !!");      
                        }
                    }
                    else
                        throw new \Exception("Tiffin Identification Not Found");
                }
            }
            else
                throw new \Exception("Provider Identification Not Found");
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found");
            $responseBody->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage());
            $responseBody->setFlash("Tiffin can't be deleted");
            $responseBody->setStatus(500);
        }
    }

    public function validator(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload, [
            'provider_id' => 'required',
            'name' => 'required | string | unique:tiffins',
            'detail' => 'required',
            'price' => 'required | numeric'         //todo:: Price must be in of range [ SQL Query Exception ]
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
}