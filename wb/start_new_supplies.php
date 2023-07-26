<?php

require_once "functions/functions.php";
require_once "functions/dop_moduls_for_orders.php";


require_once 'libs/PHPExcel-1.8/Classes/PHPExcel.php';
require_once 'libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once 'libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
$stamp_date = date('Y-m-d H:i:s');
echo "<br>$stamp_date - Начали разбор заказов <br>";
//******************************************************************************************


$token_wb = $_POST['token'];
// echo "<br>";
$Zakaz_v_1c = $_POST['Zakaz1cNumber'];
$wb_path = $_POST['wb_path'];

/******************************************************************************************
 *  ************   Создаем каталог для сегодняшнего разбора
 ******************************************************************************************/

//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
$stamp_date = date('Y-m-d H:i:s');
echo "<br>$stamp_date - Формирование папок <br>";
//******************************************************************************************

$new_date = date('Y-m-d');
make_new_dir_z('reports/'.$new_date,0); // создаем папку с датой
$new_path = 'reports/'.$new_date."/".$Zakaz_v_1c;
$path_qr_supply = $new_path.'/qr_code_supply';
$path_stikers_orders = $new_path.'/stikers_orders';
$path_arhives = $new_path.'/arhives';

if(is_dir($new_path)) {
    $link_alarm_stikers  = $path_arhives."/"."Stikers_".$Zakaz_v_1c." от ".date("Y-M-d").".zip";
    $link_alarm_qr_code  = $path_arhives."/"."QRcode-".$Zakaz_v_1c." от ".date("Y-M-d").".zip";
    
    echo "<a href=\"$link_alarm_stikers\">Скачать стикеры</a><br>";
    echo "<a href=\"$link_alarm_qr_code\">Скачать Qr код поставки</a><br>";
    die("Такой номер ЗАКАЗА на сегодняшнюю дату уже существует<br><a href=\"index.php\">Вернуться</a>");
}


/// проверяем  наличие папки с таким номером заказа
make_new_dir_z($new_path,0); // создаем папку с номером заказа
make_new_dir_z($path_qr_supply,0); // создаем папку с QR
make_new_dir_z($path_stikers_orders,0); // создаем папку со стикерами
make_new_dir_z($path_arhives,0); // создаем папку с архивами

 function make_new_dir_z($dir, $append) {

    if (!is_dir($dir)) {
        mkdir($dir, 0777, True);
    } 

}

// Получаем все новые заказы с сайта ВБ

//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
$stamp_date = date('Y-m-d H:i:s');
echo "<br>$stamp_date - Получаем все новые заказы с сайта ВБ <br>";
//******************************************************************************************

$arr_new_zakaz = get_all_new_zakaz ($token_wb);


// Сформировали массив с ключем - артикулом и значением - массив отправлений

//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
$stamp_date = date('Y-m-d H:i:s');
echo "<br>$stamp_date - Формируем массив с ключем - артикулом и значением <br>";
//******************************************************************************************

foreach ($arr_new_zakaz['orders'] as $items) {
    $new_arr_new_zakaz[$items['article']][] = $items;
}

/******************************************************************************************
 *  ************   Начинаем главный разбор ассоциативного массива
 ******************************************************************************************/

