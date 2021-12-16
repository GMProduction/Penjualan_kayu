<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $user = Auth::id();
            if ($this->request->method() === 'POST') {
                $itemId = $this->postField('barang');
                $qty = $this->postField('qty');
                $barang = Barang::find($itemId);
                if (!$barang) {
                    return $this->jsonResponse('Barang Tidak Di Temukan', 202);
                }
                if ($barang->qty < $qty) {
                    return $this->jsonResponse('Stock Barang Tidak Cukup', 202);
                }

                $isExist = Keranjang::where('user_id', '=', $user)
                    ->whereNull('transaksi_id')
                    ->where('barang_id', '=', $barang->id)
                    ->first();

                if ($isExist) {
                    $qtyExist = $isExist->qty;
                    $isExist->update([
                        'qty' => $qtyExist + $qty
                    ]);
                } else {
                    Keranjang::create([
                        'user_id' => $user,
                        'transaksi_id' => null,
                        'barang_id' => $barang->id,
                        'qty' => $qty,
                        'harga' => $barang->harga
                    ]);
                }
                return $this->jsonResponse('success', 200);
            }
            $data = Keranjang::with(['barang:id,nama,harga,satuan,gambar'])
                ->where('user_id', '=', $user)
                ->whereNull('transaksi_id')
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }

    public function checkout()
    {
        try {
            $user = Auth::id();
            $ongkir = $this->postField('ongkir') !== null ? $this->postField('ongkir') : 0;
            DB::transaction(function () use ($user, $ongkir) {
                $keranjang = Keranjang::with(['barang'])
                    ->whereNull('transaksi_id')
                    ->get();

                $sub_total = $keranjang->sum('sub_total');

                $transaksi = Transaksi::create([
                    'user_id' => $user,
                    'tanggal' => new \DateTime(),
                    'no_transaksi' => 'TR-' . strtotime('now'),
                    'sub_total' => $sub_total,
                    'ongkir' => $ongkir,
                    'total' => ($sub_total + $ongkir),
                    'alamat' => $this->postField('alamat'),
                    'ekspedisi' => $this->postField('ekspedisi'),
                    'status_transaksi' => 0,
                    'status_pembayaran' => 0,
                    'url' => null
                ]);
                foreach ($keranjang as $v) {
                    $v->transaksi_id = $transaksi->id;
                    $v->save();
                }
            });
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
