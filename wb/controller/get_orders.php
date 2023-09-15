<?php
echo "GET_ORDERS<br>";
require_once "show_sell_table.php";
require_once "functions/functions.php";


// if (isset($_GET['need_date'])) {
//   $need_date = $_GET['need_date'];
//   echo "DATE = $need_date";
// } else {
//   $need_date = null;
// }

// $raw_arr_orders_xxxxx = get_all_new_zakaz ($token_wb); // получили массив новых отправлений
                    /// Формируем массив с купленными артикулами
// foreach ($raw_arr_orders_xxxxx['orders'] as $need_item_xxxxx) {
//   $temp_art = make_right_articl($need_item_xxxxx['article']);
//     $arr_articles[$temp_art] = $need_item_xxxxx['article'];
//   }

//   echo "<pre>";
//   print_r($arr_articles);



// echo <<<HTML
// <form action="#" method="get">
// <b><label for="wb">СОБРАТЬ ЗАКАЗЫ ПО ОПРЕДЕЛЕННОЙ ДАТЕ</label></b><br>

// <label for="wb">Собрать заказы на дату</label>
  
//   <input type="radio" name="browser" value="opera"> Opera

//   <input type="submit" value="Выбрать дату">

// </form>
// HTML;


// echo <<<HTML
// <form action="#" method="get">
// <b><label for="wb"> Выбрать артикулы </label></b><br>

// <label for="wb">Выбратьартикулы для заказа</label><br>
// HTML;

// echo <<<HTML

//   <input  type="date" name="need_date" value="$need_date">
//   <input type="submit" value="Выбрать дату">

// </form>
// HTML;

// die('hhhhhhhh');

/********************************************************************************************************
 * ******************** Вычитываем и выводи заказы для ВБ
 ********************************************************************************************************/

$raw_arr_orders = get_all_new_zakaz ($token_wb); // получили массив новых отправлений



 // ******************************** Формируем массив, отсортированный только по дате формирования заказа
//   if ($need_date != null) {
//     $raw_arr_orders_temp = $raw_arr_orders;
//     unset($raw_arr_orders); // удаляем массив, чтобы создать с такимже названием

//     foreach ($raw_arr_orders_temp['orders'] as $need_item) {
//       $temp_date_zakaz = strtotime($need_item['createdAt']);
//       $new_date_zakaz = date('Y-m-d', $temp_date_zakaz);
//       if ($need_date == $new_date_zakaz) {
//         $raw_arr_orders['orders'][] = $need_item;
//       }
//     }
//   }

// echo "<pre>";
// print_r($raw_arr_orders['orders']);

// die();
/**********************************************************************************************************
 * СТАРЫЙ КОД
 *********************************************************************************************************/


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

echo "<br><b>Общее количество ВБ:".$all_count."</b><br>";
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
 echo "<br><b>Нет ЗАКАЗОВ НА ВБ (ООО ТД АНМАКС)</b>"  ;
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
 
 echo "<br><b>Общее количество ВБ ИП:".$all_count."</b><br>";
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
  echo "<br><b>Нет ЗАКАЗОВ НА ВБ (ИП Горячев)</b>"  ;
 }

/*******************************************************************************************************/



