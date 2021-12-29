<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth as JWTAuth;

class AuthController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['username', 'password']);
        if (!$token = auth('api')->setTTL(null)->attempt($credentials)) {
            return $this->jsonResponse('Username dan Password Tidak Cocok', 401);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return $this->jsonResponse('success', 200, [
            'access_token' => $token,
            'type' => 'Bearer'
        ]);
    }

    public function register()
    {
        try {
            $user = User::create([
                'username' => $this->postField('username'),
                'password' => Hash::make($this->postField('password')),
                'roles' => 'member',
                'nama' => $this->postField('nama'),
                'alamat' => $this->postField('alamat'),
                'no_hp' => $this->postField('no_hp')
            ]);
            $token = JWTAuth::fromUser($user);
            return $this->respondWithToken($token);
        } catch (\Exception $e) {
            return $this->jsonResponse('Terjadi Kesalahan ' . $e->getMessage() . $e->getFile(), 500);
        }
    }

}
