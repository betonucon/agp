<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Barang;
use App\Models\Viewbarang;
use App\Models\Accesstoken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class ProdukController extends BaseController
{
    public function index(Request $request,$tahun=null)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        $query=Viewbarang::query();

        $get=$query->orderBy('Nama_Barang','Asc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['KD_Barang'] =$o->KD_Barang;
                $cl['Nama_Barang'] = $o->Nama_Barang;
                $cl['Nama_Divisi'] = $o->Nama_Divisi;
                if($o->thumbnail!=null){
                    $cl['thumbnail'] = url_plug().'/_file_foto/'.$o->thumbnail;
                }else{
                    $cl['thumbnail'] = url_plug().'/_file_foto/example.png';
                }
                $foto=[];
                    if($o->jumlah_foto>0){
                        foreach(get_fotobarang($o->KD_Barang) as $no=>$ft){
                            $subfoto['foto']=url_plug().'/_file_foto/'.$ft->foto;
                            $foto[]=$subfoto;
                        }
                    }else{
                        $subfoto['foto']=url_plug().'/_file_foto/example.png';
                        $foto[]=$subfoto;
                    }
                    
                $cl['detail_foto'] = $foto;
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