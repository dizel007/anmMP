<?php
require_once "functions/functions.php";
require_once "functions/topen.php";
echo "Ghbdtn";


// функия формирования файла с заказами и номером поставки
function make_recovery_json_orders_file($path_recovery, $orderId, $supplyId, $article) {
    $temp_path = $path_recovery."/".$supplyId;
    make_new_dir_z($temp_path,0); // создаем папку с номером заказа

    $article =  make_rigth_file_name($article);
    file_put_contents($temp_path."/article.txt", $article);
    $orderId = $orderId.";";

    file_put_contents($temp_path."/".$supplyId.".txt", $orderId, FILE_APPEND); // добавляем данные в файл с накопительным итогом


}

make_recovery_json_orders_file('reports\2023-08-01\2633\recovery', '66667777', 'WB-GI-53796161', '82402-ч') ;



$supplyId = 'WB-GI-53892210';
$orderId = '962057195';
$link_wb = 'https://suppliers-api.wildberries.ru/api/v3/supplies/'.$supplyId.'/orders';
$res =  light_query_without_data($token_wb, $link_wb);
echo "<pre>";
print_r($res['orders']);

foreach ($res['orders'] as $temp_orders) {
 if ($orderId == $temp_orders['id']) {
    echo "<br>OK";
 }
}


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