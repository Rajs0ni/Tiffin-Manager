<?php

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use App\Order as OrderModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Validator;
use App\Tiffin;

class Order{

    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $user_id  = $requestBody->payload['user_id'];
            $user = User::findOrFail($user_id);
            $column = $user->is_provider == 1 ? 'provider_id' : 'customer_id';
            $orders = $user->orders($column)->get();
            !$orders->isEmpty() ?
            $responseBody->setData($orders)->setStatus(200) :
            $responseBody->setError('Orders Not Found')->setStatus(500);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("Orders Not Found");
        }
        catch(\Exception $e)
        {
            $responseBody->setError("Orders Not Found")->setStatus(500);
        }
    }

    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $user_id  = $requestBody->payload['user_id'];
            $user = User::findOrFail($user_id);
            $order_id = $requestBody->payload['order_id'];
            $column = $user->is_provider == 1 ? 'provider_id' : 'customer_id';
            $order = $user->orders($column)->findOrFail($order_id);
            $customer_name = User::findOrFail($order->customer_id)->name;
            $tiffin_name = Tiffin::findOrFail($order->tiffin_id)->name;

            $data = [
                'customer_name' => $customer_name,
                'tiffin_plan' => $tiffin_name,
                'order' => $order
            ];

            $responseBody->setData($data)->setStatus(200);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("Order Not Found");
        }
        catch(\Exception $e)
        {
            $responseBody->setError("Order Not Found")->setStatus(500);
        }
    }

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        
    }

    public function deliver(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $user_id  = $requestBody->payload['user_id'];
            $user = User::findOrFail($user_id);
            if($user->is_provider)
            {
                $order_id = $requestBody->payload['order_id'];
                $order = $user->orders('provider_id')->findOrFail($order_id);
                $order->status = true;
                $order->save();
                $responseBody->setFlash("Order delivered")->setStatus(200);    
            }
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("Order can't be delivered");
        }
        catch(\Exception $e)
        {
            $responseBody->setError("Order Not Found")->setStatus(500)
                         ->setFlash("Order can't be delivered");
        }
    }
}