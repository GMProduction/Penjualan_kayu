<?php

namespace App\Http\Controllers;

use App\Helper\CustomController;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.laporantransaksi');
    }

    public function indexPemasukan()
    {
        return view('admin.laporanpemasukan');
    }

    public function getLaporanTransaksi()
    {
        try {
            $status = $this->field('status');
            $start = $this->field('start');
            $end = $this->field('end');
            $data = Transaksi::with(['user', 'keranjang.barang'])
                ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))]);
            if ($status !== "") {
                $data->where('status_transaksi', '=', $status);
            }
            $result = $data->get();
            return $this->basicDataTables($result);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function cetakLaporanTransaksi()
    {
        $status = $this->field('status');
        $start = $this->field('start');
        $end = $this->field('end');
        $data = Transaksi::with(['user', 'keranjang.barang'])
            ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))]);
        if ($status !== "") {
            $data->where('status_transaksi', '=', $status);
        }
        $result = $data->get();
        return $this->convertToPdf('admin.cetaktransaksi', ['data'=> $result, 'start' => $start, 'end' => $end]);
    }

    public function getLaporanPemasukan()
    {
        try {
            $start = $this->field('start');
            $end = $this->field('end');
            $data = Transaksi::with(['user', 'keranjang.barang'])
                ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))])
                ->where('status_pembayaran', '=', 9)
                ->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function cetakLaporanPemasukan()
    {
        $start = $this->field('start');
        $end = $this->field('end');
        $data = Transaksi::with(['user', 'keranjang.barang'])
            ->whereBetween('tanggal', [date('Y-m-d', strtotime($start)), date('Y-m-d', strtotime($end))])
            ->where('status_pembayaran', '=', 9)
            ->get();
        $total = $data->sum('total');
        return $this->convertToPdf('admin.cetakpemasukan', ['data'=> $data, 'start' => $start, 'end' => $end, 'total' => $total]);
    }
//    public function dataTransaksi()
//    {
//
//        $data = [
//            'data' => "data",
//            'start' => "2012-01-01",
//            'end' => "2012-01-01",
//        ];
//
//        return view('admin/cetaktransaksi')->with($data);
//    }





//    public function dataPemasukan()
//    {
//
//        $data = [
//            'data' => "data",
//            'start' => "2012-01-01",
//            'end' => "2012-01-01",
//        ];
//
//        return view('admin/cetakpemasukan')->with($data);
//    }

}
