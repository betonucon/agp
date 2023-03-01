<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\Viewabsen;
use App\Models\Fotobarang;
use App\Models\Barang;
use App\Models\User;

class AbsenController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('absen.index',compact('template'));
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->kd);
        
        $data=Viewbarang::where('KD_Barang',$id)->first();
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('barang.view_data',compact('template','data','disabled','id'));
    }
    public function modal_foto(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Fotobarang::where('KD_Barang',$request->KD_Barang)->get();
        
        return view('barang.modal_foto',compact('data'));
    }

    

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = Viewabsen::query();
        if($request->tanggal!=""){
            $data = $query->whereDate('created_at',$request->tanggal);
        }
        $data = $query->orderBy('created_at','Desc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            
            ->addColumn('action', function ($row) {
                $btn='
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                         <i class="fa fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" onclick="lihat_data('.$row->id.',`'.$row->lat.'`,`'.$row->lon.'`,`'.$row->KD_Salesman.'`,`'.$row->nama_salesman.'`,`'.$row->Perusahaan.'`,`'.$row->foto.'`,`'.$row->created_at.'`)">View</a></li>
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    

    public function hapus_foto(request $request){
        $data = Fotobarang::where('id',$request->id)->delete();
    }
    public function aktif_foto(request $request){
        $mst = Fotobarang::where('id',$request->id)->first();
        $upd = Fotobarang::where('KD_Barang',$mst->KD_Barang)->update([
            'sts'=>0
        ]);
        $thb = Fotobarang::where('id',$request->id)->update([
            'sts'=>1
        ]);
    }

    
   
    public function upload(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['KD_Barang']= 'required';
        $messages['KD_Barang.required']= 'Pilih KD_Barang';

        $rules['foto']= 'required|mimes:jpg,png,jpeg,gif';
        $messages['foto.required']= 'Pilih foto';
        $messages['foto.mimes']= 'Format yang diterima (pg,png,jpeg,gif)';
        
       
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
            $thumbnail = $request->foto;
            $thumbnailFileName =$request->KD_Barang.date('ymdhis').'.'.$thumbnail->getClientOriginalExtension();
            $thumbnailPath =$thumbnailFileName;

            $file =\Storage::disk('public_uploads');
            if($file->put($thumbnailPath, file_get_contents($thumbnail))){
                if(cont_fotobarang($request->KD_Barang)==0){
                    $sts=1;
                }else{
                    $sts=0;
                }
                $data=Fotobarang::create([
                    
                    'KD_Barang'=>$request->KD_Barang,
                    'foto'=>$thumbnailPath,
                    'sts'=>$sts,
                    
                ]);

                echo'@ok';
            }
           
        }
    }
}