foreach ($new_arr_new_zakaz  as $key => $items) {
    $priznzak_net_massiva=0;
    $priznzak_ne_ves_massiv=0;  
    echo $key."<br>";
    $right_article = make_right_articl($key);
    $name_postavka = $Zakaz_v_1c."-(".$right_article.") ".count($new_arr_new_zakaz[$key])."шт";
    // формируем одну поставку и туда суем весь товар с этим артикулом
    $supplyId = make_postavka ($token_wb, $name_postavka); // номер поставки
usleep(300000); // трата на создание Поставки на сайте 1С
    $arr_supply[$right_article] =  array('supplayId'      =>  $supplyId['id'],
                                         'name_postavka'  =>  $name_postavka);
    
    $count_order_art=0; // количество Заказов в поставке
    
    foreach ($items as $item) {
        $orderId = $item['id']; // номер заказа для добавления в сборку
 
    //****  Запуск добавления товара в поставку - НЕВОЗВРАТНАЯ ОПЕРАЦИЯ ***********************************
    //****  раскоментировать при работе -     НЕВОЗВРАТНАЯ ОПЕРАЦИЯ ***********************************
    //****  раскоментировать при работе -     НЕВОЗВРАТНАЯ ОПЕРАЦИЯ *******************************
     $res_query[] = make_sborku_one_article_one_zakaz ($token_wb, $supplyId['id'], $orderId);
    $count_order_art++;
    usleep(100000); // трата на времени на добавление товара в поставку  
     }
usleep(500000); // трата на времени на добавление товара в поставку  
    $arr_real_orders = get_orders_from_supply($token_wb, $supplyId['id']); // список Заказов которые ТОЧНО полпали в Поставку

    foreach ($arr_real_orders as $orders) {
        $new_real_arr_orders[] = $orders['id']; // массив с номерами заказов
    }

// Проверяем есть ли хоть один заказ в Поставке (По мнению ВБ)
 if (!isset($new_real_arr_orders)) {
    $priznzak_net_massiva = 1;
    // ecли этикеток нет, то снова делаем их запрос 
        for ($error_job = 0 ;$error_job < 10; $error_job++) {
//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
            $stamp_date = date('Y-m-d H:i:s');
            echo "<br>$stamp_date - (ALARM)Нет Заказов в поставке:".$supplyId['id']." - цикл :$error_job<br>";
//******************************************************************************************
            
            usleep(500000);
            $arr_real_orders_error = get_orders_from_supply($token_wb, $supplyId['id']); // список Заказов которые ТОЧНО полпали в Поставку

            foreach ($arr_real_orders_error as $orders) {
                $new_real_arr_orders[] = $orders['id']; // массив с номерами заказов
            }
            
            if (isset($new_real_arr_orders)) { // Появились заказы в поставке
                
//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
                $stamp_date = date('Y-m-d H:i:s');
                echo "<br>$stamp_date - (DIS_ALARM) Появились заказы в поставке:".$supplyId['id']." - цикл :$error_job<br>";
//******************************************************************************************
                break;
                
            }

        
    } 
 }

// проверяем, чтобы количество заказов совпадало отправленные и фактически загруженные

if (count($new_real_arr_orders) < $count_order_art) { 
    $priznzak_ne_ves_massiv = 1;
    for ($jj = 0; $jj < 20; $jj++) {
    //********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
          $stamp_date = date('Y-m-d H:i:s');
          echo "<br>$stamp_date - (ALARM) Не Хватает заказов в Поставкe - цикл:$jj<br>";
    //******************************************************************************************
  
            $real_temp_count = count($new_real_arr_orders);
            unset($new_real_arr_orders);
            unset($arr_real_orders_error);
//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
    $stamp_date = date('Y-m-d H:i:s');
    echo "<br>$stamp_date - (ALARM) Не хватает Заказов в поставке ($real_temp_count), должно быть ($count_order_art)<br>";
//******************************************************************************************
          
usleep(500000);

            $arr_real_orders_error = get_orders_from_supply($token_wb, $supplyId['id']); // список Заказов которые ТОЧНО полпали в Поставку

            foreach ($arr_real_orders_error as $orders) {
                $new_real_arr_orders[] = $orders['id']; // массив с номерами заказов
            }
     if (count($new_real_arr_orders) == $count_order_art) { 
        $real_temp_count = count($new_real_arr_orders);

//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
    $stamp_date = date('Y-m-d H:i:s');
    echo "<br>$stamp_date - (DIS_ALARM) Дописались остальные заказы ($real_temp_count), должно быть ($count_order_art)<br>";
//******************************************************************************************
       
        break;
         }
 }
}
// echo "<br>***********     Массив с номера заказов          <br>";
// print_r($new_real_arr_orders);
// echo "<br>***********     Массив с номера заказов  КОНЕЦ        <br>";



// *********************  формируем и сохраняем стикеры себе на комп
if (isset($new_real_arr_orders)) { // проверят есть ли массив 
    $ArrFileNameForZIP[] = get_stiker_from_supply ($token_wb, $new_real_arr_orders, $Zakaz_v_1c , $right_article , $path_stikers_orders); // формируем стикеры за этой поставки
} else {
    echo ("НЕТ данных для формирования этикеток. Возможно заказы не подгрузили в поставку WB№_".$supplyId['id']." .<br>");
   }
// *********************  формируем массив реальных заказов для 1С ******
//    $arr_for_1C_file[$key] = $arr_real_orders; // 

 if (($priznzak_net_massiva == 0) AND ($priznzak_ne_ves_massiv == 0)) {
    $arr_for_1C_file_temp[$key] = $arr_real_orders; // Массчив для 1С файла (и для JS файла)

 } else {
    $arr_for_1C_file_temp[$key] = $arr_real_orders_error; // Массчив для 1С файла (и для JS файла)
 }
   



//*********** удаляем временные массивы ****************
    unset($arr_real_orders);
    unset($arr_real_orders_error);
    unset($new_real_arr_orders);


}








/******************************************************************************************
 *  ************   Формируем ексель файл для 1С
 ******************************************************************************************/

