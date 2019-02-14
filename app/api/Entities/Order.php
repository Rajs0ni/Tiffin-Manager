<?php

namespace App\Api\Entities;
use App\api\RequestBody;
use App\api\ResponseBody;
use App\Order as OrderModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;
use Validator;
use App\Tiffin;
use Carbon\Carbon;

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
                $data[] = array('key'=>$key, 'value'=>$value);
            // foreach($orders as $key => $value)
            // {
            //     if($key == 0)
            //     {
            //         foreach($value as $v)
            //         {
            //             $name = User::findOrFail($v->customer_id)->name;
            //             $pendings[] = [
            //                 'name' => $name,
            //                 'order' => $v
            //             ];
            //         }
            //         $pending[] = [
            //             'value' => $pendings
            //         ];
            //     }
            //     if($key == 1)
            //     {
            //         foreach($value as $v)
            //         {
            //             $name = User::findOrFail($v->customer_id)->name;
            //             $complete[] = [
            //                 'name' => $name,
            //                 'order' => $v
            //             ];
            //         }
            //         $completed[] = [
            //             'value' => $complete
            //         ];
            //     }
            // }
            // $data[] = [
            //     '0' => $pending,
            //     '1' => $completed
            // ];
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
            $this->validate($requestBody);
            $customerId = $requestBody->payload['customer']['id'];
            $customer = User::findOrFail($customerId);
            $customerSecret = $requestBody->payload['customer']['remember_token'];
            if(strcmp($customer->remember_token,$customerSecret) == 0)
            {
                $order = new OrderModel;
                $tiffin = Tiffin::findOrFail($customer->tiffin_plan);
                $time = date("H:i:s", time());
                $title = $requestBody->payload['title'];
                if($title == 'Lunch')
                {
                    if($time<=$tiffin->lunch_end)
                        $order->is_lunch = true;
                    else
                         throw new \Exception("Lunch time is over.Please go for the dinner");
                }
                else
                {
                    if($time<=$tiffin->dinner_end)
                        $order->is_dinner = true;
                    else
                        throw new \Exception("Oops, Dinner time is over.");
                }   
                $order->provider_id = $customer->assoc_provider;
                $order->tiffin_id = $customer->tiffin_plan;
                $order->no_of_tiffin = $requestBody->payload['quantity'];
                $order->price = $tiffin->price;
                $order->total_amount = $requestBody->payload['quantity'] * $tiffin->price;
                $customer->orders('customer_id')->save($order);

                $order ? $responseBody->setFlash("Order has been placed successfully !!") 
                                      ->setStatus(200)
                       : $responseBody->setFlash("Order can not be placed !!")
                                      ->setStatus(500);
            }
            else
                throw new \Exception('Your Session has been expired. Try to log in again')
;        }
        catch(ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash("Order Can not be placed")
                         ->setStatus(500);
        }
        catch(\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setFlash($e->getMessage())
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
            'title' => 'required | string',
            'quantity' => 'required | numeric | min:1 | max:4',
            'customer' => 'required'
        ]);

        if ($validator->fails()) {
            throw new \Exception ($validator->errors()->first());
        }
    }
}