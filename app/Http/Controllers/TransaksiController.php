<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Transaksi;

class TransaksiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.transaksi');
    }

    public function getList()
    {
        try {
            $data = Transaksi::with(['keranjang', 'user'])
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function getDetail($id)
    {
        try {
            $data = Transaksi::with(['keranjang', 'user'])
                ->where('id', '=', $id)
                ->first();
            if(!$data) {
                return $this->jsonResponse('Transaksi Tidak Di Temukan', 202);
            }
            return $this->jsonResponse('success', 200, $data);
        }catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
