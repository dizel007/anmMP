<?php
require_once 'include_funcs.php';
/*
Подключаем PHPExcel
*/
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel.php';
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';


$ozon_link = 'v3/finance/transaction/list';
$send_data = '{
    "filter": {
        "date": {
            "from": "2023-07-01T00:00:00.000Z",
            "to": "2023-07-31T00:00:00.000Z"
        },
        "operation_type": [],
        "posting_number": "",
        "transaction_type": "all"
    },
    "page": 1,
    "page_size": 1000
}';

// $send_data = json_encode($send_data);

$res = send_injection_on_ozon($token, $client_id, $send_data, $ozon_link );
echo "<pre>";
print_r($res);

die('ddddddd');

$ozon_link = 'v1/finance/realization';

$send_data =array("date" => "2023-07");
$send_data = json_encode($send_data);
echo $send_data;


$res = send_injection_on_ozon($token, $client_id, $send_data, $ozon_link );



$products = $res['result']['rows'];


echo "<pre>";
print_r($products[6]);
// print_r($products[1]);
/**********************************************************************************
 **************       Сформировали массив артикулов
 **********************************************************************************/
foreach ($products as $item) { 
     $arr_article[$item['offer_id']] = $item['offer_id'];
    //  $arr_item_article[$item['offer_id']][] = $item;
   }
unset($item);
/**********************************************************************************
 **************       формируем данные для таблицы 
 **********************************************************************************/

 foreach ($arr_article as $item_art) {
 foreach ($products as $item) {
if ($item['offer_id'] == $item_art) {
    $arr_sale[$item_art]['sale_amount'] = @$arr_sale[$item_art]['sale_amount'] + $item['sale_amount'] - $item['return_amount'];
    $arr_sale[$item_art]['sale_discount'] = @$arr_sale[$item_art]['sale_discount'] + $item['sale_discount'] - $item['return_discount'];
    $arr_sale[$item_art]['qty'] = @$arr_sale[$item_art]['qty'] + $item['sale_qty'] - $item['return_qty'];
    $arr_sale[$item_art]['sale_price_seller'] = @$arr_sale[$item_art]['sale_price_seller'] + $item['sale_price_seller'] - $item['return_price_seller'];
    $arr_sale[$item_art]['return_qty'] = @$arr_sale[$item_art]['return_qty'] + $item['return_qty'];
}

 }
 $summa_qty = @$summa_qty + $arr_sale[$item_art]['qty'];
 $summa_sale_price_seller = @$summa_sale_price_seller + $arr_sale[$item_art]['sale_price_seller'];
}


echo "<br>$summa_qty<br>";
echo "<br>$summa_sale_price_seller<br>";
// echo "<pre>";
// print_r($arr_sale);

echo <<<HTML
<table>
    <tr>
<td>***пп***</td>
<td>  артикул *++++***</td>
<td>**количетсво **</td>
<td>**сумма продаж** </td>
<td>**сумма комиссии **</td>
<td>**сумма к зачислению **</td>
<td>**количетсво возвартов**</td>

    </tr>

HTML;
$i=1;
foreach ($arr_sale as $key=>$prod) {
$qty = $prod['qty'];
$sale_amount = $prod['sale_amount'];
$sale_discount = $prod['sale_discount'];
$sale_price_seller = $prod['sale_price_seller'];
$return_qty = $prod['return_qty'];
echo <<<HTML
<tr>
    <td>$i</td>
    <td>$key</td>
    <td>$qty</td>
    <td>$sale_amount</td>
    <td>$sale_discount</td>
    <td>$sale_price_seller</td>
    <td>$return_qty</td>
        </tr>
    
HTML;
$i++;
}




