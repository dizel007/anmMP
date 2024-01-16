<?php
require_once "../tokens/topen.php";
require_once "functions/functions.php";
require_once "functions/wb_catalog.php"; // массиво с каталогов наших товаров
require_once "razbor_post_array.php"; // массиво с каталогов наших товаров

echo '<link rel="stylesheet" href="css/main_table.css">';
// echo "<pre>";
// print_r($_POST);
// die('ddd');


$market = $_POST['market'];
$warehouseId = $_POST['warehouseId'];

//  присваиваем номер склада
if ($market == 'wb'){
    $token = $token_wb;
    $warehouseId = 34790;// ID склада ООО на ВБ
    $arr_catalog = get_catalog_wb ();
} elseif ($market == 'wbip'){
    $token = $token_wb_ip;
    $warehouseId = 221597;// ID склада ИП на ВБ 
    $arr_catalog = get_catalog_wbip ();
} else {
    die('DIE не смогли выбрать склад ВБ');
}

$update_items_quantity = razbor_post_massive($_POST);
$data = array("stocks" => $update_items_quantity);

// echo "<pre>";
// print_r($data);

$ch = curl_init('https://suppliers-api.wildberries.ru/api/v3/stocks/'.$warehouseId);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Authorization:' . $token,
	'Content-Type:application/json'
));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); 
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); 

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);

$res = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код
curl_close($ch);

echo     'Результат обмена : '.$http_code. "<br>";
echo "<br><b>Обновили количество товаров на $market</b><br>";

echo "<br><a href=\"start_wb.php\"> Вернуться</a>";
// $res = json_decode($res, true);
// header('Location: get_ostatki_skladov_3.php');
exit();
die('sssssss');

