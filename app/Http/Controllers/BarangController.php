<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class BarangController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->method() === 'POST') {
            $data = [
                'nama' => $this->postField('nama'),
                'harga' => $this->postField('harga'),
                'qty' => $this->postField('qty'),
                'satuan' => $this->postField('satuan'),
                'gambar' => null
            ];

            if ($gambar = $this->request->file('foto')) {
                $ext = $gambar->getClientOriginalExtension();
                $photoTarget = uniqid('image-') . '.' . $ext;
                $data['gambar'] = '/gambar/' . $photoTarget;
                $this->uploadImage('foto', $photoTarget, 'gambar');
            }
            Barang::create($data);
            return redirect()->back()->with('success');
        }
        $data = Barang::all();

        return view('admin.barang')->with(['data' => $data]);
    }

    public function patch()
    {
        $barang = Barang::find($this->postField('id-edit'));
        $data = [
            'nama' => $this->postField('nama-edit'),
            'harga' => $this->postField('harga-edit'),
            'qty' => $this->postField('qty-edit'),
            'satuan' => $this->postField('satuan-edit'),
            'gambar' => null
        ];
        if ($gambar = $this->request->file('foto-edit')) {
            $ext = $gambar->getClientOriginalExtension();
            $photoTarget = uniqid('image-') . '.' . $ext;
            $data['gambar'] = '/gambar/' . $photoTarget;
            $this->uploadImage('foto-edit', $photoTarget, 'gambar');
        }
        $barang->update($data);
        return redirect()->back()->with('success');
    }

    public function hapus()
    {
        try {
            Barang::destroy($this->postField('id'));
            return response()->json([
                'msg' => 'success'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'msg' => 'gagal ' . $e
            ], 500);
        }
    }
}
