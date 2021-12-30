<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $id = Auth::id();
            $user = User::where('id', '=', $id)
                ->first();
            if ($this->request->method() === 'POST') {
                DB::beginTransaction();
                $user->username = $this->postField('username');
                if ($this->postField('password') !== '') {
                    $user->password = Hash::make($this->postField('password'));
                }
                $user->nama = $this->postField('nama');
                $user->alamat = $this->postField('alamat');
                $user->no_hp = $this->postField('no_hp');
                $user->save();
                return $this->jsonResponse('success', 200);
            }
            return $this->jsonResponse('success', 200, $user);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('gagal ' . $e->getMessage(), 500);
        }
    }
}
