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
            $data = Barang::all();
            return $this->jsonResponse('success', 200, $data);
        }catch (\Exception $e) {
            return $this->jsonFailedResponse($e->getMessage());
        }
    }
}
