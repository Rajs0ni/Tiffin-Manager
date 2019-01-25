<?php

namespace App\Api;
use Illuminate\Http\Request;


class ApiManager{

    public function handler(Request $request)
    {
        $responseBody = new \App\api\ResponseBody();
        
        try 
        {
            $namespace = "App\\api\\Entities\\".$request->namespace;
            $action = $request->action;
    
            if(!class_exists($namespace, true))
                throw new \Exception("$namespace Namespace Not Found");
            
            $instance = new $namespace;
            $requestBody = new \App\api\RequestBody($request);
          
            if(method_exists($instance, $action))
                $instance->$action($requestBody, $responseBody);
            else
                throw new \Exception("$action Action Not Found");

        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage())
                         ->setStatus(500);
        }
        return response()->json($responseBody);
    }
}