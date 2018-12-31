<?php 

namespace App\Api\Entities;

use App\api\RequestBody;
use App\api\ResposnseBopdy;
use App\Tiffin as TiffinModel;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\User;

class Tiffin{

    public function list(RequestBody $requestBody, ResponseBody $responseBody)
    {
        try
        {
            $provider_id = $requestBody->payload['id'];
            $provider = User::findOfFail($provider_id);

            if($provider)
            {
                $tiffins = TiffinModel::all()->where('provider_id', $provider->id);

                if($tiffins)
                {
                    $responseBody->setData($tiffins);
                    $responseBody->setStatus(200);
                }
                else
                    throw new ModelNotFoundException("Tiffins Not Found");
            }
            else
                throw new ModelNotFoundException("No Such Provider Found");

        }
        catch (ModelNotFoundException $e)
        {
            $responseBody->setError($e->getMessage());
            $responseBody->setStatus(500);
        }
        catch (\Exception $e)
        {
            $responseBody->setError($e->getMessage());
            $responseBody->setStatus(500);
        }
    }
}