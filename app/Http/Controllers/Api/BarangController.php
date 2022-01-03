<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;

class BarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getList()
    {
        try {
            $nama = $this->field('nama');
            $data = Barang::
                where('nama', 'LIKE', '%' . $nama . '%')
                ->get();
            return $this->jsonResponse('success', 200, $data);
        } catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = Barang::where('id', '=', $id)->first();
            return $this->jsonResponse('success', 200, $data);
        }catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