// echo "<br>**************** Формируем ексель файлик для 1С  ******************************************<br>";

// $xls = new PHPExcel();
//         $xls->setActiveSheetIndex(0);
//         $sheet = $xls->getActiveSheet();
//         $i=1;

// echo "<br>**************** МАССИВ ПО Которому формируем 1С файл *********<br>";
// echo "<pre>";
// print_r($arr_for_1C_file);

// foreach ($arr_for_1C_file  as $key => $items) {
//            $right_article = make_right_articl($key);
//             $sheet->setCellValue("A".$i, $right_article);
//             $sheet->setCellValue("C".$i, count($new_arr_new_zakaz[$key]));
//             // высчитываем среднюю цену за товар
//             $sum=0;
//             foreach ($items as $item) {
//                 $sum = $sum + $item['convertedPrice'];
//                 }
//              if (count($items) >0) {   
//             $midlle_price= ($sum/count($items))/100;
//             $sheet->setCellValue("D".$i, $midlle_price); // цена за 1 шт товара
//              } else {
//                 $sheet->setCellValue("D".$i, "no data"); // цена за 1 шт товара
//              }

//             $i++; // смешение по строкам
        
//        }
        
//         $objWriter = new PHPExcel_Writer_Excel2007($xls);
//         // $rnd100000 = "(".rand(0,10000).")";
       
//         $file_name_1c_list = $Zakaz_v_1c."_".date('Y-m-d').$rnd100000."_file_1C.xlsx";
//         // $objWriter->save("EXCEL/$wb_path/".$file_name_1c_list);
//         $objWriter->save($new_path."/".$file_name_1c_list);

/*************************************************************************************************
 *************    НОвый массив 1С с учетом облманых массивов по списываию данных с сайта ВБ
 ************************************************************************************************/
//********************* ДАТА ВРЕМЯ + КОММЕНТАРИЙ *******************************************
$stamp_date = date('Y-m-d H:i:s');
echo "<br> $stamp_date - Формируем файл для 1С <br>";
//******************************************************************************************
        // echo "<pre>";
        // print_r($arr_for_1C_file_temp);          

    $next_i = 1;
        foreach ($arr_for_1C_file_temp  as $key => $q_items) {
            $right_article = make_right_articl($key);
             $sheet->setCellValue("A".$next_i, $right_article);
             $sheet->setCellValue("C".$next_i, count($new_arr_new_zakaz[$key]));
             // высчитываем среднюю цену за товар
             $sum_q=0;
             foreach ($q_items as $q_item) {
                 $sum_q = $sum_q + $q_item['convertedPrice'];
                 }
              if (count($q_items) > 0) {   
             $midlle_price_q= ($sum_q/count($q_items))/100;
             $sheet->setCellValue("D".$next_i, $midlle_price_q); // цена за 1 шт товара
              } else {
                 $sheet->setCellValue("D".$next_i, "no data"); // цена за 1 шт товара
              }
 
             $next_i++; // смешение по строкам
         
        }
         
         $objWriter = new PHPExcel_Writer_Excel2007($xls);
         $rnd1000001 = "(".rand(0,10000).")";
        
         $file_name_1c_list_q = $Zakaz_v_1c."_".date('Y-m-d').$rnd1000001."_file_1C_(NEW).xlsx";
         $objWriter->save($new_path."/".$file_name_1c_list_q);     



/******************************************************************************************
 *  ***************   Формируем архив со стикерами для данного Заказа
 ******************************************************************************************/
// $zip = new ZipArchive();
// $zip->open("zip_arc/$wb_path/"."Stikers_".$Zakaz_v_1c." от ".date("Y-M-d").".zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
//  foreach ($ArrFileNameForZIP as $zips) {
//     $zip->addFile("pdf/".$zips, "$zips"); // Добавляем пдф файлы
//  }
//    $zip->addFile("EXCEL/$wb_path/".$file_name_1c_list, "$file_name_1c_list"); // добавляем для 1С файл
//     $zip->close();   

// ВТОРОЙ ЗИП АРХИВ (НОВЫХ)
echo "reports/".$path_arhives."/"."Stikers_".$Zakaz_v_1c." от ".date("Y-M-d").".zip";
    $link_dowonload_stikers = $path_arhives."/"."Stikers_".$Zakaz_v_1c." от ".date("Y-M-d").".zip";
    $zip_new = new ZipArchive();
    $zip_new->open($path_arhives."/"."Stikers_".$Zakaz_v_1c." от ".date("Y-M-d").".zip", ZipArchive::CREATE|ZipArchive::OVERWRITE);
 
    foreach ($ArrFileNameForZIP as $zips) {
    $zip_new->addFile($path_stikers_orders."/".$zips, "$zips"); // Добавляем пдф файлы
 }
    // $zip_new->addFile($new_path."/".$file_name_1c_list, "$file_name_1c_list"); // добавляем для 1С файл /// *****************
    $zip_new->addFile($new_path."/".$file_name_1c_list_q, "$file_name_1c_list_q"); // добавляем для НОВЫЙ 1С файл /// *****************
    $zip_new->close();   

