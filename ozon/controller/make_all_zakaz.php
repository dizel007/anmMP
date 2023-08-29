<?php
require_once '../include_funcs.php';
require_once 'make_1c_file.php';



/*
Подключаем PHPExcel
*/
require_once '../../libs/PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../../libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once '../../libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';


$date_query_ozon = $_GET['date_query_ozon'];

$dop_days_query = 0; // Всегда собираем за один день





/*****************************************************************************************************************
 ******  Формируем папки для разнесения информации 
 ******************************************************************************************************************/
// $new_date = date('Y-m-d');
$new_path = '../reports/'.$date_query_ozon."/";
make_new_dir_z($new_path,0); // создаем папку с датой
$path_etiketki = $new_path.'etiketki';
make_new_dir_z($path_etiketki,0); // создаем папку с датой
$path_excel_docs = $new_path.'excel_docs';
make_new_dir_z($path_excel_docs,0); // создаем папку с датой
$path_zip_archives = $new_path.'zip_archives';
make_new_dir_z($path_zip_archives,0); // создаем папку с датой


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

/*****************************************************************************************************************
 ******  Формируем JSON файл поартикульно Для формирования Листа подбора ПОТОМ
 ******************************************************************************************************************/
$string_json_list_podbora = json_encode($array_oben);
$temp_path = $path_excel_docs."/json_list_podbora.json";
file_put_contents($temp_path, $string_json_list_podbora);


/*****************************************************************************************************************
 *****************************  Формируем 1С файл
 ******************************************************************************************************************/

$xls = new PHPExcel();
$rand10000 = rand(0,10000);
$file_name_1c_list = make_1c_file($res, $date_query_ozon, $rand10000, '../EXCEL/', $xls);
 


/*****************************************************************************************************************
 *****************************  Формируем ЛИСТ Подбора
 ******************************************************************************************************************/

require_once "make_list_podbora.php";

/*****************************************************************************************************************
 *****************************  Отрисовываем ссылки на скачивание 
 ******************************************************************************************************************/

echo "<a href=\"$link_list_podbora\">Cкачать лист подбора</a>";
echo "<hr>";
$temp_link = "../EXCEL/".$file_name_1c_list;
echo "<a href=\"$temp_link\">Cкачать лист для 1С</a>";
echo "<hr>";

// echo "<pre>";
// print_r($list_tovarov);
echo "<hr>";
echo "<a href=\"../index.php\">Вернуться в начало</a>";

echo <<<HTML
<hr>
<h2>Получить этикетки на выбранную дату</h2>
  <div>
      <form method="get" action="make_etikets_for_all.php">
      <input  required type="date" name="date_query_ozon" value="$date_query_ozon">
<label> Номер заказа</label>
      <input  required type="number" name="nomer_zakaz" value="">
      
      <input hidden required type="text" name="path_etiketki" value="$path_etiketki">
      <input hidden required type="text" name="path_excel_docs" value="$path_excel_docs">
      <input hidden required type="text" name="path_zip_archives" value="$path_zip_archives">

      <input hidden required type="text" name="file_name_1c_list" value="$file_name_1c_list">
      <input hidden required type="text" name="file_name_list_podbora" value="$file_name_list_podbora">


      <input type="submit" value="Получить этикетки на выбранную дату">
    
  </div>
</form>    
<hr>
HTML;





die('ОТПРАВИЛИ МНОГО ЗАКАЗОВ');
