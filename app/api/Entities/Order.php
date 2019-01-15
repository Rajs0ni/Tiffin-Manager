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
            $orders = $orders->groupBy('status');
            foreach($orders as $key => $value)
            {
                $data[] = ['key' => $key,'value' => $value];
            }
            !$orders->isEmpty() ?
            $responseBody->setData($data)->setStatus(200) :
            $responseBody->setError('Orders Not Found')->setStatus(500);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("No Orders Found Yet");
        }
        catch(\Exception $e)
        {
            $responseBody->setError("Orders Not Found")->setStatus(500)
                         ->setFlash("No Orders Found Yet");
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
                         ->setFlash("No Such Order Found !!");
        }
        catch(\Exception $e)
        {
            $responseBody->setError("No Such Order Found !!")->setStatus(500);
        }
    }

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $customer_id = $requestBody->payload['customer_id'];
            $customer = User::findOrFail($customer_id);
            $this->validate($requestBody);
            $order = new OrderModel;
            $time = $requestBody->payload['time'];
            $order->provider_id = $customer->assoc_provider;
            $order->tiffin_id = $customer->tiffin_plan;
            $order->no_of_tiffin = $requestBody->payload['quantity'];
            $time == 'lunch' ? $order->is_lunch = true : $order->is_dinner = true;
            $order->price = $requestBody->payload['price'];
            $order->total_amount = $requestBody->payload['quantity'] * $requestBody->payload['price'];
            $customer->orders('customer_id')->save($order);

            if($order)
            {
                $responseBody->setFlash("Order has been placed successfully !!")->setStatus(200);                
            }
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("Order can not be placed !!");
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())->setStatus(500)
                         ->setFlash("Order can not be placed !!");
        }
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
                $order->status = !$order->status;
                $order->save();
                $responseBody->setFlash("Order has been processed !!")->setStatus(200);    
            }
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError("Model Not Found")->setStatus(500)
                         ->setFlash("Order can't be processed !!");
        }
        catch(\Exception $e)
        {
            $responseBody->setError("Order Not Found")->setStatus(500)
                         ->setFlash("Order can't be processed !!");
        }
    }

    public function validate(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload, [
            'quantity' => 'required | numeric | min:1 | max:5',
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
}