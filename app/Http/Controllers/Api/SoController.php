<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Viewjadwalsales;
use App\Models\Viewbarang;
use App\Models\Accesstoken;
use App\Models\Soheader;
use App\Models\Vieworder;
use App\Models\Sodetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class SoController extends BaseController
{
    public function create(Request $request,$tahun=null)
    {
        try {
            error_reporting(0);
            $auth = $request->user(); 
            $rules = [];
            $messages = [];
            
            $rules['KD_Barang']= 'required';
            $messages['KD_Barang.required']= 'Pilih Barang';

            $rules['qty']= 'required';
            $messages['qty.required']= 'Pilih Jumlah';

            $rules['NoU']= 'required';
            $messages['NoU.required']= 'Pilih KD_Customer';
            
        
            $validator = Validator::make($request->all(), $rules, $messages);
            $val=$validator->Errors();


            if ($validator->fails()) {
                    $error="";
                    foreach(parsing_validator($val) as $value){
                        
                        foreach($value as $isi){
                            $error.=$isi."\n";
                        }
                    }
                    return $this->sendResponseerror($error);
            }else{
                
                $barang=Viewbarang::where('KD_Barang',$request->KD_Barang)->firstOrfail();
                $terms=Viewjadwalsales::where('NoU',$request->NoU)->first();
                $customer=Customer::where('KD_Customer',$terms->KD_Customer)->first();
                $cek=Soheader::where('KD_Customer',$terms->KD_Customer)->where('status_data',0)->count();
                if($cek>0){
                    $mst=Soheader::where('KD_Customer',$terms->KD_Customer)->where('status_data',0)->firstOrfail();
                    $KD_Transaksi=$mst->KD_Transaksi;
                }else{
                    $KD_Transaksi=penomoran_so();
                }
                $save=Soheader::UpdateOrcreate([
                    'KD_Customer'=>$terms->KD_Customer,
                    'tanggal'=>date('Y-m-d'),
                    
                    'status_data'=>0,
                ],[
                    'KD_Salesman'=>$auth->username,
                    'KD_Transaksi'=>$KD_Transaksi,
                    'Jatuh_Tempo'=>tanggal_tempo('+'.$terms->Term),
                    'Term'=>$terms->Term,
                    'kd_divisi'=>$terms->kd_divisi,
                    'Customer'=>$customer->Perusahaan,
                    'Customer'=>$customer->Perusahaan,
                    'waktu'=>date('Y-m-d H:i:s'),
                ]);

                if($request->qty_free==null || $request->qty_free=='0'){
                    $Qtyfree=0;
                }else{
                    $Qtyfree=$request->qty_free;
                }
                if($request->discon==null || $request->discon=='0'){
                    $discon=0;
                }else{
                    $discon=$request->discon;
                }
                $harga=($barang['harga_ke4']-$discon);
                $save2=Sodetail::UpdateOrcreate([
                    'NoU'=>$request->NoU,
                    'KD_Barang'=>$request->KD_Barang,
                    'kd_transaksi'=>$KD_Transaksi,
                ],[
                    'qty'.$barang->hargamunculsatuanke=>$request->qty,
                    'Disc'.$barang->hargamunculsatuanke=>$request->discon,
                    'Satuan'=>$request->Satuan,
                    'Harga_Satuan'=>$harga,
                    'Qty'=>$request->qty,
                    'Qtyfree'=>$Qtyfree,
                    'total'=>($harga*$request->qty),
                ]);
                $success=true;
                return $this->sendResponse($success, 'success');
            }
        } catch (\Throwable $th) {
            return $this->sendResponseerror($th->getMessage(), $th->getCode());
        }
        
    }

    public function keranjang(Request $request)
    {
        $akses = $request->user(); 
        if($request->page==""){
            $page=1;
        }else{
            $page=$request->page;
        }
        
        $query=Vieworder::query();
        $get=$query->where('NoU',$request->NoU)->orderBy('id','Asc')->paginate(20);
        $cek=$query->count();
        
        $col=[];
        foreach($get as $o){
           $sub=[];
                $cl=[];
                $cl['KD_Barang'] =$o->KD_Barang;
                $cl['Nama_Barang'] = $o->Nama_Barang;
                $cl['Nama_Divisi'] = $o->Nama_Divisi;
                $cl['Satuan_aktif'] = $o->hargamunculsatuanke;
                $cl['Satuan'] = $o['Satuan'.$o->hargamunculsatuanke];
                $cl['harga'] = no_decimal($o['harga_ke'.$o->hargamunculsatuanke]);
                $cl['Satuan1'] = $o->Satuan1;
                $cl['Satuan2'] = $o->Satuan2;
                $cl['Satuan3'] = $o->Satuan3;
                $cl['Satuan4'] = $o->Satuan4;
                
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