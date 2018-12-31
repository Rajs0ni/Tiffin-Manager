<?php 

namespace App\Api;
use Illuminate\Http\Request;

class RequestBody{

    public $namespace = '';
    public $action    = '';
    public $payload   = '';

    public function __construct(Request $request)
    {
        $this->namespace = $request->namespace;
        $this->action    = $request->action;
        $this->payload   = $request->payload;
    } 
}