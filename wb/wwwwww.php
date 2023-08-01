<?php
require_once "functions/functions.php";
require_once "functions/topen.php";
echo "Ghbdtn";


// функия формирования файла с заказами и номером поставки
function make_recovery_json_orders_file($path_recovery, $orderId, $supplyId, $article) {
    $temp_path = $path_recovery."/".$supplyId;
    make_new_dir_z($temp_path,0); // создаем папку с номером заказа

    $article =  make_rigth_file_name($article);
    $article =  make_right_articl($article);
    file_put_contents($temp_path."/article.txt", $article);
// Если существует файл поставки, то открываем его 
    if (file_exists($temp_path."/".$supplyId.".txt")) {
        $str_file = file_get_contents($temp_path."/".$supplyId.".txt");
        $arr_file = json_decode($str_file);
        $sigh_order=0;

 //  перебираем все заказы из файла
        foreach ($arr_file as $order) {
            if ($order == $orderId) {
                $sigh_order=1;
            }
        }
        if ($sigh_order == 0) {
            $arr_file[] = $orderId; // добавляем заказ в поставку
            $filedata_json = json_encode($arr_file, JSON_UNESCAPED_UNICODE);
            file_put_contents($temp_path."/".$supplyId.".txt", $filedata_json); // добавляем данные в файл с накопительным итогом
        } else { // если заказ есть в поставке, то не пишем его туда
            $arr_orderId = $arr_file; // сохраняем старые заказы
            $filedata_json = json_encode($arr_orderId, JSON_UNESCAPED_UNICODE);
            file_put_contents($temp_path."/".$supplyId.".txt", $filedata_json); // добавляем данные в файл с накопительным итогом
        }

    } else { // если файл не существует , то пишем первый заказ
        $arr_orderId[] = $orderId; // добавляем в файл первый заказ
        $filedata_json = json_encode($arr_orderId, JSON_UNESCAPED_UNICODE);
        file_put_contents($temp_path."/".$supplyId.".txt", $filedata_json); // добавляем данные в файл с накопительным итогом 
    }
    

}

make_recovery_json_orders_file('reports\2023-08-01\2633\recovery', '66677337727', 'WB-GI-53796521', '82402-ч') ;



// $supplyId = 'WB-GI-53892210';
// $orderId = '962057195';
// $link_wb = 'https://suppliers-api.wildberries.ru/api/v3/supplies/'.$supplyId.'/orders';
// $res =  light_query_without_data($token_wb, $link_wb);
// echo "<pre>";
// print_r($res['orders']);

// foreach ($res['orders'] as $temp_orders) {
//  if ($orderId == $temp_orders['id']) {
//     echo "<br>OK";
//  }
// }


die('333');


$dir    = 'reports/';
$dirs = get_dir_catalog($dir);

echo "<pre>";

foreach ($dirs as $item) {
    $temp_dir = get_dir_catalog("reports/".$item."/");
   foreach ($temp_dir as $item_w) {
    $files_alarm = get_dir_catalog("reports/".$item."/".$item_w."/");
    print_r($files_alarm);
    foreach ($files_alarm as $item_z) {
        if ($item_z == 'not_ready_supply.xxx') {
            echo "<br>FIND DIN************************************************<br>";
            $open_orders[] = "reports/".$item."/".$item_w."/".$item_z;
        }
    }
   }
}



print_r($open_orders);

$file = 'not_ready_supply.xxx';
if(!is_file($file)){
    $contents = 'NOT READY FOR SUPPLY';           // Some simple example content.
    file_put_contents($file, $contents);          // Save our content to the file.
}


function get_dir_catalog($path) {
    $temp_dir = scandir($path."/");
    foreach ($temp_dir as $item) {
        if (($item ==".") or ($item =="..")) {
            continue;
            }
        $new_dir[] = $item;
    }
return $new_dir;
}