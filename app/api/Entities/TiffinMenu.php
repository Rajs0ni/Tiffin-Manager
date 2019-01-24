<?php

namespace App\Api\Entities;

use App\api\RequestBody;
use App\api\ResponseBody;
use App\Tiffin;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use App\Tiffin_Menu;

class TiffinMenu {

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider = $this->validateProvider($requestBody);
            $tiffinId = $requestBody->payload['tiffin_id'];
            $tiffin = $provider->tiffins()->findOrFail($tiffinId);
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
            $responseBody->setData($menu)
                         ->setFlash('Menu Created Successfully')
                         ->setStatus(200);
        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Menu can't be created")
                         ->setStatus(500); 
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Menu can't be created")
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
            $day = $requestBody->payload['day'];
            $tiffinWithMenu = $tiffin->load(['menus' => function ($query) use ($day) {
                $query->where('day', $day);
            }]);

            $tiffinWithMenu->menus->count() ? $responseBody->setData($tiffinWithMenu)
                                                           ->setStatus(200)
                                            : $responseBody->setError("Menu For The Day Not found")
                                                           ->setStatus(500);
   
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Menu Not Found")
                         ->setStatus(500); 
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Menu Not Found")
                         ->setStatus(500);
        }
    }

    public function validateMenu(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload, [
            'lunch_desc' => 'required | string',
            'dinner_desc' => 'required | string',
            'day' => 'required | numeric | between:0,6', 
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
