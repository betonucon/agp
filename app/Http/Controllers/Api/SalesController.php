<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Barang;
use App\Models\Viewjadwalsales;
use App\Models\Viewtagihan;
use App\Models\Viewjalursales;
use App\Models\Accesstoken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class SalesController extends BaseController
{
    public function jalur_sales(Request $request,$tahun=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $query=Viewjalursales::query();
        $get=$query->where('KD_Salesman',$akses->username)->whereDate('tgl_register',date('Y-m-d'))->orderBy('tgl_register','Desc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['nama_jalur_pengiriman'] =$o->Nama_JalurPengiriman;
                $cl['kd_jalurpengiriman'] = $o->kd_jalurpengiriman;
                $cl['kd_salesman'] = $o->KD_Salesman;
                $cl['total_toko'] = $o->total;
                $cl['tanggal'] = tanggal_indo($o->tgl_register);
                $cl['tanggal_db'] = tanggal_indo_only($o->tgl_register);
                
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

    public function jalur_sales_riwayat(Request $request,$tahun=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $gg1=prev_tanggal(date('Y-m-d'),'-1');
        $gg2=prev_tanggal(date('Y-m-d'),'-8');
        $query=Viewjalursales::query();
        $get=$query->where('KD_Salesman',$akses->username)->where('tgl_register','<',$gg2)->orderBy('tgl_register','Desc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['nama_jalur_pengiriman'] =$o->Nama_JalurPengiriman;
                $cl['kd_jalurpengiriman'] = $o->kd_jalurpengiriman;
                $cl['total_toko'] = $o->total;
                $cl['kd_salesman'] = $o->KD_Salesman;
                $cl['tanggal'] = tanggal_indo($o->tgl_register);
                $cl['tanggal_db'] = tanggal_indo_only($o->tgl_register);
                
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

    public function jalur_sales_prev(Request $request,$tahun=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $gg1=prev_tanggal(date('Y-m-d'),'-1');
        $gg2=prev_tanggal(date('Y-m-d'),'-7');
        $query=Viewjalursales::query();
        $get=$query->where('KD_Salesman',$akses->username)->whereBetween('tgl_register',[$gg2,$gg1])->orderBy('tgl_register','Desc')->paginate(20);
        $cek=$query->count();
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['nama_jalur_pengiriman'] =$o->Nama_JalurPengiriman;
                $cl['kd_jalurpengiriman'] = $o->kd_jalurpengiriman;
                $cl['total_toko'] = $o->total;
                $cl['kd_salesman'] = $o->KD_Salesman;
                $cl['tanggal'] = tanggal_indo($o->tgl_register);
                $cl['tanggal_db'] = tanggal_indo_only($o->tgl_register);
                
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

    public function jadwal_sales(Request $request,$kd_jalurpengiriman=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        
        $query=Viewjadwalsales::query();
        // if($request->Nama_Barang!=""){
        //     $get=$query->where('Nama_Barang',$request->Nama_Barang);
        // }
        $get=$query->where('KD_Salesman',$akses->username)->where('kd_jalurpengiriman',$kd_jalurpengiriman)->whereDate('tgl_register',$request->tanggal)->orderBy('tgl_register','Desc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['Perusahaan'] =$o->Perusahaan;
                $cl['NoU'] = $o->NoU;
                $cl['Alamat'] = $o->Alamat;
                $cl['status_absen'] = $o->status_absen;
                $cl['Tempo'] = $o->Term;
                $cl['Telepon'] = $o->Telepon1;
                $cl['KD_Customer'] = $o->KD_Customer;
                $cl['Nama_Kunjungan'] = $o->Nama_Kunjungan;
                $cl['limit'] = no_decimal($o->Limit_Value);
                $cl['limit_uang'] = uang($o->Limit_Value);
                $cl['Tanggal'] = tanggal_indo($o->tgl_register);
                
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

    public function jadwal_sales_prev(Request $request,$kd_jalurpengiriman=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $gg1=prev_tanggal(date('Y-m-d'),'-1');
        $gg2=prev_tanggal(date('Y-m-d'),'-7');
        $query=Viewjadwalsales::query();
        $get=$query->where('KD_Salesman',$akses->username)->where('kd_jalurpengiriman',$kd_jalurpengiriman)->whereBetween('tgl_register',[$gg2,$gg1])->orderBy('tgl_register','Desc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['Perusahaan'] =$o->Perusahaan;
                $cl['Alamat'] = $o->Alamat;
                $cl['NoU'] = $o->NoU;
                $cl['status_absen'] = $o->status_absen;
                $cl['Tempo'] = $o->Term;
                $cl['Telepon'] = $o->Telepon1;
                $cl['KD_Customer'] = $o->KD_Customer;
                $cl['Nama_Kunjungan'] = $o->Nama_Kunjungan;
                $cl['limit'] = no_decimal($o->Limit_Value);
                $cl['limit_uang'] = uang($o->Limit_Value);
                $cl['Tanggal'] = tanggal_indo($o->tgl_register);
                
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }
    public function jadwal_sales_riwayat(Request $request,$tahun=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $gg1=prev_tanggal(date('Y-m-d'),'-1');
        $gg2=prev_tanggal(date('Y-m-d'),'-8');
        $query=Viewjadwalsales::query();
        $get=$query->where('KD_Salesman',$akses->username)->where('tgl_register','<',$gg2)->orderBy('tgl_register','Desc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['Perusahaan'] =$o->Perusahaan;
                $cl['NoU'] = $o->NoU;
                $cl['status_absen'] = $o->status_absen;
                $cl['Alamat'] = $o->Alamat;
                $cl['Tempo'] = $o->Term;
                $cl['Telepon'] = $o->Telepon1;
                $cl['KD_Customer'] = $o->KD_Customer;
                $cl['Nama_Kunjungan'] = $o->Nama_Kunjungan;
                $cl['limit'] = no_decimal($o->Limit_Value);
                $cl['limit_uang'] = uang($o->Limit_Value);
                $cl['Tanggal'] = tanggal_indo($o->tgl_register);
                
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

    public function absen(Request $request)
    {
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['NoU']= 'required';
        $messages['NoU.required']= 'Lengkapi kolom NoU';

        $rules['lat']= 'required';
        $messages['lat.required']= 'Lengkapi kolom lat';
        
        $rules['lon']= 'required';
        $messages['lon.required']= 'Lengkapi kolom lon';

        $rules['foto']= 'required';
        $messages['foto.required']= 'Lengkapi foto';
        
       
        $validator = Validator::make($request->all(), $rules, $messages);
        $val=$validator->Errors();


        if ($validator->fails()) {
            echo'<div class="nitof"><b>Oops Error !</b><br><div class="isi-nitof">';
                foreach(parsing_validator($val) as $value){
                    
                    foreach($value as $isi){
                        echo'-&nbsp;'.$isi.'<br>';
                    }
                }
            echo'</div></div>';
        }else{

        }
    }

    public function tagihan(Request $request)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $gg1=prev_tanggal(date('Y-m-d'),'-1');
        $gg2=prev_tanggal(date('Y-m-d'),'-8');
        $query=Viewtagihan::query();
        $get=$query->where('KD_Salesman',$akses->username)->where('KD_Customer',$request->KD_Customer)->whereDate('Due_Date',$request->tanggal)->orderBy('Due_Date','Desc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['Tgl_Transaksi'] =tanggal_indo($o->Tgl_Transaksi);
                $cl['KD_Customer'] = $o->KD_Customer;
                $cl['Perusahaan'] = $o->Perusahaan;
                $cl['KD_Salesman_order'] = $o->KD_Salesman_order;
                $cl['Due_Date'] = tanggal_indo($o->Due_Date);
                $cl['KD_Salesman'] = $o->KD_Salesman;
                $cl['Jml_Tagihan'] = no_decimal($o->Jml_Tagihan);
                $cl['Jml_Sisa'] = no_decimal($o->Jml_Sisa);
                $cl['jumlahtagih'] = no_decimal($o->jumlahtagih);
                
                $sub=$cl;  
                
            $col[]=$sub;
        }
        $success['total_page'] =  ceil($cek/10);
        $success['total_item'] =  $cek;
        $success['current_page'] =  $page;
        $success['result'] =  $col;
        
        

        return $this->sendResponse($success, 'success');
    }

    

}