/******************************************************************************************
 *  ************************   Формируем JSON со списком поставок
 ******************************************************************************************/
 
$filedata_json = json_encode($arr_supply, JSON_UNESCAPED_UNICODE);
$file_json_new = $new_path."/".$Zakaz_v_1c." от ".date("Y-M-d").".json";
file_put_contents($file_json_new, $filedata_json, FILE_APPEND); // добавляем данные в файл с накопительным итогом

// для восстановления 
$recovery_array = ["token"             => $token_wb,
                   "json_path"         => $file_json_new,
                   "path_qr_supply"    => $path_qr_supply,
                   "path_arhives"      => $path_arhives,
                   "downloads_stikers" => $link_dowonload_stikers,
                   "Zakaz1cNumber"     => $Zakaz_v_1c];
$recovery_data_json = json_encode($arr_supply, JSON_UNESCAPED_UNICODE);
$file_recovery_data_json = $new_path."/not_ready_supply.json"; // создаем файл для продолжение перевода в доставку товаров
file_put_contents($recovery_data_json, $file_recovery_data_json, FILE_APPEND); // добавляем данные в файл с накопительным итогом

/******************************************************************************************
 *  *********************   Формируем JSON со списком реальных заказов (ДЛЯ ОТРАБОТКИ)
 ******************************************************************************************/
 
 $filedata_json_orders = json_encode($arr_for_1C_file_temp, JSON_UNESCAPED_UNICODE);
 file_put_contents($new_path."/".$Zakaz_v_1c." от ".date("Y-M-d")."_real_orders.json", $filedata_json_orders, FILE_APPEND); // добавляем данные в файл с накопительным итогом

/******************************************************************************************
 *  **************   ДУБЛИРУЕМ ВСЕ ОПЕРАЦИИ С ПОМОЩТЮ ФУНКЦИЙ (ДЛЯ ОТРАБОТКИ)
 ******************************************************************************************/
// make_1c_file_($arr_for_1C_file, $new_arr_new_zakaz, $Zakaz_v_1c);  // ексель для 1С
// make_zip_archive($ArrFileNameForZIP, $Zakaz_v_1c, $file_name_1c_list ); // zip архив этикеток и 1с файла




/******************************************************************************************
 *  **************   Выводим кнопку для продолжения работы -> перевод поставок в ДОСТАВКУ
 ******************************************************************************************/
$link_q1=$path_arhives."/"."Stikers_".$Zakaz_v_1c." от ".date("Y-M-d").".zip";

 echo "<a href=\"$link_q1\">СКАЧАТЬ АРХИВ СО СТИКЕРАМИ И ФАЙЛОМ для 1С(новый)</a>"; // 

echo <<<HTML
<form action="make_dostavka.php" method="post">
<label for="wb">ПЕРЕВЕЗТИ ЗАКАЗЫ В ДОСТАВКУ</label><br>
<label for="wb">Номер заказа</label><br>
  <input hidden type="text" name="token" value="$token_wb">
  <input hidden type="text" name="json_path" value="$file_json_new">
  
  <input hidden type="text" name="path_qr_supply" value="$path_qr_supply">
  <input hidden type="text" name="path_arhives" value="$path_arhives">
  <input hidden type="text" name="downloads_stikers" value="$link_dowonload_stikers">

  

  <input hidden type="text" name="Zakaz1cNumber" value="$Zakaz_v_1c">
  <input type="submit" value="В ДОСТАВКУ">
</form>
HTML;

die('FINISH WORK');

// Функция готовить информацию и запускает добавление товара в поставку
function make_sborku_one_article_one_zakaz ($token_wb, $supplyId, $orderId){
    $data = array(
        'supplyId' => $supplyId,
        'orderId' => $orderId
        );
        $link_wb = 'https://suppliers-api.wildberries.ru/api/v3/supplies/'.$supplyId."/orders/".$orderId;
    
// echo "<br>$link_wb<br>"; // выводим ссылку на экран
    
    //  Запуск добавления товара в поставку - НЕВОЗВРАТНАЯ ОПЕРАЦИЯ ***********************************
    // раскоментировать при работе
        $res =  patch_query_with_data($token_wb, $link_wb, $data);

        // echo "<pre>";
        // print_r($res);
return $res;
}

