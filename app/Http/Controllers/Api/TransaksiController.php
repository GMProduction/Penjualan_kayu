<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $user = Auth::id();
            $data = Transaksi::with(['user', 'keranjang.barang'])->where('user_id', '=', $user)
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $user = Auth::id();
            $data = Transaksi::with(['user', 'keranjang.barang'])
                ->where('user_id', '=', $user)
                ->where('id', '=', $id)
                ->first();
            if (!$data) {
                return $this->jsonResponse('Data Transaksi Tidak Di Temukan', 202);
            }
            if ($this->request->method() === 'POST') {
                $bank = $this->postField('bank');
                $bukti = null;
                if ($bukti = $this->request->file('bukti')) {
                    $ext = $bukti->getClientOriginalExtension();
                    $photoTarget = uniqid('bukti-') . '.' . $ext;
                    $bukti = '/bukti/' . $photoTarget;
                    $this->uploadImage('bukti', $photoTarget, 'bukti');
                } else {
                    return $this->jsonResponse('Mohon Lampirkan Bukti Pembayaran', 202);
                }
                $data->status_transaksi = 1;
                $data->url = $bukti;
                $data->bank = $bank;
                $data->save();
                return $this->jsonResponse('success', 200);
            }
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }

}
