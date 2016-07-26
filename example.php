<?php

// include data-kpu.php
require('data-kpu.php');

// memasukan NIK 
$nik = '1234xxxxx';
	
// menjalankan proses curl dan return array
$data = cek_ktp($nik);
// print_r($data);
	
// merubah data array menjadi json
echo json_encode($data);
	
?>