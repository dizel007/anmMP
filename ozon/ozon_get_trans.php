<?php
/**********************************************************************************************************
 *     ***************    Получаем массив всех транзакций
*********************************************************************************************************/

require_once 'include_funcs.php';

echo <<<HTML
<head>
<link rel="stylesheet" href="css/main_ozon.css">

</head>
HTML;

/*
Подключаем PHPExcel
*/
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel.php';
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';

$date_from = "2023-08-01";
$date_to = "2023-08-31";

$ozon_link = 'v3/finance/transaction/list';
$send_data = array(
    "filter" => array(
        "date" => array (
            "from" => $date_from."T00:00:00.000Z",
            "to"=> $date_to."T00:00:00.000Z"
    ),
        "operation_type" => [],
        "posting_number" => "",
        "transaction_type" => "all"
    ),
    "page" => 1,
    "page_size" => 1000
);
$send_data = json_encode($send_data);

$res = send_injection_on_ozon($token, $client_id, $send_data, $ozon_link );
$page_count = $res['result']['page_count'];
$row_count = $res['result']['row_count'];
echo $page_count ." ". $row_count;

echo "<pre>";
// print_r($res['result']['operations']);
// die('fffffffffffffffffffffffffffffffffffffffffffffffffffffff');

for ($i=1; $i <=$page_count; $i ++) {
    $send_data = array(
        "filter" => array(
            "date" => array (
                "from" => $date_from."T00:00:00.000Z",
                "to"=> $date_to."T00:00:00.000Z"
        ),
            "operation_type" => [],
            "posting_number" => "",
            "transaction_type" => "all"
        ),
        "page" => $i,
        "page_size" => 1000
    );
    $send_data = json_encode($send_data);
    $res = send_injection_on_ozon($token, $client_id, $send_data, $ozon_link );
    $prod_array[] = $res['result']['operations'];

}


require_once "ozon_get_trans_1.php";
require_once "ozon_get_trans_2.php";
