<?php

function get_kdjenis(){
    $data=App\Models\Barang::select('kd_divisi')->groupBy('kd_divisi')->get();
    return $data;
}
function get_divisi(){
    $data=App\Models\Mdivisi::orderBy('KD_Divisi','Asc')->get();
    return $data;
}
function get_provinsi(){
    $data=App\Models\Provinsi::where('Editke',1)->orderBy('Nama_Propinsi','Asc')->get();
    return $data;
}
function get_sales(){
    $data=App\Models\Viewsales::orderBy('KD_Salesman','Asc')->get();
    return $data;
}
function get_statusapprove(){
    $data=App\Models\Statusapprove::orderBy('id','Asc')->get();
    return $data;
}
function get_Kota(){
    $data=App\Models\Customer::select('Kota')->groupBy('Kota')->get();
    return $data;
}
function cont_fotobarang($KD_Barang){
    $data=App\Models\Fotobarang::where('KD_Barang',$KD_Barang)->count();
    return $data;
}
function get_fotobarang($KD_Barang){
    $data=App\Models\Fotobarang::where('KD_Barang',$KD_Barang)->orderBy('sts','Desc')->get();
    return $data;
}
function get_CustomerYear(){
    // $get=TransBpVd::select('cust_code',DB::raw("(MONTH(billing_date)) as month"),DB::raw("(YEAR(billing_date)) as year"))->where('cust_code',$customer_code)->groupBy('cust_code',DB::raw("MONTH(billing_date)"),DB::raw("YEAR(billing_date)"))->orderBy(DB::raw("MONTH(billing_date)"),'Desc')->get();
        
    $data=App\Models\Customer::select(DB::raw("(YEAR(TGL_REGISTRASI)) as year"))->where('TGL_REGISTRASI','!=',null)->groupBy(DB::raw("(YEAR(TGL_REGISTRASI))"))->orderBy(DB::raw("(YEAR(TGL_REGISTRASI))"),'Asc')->get();
    return $data;
}
function count_yearcustomer($tahun){
    $data=App\Models\Customer::whereYear('TGL_REGISTRASI',$tahun)->count();
    return $data;
}
function get_GroupSales(){
    $data=App\Models\Sales::select('KD_GroupSales')->groupBy('KD_GroupSales')->get();
    return $data;
}
function count_kdjenis(){
    $data=App\Models\Barang::select('Kd_JenisBarang')->groupBy('Kd_JenisBarang')->count();
    return $data;
}
function count_barang(){
    $data=App\Models\Barang::count();
    return $data;
}
function count_sales(){
    $data=App\Models\Sales::count();
    return $data;
}
function count_Customer(){
    $data=App\Models\Customer::count();
    return $data;
}
function count_barang_even($Kd_JenisBarang){
    $data=App\Models\Barang::where('Kd_JenisBarang',$Kd_JenisBarang)->count();
    
    return $data;
}
function kode_customer(){
    
    $cek=App\Models\Mobilecustomer::where('tahun',date('Y'))->count();
    if($cek>0){
        $mst=App\Models\Mobilecustomer::where('tahun',date('Y'))->orderBy('kode_customer','Desc')->firstOrfail();
        $urutan = (int) substr($mst['kode_customer'], 2, 6);
        $urutan++;
        $nomor=date('y').sprintf("%06s",  $urutan);
    }else{
        $nomor=date('y').sprintf("%06s",  1);
    }
    return $nomor;
}
function persen_barang_even($Kd_JenisBarang){
    $der=App\Models\Barang::where('Kd_JenisBarang',$Kd_JenisBarang)->count();
    $data=round(($der/count_barang())*100);
    return $data;
}

?>