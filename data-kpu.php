<?php

/*
	Just4Fun by iBacor.com ^^
*/

// menghilangkan pesan error karena proses dom yg tdk smpurna
error_reporting(0);

function cek_ktp($nik, $kpu = 'https://data.kpu.go.id/dps2015.php') {
		
	################################################ MULAI cURL ###############################################
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_USERAGENT, "Googlebot/2.1 (http://www.googlebot.com/bot.html)");
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_REFERER, 'https://data.kpu.go.id/');
	// URL KPU yg akan di cURL
	curl_setopt($ch, CURLOPT_URL, $kpu);
	// mengirm rquest kepada URL KPU menggunakan method POST dengan parameter seperti dibawah
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'wilayah_id=0&page=&nik_global='.$nik.'&g-recaptcha-response=capcay&cmd=Cari.');
	################################################# END cURL ################################################
		
	// data array untuk output nanti
	$array = array();
		
	// Gagal ngecURL
    if(!$html = curl_exec($ch)){
		$array['status'] = "error";
		$array['pesan'] = "website sedang offline";
	}
		
	// Sukses ngecURL
	else{
			
		// manipulasi data html
		$dom = new DOMDocument;
		$dom->loadHTML($html);
			
		// mengambil data html yang ada didalam tag <span>
		$span = $dom->getElementsByTagName('span');
			
		// jika nik tidak ada maka status error
		if(empty($span->item(1))){
		
		    // jika nik tidak ada di dps2015.php kita coba di ss8.php
			if($kpu == 'https://data.kpu.go.id/dps2015.php'){
				return cek_ktp($nik, 'https://data.kpu.go.id/ss8.php');
				break;
			}else{
				$array['status'] = "error";
				$array['pesan'] = "data tidak ada";
			}
		}else{
				
			// jika data nik ada maka status success
			$array['status'] = "success";
			$array['pesan'] = "data ada";
				
			// mengekstrak semua data html yang ada didalam tag <span> dan di ambil yang diperlukan saja berdasarkan key array.y
			foreach ($span as $key => $value) {
				if($key == 1){
					$nik = $value->nodeValue;
				}else if($key == 3){
					$nama = $value->nodeValue;
				}else if($key == 5){
					$kelamin = $value->nodeValue;
				}else if($key == 7){
					$kelurahan = $value->nodeValue;
				}else if($key == 9){
					$kecamatan = $value->nodeValue;
				}else if($key == 11){
					$kabupaten_kota = $value->nodeValue;
				}else if($key == 13){
					$provinsi = $value->nodeValue;
				}
			}
				
			// memasukan data yang diperlukan ke array data untuk output
			$data = array(
						'nik' => strtolower($nik),
						'nama' => strtolower($nama),
						'kelamin' => strtolower($kelamin),
						'kelurahan' => strtolower($kelurahan),
						'kecamatan' => strtolower($kecamatan),
						'kabupaten_kota' => strtolower($kabupaten_kota),
						'provinsi' => strtolower($provinsi)
					);
			$array['data'] = $data;
		}
			
		return $array;
		
	}
		
}

?>