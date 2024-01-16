<?php

/*******************************************************************************************************
********      Достаем фактические остатки товаров и цепляем их к каталогу товаров***********************
*******************************************************************************************************/
function get_ostatki_wb ($token_wb, $warehouseId, $wb_catalog) {
// формируем массив с запрашиваемыми баркодами
    foreach ($wb_catalog as $items) {
        $arr_skus[] = $items['barcode'];
    }
 
$link_wb  = "https://suppliers-api.wildberries.ru/api/v3/stocks/".$warehouseId;
$data = array("skus"=> $arr_skus);
$res = light_query_with_data($token_wb, $link_wb, $data);

// Формируем массив для вывода на экран (артикулы, СКУ, имя, Баркод, количество)
    foreach ($res['stocks'] as $prods)  {
        foreach ($wb_catalog as &$items) {
            if ($prods['sku'] == $items['barcode']) {
                $items['quantity'] = $prods['amount'];
            }
        }
    }
return $wb_catalog;
}


/*******************************************************************************************************
********      Достаем фактические заказанные товары и цепляем их к каталогу товаров*********************
*******************************************************************************************************/
function get_new_zakazi_wb ($token_wb, $wb_catalog) {

    $link_wb = 'https://suppliers-api.wildberries.ru/api/v3/orders/new';
    $result = light_query_without_data($token_wb, $link_wb);
    
     // формируем массив ключ - артикул ; значение - количество элементов этого артикула
    
    foreach ($result['orders'] as $items_wb) {
        $arr_name[$items_wb['article']][]= $items_wb;
    // $sum = @$sum + $itemss['convertedPrice']/100;
    }
    unset($items_wb);
    
    if (isset ($arr_name)) {  // проверяем есть ли массив проданных товаров
       foreach ($arr_name as $key => $temp_items) {
           $arr_article_count[$key] = count($arr_name[$key]);
       }
    
       foreach ($arr_article_count as $key=>$prods)  {
           foreach ($wb_catalog as &$items_wb) {
               // echo "<br>key=$key<br>";
               if ($key == $items_wb['article']) {
                $items_wb['sell_count'] = $prods;
               } 
           }
    
       }
    }
return $wb_catalog;
}


/*******************************************************************************************************
********      Достаем фактические заказанные товары и цепляем их к каталогу товаров*********************
*******************************************************************************************************/

function get_new_zakazi_ozon ($token_ozon, $client_id_ozon, $ozon_catalog) {
$date_query_ozon = date('Y-m-d');
$date_query_ozon = date('Y-m-d', strtotime('-4 day', strtotime($date_query_ozon))); // начальную датк на 4 дня раньше берем

$dop_days_query = 14; // захватывает 14 дней после сегодняшней даты

//  Получаем фактические заказы с сайта озона (4 дня доо и 14 после сегодняшне йдаты)
$res = get_all_waiting_posts_for_need_date($token_ozon, $client_id_ozon, $date_query_ozon, 'awaiting_packaging', $dop_days_query);

foreach ($res['result']['postings'] as $items) {
    foreach ($items['products'] as $product) {
        $arr_products[$product['offer_id']] = @$arr_products[$product['offer_id']] + $product['quantity'];
    }
    
}

foreach ($arr_products as $key=>$prods) {
    foreach ($ozon_catalog as &$items_ozon) {
        // echo "<br>key=$key<br>";
        if ($key == $items_ozon['article']) {
            $items_ozon['sell_count'] = $prods;
        } 
    }
}


return $ozon_catalog;
}

/*******************************************************************************************************
********      Достаем фактические остатки товаров и цепляем их к каталогу товаров***********************
*******************************************************************************************************/
function  get_ostatki_ozon ($token_ozon, $client_id_ozon, $ozon_catalog) {
// FПолучаем фактическое количество товаров указанное на складе ОЗОН
$ozon_dop_url = 'v1/product/info/stocks-by-warehouse/fbs';
$data = '';

foreach ($ozon_catalog as $item)
 {
     $data .="\"".$item['sku']."\",";
}
$data = substr($data, 0, -1);
$send_data ='{"sku": ['.$data.']}';

$res = send_injection_on_ozon($token_ozon, $client_id_ozon, $send_data, $ozon_dop_url );

foreach ($res['result'] as $items) {
foreach ($ozon_catalog as &$prods) {
    if ($prods['OzonProductID'] == $items['product_id']) {
        $prods['quantity'] = $items['present'] - $items['reserved'];
        break 1;
    }
}
}
return $ozon_catalog;
 }
