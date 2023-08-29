<?php

require_once "wb/functions/topen.php";
require_once "wb/functions/functions.php";
require_once "libs/fpdf/fpdf.php";


// $dop_link="?type=png&width=40&height=30";  // QUERY PARAMETERS
// $link_wb  = "https://suppliers-api.wildberries.ru/api/v3/orders/stickers".$dop_link;;
// $arr[]= 1009882028;

// echo "<pre>";
// print_r($arr);




	// массив с номерами заказа
	// $data = array(
	// 	"orders"=> $arr
	// );
	// // получаем данные со стикерами 
	// $arr_temp_res_stikers[] = light_query_with_data($token_wb, $link_wb, $data);


    // echo "<pre>";
	// $item = $arr_temp_res_stikers[0]['stickers'][0];
    // print_r($item['file']);




$artik = "8910-30-ч";
$artik = MakeUtf8Font($artik);
//create pdf object
// $pdf = new FPDF('L','mm', array(80, 106)); // задаем пдф файл размером с пнг файл
$pdf = new FPDF('L','mm', array(100, 106)); // задаем пдф файл размером с пнг файл

// подключаем шрифты
define('FPDF_FONTPATH',"libs/fpdf/font/");
// добавляем шрифт ариал
$pdf->AddFont('TimesNRCyrMT','','timesnrcyrmt.php');// добавляем шрифт ариал

//add new page
$pdf->AliasNbPages();


$pdf->AddPage();
$file = "0000.png";
// $filedata = base64_decode($item['file']);

// file_put_contents($file, $filedata, FILE_APPEND); // добавляем данные в файл с накопительным итогом
$pdf->image($file,0,0,'PNG');
$pdf->SetFont('TimesNRCyrMT','', 34);
$pdf->text(10,90 ,$artik);

$pdf->Output('pdf_file.pdf', 'F');

die('fyyff');

function MakeUtf8Font($string) {
	$string = iconv('utf-8', 'windows-1251', $string);
	return $string;
  }




