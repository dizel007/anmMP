<?php
/**
 * Тут будем пробовать строить систему восстановления работы программы при сбоях
 */
 //********************************************************************************************************************************* */

 // функция созжает маркерный файл, что сборка началась
function create_marker_recover_file($new_path) {
 $file_recovery = 'not_ready_supply.xxx';
 if(!is_file($new_path.'/recovery/'.$file_recovery)){
     $contents = 'NOT READY FOR SUPPLY';           // Some simple example content.
     file_put_contents($new_path.'/recovery/'.$file_recovery, $contents);          // Save our content to the file.
 }
}
 //********************************************************************************************************************************* */
 // функция удаляет маркерный файл, что сборка закончилась
 function delete_marker_recover_file($new_path) {
    $file_recovery = 'not_ready_supply.xxx';
    unlink($new_path.'/recovery/'.$file_recovery);
   }
   
 //********************************************************************************************************************************* */
// функция проверяет наличие Заказа в Поставке
// Если заказ в поставке, то вернется 0, если нет то 1
 function test_find_order_in_supply ($token_wb, $orderId, $supplyId) {
    // $supplyId = 'WB-GI-53892210';
    // $orderId = '962057195';
    usleep(10000); // 10ms pause
    $link_wb = 'https://suppliers-api.wildberries.ru/api/v3/supplies/'.$supplyId.'/orders';
    $res =  light_query_without_data($token_wb, $link_wb);
    // echo "<pre>";
    // print_r($res['orders']);
 foreach ($res['orders'] as $temp_orders) 
  {
        if ($orderId == $temp_orders['id']) {
            echo "<br> Заказ: $orderId в Поставке: $supplyId(УСПЕШНО)";
            return 0;
        }
        
  } 
  echo "<br> Заказа: $orderId НЕТ в Поставке: $supplyId (ОТКАЗ)";
  return 1;

 }

 //********************************************************************************************************************************* */
// функия формирования файла с заказами и номером поставки
function make_recovery_json_orders_file($path_recovery, $orderId, $supplyId, $article) {
    $article = make_rigth_file_name($$article);
    file_put_contents($path_recovery."/".$article.".txt", $article);
    $orderId = $orderId.";";

    file_put_contents($path_recovery."/".$supplyId.".txt", $orderId, FILE_APPEND); // добавляем данные в файл с накопительным итогом


}




