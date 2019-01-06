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
            $orders = $user->is_provider == 1 ? $user->orders('provider_id')->get() : $user->orders('customer_id')->get() ;
            !$orders->isEmpty() ?
            $responseBody->setData($orders)->setStatus(200) :
            $responseBody->setError('Orders Not Found')->setStatus(500);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500);
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

            if($user->is_provider == 1)
            {
                $order = $user->orders('provider_id')->findOrFail($order_id);     
            }
            else
            {
                $order = $user->orders('customer_id')->findOrFail($order_id);
            }

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
            $responseBody->setError("Model Not Found")->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError("Order Not Found")->setStatus(500);
        }
    }
}