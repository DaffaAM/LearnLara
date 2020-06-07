<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\tbl_katalog;



class Barang extends Controller
{
    public function getData(){
        $data = DB::table('tbl_katalog')->get();
        if(count($data) > 0){
            $res['message'] = "Success Get Data!";
            $res['value'] = $data;
            return response($res);
        } else {
            $res['message'] = "Empty!";
            return response($res);
        }
    }

    public function store(Request $request){
        $this->validate($request, [
            'file' => 'required|max:1280000'
        ]);
        
        // save data file into $file 
        $file = $request->file('file');
        $nama_file = time()."_".$file->getClientOriginalName();
        // saved folder file 
        $tujuan_upload =  'data_file';
        if($file->move($tujuan_upload, $nama_file)){
            $data = tbl_katalog::create([
                'nama_produk' => $request->nama_produk,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'gambar' => $nama_file,
                'keterangan' => $request->keterangan 
            ]);
            $res['message'] = "Success Post";
            $res['values'] = $data;
            return response($res);
        }
    }

    public function Post2 (Request $request){
        $data = new tbl_katalog;
        $data->nama_produk = $request->nama_produk;
        $data->berat = $request->berat;
        $data->harga = $request->harga;
        $data->gambar = $request->gambar;
        $data->keterangan = $request->keterangan;
        $data->save();


        $res['message'] = "Success Post";
        $res['data'] = $data;   
        return response($res);
    }
}
