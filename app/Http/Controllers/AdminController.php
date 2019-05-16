<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;

use App\Http\Requests;
use App\Banner;
use App\UserModel;
use App\Artikel;
use App\UbahPassword;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->has('username')) {
            return redirect('admin/home');
        }else{
            $message = "";
    	   return view('admin/login')->with('message', $message);
        }
    }

    public function artikel()
    {
        $artikel = Artikel::all();

        return view('admin/artikel')->with('artikel', $artikel);
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $cekUser = UserModel::where('username', $username)
                            ->where('password', $password)
                            ->where('status','1')
                            ->first();

        if ($cekUser!=null) {
            $request->session()->put('username', $username);
            return redirect('admin/home');
        }else{
            return redirect('admin')->with('message', 'Username atau Password Salah');   
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('username');
        $request->session()->flush();

        return redirect ('admin');
    }

	public function home(Request $request)
    {
        if ($request->session()->has('username')) {
            $username = $request->session()->get('username');
           $banner = Banner::all();
            return view('admin/banner', ['banner' => $banner])->with('username',$username);
        }else{
            return redirect('admin');
        }    

    }

    public function addBanner(Request $request)
    {
        $fotoname = 'foto' . time() . '.png';
        $request->file('gambar')->storeAS('storage/banner', $fotoname);

        $banner = new Banner;
        $banner->gambar = $fotoname;
        $banner->judul_banner = $request->judul;
        $banner->keterangan = $request->keterangan;
        $banner->save();
    	return redirect('admin/home');
    }

    public function editBanner(Request $request)
    {

        $banner = Banner::find($request->id_banner);

        if ($request->file('gambar')!=null) {
            $fotoname = 'foto' . time() . '.png';
            $request->file('gambar')->storeAS('storage/banner', $fotoname);
            Storage::disk('uploads')->delete('storage/banner/'.$request->gambar_awal);
            $banner->gambar = $fotoname;
        }else{

        }

        $banner->judul_banner = $request->judul;
        $banner->keterangan = $request->keterangan;
        $banner->save();
        return redirect('admin/home');
        
    }

    public function deleteBanner($id_banner, $image){
    	$banner = Banner::where('id_banner',$id_banner)->delete();
        Storage::disk('uploads')->delete('storage/banner/'.$image);
    	return redirect('admin/home');	
    }

    public function addArtikel(Request $request)
    {
        $fotoname = 'foto' . time() . '.png';
        $request->file('gambar')->storeAS('storage/artikel', $fotoname);

        $artikel = new Artikel;
        $artikel->gambar = $fotoname;
        $artikel->judul = $request->judul;
        $artikel->isi = $request->keterangan;
        $artikel->save();
        return redirect('admin/artikel');
    }

    public function editArtikel(Request $request)
    {

        $artikel = Artikel::find($request->id_banner);

        if ($request->file('gambar')!=null) {
            $fotoname = 'foto' . time() . '.png';
            $request->file('gambar')->storeAS('storage/artikel', $fotoname);
            Storage::disk('uploads')->delete('storage/artikel/'.$request->gambar_awal);
            $artikel->gambar = $fotoname;
        }else{

        }

        $artikel->judul = $request->judul;
        $artikel->isi = $request->keterangan;
        $artikel->save();
        return redirect('admin/artikel');
        
    }

    public function deleteArtikel($id_banner, $image){
        $artikel = Artikel::where('id',$id_banner)->delete();
        Storage::disk('uploads')->delete('storage/artikel/'.$image);
        return redirect('admin/artikel');  
    }

    public function password_status()
    {
        $status = UbahPassword::first();

           return view('admin/ubah_password')->with('status', $status);
    }

    public function ubah_password(Request $request)
    {

        $status = UbahPassword::find($request->id);

        if ($request->submit == "Konfirmasi") {
            $status->status = 0;
            $status->username = $request->username;
            $status->password = $request->password;
            $status->save();

            if ($status) {
                $user = UserModel::find(1);
                $user->username = $status->username;
                $user->password = $status->password;
                $user->save();
            }


        }else if ($request->submit == "Tolak") {       
            $status->status = 0;
            $status->save();
        }


        return redirect('admin/password_status')->with('status', $status);
    }

    function getBannerById(Request $request){
        $banner = Banner::find($request->id_banner);
        return json_encode($banner);
    }

    function getArtikelById(Request $request){
        $artikel = Artikel::find($request->id_artikel);
        return json_encode($artikel);
    }
}
