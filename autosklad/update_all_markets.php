<?php
require_once "tokens/topen.php";
require_once "functions/mp_catalog.php"; // массиво с каталогов наших товаров
require_once "functions/razbor_post_array.php"; // массиво с каталогов наших товаров

echo '<link rel="stylesheet" href="css/main_table.css">';
echo "<pre>";
// print_r($_POST);
// die('ddd');

/* **************************   МАссив для обновления ВБ *********************************** */

$wb_update_items_quantity = razbor_post_massive_wb($_POST);
$warehouseId = 34790;// ID склада ООО на ВБ
    foreach ($wb_update_items_quantity as $wb_item) {
        $data_wb["stocks"][] = $wb_item;
    }
    // обновляем остатки на ВБ
$result_wb = update_wb_ostatki($warehouseId, $token_wb, $data_wb);
// print_r($result_wb);
// print_r($wb_update_items_quantity);

/* **************************   МАссив для обновления ВБ ИП *********************************** */

$wbip_update_items_quantity = razbor_post_massive_wbip($_POST);
$warehouseId = 221597;// ID склада ООО на ВБ
    foreach ($wbip_update_items_quantity as $wbip_item) {
        $data_wbip["stocks"][] = $wbip_item;
    }
    // обновляем остатки на ВБ
$result_wbip = update_wb_ostatki($warehouseId, $token_wb_ip, $data_wbip);

// print_r($result_wbip);
// print_r($wbip_update_items_quantity);


/* **************************   МАссив для обновления ОЗОН *********************************** */
$ozon_update_items_quantity = razbor_post_massive_ozon($_POST);
$arr_catalog = get_catalog_ozon ();

// добавляем к массиву артикул
foreach ($ozon_update_items_quantity as &$item) {
    foreach ($arr_catalog as $prods) {
     if ($item ['sku'] == $prods['sku']) {
        $item['article'] = $prods['article'];
     }
    }
}

unset($item);

// Формируем массив для метода ОЗОНа по обновления остатков
foreach ($ozon_update_items_quantity as $prods) {
    $temp_data_send[] = 
        array(
            "offer_id" =>  $prods['article'],
            "product_id" =>   $prods['sku'],
            "stock" => $prods['amount'],
           )
       
       
        ;


}
$send_data =  array("stocks" => $temp_data_send);

// print_r($send_data);

$send_data = json_encode($send_data, JSON_UNESCAPED_UNICODE)  ;
$ozon_dop_url = "v1/product/import/stocks";
$result_ozon = update_ozon_ostatki($token_ozon, $client_id_ozon, $send_data, $ozon_dop_url );

/* *************** возвращаемся к таблице*/
header('Location: get_all_ostatki_skladov.php?return=777', true, 301);


die();


/* **************************************************************************************************************
*********  Функция обновляния данных на WB *********************************************************
************************************************************************************************************** */

function update_wb_ostatki($warehouseId, $token_wb, $data) { // обновляем остатки товаров на ВБ
$ch = curl_init('https://suppliers-api.wildberries.ru/api/v3/stocks/'.$warehouseId);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	'Authorization:' . $token_wb,
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

if (intdiv($http_code,100) > 2) {
echo     'Результат обмена : '.$http_code. "<br>";
}
$res = json_decode($res, true);
// echo "<pre>";
// print_r($res);

return $res;
}

/* **************************************************************************************************************
*********  Функция обновляния данных Она ОЗОН
************************************************************************************************************** */

function update_ozon_ostatki($token, $client_id, $send_data, $ozon_dop_url ) {
 
	$ch = curl_init('https://api-seller.ozon.ru/'.$ozon_dop_url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Api-Key:' . $token,
		'Client-Id:' . $client_id, 
		'Content-Type:application/json'
	));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $send_data); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

	curl_close($ch);
	
	$res = json_decode($res, true);

    if (intdiv($http_code,100) > 2) {
        echo     'Результат обмена : '.$http_code. "<br>";
        }
   
    return($res);	

}