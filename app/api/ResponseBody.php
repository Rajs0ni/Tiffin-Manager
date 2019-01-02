<?php 

namespace App\Api;

class ResponseBody{

    public $error_message = '';
    public $flash_message = '';
    public $data          = '';
    public $status        = '';

    public function setError($errMessage){
        $this->error_message = $errMessage;
        return $this;
    }

    public function setFlash($flashMessage){
        $this->flash_message = $flashMessage;
        return $this;
    }

    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function setStatus($status){
        $this->status = $status;
        return $this;
    }
}