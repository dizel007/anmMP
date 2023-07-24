<?php
echo "GET_ORDERS<br>";
require_once "show_sell_table.php";
require_once "functions/functions.php";


/********************************************************************************************************
 * ******************** Вычитываем и выводи заказы для ВБ
 ********************************************************************************************************/

$raw_arr_orders = get_all_new_zakaz ($token_wb); // получили массив новых отправлений

if (isset($raw_arr_orders['orders'][0])) {
// массив новых отправлений собранный по артикулу
$full_price = 0;
foreach ($raw_arr_orders['orders'] as $orders) {
    $new_arr_orders[$orders['article']][] = $orders;
    $full_price = $full_price + $orders['convertedPrice']/100;
}
$middle_price=1;
$all_count = count($raw_arr_orders['orders']);
foreach ($new_arr_orders as $key=>$orders) {
    $raw_price=0;

    foreach ($orders as $order){
  $raw_price = $raw_price + $order['convertedPrice'];
    }
    $middle_price = number_format(($raw_price/count($new_arr_orders[$key]))/100,2);
    $sum_arr_article[make_right_articl($key)] = array('count' =>count($new_arr_orders[$key]),
                                                      'price' => $middle_price);
}

echo "<b>Общее количество ВБ:".$all_count."</b><br>";
echo "<b>Общее стоимость  ВБ:".number_format($full_price,2)."</b><br>";

echo <<<HTML
<form action="start_new_supplies.php" method="post">
<b><label for="wb">СОБРАТЬ ЗАКАЗЫ ДЛЯ ВБ (ООО ТД АНМАКС)</label></b><br>

<label for="wb">Номер заказа</label><br>
  <input hidden type="text" name="token" value="$token_wb">
  <input hidden type="text" name="wb_path" value="ooo">
  <input required type="number" name="Zakaz1cNumber" value="">
  <input type="submit" value="СОБРАТЬ">

</form>
HTML;

show_orders ($sum_arr_article);


unset($raw_arr_orders);
unset($new_arr_orders);
unset($sum_arr_article);
} else {
 echo "<b>Нет ЗАКАЗОВ НА ВБ (ООО ТД АНМАКС)</b>"  ;
}

echo "<hr>";
echo "<hr>";
/********************************************************************************************************
 * ******************** Вычитываем и выводи заказы для ВБ ИП
 ********************************************************************************************************/

 $raw_arr_orders = get_all_new_zakaz ($token_wb_ip); // получили массив новых отправлений
 
 if (isset($raw_arr_orders['orders'][0])) {
 // массив новых отправлений собранный по артикулу
 $full_price = 0;
 foreach ($raw_arr_orders['orders'] as $orders) {
     $new_arr_orders[$orders['article']][] = $orders;
     $full_price = $full_price + $orders['convertedPrice']/100;
 }
 $middle_price=1;
 $all_count = count($raw_arr_orders['orders']);
 foreach ($new_arr_orders as $key=>$orders) {
     $raw_price=0;
 
     foreach ($orders as $order){
   $raw_price = $raw_price + $order['convertedPrice'];
     }
     $middle_price = number_format(($raw_price/count($new_arr_orders[$key]))/100,2);
     $sum_arr_article[make_right_articl($key)] = array('count' =>count($new_arr_orders[$key]),
                                                       'price' => $middle_price);
 }
 
 echo "<b>Общее количество ВБ ИП:".$all_count."</b><br>";
 echo "<b>Общее стоимость  ВБ ИП:".number_format($full_price,2)."</b><br>";
 


 echo <<<HTML

 <form action="start_new_supplies.php" method="post">
 <b><label for="wb">СОБРАТЬ ЗАКАЗЫ ДЛЯ ВБ (ИП ГОРЯЧЕВ)</label></b><br>
 
 <label for="wb">Номер заказа</label><br>
   <input hidden type="text" name="token" value="$token_wb_ip">
   <input hidden type="text" name="wb_path" value="ip">
   <input required type="number" name="Zakaz1cNumber" value="">
   <input type="submit" value="СОБРАТЬ">
 
 </form>
HTML;


show_orders ($sum_arr_article);

 unset($raw_arr_orders);
 unset($new_arr_orders);
 unset($sum_arr_article);
} else {
  echo "<b>Нет ЗАКАЗОВ НА ВБ (ИП Горячев)</b>"  ;
 }

/*******************************************************************************************************/



