<?php
function send_injection_on_ozon($token, $client_id, $send_data, $ozon_dop_url ) {
 
	$ch = curl_init('https://api-seller.ozon.ru/'.$ozon_dop_url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Api-Key:' . $token,
		'Client-Id:' . $client_id, 
		'Content-Type:application/json'
	));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $send_data); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Получаем HTTP-код

	curl_close($ch);
	
	$res = json_decode($res, true);

   echo     'Результат обмена : '.$http_code. "<br>";
   
    return($res);	

}

/* * ********
Выводим список заказов ОЗОН на определенную дату 
РАБОЧАЯ ВЕРСИЯ 
*** ожидает упаковки ****
*** */
function get_all_waiting_posts_for_need_date($token, $client_id, $date_query_ozon, $send_status, $dop_days_query){
    // awaiting_packaging - заказы ожидают сборку
    // awaiting_deliver   - заказы ожидают отгрузку 
echo "<br>";
// echo $token."<br>";
// echo $client_id."<br>";
// echo $date_query_ozon."<br>";

$temp_dop_day = "+".$dop_days_query.' day';
$date_query_ozon_end = date('Y-m-d', strtotime($temp_dop_day, strtotime($date_query_ozon)));

                        
echo "<br>";


$send_data=  array(
    "dir" => "ASC",
    "filter" => array(
    "cutoff_from" => $date_query_ozon."T00:00:00Z",
    "cutoff_to" =>   $date_query_ozon_end."T23:59:59Z",
    "delivery_method_id" => [ ],
    "provider_id" => [ ],
    "status" => $send_status,
    "warehouse_id" => [ ]
    ),
    "limit" => 1000,
    "offset" => 0,
    "with" => array(
    "analytics_data"  => true,
    "barcodes"  => true,
    "financial_data" => true,
    "translit" => true
    )
    );

 $send_data = json_encode($send_data, JSON_UNESCAPED_UNICODE)  ;  


$ozon_dop_url = "v3/posting/fbs/unfulfilled/list";


// запустили запрос на озона
$res = send_injection_on_ozon($token, $client_id, $send_data, $ozon_dop_url );
return $res;
}

