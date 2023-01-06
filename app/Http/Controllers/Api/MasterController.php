<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kota;
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

}