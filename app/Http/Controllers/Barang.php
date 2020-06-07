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

    public function update(Request $request){
        if(!empty($request->file)){
            $this->validate($request, [
                'file' => 'required|max:1280000'
            ]);
            
            // save data file into $file 
            $file = $request->file('file');
            $nama_file = time()."_".$file->getClientOriginalName();
            // saved folder file 
            $tujuan_upload =  'data_file';
            $file->move($tujuan_upload, $nama_file);
            $data = DB::table('tbl_katalog')->where('id', $request->id)->get();

            foreach ($data as $katalog) {
                @unlink(public_path('data_file/'.$katalog->gambar));
            $ket = DB::table('tbl_katalog')->where('id', $request->id)->update([
                'nama_produk' => $request->nama_produk,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'gambar' => $nama_file,
                'keterangan' => $request->keterangan 
            ]);
            $res['message'] = "Success Update Data";
            $res['values'] = $ket;
            return response($res);
        }

        }else{
            $data = DB::table('tbl_katalog')->where('id', $request->id)->get();

            foreach ($data as $katalog) {
            
            $ket = DB::table('tbl_katalog')->where('id', $request->id)->update([
                'nama_produk' => $request->nama_produk,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'keterangan' => $request->keterangan 
            ]);
            $res['message'] = "Success Update Data";
            $res['values'] = $ket;
            return response($res);
            }
         }
    }

    public function update2(request $request){
        $nama_produk = $request->nama_produk;
        $berat = $request->berat;
        $harga = $request->harga;
        $gambar = $request->gambar;
        $keterangan = $request->keterangan;

        $ubah = tbl_katalog::find($id);
        $ubah->nama_produk = $nama_produk;
        $ubah->berat = $berat;
        $ubah->harga = $harga;
        $ubah->gambar = $gambar;
        $ubah->keterangan = $keterangan;
        $ubah->save(); 

        $res['message'] = "Success Update";
        $res['values'] = $ubah;
        return response($res);


    }

    public function hapus($id){
        $data = DB::table('tbl_katalog')->where('id', $id)->get();
        foreach($data as $katalog){
            if(file_exists(public_path('data_file/'.$katalog->gambar))){
                @unlink(public_path('data_file/'.$katalog->gambar));
                DB::table('tbl_katalog')->where('id', $id)->delete();
                $res['message'] = "Success Delete";
                return response($res);
            }else{
                $res['message'] = "Empty";
                return response($res);
            }

        }
    }

    public function getid($id){
        $data = DB::table('tbl_katalog')->where('id', $id)->get();
        if(count($data) > 0){
        $res['message'] = "Success";
        $res['values'] = $data;
        return response($res);
        }else{
            $res['message'] = 'Empty!';
            return response($res);
           }
        }

}
