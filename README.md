# Cek-NIK-KTP
Data yang dihasilkan bersumber dari data.kpu.go.id
<h3>Usage</h3>
<pre>&lt;?php

// include data-kpu.php
require('data-kpu.php');

// memasukan NIK 
$nik = '1234xxxxx';
    
// menjalankan proses curl dan return array
$data = cek_ktp($nik);
// print_r($data);
    
// merubah data array menjadi json
echo json_encode($data);
    
?&gt;</pre>

<a href='http://ibacor.com/widget'><h3>DEMO</h3></a>
