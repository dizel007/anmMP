<?php
require_once '../include_funcs.php';

/*
Подключаем PHPExcel
*/
require_once '../../libs/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../../libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once '../../libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';


$date_query_ozon = $_GET['date_query_ozon'];

// $dop_days_query = $_GET['dop_days_query'];
$dop_days_query = 0; // Всегда собираем за один день

// вычитываем все Заказы н эту дату
$res = get_all_waiting_posts_for_need_date($token, $client_id, $date_query_ozon, "awaiting_packaging", $dop_days_query);

$i=0;
// Из полученного массива формируем массив данных, с которым убодно будет отправлять заказы на сборку
// также тут формируем массив    $array_art   для создания Заказа в 1С.
   foreach ($res['result']['postings'] as $posts) {
        $arr_for_zakaz[$i]['posting_number'] = $posts['posting_number'];
        $arr_for_zakaz[$i]['shipment_date'] = substr($posts['shipment_date'],0,10);
                  
            foreach ($posts['products'] as $prods) 
            {
              $arr_for_zakaz[$i]['products'][$prods['offer_id']]['sku'] = $prods['sku'];
              $arr_for_zakaz[$i]['products'][$prods['offer_id']]['name'] = $prods['name'];
              $arr_for_zakaz[$i]['products'][$prods['offer_id']]['quantity'] = $prods['quantity'];
             }

    $i++;
   }

 


// если есть Заказы на ОЗОН, то перебираем все отправления по одному и формируем JSON для отправки в ОЗОН
// echo "<pre>";
  foreach ($arr_for_zakaz as $one_post) {
    // echo "<br>==/ Следующий заказ /==";
    $result = make_packeges_for_one_post($token, $client_id,$one_post);
    usleep(10000);
    $array_list_podbora[] = $result['list_podbora'];
    $array_oben[] = $result['obmen'];
    // print_r($result['obmen']);

}
 

// *********************   Формируем 1С файл  ***********************************************************
require_once "make_1c_file.php";

// *********************   Формируем ЛИСТ Подбора  ***********************************************************
require_once "make_list_podbora.php";


//***************************************** */

echo "<a href=\"$link_list_podbora\">Cкачать лист подбора</a>";
echo "<hr>";
echo "<a href=\"$link_list_tovarov\">Cкачать лист для 1С</a>";
echo "<hr>";

// echo "<pre>";
// print_r($list_tovarov);
echo "<hr>";
echo "<a href=\"../index.php\">Вернуться в начало</a>";
echo "<hr>";




die('ОТПРАВИЛИ МНОГО ЗАКАЗОВ');
