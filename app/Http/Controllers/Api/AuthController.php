<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\Accesstoken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    
    public function login(Request $request)
    {
        error_reporting(0);
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $hapus=Accesstoken::where('tokenable_id',$user->id)->delete();
            
                if($user->active_status==1){

                    $berier=$user->createToken('MyApp')->plainTextToken;
                    $token=explode('|',$berier);
                    // $success['token'] =  $berier; 
                    $success['token'] =  $berier; 
                    $success['name'] =  $user->name;
                    
                    return $this->sendResponse($success, 'User login successfully.');
                }else{
                    if($user->active_status==2){
                        $error='Menunggu Approval admin';
                        return $this->sendResponseerror($error);
                    }else{
                        $error='Akun anda telah dibekukan';
                        return $this->sendResponseerror($error);
                    }
                }
            
            
        } 
        else{ 
            $error='Email atau password anda salah';
            return $this->sendResponseerror($error);
        } 
    }

    public function cek_login(Request $request)
    {
        error_reporting(0);
        if(Auth::attempt(['email' => $request->username, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $cek=Accesstoken::where('tokenable_id',$user->id)->count();
            if($cek>0){
                $success=false;
                return $this->sendResponselogin($success);
                
            }else{
                $success=true;
                return $this->sendResponselogin($success);
            }
            
        } 
        else{ 
            $success=true;
            return $this->sendResponselogin($success);
        } 
    }

    public function fcm_token(Request $request)
    {
        $akses = $request->user(); 
        $token=explode('|',$request->bearerToken());
        $cek=Accesstoken::where('tokenable_id',$akses->id)->where('id','!=',$token[0])->where('token_device',$request->token)->update([
            'active_status'=>0,
            'token_device'=>null,
        ]);
        $hapus=Accesstoken::where('tokenable_id','!=',$akses->id)->where('token_device',$request->token)->delete();
        $update=Accesstoken::where('id',$token[0])->update([
            'token_device'=>$request->token,
            'active_status'=>1,
            'customer_code'=>$akses->cust_id,
        ]);
        $delete=Accesstoken::where('id','!=',$token[0])->where('token_device',$request->token)->delete();
        $success=[];
        return $this->sendResponse($success, 'success');
    }

    public function logout(Request $request)
    {
        $akses = $request->user(); 
        $token=explode('|',$request->bearerToken());
        $hapus=Accesstoken::where('tokenable_id',$akses->id)->delete();
        $success=[];
        return $this->sendResponse($success, 'success');
    }
}