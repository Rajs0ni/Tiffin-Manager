<?php 

namespace App\Api\Entities;

use App\api\RequestBody;
use App\api\ResponseBody;
use App\Tiffin as TiffinModel;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\Tiffin_Menu;

class Tiffin {

    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffins = $provider->tiffins;
            !$tiffins->isEmpty() ? $responseBody->setData($tiffins)
                                                ->setStatus(200)
                                 : $responseBody->setFlash('Tiffins Not Found')
                                                ->setStatus(500);
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setStatus(500);
        }   
    }

    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffinId = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrFail($tiffinId);
            $responseBody->setData(gettype($tiffin))
                         ->setStatus(200);              
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Tiffin Not Found")
                         ->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Tiffin Not Found")      
                         ->setStatus(500);
        }
       
    }

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $this->validateTiffin($requestBody);
            $tiffinId = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrNew($tiffinId);
            $tiffin->name = $requestBody->payload['name'];
            $tiffin->detail = $requestBody->payload['detail'];
            $tiffin->price = $requestBody->payload['price'];
            $provider->tiffins()->save($tiffin);

            $tiffin ? $responseBody->setData($tiffin)
                                   ->setFlash("Tiffin Created Successfully !!") 
                                   ->setStatus(200)
                    : $responseBody->setFlash("Tiffin can't be created")
                                   ->setStatus(500);
                                 
        }                       
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Tiffin can't be created")
                         ->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Tiffin can't be created")
                         ->setStatus(500);
        }
    }

    public function delete(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffinId = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrFail($tiffinId);
            $tiffin->delete();

            $responseBody->setFlash("Tiffin Deleted Successfully !!")
                         ->setStatus(200);        
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Tiffin can't be deleted")
                         ->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Tiffin can't be deleted")
                         ->setStatus(500);                 
        }
    }


    public function validateTiffin(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload, [
            'provider_id' => 'required',
            'name' => 'required | string |unique:tiffins,name,'.$requestBody->payload['tiffin_id'],
            'detail' => 'required | regex:/[^a-zA-Z0-9]/',
            'price' => 'required | numeric' 
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }

    public function validateProvider(RequestBody $requestBody)
    {
        $providerId = $requestBody->payload['provider_id'];
        $provider = User::findOrFail($providerId);
        if($provider->is_provider == 1)
            return $provider;
        else
            throw new \Exception("Not a Provider");
    }
}