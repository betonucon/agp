<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\Mobilecustomer;
use App\Models\Viewmobilecustomer;
use App\Models\User;

class CustomermobileController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('customer-mobile.index',compact('template'));
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->kd);
        
        $data=Mobilecustomer::where('kode_customer',$id)->first();
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('customer-mobile.view_data',compact('template','data','disabled','id'));
    }
    

    

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = Viewmobilecustomer::query();
        if($request->Kd_Propinsi!=""){
            $data = $query->where('Kd_Propinsi',$request->Kd_Propinsi);
        }
        $data = $query->orderBy('kode_customer','Asc')->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('akun', function ($row) {
                if($row->active_status==1){
                    $btn='Aktive';
                }else{
                    if($row->active_status=='2'){
                        $btn='Block';
                    }else{
                        $btn='No'; 
                    }
                }
                
                
                return $btn;
            })
            ->addColumn('action', function ($row) {
                $btn='
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                         <i class="fa fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="javascript:;" onclick="location.assign(`'.url('customermobile/view').'?kd='.encoder($row->kode_customer).'`)">View</a></li>';
                            if($row->active_status==1){
                                $btn.='<li><a href="javascript:;" onclick="tutup_user(`'.$row->users_id.'`)">Close Akun</a></li>';
                            }else{
                                
                                    $btn.='<li><a href="javascript:;" onclick="open_user(`'.$row->users_id.'`)">Open Akun</a></li>';
                                
                            }
                            
                            $btn.='
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    

    public function delete_data(request $request){
        $data = Supplier::where('id',$request->id)->delete();
    }

    public function tutup_user(request $request){
        $data = User::where('id',$request->users_id)->where('role_id',4)->update([
            'active_status'=>2
        ]);
    }
    public function open_user(request $request){
        $data = User::where('id',$request->users_id)->where('role_id',4)->update([
            'active_status'=>1
        ]);
    }
   
    public function store(request $request){
        error_reporting(0);
        $rules = [];
        $messages = [];
        
        $rules['supplier']= 'required';
        $messages['supplier.required']= 'Lengkapi kolom supplier';
        
        $rules['no_telepon']= 'required';
        $messages['no_telepon.required']= 'Lengkapi kolom nomor telepon';
        
       
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
            if($request->id==0){
               
                    $data=Supplier::create([
                        
                        'supplier'=>$request->supplier,
                        'no_telepon'=>$request->no_telepon,
                    ]);

                    echo'@ok';
                
                
            }else{
                $data=Supplier::UpdateOrcreate([
                    'id'=>$request->id,
                ],
                [
                    'supplier'=>$request->supplier,
                    'no_telepon'=>$request->no_telepon,
                ]);

                echo'@ok';
            }
        }
    }
}
