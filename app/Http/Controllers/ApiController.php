<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use App\Http\Requests;
use App\UserModel;
use App\Motor;
use App\Merk;
use App\Tipe;
use App\Sales;
use App\PendingBeli;
use App\PendingJual;
use App\UbahPassword;
use App\Customer;
use App\Transaksi;
use App\KonfigInsentif;
use DateTime;


class ApiController extends Controller
{
    public function getMotor(Request $request)
    {
         if ($request->id_user == 1)
         {$equalStatus = '<>' ;
          $status = -1 ;     }
         else
         {$equalStatus = '=' ;
          $status = 0 ;     
         }
         
         
    	$motor = Motor::orderBy('updated_at','desc')
    	         ->where('status',$equalStatus,$status)
    	         ->get();
    	
    	$motor = Motor::orderBy('status','asc')
    	         ->where('status',$equalStatus,$status)
    	         ->get();
    	
    	return json_encode($motor);
    }

    public function getId()
    {
    	$id = UserModel::all('id_user');
    	return json_encode($id);
    }

    public function getMerk()
    {
        $merk = Merk::all();
        return json_encode($merk);
    }

    public function getTipe(Request $request)
    {
        $tipe = Tipe::where('id_merk', $request->id_merk)
                    ->get();

        return json_encode($tipe);
    }
    

    public function getMerkById(Request $request)
    {
        $merk = Merk::where('tb_merk.id_merk', $request->id_merk)
                    ->where('tb_tipe.id_tipe', $request->id_tipe)
                    ->join('tb_tipe', 'tb_tipe.id_merk', '=', 'tb_merk.id_merk')
                    ->get();

        return json_encode($merk);
    }


    public function deleteMotor(Request $request)
    {
        $motor = Motor::where('no_mesin', $request->no_mesin)
                        ->delete();
        if ($request->gambar!=null) {
            Storage::disk('uploads')->delete('storage/motor/'.$request->gambar);
        }
        if ($request->gambar1!=null) {
            Storage::disk('uploads')->delete('storage/motor/'.$request->gambar1);
        }
        if ($request->gambar2!=null) {
            Storage::disk('uploads')->delete('storage/motor/'.$request->gambar2);
        }
        
        
        $data = array('message'=>'success');
        
        return $data;  
    }

    public function login(Request $request)
    {
    	// $password = md5($request->password);
        $password = $request->password;
    	$tes = UserModel::where('username', $request->username)
    						->where('password', $password)
    						->first();

    	if ($tes!=null) {
            $token = DB::table('tb_user')
                        ->where('id_user',$tes->id_user)
            ->update(['AccesToken' => md5(time())]);

	    		$data = DB::table('tb_user')
	            ->select('*' )
                ->where('tb_user.id_user', $tes->id_user)
	            ->join('tb_sales', 'tb_sales.id_user', '=', 'tb_user.id_user')
	            ->first();

                $data->message = 'success';
    	}else{
    		$data = array('message'=>'failed');
    	}

    	return json_encode($data);    		

    }

    public function addMotor(Request $request)
    {
        

        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();

        if ($cekUser!=null) {

            $motor = new Motor;
            $motor->no_mesin = $request->no_mesin;
            $motor->no_polisi = $request->no_polisi;
            $motor->no_rangka = $request->no_rangka;
            $motor->tahun = $request->tahun;
            $motor->status = $request->status;
            $motor->hjm = $request->hjm;
            $motor->id_tipe = $request->tipe;
            $motor->id_merk = $request->merk;   
            $motor->id_user = $request->id_user; 
            $motor->kondisi = 0;
            $motor->harga = $request->harga;
            $motor->harga_terjual = $request->harga_terjual;
            $motor->dp = $request->dp;
            $motor->cicilan = $request->cicilan;
            $motor->tenor = $request->tenor;

            $input=$request->all();
            $images=array();
            foreach($request->file as $index => $file){
                $name= time().$file->getClientOriginalName();
                $file->storeAS('storage/motor',$name);
                $images[]=$name;
            }

            if(!empty($images[0])){
                $motor->gambar = $images[0];
            }
            if (!empty($images[1])) {
                $motor->gambar1 = $images[1];
            }if (!empty($images[2])) {
                $motor->gambar2 = $images[2];
            }

            $motor->save();
            $data = array('message'=>'success');
        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);

    }


