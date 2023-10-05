<?php
require_once "parce_xlsx_price.php";
$arr_catalog = get_catalog_VI();



// echo "<pre>";
// print_r($arr_catalog);

if (isset($_FILES['file'])) {
    $xml_file =$_FILES['file']['name'];
    $path = 'uploads/';
	if (move_uploaded_file($_FILES['file']['tmp_name'], $path . $xml_file)) {
        // Далее можно сохранить название файла в БД и т.п.
        $success = 'Файл «' . $xml_file . '» успешно загружен.';
    } else {
        $error = 'Не удалось загрузить файл.';
    }
    // print_r($_FILES);
} else {
    echo <<<HTML
    <form action="" method="post" enctype="multipart/form-data">
        <input required type="file" name="file">
        <input type="submit" value="Отправить">
    </form>
HTML;

    echo "Файл отсутствует";
    die('');
}

$xml_file =$_FILES['file']['name'];
$xmlstring = file_get_contents($path.$xml_file);

$xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
$json = json_encode($xml);
$array = json_decode($json,TRUE);

// Проверяем есть ли номер документа
if (!isset($array['ORDER']['DocumentNumber'])) {
    die('Не смогли распарсить XML file');
}

$DocNumber = $array['ORDER']['DocumentNumber'];
echo "<b>НОМЕР ЗАКАЗА :". $DocNumber."</b>" ;
// создаем папку с заказом
$temp_dir = 'reports/'.$DocNumber;
if (!is_dir($temp_dir)) {
	mkdir($temp_dir, 0777, True);
}

echo "<pre>";
// print_r($array['ORDER']['OrderDetail']);


// перебираем массив из ВИ
foreach ($array['ORDER']['OrderDetail'] as &$item) {

    $item['price'] = get_price_for_1C ($arr_catalog, $item['SenderPrdCode']);
    $barnumber=$item['EAN'];
    $file=$item['SenderPrdCode'];
    	require("barcode/barcode.php");
    $file_name = $file.".png";
   $arr_file_names[] = get_shtrih_code ($item , $DocNumber, $file_name);
    unlink($file_name);

}

print_r($array['ORDER']['OrderDetail']);
//// Формируем файл для 1С
$file_name_1c_list = make_1c_file ($array['ORDER']['OrderDetail'], $temp_dir.'/');

$zip = new ZipArchive();
$archive_path = $temp_dir. '/'."$DocNumber.zip";
$zip->open($archive_path , ZipArchive::CREATE|ZipArchive::OVERWRITE);

    foreach ($arr_file_names as $arc) {
        $zip->addFile($temp_dir."/".$arc ,  $arc);
    }
    $zip->addFile($temp_dir."/".$file_name_1c_list ,  $file_name_1c_list); // пакуем файл для 1С
$zip->close();
// print_r($arr_file_names);

echo <<<HTML
<br><br>
<h2><a href="$archive_path">Cкачать архив с этикетками</a></h2>
<br><br>
HTML;
die('РАЗОБРАЛИ');






/****************************************************************************************************************
*******************      Функция формирования штрихкодов  ******************************
****************************************************************************************************************/
function get_shtrih_code ($array_items, $DocNumber, $file) {
require_once "libs/fpdf/fpdf.php";
//create pdf object
// $pdf = new FPDF('L','mm', array(121, 107));
$pdf = new FPDF('L','mm', array(120, 80));

$pdf->AddFont('TimesNRCyrMT','','timesnrcyrmt.php');// добавляем шрифт ариал

for ($i=1; $i <= $array_items['QTY']; $i++) {
//add new page
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->image($file ,2,2,'PNG');

// unlink ($file); // удаляем png файл

$pdf->SetFont('TimesNRCyrMT','', 24); // устанавливаем шрифт для артикула

$article = "арт.(".$array_items['SenderPrdCode'].")";
$article_rus = MakeUtf8Font($article);
$pdf->text(10,75 ,$article_rus); // припечатываем артикул к ПДФ


// break; /************************************************************************************************************************/
}
$item_count = round($array_items['QTY'],0);
$file_names = "ВИ_зак№($DocNumber)_арт.(".$article.")_(".$item_count." шт)".".pdf";

$pdf_file = 'reports/'.$DocNumber."/". $file_names; // название PDF  которое сохраниться в итоге
// $pdf_file = MakeUtf8Font($pdf_file);
// $pdf->Output("pdf/$wb_path/".$pdf_file, 'F');

$pdf->Output($pdf_file, 'F');
return $file_names;
}


/****************************************************************************************************************
*******************      Функция перекодировки текста чтобы в ПДФ были русские буквы ******************************
****************************************************************************************************************/
function MakeUtf8Font($string) {
    $string = iconv('utf-8', 'windows-1251', $string);
    return $string;
  }


/****************************************************************************************************************
*******************      Функция перекодировки текста чтобы в ПДФ были русские буквы ******************************
****************************************************************************************************************/
function get_price_for_1C ($arr_catalog, $article) {
    foreach ($arr_catalog as $catalog_item) {
        // echo "<br>7777".$article."*****".$catalog_item['article']."77777<br>";
        if((string)$article == (string)$catalog_item['article']) {
        // echo "<br>".$article."*****".$catalog_item['article']."<br>";
            return $catalog_item['price'];
        }
  }
  return 0;
}


function make_1c_file ($arr_for_1C, $new_path){

    $xls = new PHPExcel();
    $xls->setActiveSheetIndex(0);
    $sheet = $xls->getActiveSheet();
    $next_i = 1;
    foreach ($arr_for_1C  as $q_items) {
         $sheet->setCellValue("A".$next_i, $q_items['SenderPrdCode']);
         $sheet->setCellValue("C".$next_i, $q_items['QTY']);
         $sheet->setCellValue("D".$next_i, $q_items['price']); // цена за 1 шт товара

         $next_i++; // смешение по строкам
     
    }
       

     $objWriter = new PHPExcel_Writer_Excel2007($xls);
     $rnd1000001 = "(".rand(0,10000).")";
     $file_name_1c_list_q = "VI_Zakaz_v_1c_".date('Y-m-d').$rnd1000001."_(NEW_funck).xlsx";
     $objWriter->save($new_path."/".$file_name_1c_list_q);  
     return $file_name_1c_list_q;
    
    }