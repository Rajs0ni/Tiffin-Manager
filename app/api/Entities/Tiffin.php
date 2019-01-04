<?php 

namespace App\Api\Entities;

use App\api\RequestBody;
use App\api\ResponseBody;
use App\Tiffin as TiffinModel;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\Tiffin_Menu;

class Tiffin{

    public function validateProvider(RequestBody $requestBody)
    {
        $provider_id = $requestBody->payload['provider_id'];
        $provider = User::findOrFail($provider_id);
        if($provider->is_provider)
            return $provider;
        else
            throw new \Exception("Not a Provider");
    }

    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffins = $provider->tiffins;
            !$tiffins->isEmpty() ? 
            $responseBody->setData($tiffins)->setStatus(200) :
            $responseBody->setError('Tiffins Not Found')->setStatus(500);
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())->setStatus(500);
        }   
    }

    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffin_id = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrFail($tiffin_id);

            $responseBody->setData($tiffin)->setStatus(200);              
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())->setStatus(500);
        }
       
    }

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $this->validateTiffin($requestBody);
            $tiffin_id = $requestBody->payload['id'];
            $tiffin = $provider->tiffins()->findOrNew($tiffin_id);
            $tiffin->name = $requestBody->payload['name'];
            $tiffin->detail = $requestBody->payload['detail'];
            $tiffin->price = $requestBody->payload['price'];
            $provider->tiffins()->save($tiffin);

            $tiffin?$responseBody->setData($tiffin)->setStatus(200)->setFlash("Tiffin Created Successfully !!"):'';
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")
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
            $tiffin_id = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrFail($tiffin_id);
            $tiffin->delete();

            $responseBody->setStatus(200)->setFlash("Tiffin Deleted Successfully !!");        
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500);
                        
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())->setStatus(500)
                         ->setFlash("Tiffin can't be deleted");                 
        }
    }

    public function saveMenu(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffin_id = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrFail($tiffin_id);
            $this->validateMenu($requestBody);
            $day = $requestBody->payload['day'];
            $menu = $tiffin->menus()->where('day',$day)->first();

            if($menu == null)
            {
                $menu = new Tiffin_Menu;
                $menu->day = $day;
            }
            $menu->lunch_desc = $requestBody->payload['lunch_desc'];
            $menu->dinner_desc = $requestBody->payload['dinner_desc'];
            $tiffin->menus()->save($menu);
            $responseBody->setData($menu)->setStatus(200)->setFlash('Menu Created Successfully');
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("Menu can't be created"); 
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())->setStatus(500)
                         ->setFlash("Menu can't be created");
        }
    }

    public function getMenu(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffin_id = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrFail($tiffin_id);
            $day = $requestBody->payload['day'];
            $menu = $tiffin->menus()->where('day',$day)->first();

            isset($menu) ?
            $responseBody->setData($menu)->setStatus(200) :
            $responseBody->setError("Menu Not found for the day ".$day)->setStatus(500);

        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("Menu Not Found"); 
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())->setStatus(500)
                         ->setFlash("Menu Not Found");
        }
    }

    public function validateTiffin(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload, [
            'provider_id' => 'required',
            'name' => 'required | string | unique:tiffins',
            'detail' => 'required',
            'price' => 'required | numeric' 
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }

    public function validateMenu(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload, [
            'lunch_desc' => 'required | string',
            'dinner_desc' => 'required | string',
            'day' => 'required | numeric | between:1,7', 
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
}