    public function updateMotor(Request $request)
    {
        

        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();

         if ($cekUser!=null) {

            $motor = Motor::find($request->no_mesin_awal);
            $motor->no_mesin = $request->no_mesin;
            $motor->no_polisi = $request->no_polisi;
            $motor->no_rangka = $request->no_rangka;
            $motor->tahun = $request->tahun;
            $motor->id_user = $request->id_user;
            $motor->status = $request->status;
            $motor->hjm = $request->hjm;
            $motor->id_tipe = $request->tipe;
            $motor->id_merk = $request->merk;
            $motor->harga = $request->harga;
            $motor->harga_terjual = $request->harga_terjual;
            $motor->dp = $request->dp;
            $motor->cicilan = $request->cicilan;
            $motor->tenor = $request->tenor;
            
            if ($motor->kondisi == 0) {
             if ($request->harga_terjual!=null && $request->harga_terjual != 0) {
                 
                 if ($motor->hjm != null) {
                 $motor->selisih = $motor->harga_terjual - $motor->hjm - $motor->mediator ;
                
                  if ($motor->selisih < 0) 
                  {$motor->selisih = 0 ;}}
                
                //   $motor->dp = null ;
                //   $motor->cicilan = null;
                //   $motor->tenor = null;
            
                } 
                else {
                  $motor->dp = $request->dp;
                  $motor->cicilan = $request->cicilan;
                  $motor->tenor = $request->tenor;
                
                //   $motor->harga = $request->dp + ($request->cicilan * $request->tenor) + $motor->pencairanLeasing - $motor->mediator;
                
                    
                  if ($motor->hjm != null) {
                  $motor->selisih = $motor->dp + $motor->pencairanLeasing - $motor->hjm - $motor->mediator ;
                
                  if ($motor->selisih < 0) 
                  {$motor->selisih = 0 ;}}
                
               }
            }
            
            
            if ($request->gambar!=null) {
                   $motor->gambar = $request->gambar;
               }
            if ($request->gambar1!=null) {
                   $motor->gambar1 = $request->gambar1;
               }
            if ($request->gambar2!=null) {
                   $motor->gambar2 = $request->gambar2;
               }    

            $input=$request->all();
            $images=array();
            if ($request->file!=null) {                    
                foreach($request->file as $index => $file){
                    $name= time().$file->getClientOriginalName();
                    $file->storeAS('storage/motor',$name);
                    $images[]=$name;
                }
            }

            if(!empty($images[0])){
                $motor->gambar = $images[0];
                Storage::disk('uploads')->delete('storage/motor/'.$request->gambar);
            }
            if (!empty($images[1])) {
                $motor->gambar1 = $images[1];
                Storage::disk('uploads')->delete('storage/motor/'.$request->gambar1);
            }if (!empty($images[2])) {
                $motor->gambar2 = $images[2];
                Storage::disk('uploads')->delete('storage/motor/'.$request->gambar2);
            }

            $motor->save();
            $data = array('message'=>'success');
         }else{
             $data = array('message'=>'failed');
         }

        return json_encode($data);

    }

    public function delete(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();

        if ($cekUser!=null) {
            
            $transaksi = Transaksi::where('no_mesin', $request->no_mesin)
                        ->delete();
            $motor = Motor::where('no_mesin', $request->no_mesin)
                        ->delete();
            if ($request->gambar!=null) {
                Storage::disk('uploads')->delete('storage/motor/'.$request->gambar);
            }
            if ($request->gambar1!=null) {
                Storage::disk('uploads')->delete('storage/motor/'.$request->gambar1);
            }
            if ($request->gambar2!=null) {
                Storage::disk('uploads')->delete('storage/motor/'.$request->gambar2);
            }
         
        
         $data = array('message'=>'success');
        
        // return $data;  

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data); 

    }


    public function getDetail(Request $request)
    {
        $motor = DB::table('tb_motor')
            ->join('tb_merk', 'tb_motor.id_merk', '=', 'tb_merk.id_merk')
            ->join('tb_tipe', 'tb_motor.id_tipe', '=', 'tb_tipe.id_tipe')
            ->join('tb_sales', 'tb_motor.id_user', '=', 'tb_sales.id_user')
            ->select('tb_motor.no_mesin','tb_motor.harga','tb_motor.dp','tb_motor.cicilan','tb_motor.tenor','tb_motor.no_polisi','tb_motor.no_rangka','tb_motor.hjm','tb_motor.kondisi', 'tb_motor.tahun','tb_motor.status','tb_motor.harga_terjual','tb_motor.gambar','tb_motor.gambar1','tb_motor.gambar2', 'tb_merk.nama_merk', 'tb_tipe.nama_tipe','tb_sales.no_wa','tb_motor.subsidi','tb_motor.pencairan_leasing')
            ->where('tb_motor.no_mesin', $request->no_mesin)
            ->first();

        return json_encode(($motor));
    }

    public function getSales(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

        $sales = DB::table('tb_sales')
            ->join('tb_user', 'tb_user.id_user', '=', 'tb_sales.id_user')
            ->select('*')
            ->where('tb_user.status', 0)
            ->get();

        }

