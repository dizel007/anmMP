<?php

require_once "functions/functions.php";
require_once "functions/dop_moduls_for_orders.php";
usleep(500000); // трата на транзакции на сайте ВБ (перевод состояния поставок)

$file_json = $_POST['json_path'];
$token_wb = $_POST['token'];
$wb_path = $_POST['wb_path'];

$path_qr_supply =  $_POST['path_qr_supply'];
$path_arhives  = $_POST['path_arhives'];
$link_downloads_stikers = $_POST['downloads_stikers']; //

$Zakaz_v_1c = $_POST['Zakaz1cNumber'];

$data = file_get_contents($file_json);
$arr_data = json_decode($data,true);

echo $wb_path."<br>";
echo $path_qr_supply."<br>";
echo $path_arhives."<br>";
echo $Zakaz_v_1c."<br>";
echo "<pre>";
print_r($arr_data);



// die('DOST');
/************************************************************************************************
 *  ***************   Перебираем массив поставок и отправляем в доставку ************************
 *  ***************   и получаем QR код каждой поставки                   ************************
 ************************************************************************************************/
foreach ($arr_data as $key=>$supply) {

            echo "<br> Номер поставки :".$supply['supplayId']."<br>";  
            echo "<br> Название поставки :".$supply['name_postavka']."<br>";  
    put_supply_in_deliver ($token_wb, $supply['supplayId']); // отправляем поставку в доставку
        usleep(500000); // трата на формирование этикетки
    $app_qr_pdf_file_names[] = get_qr_cod_supply($token_wb, $supply['supplayId'], $supply['name_postavka'] ,$wb_path,$path_qr_supply);
}

echo "<br> ИНФОРМАЦИЯ ПО QR кодам Поставки (ДЛЯ ОТРАБОТКИ)<br>";  
echo "<pre>";
print_r($app_qr_pdf_file_names);


/******************************************************************************************
 *  ***************   Формируем архив с QR кодам поставок ********************************
 ******************************************************************************************/
$zip = new ZipArchive();
$zip->open("zip_arc/$wb_path/"."QRcode-".$Zakaz_v_1c." от ".date("Y-M-d").".zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
 foreach ($app_qr_pdf_file_names as $zips) {
    $zip->addFile("pdf/$wb_path/".$zips, "$zips"); // Добавляем пдф файлы
 }
    $zip->close(); 

/// ВТорой архив
$zip_new = new ZipArchive();
$zip_new->open($path_arhives."/"."QRcode-".$Zakaz_v_1c." от ".date("Y-M-d").".zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
 foreach ($app_qr_pdf_file_names as $zips) {
    $zip_new->addFile($path_qr_supply."/".$zips, "$zips"); // Добавляем пдф файлы
 }
    $zip_new->close(); 

    $link_downloads_qr_codes = $path_arhives."/"."QRcode-".$Zakaz_v_1c." от ".date("Y-M-d").".zip";
echo <<<HTML
<a href="$link_downloads_stikers"> Стикеры заказов</a>
<a href="$link_downloads_qr_codes"> QR коды поставки</a>

HTML;


die('<br>ПЕРЕДАНО В ДОСТАВКУ');


 function put_supply_in_deliver ($token_wb, $supplyId){
        $link_wb = "https://suppliers-api.wildberries.ru/api/v3/supplies/".$supplyId."/deliver";
        echo "<br>$link_wb<br>";
    //  Запуск добавления товара в поставку - НЕВОЗВРАТНАЯ ОПЕРАЦИЯ ***********************************
    // раскоментировать при работе
        $res =  patch_query_with_data($token_wb, $link_wb, "");
        echo "<pre>";
        print_r($res);
        return $res;
}


function get_qr_cod_supply($token_wb, $supplyId, $name_postavka,$wb_path ,$path_qr_supply){
$dop_link="?type=png";  // QUERY PARAMETERS
$link_wb  = "https://suppliers-api.wildberries.ru/api/v3/supplies/".$supplyId."/barcode".$dop_link;

$qr_supply = light_query_without_data($token_wb, $link_wb); // запрос QR кода поставки
require_once "libs/fpdf/fpdf.php";
//create pdf object
$pdf = new FPDF('L','mm', array(151, 107));
//add new page
$pdf->AliasNbPages();
$filedata=''; // очищаем строку для ввода данных
$pdf->AddPage();

$file = "EXCEL/".$supplyId.".png"; // название пнг
$filedata = base64_decode($qr_supply['file']);
    file_put_contents($file, $filedata, FILE_APPEND);
$pdf->image($file,0,0,'PNG');
unlink ($file); // удаляем png файл

$pdf_file = "QR-code-".$name_postavka.".pdf"; // название PDF  которое сохраниться в итоге
$pdf->Output("pdf/$wb_path/".$pdf_file, 'F');

$pdf->Output($path_qr_supply."/".$pdf_file, 'F');

return $pdf_file;
}

