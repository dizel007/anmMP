<?php
require_once 'include_funcs.php';
/*
Подключаем PHPExcel
*/
require_once '../libs/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

echo <<<HTML

<img src="../pics/ozon.jpg">

HTML;

if (isset($_GET['date_query_ozon'])) {
    $date_query_ozon = $_GET['date_query_ozon'];  
    $dop_days_query = $_GET['dop_days_query'];

}else {
    $date_query_ozon =''; 
}

echo <<<HTML
<h2>Найти заказы для комплектации по дате</h2>
<div>
    <form method="get" action="#">
    <input  required type="date" name="date_query_ozon" value="$date_query_ozon">
    <input type="submit" value="Найти заказы на выбранную дату">
   
</div>
<label for="dop_days_query">Количество дополнительных дней</label>
<select name="dop_days_query" >
         <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
          <option value="9">9</option>
          <option value="10">10</option>
          <option value="11">11</option>
          <option value="12">12</option>

      </select>
      </form>    
<hr>
HTML;

// если есть Дата поиска, то начинаем вычитывать данные с сайта ОЗОН
if (isset($date_query_ozon)) {
    if ($date_query_ozon <> '') {
   // получаем массив всех отправления на эту дату
   $res = get_all_waiting_posts_for_need_date($token, $client_id, $date_query_ozon, "awaiting_packaging" , $dop_days_query);
   



// Из полученного массива формируем массив данных,$array_art   для создания Заказа в 1С.
$kolvo_tovarov = 0;
   foreach ($res['result']['postings'] as $posts) {
      foreach ($posts['products'] as $prods) 
        {
           $array_art[$prods['offer_id']]= @$array_art[$prods['offer_id']] + $prods['quantity'];
           $kolvo_tovarov = $kolvo_tovarov + $prods['quantity'];
        //    echo $prods['price']."<br>";
          $array_art_price[$prods['offer_id']] = array("price"    => $prods['price'],
                                                       "quantity" => $array_art[$prods['offer_id']],
                                                        "name"    => $prods['name']);
        }
 }

 //  Выводим таблицу с Количество купленно
 if (isset($array_art_price)){
 echo "<h2>Список купленных товаров</h2>";
 make_spisok_sendings_ozon_1С ($array_art_price);

 //  Выводим таблицу с Заказами
 echo "<h2>Перечень заказов</h2>";
make_spisok_sendings_ozon ($res['result']['postings']);
// Ссылка для запуска сбора всех заказов
$link ="controller/make_all_zakaz.php?date_query_ozon=".$date_query_ozon."&dop_days_query=0";
echo "Собрать все Заказы<a href=\"$link\">*СТАРТ*</a> ";
 } else {
    echo "<h2>НЕТ ДАНЫХ ДЛЯ ВЫДАЧИ</h2>";
 }

  }
 }