        return json_encode($sales);
    }

    public function addSales(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {
            
            $user = new UserModel;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->status = 0;
            $user->save();

            if ($user) {
                $sales = new Sales;
                $sales->no_ktp_sales = $request->no_ktp;
                $sales->id_user = $user->id_user;
                $sales->nama = $request->nama;
                $sales->alamat = $request->alamat;
                $sales->no_wa = $request->no_wa;

                $sales->save();
            }

            $data = array('message'=>'success');
        

        }else{
            $data = array('message'=> 'failed');
        }
        return json_encode($data);

    }

    public function deleteSales(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


  

        $idTransaksi = Transaksi::whereno_ktp_sales($request->no_ktp_sales)
                       ->pluck('id_transaksi');

        $idMotor = Motor::whereid_user($request->id_user)
                       ->pluck('no_mesin');

        $idPendingJual = PendingJual::whereid_user($request->id_user)
                       ->pluck('id_pending');
                       
        $idPendingBeli = PendingBeli::whereid_user($request->id_user)
                       ->pluck('id_pending');
                       
        $ktpOwner =   Sales::whereid_user($request->id_owner)
                       ->pluck('no_ktp_sales');         

        
        $idTransaksi->toArray() ;
        $idMotor->toArray() ;
        $idPendingJual->toArray() ;
        $idPendingBeli->toArray() ;
        $ktpOwner->toArray() ;
        
        //ubah tiap transaksi jadi ktp owner menggunakan for each
      

        foreach ($idTransaksi as $idTransaksiNow) {
        
        $transaksi = Transaksi::find($idTransaksiNow);
        $transaksi->no_ktp_sales = $ktpOwner[0];
        $transaksi->save();
        
        }
        
        //ubah tiap motor jadi id owner menggunakan for each
      
        foreach ($idMotor as $idMotorNow) {
        
        $motor = Motor::find($idMotorNow);
        $motor->id_user = $request->id_owner;
        $motor->save();
        
        }
        
        //ubah tiap pendingJual jadi id owner menggunakan for each
      
        foreach ($idPendingJual as $idPendingJualNow) {
        
        $pendingJual = PendingJual::find($idPendingJualNow);
        $pendingJual->id_user = $request->id_owner;
        $pendingJual->save();
        
        }
        
        //ubah tiap pendingBeli jadi id owner menggunakan for each
      
        foreach ($idPendingBeli as $idPendingBeliNow) {
        
        $pendingBeli = PendingBeli::find($idPendingBeliNow);
        $pendingBeli->id_user = $request->id_owner;
        $pendingBeli->save();
        
        }
        
        //delete sales dari tabel user
        $user = UserModel::where('id_user', $request->id_user)
                        ->delete();
        
        $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }



        return $ktpOwner;
    }

    public function updateSales(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

            $sales = Sales::find($request->no_ktp_lama);
            $sales->nama = $request->nama;
            $sales->no_ktp_sales = $request->no_ktp;
            $sales->alamat = $request->alamat;
            $sales->no_wa = $request->no_wa;
            $sales->save();

            $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);

    }

    public function addMerk(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

             $merk = new Merk;
             $merk->nama_merk = $request->nama_merk;

             $merk->save();

             $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);

    }

     public function deleteMerk(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


        $merk = Merk::where('id_merk', $request->id_merk)
                        ->delete();

        $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);
    }

    public function updateMerk(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

            $merk = Merk::find($request->id_merk_lama);
            
            $merk->nama_merk = $request->nama_merk;
            $merk->save();

            $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);

    }

    public function getTipeMotor()
    {
        $tipe = DB::table('tb_tipe')
            ->join('tb_merk', 'tb_merk.id_merk', '=', 'tb_tipe.id_merk')
            ->select('*')
            ->orderBy('tb_merk.id_merk')
            ->get();

        return json_encode($tipe);
    }

     public function addTipeMotor(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


             $tipe = new Tipe;
             $tipe->id_merk = $request->id_merk;
             $tipe->nama_tipe = $request->nama_tipe;

             $tipe->save();

             $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);

    }

    public function deleteTipeMotor(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


        $tipe = Tipe::where('id_tipe', $request->id_tipe)
                        ->delete();

        $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);
    }

    public function updateTipeMotor(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

            $tipe = Tipe::find($request->id_tipe);
            
            $tipe->nama_tipe = $request->nama_tipe;
            $tipe->id_merk = $request->id_merk;
            
            $tipe->save();

            $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);

    }

    public function getPendingBeli(Request $request)
    {
        
         if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
        
        $Pending = DB::table('tb_pending_beli AS p')
            ->select('p.id_pending', 'p.nama', 'p.alamat','p.no_telp','p.tahun','p.harga','m.nama_merk','m.id_merk','t.nama_tipe','t.id_tipe','p.tanggal_beli')
            ->join('tb_merk AS m', 'p.id_merk', '=', 'm.id_merk')
            ->join('tb_tipe AS t', 'p.id_tipe', '=', 't.id_tipe')
            ->where('p.id_user',$equalUser,$user)
            ->orderBy('created_at','DESC')
            ->get();

            return json_encode($Pending);
    }


    public function getPendingJual(Request $request)
    {
          if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
        
        $Pending = DB::table('tb_pending_jual AS p')
            ->select('p.id_pending', 'p.nama', 'p.alamat','p.no_telp','p.tahun','p.harga','p.no_mesin','p.no_polisi','m.nama_merk','m.id_merk','t.nama_tipe','t.id_tipe','p.tanggal_jual')
            ->join('tb_merk AS m', 'p.id_merk', '=', 'm.id_merk')
            ->join('tb_tipe AS t', 'p.id_tipe', '=', 't.id_tipe')
            ->where('p.id_user',$equalUser,$user)
            ->orderBy('created_at','DESC')
            ->get();

            return json_encode($Pending);
    }

    public function addPendingBeli(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


             $pending = new PendingBeli;
             $pending->id_user = $request->id_user;
             $pending->nama = $request->nama;
             $pending->alamat = $request->alamat;
             $pending->no_telp = $request->telepon;
             $pending->id_merk = $request->id_merk;
             $pending->id_tipe = $request->id_tipe;
             $pending->tahun = $request->tahun;
             $pending->harga = $request->harga;
             $pending->tanggal_beli = $request->tanggal_beli;

             $pending->save();

             $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);
    }

    public function addPendingJual(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


             $pending = new PendingJual;
             $pending->id_user = $request->id_user;
             $pending->nama = $request->nama;
             $pending->alamat = $request->alamat;
             $pending->no_telp = $request->telepon;             
             $pending->id_merk = $request->id_merk;
             $pending->id_tipe = $request->id_tipe;
             $pending->no_mesin = $request->no_mesin;
             $pending->no_polisi = $request->no_polisi;
             $pending->tahun = $request->tahun;
             $pending->harga = $request->harga;
             $pending->tanggal_jual = $request->tanggal_jual;

             $pending->save();

             $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);
    }

    public function deletePendingBeli(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


        $pending = PendingBeli::where('id_pending', $request->id_pending)
                        ->delete();

        $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);
    }

    public function updatePendingBeli(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

            $pending = PendingBeli::find($request->id_pending);
            
             $pending->nama = $request->nama;
             $pending->alamat = $request->alamat;
             $pending->no_telp = $request->telepon;
             $pending->id_merk = $request->id_merk;
             $pending->id_tipe = $request->id_tipe;
             $pending->tahun = $request->tahun;
             $pending->harga = $request->harga;
             $pending->tanggal_beli = $request->tanggal_beli;

             $pending->save();

            $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);

    }

    public function deletePendingJual(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {


        $pending = PendingJual::where('id_pending', $request->id_pending)
                        ->delete();

        $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);
    }

    public function updatePendingJual(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

            $pending = PendingJual::find($request->id);
            
             $pending->nama = $request->nama;
             $pending->alamat = $request->alamat;
             $pending->no_telp = $request->telepon;
             $pending->id_merk = $request->id_merk;
             $pending->id_tipe = $request->id_tipe;
             $pending->no_mesin = $request->no_mesin;
             $pending->no_polisi = $request->no_polisi;
             $pending->tahun = $request->tahun;
             $pending->harga = $request->harga;
             $pending->tanggal_jual = $request->tanggal_jual;

             $pending->save();

            $data = array('message'=>'success');

        }else{
            $data = array('message'=> 'failed');
        }

        return json_encode($data);

    }

    public function getProfile(Request $request)
    {

        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

                $data = DB::table('tb_user')
                ->select('*' )
                ->where('tb_user.id_user', $request->id_user)
                ->join('tb_sales', 'tb_sales.id_user', '=', 'tb_user.id_user')
                ->first();

                $data->message = 'success';

        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);          

    }

    public function editProfile(Request $request)
    {
        
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

            $user = UserModel::find($request->id_user);
            $user->username = $request->username;
            $user->password = $request->password;
            $user->save();

            if ($user) {
                
                $sales = Sales::find($request->no_ktp_sales);
                if ($request->no_ktp!=null) {
                    $sales->no_ktp_sales = $request->no_ktp;
                }

                $sales->nama = $request->nama;
                $sales->alamat = $request->alamat;
                $sales->no_wa = $request->no_wa;
                $sales->save();

            }

            $data = array('message'=>'success');

        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);   
    }

    public function editProfileOwner(Request $request)
    {
        
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

            $sales = Sales::find($request->no_ktp_sales);
            if ($request->no_ktp!=null) {
                $sales->no_ktp_sales = $request->no_ktp;
            }

            $sales->nama = $request->nama;
            $sales->alamat = $request->alamat;
            $sales->no_wa = $request->no_wa;
            $sales->save();

            if ($sales) {
                $status = UbahPassword::find(1);
                $status->username = $request->username;
                $status->password = $request->password;
                $status->status = 1;
                $status->save();
            }

        $data = array('message'=>'success');

        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);   
    }


    public function getCustomerById(Request $request) {

        $customer = Customer::where('no_ktp', $request->no_ktp)->get();
        return json_encode($customer);

    }
    
    public function getCustomer(Request $request) {
        
         if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
        

        $hasil = DB::table('tb_customer AS c')
                    ->select('c.no_ktp','c.nama','c.alamat','c.no_telp','c.ttl',      'c.Agama','c.pekerjaan','c.whatsapp', 
                             'c.instagram','c.facebook','c.jumlah_pembelian')
                    ->join('tb_transaksi as t','c.no_ktp','=','t.no_ktp')
                    ->join('tb_sales as s','t.no_ktp_sales','=', 
                            's.no_ktp_sales' )
                    ->where('s.id_user',$equalUser,$user)
                    ->distinct()
                    ->get();  

        return json_encode($hasil);

    }
    
    

    public function getMotorById(Request $request) {

        $motor = Motor::where('no_mesin', $request->no_mesin)
                        ->where('status',0)
                        ->where('kondisi',0)
                        ->get();
        return json_encode($motor);

    }
    
   

    public function mokasWithNoCust(Request $request)
    {       
        $motor = Motor::find($request->no_mesin);
        $motor->status = 1;
        if ($request->harga_terjual!=null && $request->harga_terjual != 0) {
                $motor->mediator = $request->mediator;
                $motor->harga = $request->harga_terjual ;
                $motor->harga_terjual = $request-> harga_terjual ;
                
                $motor->selisih = $motor->harga_terjual - $motor->hjm - $motor->mediator ;
                
                if ($motor->selisih < 0) 
                {$motor->selisih = 0 ;}
                
                $motor->dp = null ;
                $motor->cicilan = null;
                $motor->tenor = null;
            }else{
                $motor->dp = $request->dp;
                $motor->cicilan = $request->cicilan;
                $motor->tenor = $request->tenor;
                $motor->pencairan_leasing = $request->pencairanLeasing;
                $motor->mediator = $request->mediator ;
                
                $motor->harga = $request->dp + ($request->cicilan * $request->tenor) + $request->pencairanLeasing - $request->mediator;
                
                $motor->harga_terjual = $request->dp + ($request->cicilan * $request->tenor) + $request->pencairanLeasing - $request->mediator;
                
                $motor->selisih = $motor->dp + $request->pencairanLeasing - $motor->hjm - $motor->mediator ;
                
                 if ($motor->selisih < 0) 
                {$motor->selisih = 0 ;}
                
                
            }
            
        $motor->save();

        if ($motor) {
            $customer = Customer::find($request->no_ktp);
            $customer->jumlah_pembelian = $customer->jumlah_pembelian+1;
            $customer->save();

            $transaksi = new Transaksi;
            $transaksi->no_ktp = $request->no_ktp;
            $transaksi->no_ktp_sales = $request->no_ktp_sales;
            
            $dt = new DateTime();
            $dt->format('Y-m-d');
            $transaksi->tanggal = $dt;

            $transaksi->no_mesin = $request->no_mesin;
            $transaksi->save();

            $data = array('message'=>'success');
        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);  

    }

    public function mokasWithCust(Request $request)
    {       
        $motor = Motor::find($request->no_mesin);
        $motor->status = 1;
        
        if ($request->harga_terjual!=null && $request->harga_terjual != 0) {
                $motor->mediator = $request->mediator;
                $motor->harga = $request->harga_terjual ;
                $motor->harga_terjual = $request-> harga_terjual ;
                
                $motor->selisih = $motor->harga_terjual - $motor->hjm - $motor->mediator ;
                
                if ($motor->selisih < 0) 
                {$motor->selisih = 0 ;}
                
                $motor->dp = null ;
                $motor->cicilan = null;
                $motor->tenor = null;
            }else{
                $motor->dp = $request->dp;
                $motor->cicilan = $request->cicilan;
                $motor->tenor = $request->tenor;
                $motor->pencairan_leasing = $request->pencairanLeasing;
                $motor->mediator = $request->mediator ;
                
                $motor->harga = $request->dp + ($request->cicilan * $request->tenor) + $request->pencairanLeasing - $request->mediator;
                
                $motor->harga_terjual = $request->dp + ($request->cicilan * $request->tenor) + $request->pencairanLeasing - $request->mediator;
                
                $motor->selisih = $motor->dp + $request->pencairanLeasing - $motor->hjm - $motor->mediator ;
                
                if ($motor->selisih < 0) 
                {$motor->selisih = 0 ;}
                
            }
            
        $motor->save();

        if ($motor) {
            $customer = new Customer;
            $customer->jumlah_pembelian = 1;
            $customer->no_ktp = $request->no_ktp;
            $customer->nama = $request->nama;
            $customer->alamat = $request->alamat;
            $customer->no_telp = $request->no_telp;
            
            $customer->ttl = $request->ttl;

            $customer->Agama = $request->agama;
            $customer->pekerjaan = $request->pekerjaan;
            $customer->whatsapp = $request->whatsapp;
            $customer->instagram = $request->instagram;
            $customer->facebook = $request->facebook;
            $customer->save();

            $transaksi = new Transaksi;
            $transaksi->no_ktp = $request->no_ktp;
            $transaksi->no_ktp_sales = $request->no_ktp_sales;
            
            $dt = new DateTime();
            $dt->format('Y-m-d');
            $transaksi->tanggal = $dt;

            $transaksi->no_mesin = $request->no_mesin;
            $transaksi->save();

            $data = array('message'=>'success');
        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);  

    }

    public function mobarWithNoCust(Request $request)
    {       
      $motor = new Motor;  
            $motor->no_mesin = $request->no_mesin;
            $motor->no_rangka = $request->no_rangka;
            $motor->tahun = $request->tahun;
            $motor->status = 1 ;
            $motor->kondisi = 1 ;
            $motor->hjm = $request->hjm;
            $motor->id_tipe = $request->id_tipe;
            $motor->id_merk = $request->id_merk;
            $motor->id_user = $request->id_user;
            if ($request->harga_terjual!=null && $request->harga_terjual != 0) {
                $motor->mediator = $request->mediator;
                $motor->harga = $request->harga_terjual - $request->mediator;
                $motor->harga_terjual = $request->harga_terjual - $request->mediator;
            }else{
                $motor->dp = $request->dp;
                $motor->cicilan = $request->cicilan;
                $motor->tenor = $request->tenor;
                $motor->subsidi = $request->subsidi;
                $motor->mediator = $request->mediator;
                
                $motor->harga = $request->dp + ($request->cicilan * $request->tenor) - $request->subsidi - $request->mediator;
                
                $motor->harga_terjual = $request->dp + ($request->cicilan * $request->tenor) - $request->subsidi - $request->mediator;
                
            }

       $motor->save();     


        if ($motor) {
            $customer = Customer::find($request->no_ktp);
            $customer->jumlah_pembelian = $customer->jumlah_pembelian+1;
            $customer->save();

            $transaksi = new Transaksi;
            $transaksi->no_ktp = $request->no_ktp;
            $transaksi->no_ktp_sales = $request->no_ktp_sales;
            
            $dt = new DateTime();
            $dt->format('Y-m-d');
            $transaksi->tanggal = $dt;

            $transaksi->no_mesin = $request->no_mesin;
            $transaksi->save();

            $data = array('message'=>'success');
        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);  

    }
    
    public function mobarWithCust(Request $request)
    {       
      $motor = new Motor;  
            $motor->no_mesin = $request->no_mesin;
            $motor->no_rangka = $request->no_rangka;
            $motor->tahun = $request->tahun;
            $motor->status = 1 ;
            $motor->kondisi = 1 ;
            $motor->hjm = $request->hjm;
            $motor->id_tipe = $request->id_tipe;
            $motor->id_merk = $request->id_merk;
            $motor->id_user = $request->id_user;
         if ($request->harga_terjual!=null && $request->harga_terjual != 0) {
                $motor->mediator = $request->mediator;
                $motor->harga = $request->harga_terjual - $request->mediator;
                $motor->harga_terjual = $request->harga_terjual - $request->mediator;
            }else{
                $motor->dp = $request->dp;
                $motor->cicilan = $request->cicilan;
                $motor->tenor = $request->tenor;
                $motor->subsidi = $request->subsidi;
                $motor->mediator = $request->mediator;
                
                $motor->harga = $request->dp + ($request->cicilan * $request->tenor) - $request->subsidi - $request->mediator;
                
                $motor->harga_terjual = $request->dp + ($request->cicilan * $request->tenor) - $request->subsidi - $request->mediator;
                
            }

       $motor->save();     


        if ($motor) {
            $customer = new Customer;
            $customer->jumlah_pembelian = 1;
            $customer->no_ktp = $request->no_ktp;
            $customer->nama = $request->nama;
            $customer->alamat = $request->alamat;
            $customer->no_telp = $request->no_telp;
            
            $customer->ttl = $request->ttl;

            $customer->Agama = $request->Agama;
            $customer->pekerjaan = $request->pekerjaan;
            $customer->whatsapp = $request->whatsapp;
            $customer->instagram = $request->instagram;
            $customer->facebook = $request->facebook;
            $customer->save();

            $transaksi = new Transaksi;
            $transaksi->no_ktp = $request->no_ktp;
            $transaksi->no_ktp_sales = $request->no_ktp_sales;
            
            $dt = new DateTime();
            $dt->format('Y-m-d');
            $transaksi->tanggal = $dt;

            $transaksi->no_mesin = $request->no_mesin;
            $transaksi->save();

            $data = array('message'=>'success');
        }else{
            $data = array('message'=>'failed');
        }

        return json_encode($data);  

    }
    
    function getTransaksi(Request $request){
     
         if ($request->sales == -1)
         {$equalSales = '<>' ;}
         else
         {$equalSales = '=' ;}
         
         if ($request->kondisi == -1)
         {$equalKondisi = '<>' ;}
         else
         {$equalKondisi = '=' ;}
         
                
         $dari = date($request->dari);
         $ke = date($request->ke);
         
         
         if ($request->caraBayar == -1)
         {
             $transaksi = DB::table('tb_transaksi AS t')
                    ->select('t.tanggal', 't.no_mesin AS nosin', 'm.no_polisi AS nopol', 'c.nama AS pembeli', 's.nama AS sales', 'm.kondisi', 'm.dp','m.pencairan_leasing AS pencairanLeasing','m.subsidi','m.mediator','m.harga_terjual')
                    ->join('tb_motor AS m', 't.no_mesin', '=', 'm.no_mesin')
                    ->join('tb_customer AS c', 't.no_ktp', '=', 'c.no_ktp')
                    ->join('tb_sales AS s', 't.no_ktp_sales', '=', 's.no_ktp_sales')
                    ->whereBetween('t.tanggal',[$dari,$ke])
                    ->where('t.no_ktp_sales',$equalSales,$request->sales)
                    ->where('m.kondisi',$equalKondisi,$request->kondisi)
                    ->get();  
         }
         
         //cash (dp is null)
         else if ($request->caraBayar == 0)
         {
          
                $transaksi = DB::table('tb_transaksi AS t')
                    ->select('t.tanggal', 't.no_mesin AS nosin', 'm.no_polisi AS nopol', 'c.nama AS pembeli', 's.nama AS sales', 'm.kondisi', 'm.dp','m.pencairan_leasing AS pencairanLeasing','m.subsidi','m.mediator','m.harga_terjual')
                    ->join('tb_motor AS m', 't.no_mesin', '=', 'm.no_mesin')
                    ->join('tb_customer AS c', 't.no_ktp', '=', 'c.no_ktp')
                    ->join('tb_sales AS s', 't.no_ktp_sales', '=', 's.no_ktp_sales')
                    ->whereBetween('t.tanggal',[$dari,$ke])
                    ->where('t.no_ktp_sales',$equalSales,$request->sales)
                    ->where('m.kondisi',$equalKondisi,$request->kondisi)
                    ->whereNull('m.dp')
                    ->get();  
             
         }
         
         //kredit
         else
         {
             
                $transaksi = DB::table('tb_transaksi AS t')
                    ->select('t.tanggal', 't.no_mesin AS nosin', 'm.no_polisi AS nopol', 'c.nama AS pembeli', 's.nama AS sales', 'm.kondisi', 'm.dp','m.pencairan_leasing AS pencairanLeasing','m.subsidi','m.mediator','m.harga_terjual')
                    ->join('tb_motor AS m', 't.no_mesin', '=', 'm.no_mesin')
                    ->join('tb_customer AS c', 't.no_ktp', '=', 'c.no_ktp')
                    ->join('tb_sales AS s', 't.no_ktp_sales', '=', 's.no_ktp_sales')
                    ->whereBetween('t.tanggal',[$dari,$ke])
                    ->where('t.no_ktp_sales',$equalSales,$request->sales)
                    ->where('m.kondisi',$equalKondisi,$request->kondisi)
                    ->whereNotNull('m.dp')
                    ->get();  
             
         }
     
        print_r(json_encode($transaksi));
    }
    
    public function searchCustomer(Request $request){
        
         if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
        

        $hasil = DB::table('tb_customer AS c')
                    ->select('c.no_ktp','c.nama','c.alamat','c.no_telp','c.ttl',      'c.Agama','c.pekerjaan','c.whatsapp', 
                             'c.instagram','c.facebook','c.jumlah_pembelian')
                    ->join('tb_transaksi as t','c.no_ktp','=','t.no_ktp')
                    ->join('tb_sales as s','t.no_ktp_sales','=', 
                            's.no_ktp_sales' )
                    ->where('s.id_user',$equalUser,$user)
                    ->where('c.nama', 'like', '%'.$request->nama.'%')
                    ->distinct()
                    ->get();  


        return json_encode($hasil);
    }

    public function searchNoPol(Request $request){
        $motor = DB::table('tb_motor')
                    ->where('no_polisi', 'like', '%'.$request->no_polisi.'%')
                    ->get();

        return json_encode($motor);
    }

    public function searchNoMesin(Request $request){
        $motor = DB::table('tb_motor')
                    ->where('no_mesin', 'like', '%'.$request->no_mesin.'%')
                    ->get();

        return json_encode($motor);
    }
    
    public function getFilterSales(Request $request)
    {
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();
        if ($cekUser!=null) {

        $sales = DB::table('tb_sales')
            ->select('*')
            ->get();

        }

        return json_encode($sales);
    }

    public function getNamaCustomerAndNoTelp(Request $request){
        $hasil = DB::table('tb_motor AS m')
                    ->select('c.nama','c.no_telp')
                    ->join('tb_transaksi AS t', 'm.no_mesin', '=', 't.no_mesin')
                    ->join('tb_customer AS c', 't.no_ktp', '=', 'c.no_ktp')
                    ->where('m.no_mesin','=',$request->no_mesin)
                    ->get();  

        return json_encode($hasil);
    }
    
    public function getFilteredMotor(Request $request){
         
         if ($request->id_user == 1)
         {   
             if ($request->status == -1)
             {$equalStatus = '<>' ;
                 
             }
             else
             {$equalStatus = '=' ;
             }
             $status = $request->status ;
         }
         else
         {$equalStatus = '=' ;
          $status = 0 ;     
         }
        
         
         if ($request->merk == -1)
         {$equalMerk = '<>' ;}
         else
         {$equalMerk = '=' ;}
         
         if ($request->tipe == -1)
         {$equalTipe = '<>' ;}
         else
         {$equalTipe = '=' ;}
         
         if ($request->tahun == -1)
         {$equalTahun = '<>' ;}
         else
         {$equalTahun = '=' ;}
        
        $hasil = DB::table('tb_motor AS m')
                    ->where('m.tahun',$equalTahun,$request->tahun)
                    ->where('m.id_merk',$equalMerk,$request->merk)
                    ->where('m.id_tipe',$equalTipe,$request->tipe)
                    ->where('m.status',$equalStatus,$status)
                    ->get();  

        return json_encode($hasil);
    }
    
    
       public function getFilteredPendingJual(Request $request){
         
         if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
        
         if ($request->merk == -1)
         {$equalMerk = '<>' ;}
         else
         {$equalMerk = '=' ;}
         
         if ($request->tipe == -1)
         {$equalTipe = '<>' ;}
         else
         {$equalTipe = '=' ;}
         
        
        $hasil = DB::table('tb_pending_jual AS p')
                	->select('p.id_pending', 'p.nama', 'p.alamat','p.no_telp','p.tahun','p.harga','m.nama_merk','m.id_merk','t.nama_tipe','t.id_tipe')
		            ->join('tb_merk AS m', 'p.id_merk', '=', 'm.id_merk')
		            ->join('tb_tipe AS t', 'p.id_tipe', '=', 't.id_tipe')
                    ->where('p.id_user',$equalUser,$user)
                    ->where('p.id_merk',$equalMerk,$request->merk)
                    ->where('p.id_tipe',$equalTipe,$request->tipe)
                    ->get();  

        return json_encode($hasil);
    }
    
     public function getFilteredPendingBeli(Request $request){
         
          if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
        
         if ($request->merk == -1)
         {$equalMerk = '<>' ;}
         else
         {$equalMerk = '=' ;}
         
         if ($request->tipe == -1)
         {$equalTipe = '<>' ;}
         else
         {$equalTipe = '=' ;}
         
        
        $hasil = DB::table('tb_pending_beli AS p')
                  	->select('p.id_pending', 'p.nama', 'p.alamat','p.no_telp','p.tahun','p.harga','m.nama_merk','m.id_merk','t.nama_tipe','t.id_tipe')
		            ->join('tb_merk AS m', 'p.id_merk', '=', 'm.id_merk')
		            ->join('tb_tipe AS t', 'p.id_tipe', '=', 't.id_tipe')
                    ->where('p.id_user',$equalUser,$user)
                    ->where('p.id_merk',$equalMerk,$request->merk)
                    ->where('p.id_tipe',$equalTipe,$request->tipe)
                    ->get();  

        return json_encode($hasil);
    }
    
    public function searchPendingBeli(Request $request)
    {
         if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
         
    	$motor = DB::table('tb_pending_beli AS p')
    				->select('p.id_pending', 'p.nama', 'p.alamat','p.no_telp','p.tahun','p.harga','m.nama_merk','m.id_merk','t.nama_tipe','t.id_tipe')
		            ->join('tb_merk AS m', 'p.id_merk', '=', 'm.id_merk')
		            ->join('tb_tipe AS t', 'p.id_tipe', '=', 't.id_tipe')
		            ->where('p.id_user',$equalUser,$user)
                    ->where('nama', 'like', '%'.$request->nama.'%')
                    ->get();

        return json_encode($motor);
    }

    public function searchPendingJual(Request $request)
    {      
        if ($request->id_user == 1)
         {$equalUser = '<>' ;
          $user = -1 ;     
         }
         else
         {$equalUser = '=' ;
          $user = $request->id_user ;     
         }
         
    	$motor = DB::table('tb_pending_jual AS p')
			    ->select('p.id_pending', 'p.nama', 'p.alamat','p.no_telp','p.tahun','p.harga','p.no_mesin','p.no_polisi','m.nama_merk','m.id_merk','t.nama_tipe','t.id_tipe')
	            ->join('tb_merk AS m', 'p.id_merk', '=', 'm.id_merk')
	            ->join('tb_tipe AS t', 'p.id_tipe', '=', 't.id_tipe')
	            ->where('p.id_user',$equalUser,$user)
                ->where('nama', 'like', '%'.$request->nama.'%')
                ->get();

        return json_encode($motor);
    }
    
    public function updateCustomer(Request $request){
        $customer = Customer::find($request->no_ktp);
        
        $customer->no_telp = $request->no_telp;    
        $customer->whatsapp = $request->wa;
        $customer->instagram = $request->ig;
        $customer->facebook = $request->fb;
        $customer->save();
        $data = array('message'=>'success');

        return json_encode($data);
    }
    
    public function motorValidate(Request $request) {

        $motor = Motor::find($request->no_mesin) ;
                        
        
        if ($motor != null) {
            //motor ada berati bila dia sold out rubah status menjadi available dan masukkan nomor sales, bila dia available munculkan pesan sudah ada
            
            //if motor available
            if ($motor->status == 0)
            {   $motor = new Motor() ;
                $motor->no_mesin = 0 ;
            }   
            else {
               
            }
            
        }
        else 
            {//motor tidak ada berati lanjut add motor
                $motor = new Motor() ;
                $motor->no_mesin = 1 ;   }
   
        
        return json_encode($motor);

    }
    
    public function searchTipe(Request $request){
        $motor = DB::table('tb_tipe')
    				->select('*')
		            ->join('tb_merk', 'tb_merk.id_merk', '=', 'tb_tipe.id_merk')
                    ->where('nama_tipe', 'like', '%'.$request->nama_tipe.'%')
                    ->get();

        return json_encode($motor);
    }
    
      public function getKonfigInsentif(Request $request)
    {
        
        $konfig = KonfigInsentif::where('id', 1)
                    ->get();

        return json_encode($konfig);
    }
    
      public function updateKonfigInsentif(Request $request){
        
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();

         if ($cekUser!=null)
        
        {$konfig = KonfigInsentif::find(1);
        
        $konfig->persentase = $request->persen;    
        $konfig->insentif_mobar = $request->insentif_mobar;
        $konfig->insentif_mokas15 = $request->lima;
        $konfig->insentif_mokas610 = $request->sepuluh;
        $konfig->insentif_mokas1115 = $request->limaBelas;
        $konfig->insentif_mokas1620 = $request->duaPuluh;
        $konfig->insentif_mokas21 = $request->duaSatu;
        
        $konfig->save();
        $data = array('message'=>'success');
        
        }else{
            $data = array('message'=>'failed');
        }
      

        return json_encode($data);
    }
    
       public function getJumlahMobarInsentif(Request $request)
    {
        
        $id = $request->id ;
        $dari = date($request->dari);
        $hingga = date($request->hingga);
        
        $jumlah =   DB::table('tb_transaksi AS t')
                    ->select('*')
                    ->join('tb_sales AS s', 't.no_ktp_sales', '=', 's.no_ktp_sales')
                    ->join('tb_motor AS m', 't.no_mesin', '=', 'm.no_mesin')
                    ->whereBetween('t.tanggal',[$dari,$hingga])
                    ->where('m.kondisi',1)
                    ->where('s.id_user',$id)
                    ->count();  

        return $jumlah;
    }


        public function getJumlahMokasInsentif(Request $request)
    {
        
        $id = $request->id ;
        $dari = date($request->dari);
        $hingga = date($request->hingga);
        
        $jumlah =   DB::table('tb_transaksi AS t')
                    ->select('*')
                    ->join('tb_sales AS s', 't.no_ktp_sales', '=', 's.no_ktp_sales')
                    ->join('tb_motor AS m', 't.no_mesin', '=', 'm.no_mesin')
                    ->whereBetween('t.tanggal',[$dari,$hingga])
                    ->where('m.kondisi',0)
                    ->where('s.id_user',$id)
                    ->count();  

        return $jumlah;
    }
    
        public function getLain(Request $request)
    {
        
        $mentah = DB::table('tb_sales')
    				->select('lain')
                    ->where('id_user', $request->id)
                    ->get();
                    
        json_encode($mentah);
        json_decode($mentah,true) ;
        
        $hasil = $mentah[0]->lain ;
                    

        return $hasil;
    }
    
         public function getPersentaseMobar(Request $request)
    {
        
        $mentah = DB::table('tb_sales')
    				->select('persentase_mobar')
                    ->where('id_user', $request->id)
                    ->get();
                    
        json_encode($mentah);
        json_decode($mentah,true) ;
        
        $hasil = $mentah[0]->persentase_mobar ;
                    

        return $hasil;
    }
    
       public function updateLain(Request $request){
        
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();

         if ($cekUser!=null)
        
        {$sales = Sales::find($request->ktp);
        $sales->lain = $request->lain;    
        $sales->save();
        $data = array('message'=>'success');
        }else{
            $data = array('message'=>'failed');
        }
      

        return json_encode($data);
    }
    
     public function updatePersentaseMobar(Request $request){
        
        $header = $request->header('Authorization');
        $cekUser = UserModel::where('AccesToken', $header)
                            ->first();

         if ($cekUser!=null)
        
        {$sales = Sales::find($request->ktp);
        $sales->persentase_mobar = $request->persentase_mobar;    
        $sales->save();
        $data = array('message'=>'success');
        }else{
            $data = array('message'=>'failed');
        }
      

        return json_encode($data);
    }
    
    
        public function getPersentaseMokas(Request $request)
    {
        
        $id = $request->id ;
        $dari = date($request->dari);
        $hingga = date($request->hingga);
        
        $jumlah =   DB::table('tb_transaksi AS t')
                    ->select('*')
                    ->join('tb_sales AS s', 't.no_ktp_sales', '=', 's.no_ktp_sales')
                    ->join('tb_motor AS m', 't.no_mesin', '=', 'm.no_mesin')
                    ->whereBetween('t.tanggal',[$dari,$hingga])
                    ->where('m.kondisi',0)
                    ->where('s.id_user',$id)
                    ->sum('selisih');  

        return $jumlah;
    }
    
    
    public function getHjmMotor(Request $request){
        
        $hasil = DB::table('tb_motor AS m')
                    ->whereNull('hjm')
                    ->get();

        return json_encode($hasil);
    }
}
