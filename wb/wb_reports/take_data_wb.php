<?php
require_once "functions/functions.php";
require_once "wb_get_sebes.php";
require_once "../functions/topen.php";
/// для ООО
if (isset($_GET['wb'])){
if ($_GET['wb'] == 1) {
$token_wb_stat = $token_wb_stat;
echo "<b>СТАТИСТИКА ДЛЯ ООО</b>";
}
/// для ИП
if ($_GET['wb'] == 2) {
    $token_wb_stat = $token_wb_ip_stat;
    echo "<b>СТАТИСТИКА ДЛЯ ИП</b>";
}
}
    

if (isset($_GET['dateFrom'])) {
    $dateFrom = $_GET['dateFrom'];
} else {
    $dateFrom = false;
}

if (isset($_GET['dateTo'])) {
    $dateTo = $_GET['dateTo'];
} else {
    $dateTo = false;
}


echo <<<HTML
<head>
<link rel="stylesheet" href="css/main_table.css">

</head>
<body>

<form action="" method="get">
<label>Магазин</label>
<select required name="wb">
    <option value = "1">WB ООО</option>
    <option value = "2">WB ИП</option>
</select>


<label>дата начала</label>
<input required type="date" name = "dateFrom" value="$dateFrom">
<label>дата окончания</label>
<input required type="date" name = "dateTo" value="$dateTo">

<input type="submit"  value="START">
</form>
HTML;


if (($dateFrom == false) or ($dateTo == false)) {
die ('Нужно выбрать даты');
} 

$dop_link = "?dateFrom=".$dateFrom."&limit=100000&dateTo=".$dateTo."&rrdid=0";
$link_wb = "https://statistics-api.wildberries.ru/api/v1/supplier/reportDetailByPeriod".$dop_link;

$arr_result = light_query_without_data($token_wb_stat, $link_wb);

// echo "<pre>";
// print_r($arr_result);


if ((@$arr_result['code'] == 401)) {
    die ('<br>НЕТ ДАННЫХ ДЛЯ ВЫВОДА, ВБ НЕ ВЕРНУЛ МАССИВ');
}
  // формируем массива с артикулами
  foreach ($arr_result as $item) {
    $arr_key[] = $item['sa_name']; // массив артикулов
  }
  $arr_key = array_unique($arr_key); //  оставляем только уникальные артикулы




$sum_k_pererchisleniu = 0;
$sum_logistiki = 0;
$sum_shtraf = 0 ;
$sum_voznagrazhdenie_wb = 0;
$sum_vozvratov = 0;
$sum_avance = 0 ;
$sum_brak = 0;
$sum_nasha_viplata = 0;


foreach ($arr_result as $item) {

    // Сумма к перечислению************************************************************************************************************
    if ($item['supplier_oper_name'] == 'Продажа') {
        $arr_sum_k_pererchisleniu[$item['sa_name']] = @$arr_sum_k_pererchisleniu[$item['sa_name']] + $item['ppvz_for_pay'];
        $sum_k_pererchisleniu = $sum_k_pererchisleniu  + $item['ppvz_for_pay'];
        $arr_count[$item['sa_name']] = @$arr_count[$item['sa_name']] + 1;
    }
 
    // Сумма возвоатов ************************************************************************************************************
    if ($item['supplier_oper_name'] == 'Возврат') {
        $arr_sum_vozvratov[$item['sa_name']] = @$arr_sum_vozvratov[$item['sa_name']] + $item['ppvz_for_pay'];
        $sum_vozvratov = $sum_vozvratov  + $item['ppvz_for_pay'];
        $arr_count[$item['sa_name']] = @$arr_count[$item['sa_name']] - 1;
    }
    
    // Авансовая оплата за товар без движения
    if ($item['supplier_oper_name'] == 'Авансовая оплата за товар без движения') {
        $arr_sum_avance[$item['sa_name']] = @$arr_sum_avance[$item['sa_name']] + $item['ppvz_for_pay'];
        $sum_avance = $sum_avance  + $item['ppvz_for_pay'];
    }

    //Частичная компенсация брака
    if ($item['supplier_oper_name'] == 'Частичная компенсация брака') {
        $arr_sum_brak[$item['sa_name']] = @$arr_sum_brak[$item['sa_name']] + $item['ppvz_for_pay'];
        $sum_brak = $sum_brak  + $item['ppvz_for_pay'];
    }


    // Сумма логистики ************************************************************************************************************
    if ($item['supplier_oper_name'] == 'Логистика') {
        $arr_sum_logistik[$item['sa_name']] = @$arr_sum_logistik[$item['sa_name']] + $item['delivery_rub'];
        $sum_logistiki = $sum_logistiki  + $item['delivery_rub'];
    }

    // Сумма ШТРАФОв   ************************************************************************************************************
    if ($item['supplier_oper_name'] == 'Штрафы') {
        $arr_sum_shtraf[$item['sa_name']] = @$arr_sum_shtraf[$item['sa_name']] + $item['penalty'];
        $sum_shtraf = $sum_shtraf  + $item['penalty'];
    }
    
    // Вознаграждение ВБ  ************************************************************************************************************
   
        $arr_sum_voznagrazhdenie_wb[$item['sa_name']] = @$arr_sum_voznagrazhdenie_wb[$item['sa_name']] + $item['ppvz_vw']  + $item['ppvz_vw_nds'];
        $sum_voznagrazhdenie_wb = $sum_voznagrazhdenie_wb  + $item['ppvz_vw']  + $item['ppvz_vw_nds'];
   
    }



