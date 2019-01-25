<?php

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use App\Order as OrderModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Validator;
use App\Tiffin;

class Order {

    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $userId  = $requestBody->payload['user_id'];
            $user = User::findOrFail($userId);
            $column = $user->is_provider == 1 ? 'provider_id' : 'customer_id';
            $orders = $user->orders($column)->get();
            $orders = $orders->groupBy('status');
            foreach($orders as $key => $value)
            {
                $data[] = ['key' => $key,'value' => $value];
            }
            !$orders->isEmpty() ? $responseBody->setData($data)
                                               ->setStatus(200)
                                : $responseBody->setError('Orders Not Found')
                                               ->setStatus(500);
        }                   
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("No Orders Found Yet")
                         ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("No Orders Found Yet")
                         ->setStatus(500);
        }
    }

    public function get(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $userId  = $requestBody->payload['user_id'];
            $user = User::findOrFail($userId);
            $orderId = $requestBody->payload['order_id'];
            $column = $user->is_provider == 1 ? 'provider_id' : 'customer_id';
            $order = $user->orders($column)->findOrFail($orderId);
            $customerName = User::findOrFail($order->customer_id)->name;
            $tiffinName = Tiffin::findOrFail($order->tiffin_id)->name;

            $data = [
                'customer_name' => $customerName,
                'tiffin_plan' => $tiffinName,
                'record' => $order
            ];

            $responseBody->setData($data)
                         ->setStatus(200);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("No Such Order Found !!")
                         ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("No Such Order Found !!")
                         ->setStatus(500);
        }
    }

    public function save(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $customerId = $requestBody->payload['customer_id'];
            $customer = User::findOrFail($customerId);
            $this->validate($requestBody);
            $time = $requestBody->payload['time'];
            $data = $requestBody->payload['data'];
            $tiffin = Tiffin::findOrFail($data['id']);
            $order = new OrderModel;
            $order->provider_id = $tiffin->provider_id;
            $order->tiffin_id = $tiffin->id;
            $order->no_of_tiffin = $requestBody->payload['quantity'];
            if($time<=date('G',strtotime($tiffin->lunch_end)))
                $order->is_lunch = true;
            else
                $order->is_dinner = true;
            $order->price = $tiffin->price;
            $order->total_amount = $requestBody->payload['quantity'] * $tiffin->price;
            $customer->orders('customer_id')->save($order);

            $order ? $responseBody->setFlash("Order has been placed successfully !!") 
                                   ->setStatus(200)
                   : $responseBody->setFlash("Order can not be placed !!")
                                   ->setStatus(500);
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Order can not be placed !!")
                         ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Order can not be placed !!")
                         ->setStatus(500);
        }
    }

    public function deliver(RequestBody $requestBody, ResponseBody $responseBody)
    {
        
        try
        {
            $userId  = $requestBody->payload['user_id'];
            $user = User::findOrFail($userId);
            if($user->is_provider)
            {
                $orderId = $requestBody->payload['order_id'];
                $order = $user->orders('provider_id')->findOrFail($orderId);
                $order->status = !$order->status;
                $order->save();
                $responseBody->setFlash("Order has been processed !!")
                             ->setStatus(200);    
            }
        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Order can't be processed !!")
                         ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Order can't be processed !!")
                         ->setStatus(500);
        }
    }

    public function validate(RequestBody $requestBody)
    {
        $validator = Validator::make($requestBody->payload, [
            'quantity' => 'required | numeric | min:1 | max:4',
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
}