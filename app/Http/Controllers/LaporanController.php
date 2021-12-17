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

    public function getLaporanTransaksi()
    {
        try {
            $status = $this->field('status');
            $start = $this->field('start');
            $end = $this->field('end');
            $data = Transaksi::with(['user', 'keranjang.barang'])
                ->whereBetween('tanggal', [$start, $end]);
            if ($status !== "") {
                $data->where('status_transaksi', '=', $status);
            }
            $result = $data->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function cetakLaporanTransaksi()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataTransaksi())->setPaper('f4', 'potrait');

        return $pdf->stream();
    }

    public function dataTransaksi()
    {

        $data = [
            'data' => "data",
            'start' => "2012-01-01",
            'end' => "2012-01-01",
        ];

        return view('admin/cetaktransaksi')->with($data);
    }

    public function cetakLaporanPemasukan()
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->dataPemasukan())->setPaper('f4', 'potrait');

        return $pdf->stream();
    }

    public function dataPemasukan()
    {

        $data = [
            'data' => "data",
            'start' => "2012-01-01",
            'end' => "2012-01-01",
        ];

        return view('admin/cetakpemasukan')->with($data);
    }

}