echo <<<HTML
<table class="prod_table">
  <tr>
<td>Артикул</td>
<td>Кол-во<br> продаж</td>
<td>Сумма выплат с ВБ</td>
<td>Авансовая <br>оплата</td>

<td>Компенсация<br> брака</td>
<td>Возвраты</td>
<td>Стоимость <br> логистки</td>

<td>Комиссия ВБ</td>
<td>Штрафы ВБ</td>
<td>НАША ВЫПЛАТА</td>
<td>цена за шт</td>
<td>Себест</td>
<td>Дельта</td>
<td>Прибыль<br> с артикула</td>
 </tr>


HTML;


$sebestoimos = get_sebestiomost_wb ();
 foreach ($arr_key as $key){
// Находим себестоимость товара
    foreach ($sebestoimos as $sebes_item) {
        $right_key = mb_strtolower(make_right_articl($key));
        $right_atricle = mb_strtolower($sebes_item['article']);
        // echo "$right_key  и $right_atricle"."<br>";
        if ($right_atricle ==  $right_key) {
           $sebes_str_item = $sebes_item['sebestoimost'] ;
        //    echo "**************************** $right_key  и $right_atricle"."<br>";
           break;
        } else {
            $sebes_str_item = 0;
        }
       }

     echo "<tr>";
        echo "<td>".$key."</td>";
        echo "<td>".@$arr_count[$key]."</td>";
///     Сумма выплат с ВБ до вычета 
echo "<td class=\"plus\">".number_format(@$arr_sum_k_pererchisleniu[$key],2, ',', ' ')."</td>";

// Авансовая оплата за товар без движения
echo "<td class=\"plus\">".number_format(@$arr_sum_avance[$key],2, ',', ' ')."</td>"; 


///     Сумма компенсация брака 
echo "<td class=\"plus\">".number_format(@$arr_sum_brak[$key],2, ',', ' ')."</td>"; 

///     Сумма выплат с возвратов 
echo "<td class=\"minus\">".number_format(@$arr_sum_vozvratov[$key],2, ',', ' ')."</td>";

///     Сумма ЛОгистики 
 echo "<td class=\"minus\">".number_format(@$arr_sum_logistik[$key],2, ',', ' ')."</td>";



///     Сумма Комиссии ВБ
echo "<td class=\"minus\">".number_format(@$arr_sum_voznagrazhdenie_wb[$key],2, ',', ' ')."</td>";

///     Сумма Штрафов  
echo "<td class=\"minus\">".number_format(@$arr_sum_shtraf[$key],2, ',', ' ')."</td>";


///     Сумма к выплате
$temp[$key] =  @$arr_sum_k_pererchisleniu[$key] - @$arr_sum_vozvratov[$key] + @$arr_sum_avance[$key] +  
@$arr_sum_brak[$key] - @$arr_sum_logistik[$key] - @$arr_sum_shtraf[$key];
$sum_nasha_viplata = $sum_nasha_viplata + $temp[$key];

echo "<td class=\"our_many\">".number_format(@$temp[$key],2, ',', ' ')."</td>";  
if (isset($arr_count[$key])) {
$price_for_shtuka = @$temp[$key]/@$arr_count[$key];
} else {
    $price_for_shtuka = 0;
}
///     Цена за штуку
echo "<td>".number_format($price_for_shtuka,2, ',', ' ')."</td>"; // цена за штукту

///     себестоимость
echo"<td class=\"plus\">"."$sebes_str_item"."</td>"; // себестоимость
$temp_delta = ($price_for_shtuka - $sebes_str_item);

///     Разница в стоимости
echo"<td class=\"plus\">".number_format($temp_delta,2, ',', ' ')."</td>"; // дельта
$our_pribil  = $temp_delta * @$arr_count[$key];

$sum_our_pribil = @$sum_our_pribil + $our_pribil; // Наша заработок по всем артикулам

///     Заработок с артикула 
echo"<td class=\"our_many\"><b>".number_format($our_pribil,2, ',', ' ')."</b></td>"; // заработали на артикуле
  echo "</tr>";

}

echo"<tr>";
echo"<td></td>";
echo"<td></td>";
echo"<td class=\"plus\"><b>".number_format($sum_k_pererchisleniu,2, ',', ' ')."</b></td>";
echo"<td class=\"plus\"><b>".number_format($sum_avance,2, ',', ' ')."</b></td>";
echo"<td class=\"plus\"><b>".number_format($sum_brak,2, ',', ' ')."</b></td>";
echo"<td class=\"minus\"><b>".number_format($sum_vozvratov,2, ',', ' ')."</b></td>";
echo"<td class=\"minus\"><b>".number_format($sum_logistiki,2, ',', ' ')."</b></td>";
echo"<td class=\"minus\"><b>".number_format($sum_voznagrazhdenie_wb,2, ',', ' ')."</b></td>";
echo"<td class=\"minus\"><b>".number_format($sum_shtraf,2, ',', ' ')."</b></td>";
echo"<td class=\"our_many\"><b>".number_format($sum_nasha_viplata,2, ',', ' ')."</b></td>";
echo"<td></td>";
echo"<td></td>";
echo"<td></td>";
echo"<td class=\"our_many\"><b>".number_format($sum_our_pribil,2, ',', ' ')."</b></td>";
echo "</tr>";



echo "</table>";

die('РАСЧЕТ ОКОНЧЕН');








