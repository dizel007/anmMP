<?php

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

echo $DocNumber = $array['ORDER']['DocumentNumber'];
$temp_dir = 'reports/'.$DocNumber;
if (!is_dir($temp_dir)) {
	mkdir($temp_dir, 0777, True);
}

echo "<br>";
echo "<pre>";
// print_r($array['ORDER']['OrderDetail']);

$files = scandir('pics_shtrih', SCANDIR_SORT_ASCENDING); // получаем список всех файлов со штрихкодами
$count_item = 0;
foreach ($array['ORDER']['OrderDetail'] as &$items) {
    $priznak_find_file = 0;
    foreach ($files as $file) {
        $file_temp = "zzz".$file;
        if (strpos($file_temp, $items['EAN'])) {
            $items['filename'] = $file;
            $new_arr_items[]=$items;
            $priznak_find_file = 1;
            
        }
    }
    $count_item ++;

    if ($priznak_find_file !=1 ) {
        $strih = $items['SenderPrdCode'];
        echo "<br><h2><b>Не нашли штрихкод  для артикула [$strih] </b></h2><br>"; 
    }
}

if ($count_item != count($new_arr_items)) {
    echo "<br> Не все ШТРИХ кода нашли" ;
} else {
    echo "<br> все ШТРИХ на месте !!!" ;
}

print_r($new_arr_items);


foreach ($new_arr_items as $item) {
    $barnumber=$item['EAN'];
    $file=$item['SenderPrdCode'];

	require("barcode/barcode.php");
    $file_name = $file.".png";
   $arr_file_names[] = get_shtrih_code ($item , $DocNumber, $file_name);
    unlink($file_name);
}
$zip = new ZipArchive();
$archive_path = $temp_dir. '/'."$DocNumber.zip";
$zip->open($archive_path , ZipArchive::CREATE|ZipArchive::OVERWRITE);

    foreach ($arr_file_names as $arc) {
        $zip->addFile($temp_dir."/".$arc ,  $arc);
    }
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
// $file = "pics_shtrih/".$array_items['filename']; // название пнг файлв с кьюР кодом
// $filedata = base64_decode($qr_supply['file']);
//     file_put_contents($file, $filedata, FILE_APPEND);

$pdf->image($file ,2,2,'PNG');
// unlink ($file); // удаляем png файл


$article = $array_items['SenderPrdCode'];
$pdf->SetFont('TimesNRCyrMT','', 24); // устанавливаем шрифт для артикула

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


