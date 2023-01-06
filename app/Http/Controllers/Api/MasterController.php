<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Mdivisi;
use App\Models\Accesstoken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class MasterController extends BaseController
{
    public function provinsi(request $request)
    {
        
        $query=Provinsi::query();
        if($request->Nama_Propinsi!=""){
            $get=$query->where('Nama_Propinsi',$request->Nama_Propinsi);
        }
        $get=$query->where('Editke',1)->orderBy('Nama_Propinsi','Asc')->get();
        $cek=$query->count();
        
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['Kd_Propinsi'] =$o->Kd_Propinsi;
                $suc['Nama_Propinsi'] = $o->Nama_Propinsi;
            $success[]=$suc;    
        }
        
        
        

        return $this->sendResponse($success, 'success');
    }

    public function kota(request $request,$Kd_Propinsi=null)
    {
        
        $query=Kota::query();
        $get=$query->where('kd_propinsi',$Kd_Propinsi);
        $get=$query->orderBy('Nama_Kabupaten','Asc')->paginate(20);
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['Kd_Kabupaten'] =$o->Kd_Kabupaten;
                $suc['Nama_Kabupaten'] = $o->Nama_Kabupaten;
            $success[]=$suc;    
        }
        

        return $this->sendResponse($success, 'success');
    }

    public function kategori_produk(request $request)
    {
        
        $query=Mdivisi::query();
        $get=$query->whereIn('KD_Divisi',array('ATK','NP','PL'));
        $get=$query->orderBy('KD_Divisi','Asc')->get();
        $success=[];
        foreach($get as $o){
            $suc=[];
                $suc['KD_Divisi'] =$o->KD_Divisi;
                $suc['kategori_produk'] = $o->Nama_Divisi;
                $suc['icon'] = url_plug().'/img/'.$o->icon;
            $success[]=$suc;    
        }
        

        return $this->sendResponse($success, 'success');
    }

}