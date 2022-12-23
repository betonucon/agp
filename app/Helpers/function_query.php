<?php

function get_kdjenis(){
    $data=App\Models\Barang::select('Kd_JenisBarang')->groupBy('Kd_JenisBarang')->get();
    return $data;
}
function count_barang(){
    $data=App\Models\Barang::count();
    return $data;
}

?>