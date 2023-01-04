<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Validator;
use App\Models\Sales;
use App\Models\Viewsales;
use App\Models\User;

class SalesController extends Controller
{
    
    public function index(request $request)
    {
        error_reporting(0);
        $template='top';
        
        return view('sales.index',compact('template'));
    }
    public function view_data(request $request)
    {
        error_reporting(0);
        $template='top';
        $id=decoder($request->kd);
        
        $data=Sales::where('KD_Salesman',$id)->first();
        if($id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('sales.view_data',compact('template','data','disabled','id'));
    }
    public function modal(request $request)
    {
        error_reporting(0);
        $template='top';
        $data=Supplier::find($request->id);
        $id=$request->id;
        if($request->id==0){
            $disabled='';
        }else{
            $disabled='readonly';
        }
        return view('supplier.modal',compact('template','data','disabled','id'));
    }

    

    public function get_data(request $request)
    {
        error_reporting(0);
        $query = Viewsales::query();
        if($request->KD_GroupSales!=""){
            $data = $query->where('KD_GroupSales',$request->KD_GroupSales);
        }
        $data = $query->orderBy('active_status','Asc')->get();

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
                            <li><a href="javascript:;" onclick="location.assign(`'.url('sales/view').'?kd='.encoder($row->KD_Salesman).'`)">View</a></li>';
                            if($row->active_status==1){
                                $btn.='<li><a href="javascript:;" onclick="tutup_user(`'.$row->KD_Salesman.'`)">Close Akun</a></li>';
                            }else{
                                if($row->active_status==2){
                                    $btn.='<li><a href="javascript:;" onclick="open_user(`'.$row->KD_Salesman.'`)">Open Akun</a></li>';
                                }else{
                                    $btn.='<li><a href="javascript:;" onclick="buat_user(`'.$row->KD_Salesman.'`)">Create Akun</a></li>'; 
                                }
                            }
                            
                            $btn.='
                            <li><a href="javascript:;">Delete</a></li>
                        </ul>
                    </div>
                ';
                return $btn;
            })
            
            ->rawColumns(['action'])
            ->make(true);
    }
    

    public function buat_user(request $request){
        $sales=Sales::where('KD_Salesman',$request->KD_Salesman)->first();
        $data = User::UpdateOrcreate([
            'username'=>$request->KD_Salesman,
        ],[
            'name'=>$sales->Nama,
            'email'=>$request->KD_Salesman.'@gmail.com',
            'password'=>Hash::make('agp123'),
            'role_id'=>3,
            'active_status'=>1,
        ]);
    }
    public function tutup_user(request $request){
        $data = User::where('username',$request->KD_Salesman)->where('role_id',3)->update([
            'active_status'=>2
        ]);
    }
    public function open_user(request $request){
        $data = User::where('username',$request->KD_Salesman)->where('role_id',3)->update([
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
