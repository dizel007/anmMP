<?php
/**********************************************************************************************************
 *     ***************    Получаем массив всех транзакций
*********************************************************************************************************/

require_once '../include_funcs.php';
require_once '../../mp_sklad/functions/ozon_catalog.php';
require_once "ozon_get_trans_6(sebes).php"; // массив с себестоимостью товаров

echo <<<HTML
<head>
<link rel="stylesheet" href="../css/main_ozon.css">

</head>
HTML;

/*
Подключаем PHPExcel
*/
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel.php';
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
// require_once '../libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';


if (isset($_GET['dateFrom'])) {
    $date_from = $_GET['dateFrom'];
} else {
    $date_from = false;
}

if (isset($_GET['dateTo'])) {
    $date_to = $_GET['dateTo'];
} else {
    $date_to = false;
}


echo <<<HTML
<head>
<link rel="stylesheet" href="css/main_table.css">

</head>
<body>

<form action="#" method="get">
<label>Магазин</label>
<select required name="ozon">
    <option value = "1">OZON</option>
</select>


<label>дата начала</label>
<input required type="date" name = "dateFrom" value="$date_from">
<label>дата окончания</label>
<input required type="date" name = "dateTo" value="$date_to">

<input type="submit"  value="START">
</form>
HTML;

if (($date_from == false) or ($date_to == false)) {
    die ('Нужно выбрать даты');
    } 

// $date_from = "2023-08-19";
// $date_to = "2023-09-19";
echo "Период запроса с ($date_from) по  ($date_to)<br>";
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
