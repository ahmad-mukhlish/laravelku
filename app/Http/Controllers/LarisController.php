<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Banner;
use App\Motor;
use App\Artikel;
use App\Http\Requests;


  
class LarisController extends Controller
{
  
    private $array ;
    
    public function index()
    {
    	$banner = Banner::all();
    	$motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_motor.harga','tb_motor.cicilan','tb_motor.tenor','tb_motor.dp','tb_merk.nama_merk', 'tb_tipe.nama_tipe') 
            ->orderBy('status','ASC')  
            ->orderBy(DB::raw('RAND()'))  
            ->limit(9)
            ->get();

    //    $this->array = (json_decode(json_encode($motor), true));
      
        $this->array = "2" ;
           
        $merk = DB::table('tb_merk')
            ->select('nama_merk')
            ->get();

    	return view('larisview/home')->with('banner', $banner)->with('motor',$motor)->with('merk', $merk);
    }

    public function artikel()
    {
        $artikel = Artikel::all();

        echo $this->array ;
        return view('larisview/artikel')->with('artikel', $artikel);
    }

    public function artikelById(Request $request)
    {
        $artikel = Artikel::find($request->id);

        return view('larisview/artikel_lengkap')->with('artikel', $artikel);
    }

    public function getMotor(Request $request)
    {

        $page = $request->halaman;
        $perPage = 15;
        $offset = ($page * $perPage) - $perPage;

        $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga','tb_motor.cicilan','tb_motor.tenor','tb_motor.dp')
            ->limit($perPage)
            ->offset($offset)
            ->orderBy('status','ASC')  
            ->orderBy(DB::raw('RAND()')) 
            ->get();
            
            
    
        $total = count(Motor::all());
        
        
        return view('larisview/motor')->with('motor',$motor)->with('total',$total)->with('perPage',$perPage)->with('page',$page);

    }

    public function searchMotorByName(Request $request)
    {

        $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk', 'like', '%' .$request->search . '%')
            ->orWhere('tb_tipe.nama_tipe', 'like', '%' .$request->search . '%')
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

        return view('larisview/search_motor_by_name')->with('motor',$motor);
    }

    public function searchMotorByForm(Request $request)
    {
        if($request->merk!=null && $request->tahun==null && $request->pricemin==null && $request->pricemax==null){
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();
        
            return view('larisview/search_motor_by_name')->with('motor',$motor);

        }else if ($request->merk==null && $request->tahun!=null && $request->pricemin==null && $request->pricemax==null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_motor.tahun', $request->tahun)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk==null && $request->tahun==null && $request->pricemin!=null && $request->pricemax==null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_motor.hjm','>=' ,$request->pricemin)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk==null && $request->tahun==null && $request->pricemin==null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_motor.hjm','<' ,$request->pricemax)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk!=null && $request->tahun!=null && $request->pricemin==null && $request->pricemax==null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->where('tb_motor.tahun', $request->tahun)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk!=null && $request->tahun==null && $request->pricemin!=null && $request->pricemax==null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->where('tb_motor.hjm', '>',$request->pricemin)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            dd($motor);
        }else if ($request->merk!=null && $request->tahun==null && $request->pricemin==null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->where('tb_motor.hjm','<=', $request->pricemax)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk==null && $request->tahun!=null && $request->pricemin!=null && $request->pricemax==null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_motor.hjm','>',$request->pricemin)
            ->where('tb_motor.tahun', '>',$request->tahun)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk==null && $request->tahun!=null && $request->pricemin==null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_motor.tahun',$request->tahun)
            ->where('tb_motor.hjm','<=', $request->pricemax)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk==null && $request->tahun==null && $request->pricemin!=null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_motor.hjm','>',$request->pricemin)
            ->where('tb_motor.hjm','<=', $request->pricemax)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }
        else if ($request->merk!=null && $request->tahun!=null && $request->pricemin!=null && $request->pricemax==null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->where('tb_motor.tahun',$request->tahun)
            ->where('tb_motor.hjm','>', $request->pricemin)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk!=null && $request->tahun!=null && $request->pricemin==null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->where('tb_motor.tahun',$request->tahun)
            ->where('tb_motor.hjm','<=', $request->pricemax)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk!=null && $request->tahun==null && $request->pricemin!=null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->where('tb_motor.hjm','<=', $request->pricemax)
            ->where('tb_motor.hjm','>', $request->pricemin)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk==null && $request->tahun!=null && $request->pricemin!=null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_motor.tahun',$request->tahun)
            ->where('tb_motor.hjm','<=', $request->pricemax)
            ->where('tb_motor.hjm','>', $request->pricemin)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else if ($request->merk!=null && $request->tahun!=null && $request->pricemin!=null && $request->pricemax!=null) {
            $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->where('tb_merk.nama_merk',$request->merk)
            ->where('tb_motor.tahun',$request->tahun)
            ->where('tb_motor.hjm','<=', $request->pricemax)
            ->where('tb_motor.hjm','>', $request->pricemin)
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
            ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }else{
            $motor = DB::table('tb_motor')
                ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
                ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
                ->select('tb_motor.no_mesin', 'tb_motor.hjm', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_motor.harga')
            ->orderBy('status','DESC')  
            ->orderBy('created_at','ASC')  
                ->get();

            return view('larisview/search_motor_by_name')->with('motor',$motor);
            
        }
    }

    public function detail($no_mesin)
    {
        $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->join('tb_sales', 'tb_motor.id_user', '=', 'tb_sales.id_user')
            ->select('tb_motor.no_mesin','tb_motor.no_polisi','tb_motor.no_rangka','tb_motor.hjm','tb_motor.kondisi', 'tb_motor.tahun','tb_motor.status','tb_motor.gambar','tb_motor.gambar1','tb_motor.gambar2', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_sales.no_wa','tb_motor.harga','tb_motor.cicilan','tb_motor.tenor','tb_motor.dp')
            ->where('tb_motor.no_mesin', $no_mesin)
            ->first();

    	return view('larisview/detail')->with('motor', $motor);
    }

    public function privacy()
    {
        return view('larisview/privacy');
    }
}
