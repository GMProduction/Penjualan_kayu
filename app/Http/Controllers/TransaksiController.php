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
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function getDetail($id)
    {
        try {
            $data = Transaksi::with(['keranjang.barang', 'user'])
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonResponse('Transaksi Tidak Di Temukan', 202);
            }

            if ($this->request->method() === 'POST') {
                $type = $this->postField('type');
                $status = $this->postField('status');
                if ($type === 'bayar') {
                    if ($status === 9 || $status === '9') {
                        $data->status_pembayaran = 9;
                        $data->status_transaksi = 2;
                    } else {
                        $data->status_pembayaran = 6;
                        $data->status_transaksi = 0;
                        $data->url = null;
                        $data->bank = null;
                    }
                } else {
                    $data->status_transaksi = $status;
                }
                $data->save();
            }
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
