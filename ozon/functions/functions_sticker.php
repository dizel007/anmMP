<?php


/************************************************************************
 * Достаем штрих коды массива заказов (отправления)
 * РАБОЧАЯ ВЕРСИЯ 
 *************************************************************************/
function get_all_barcodes_for_all_sending ($token, $client_id,   $string_etiket, $date_send, $path_etiketki) {
    echo "<pre>";
    // Данные запроса
    $send_data='
    {
        "posting_number": ['.
        $string_etiket.'
        ]
      }
    ';
 
    // Метод запрос на подготовку этикетки 
    $ozon_dop_url ="v1/posting/fbs/package-label/create";
    $res = send_injection_on_ozon($token, $client_id, $send_data, $ozon_dop_url );
    
    sleep(5);
    // Получаем task_id на скачивание файла с штрих кодами
    $task_id = $res['result']['task_id'];
    
    // echo "<br> Задание на скачивание отправлено : ";
    // print_r($task_id);

    $send_data='{"task_id":'.$task_id.'}';
    
    $ozon_dop_url ="v1/posting/fbs/package-label/get";
    $res = send_injection_on_ozon($token, $client_id, $send_data, $ozon_dop_url );
    

    $url = $res['result']['file_url']; // получаем информацию в формате PDF 
    // echo "<br> Ссылка на пдф файл : ";
    // print_r($url);
    
    // НАзвание файла с этикеткой	
        $file = $date_send.".pdf";
       
        if (file_put_contents($path_etiketki."/".$file, file_get_contents($url)))
        {
            echo "Файл со штрихкодам получен";
        }
        else
        {
            echo "Ошибка скачивания файла со штрихкодами.";
        }
    
       return $file;
 }  

 function make_new_dir_z($dir, $append) {
//    echo "<br>Создаем папку: $dir";
    if (!is_dir($dir)) {
        mkdir($dir, 0777, True);
    } 

}