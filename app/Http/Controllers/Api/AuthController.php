<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }


}
