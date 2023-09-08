<?php


    $one_procent_from_sum_amount =  $sum_amount/100; // один процент от суммы к перечислению за все товары

echo <<<HTML
<table class="prod_table">
<tr>
    <td>пп</td>
    <td>Наименование</td>
    <td>Ко-во</td>
    <td>сум к переводу <br> (с сервисн. сборам)</td>
    <td>% от суммы <br> к переводу</td>
    <td>сумма к вычитанию <br>(сервиные сборы)</td>
    <td>сумма к переводу факт<br>(без сервис. сборов)</td>
  <td><b>К НАМ на счет<br> за шт</b></td>
    <td>сумма<br> комиссии ВБ</td>
    <td>Логистика<br> Логистика шт</td>
    <td>сборка<br> сборка шт</td>
    <td>посл.миля<br> посл.миля шт</td>
    <td>НАЧИСЛЕНИЯ</td>

</tr>

HTML;
$i=1;
foreach ($arr_atricrle as $key=>$prod) {
    $name = $arr_atricrle[$key]['name'];
    $qty = $arr_atricrle[$key]['count'];
    $amount = $arr_atricrle[$key]['amount'] ;
    $sale_commission = $arr_atricrle[$key]['sale_commission'] ;
    $logistika = $arr_atricrle[$key]['logistika'];
    $sborka = $arr_atricrle[$key]['sborka'];
    $lastMile = $arr_atricrle[$key]['lastMile'];
    $summa_NACHILS = $amount - $logistika - $sborka - $lastMile;

    $proc_row = $amount / $one_procent_from_sum_amount; // рассчитываем процент от всей суммы к переводу ( сколько % суммы товара в полной сумме)
    $proc_row_temp = number_format($proc_row,2);
    $sum_row_ruble = ($summa_vseh_sborov/100) * $proc_row; // ссервисные сборы за каждый товар 
    $sum_row_ruble_temp = number_format($sum_row_ruble,2);
    $sum_row_perevod_fact = $amount + $sum_row_ruble; // фактическая сумма которую нам первели за товары одного артикула
    $sum_row_perevod_fact_temp = number_format($sum_row_perevod_fact,2);
    $price_row_one_item = $sum_row_perevod_fact/$qty;
    $price_row_one_item_temp = number_format($price_row_one_item,2);
    $logistika_one_item = number_format($logistika/$qty,2);
    $sborka_one_item = number_format($sborka/$qty,2);
    $lastMile_one_item = number_format($lastMile/$qty,2);
// Считаем стольбы с суммами
    // $sum_amount = @$sum_amount+ $amount;
    // $sum_sale_commission = @$sum_sale_commission + $sale_commission;
    // $sum_logistika = @$sum_logistika+ $logistika;
    // $sum_sborka = @$sum_sborka + $sborka;
    // $sum_lastMile = @$sum_lastMile + $lastMile;
    // $sum_nas_all = @$sum_nas_all + $summa_NACHILS; // сумма начислений с сервисными сборами

// $name_temp = substr($name, -30); 
echo <<<HTML
<tr>
    <td>$i</td>
    <td>$name</td>
    <td>$qty</td>
    <td>$amount</td>
    <td>$proc_row_temp</td>
    <td>$sum_row_ruble_temp</td>
    <td>$sum_row_perevod_fact_temp</td>
<td><b>$price_row_one_item_temp</b></td>
    <td>$sale_commission</td>
    <td>$logistika <br> $logistika_one_item</td>
    <td>$sborka<br>$sborka_one_item</td>
    <td>$lastMile<br>$lastMile_one_item</td>
    <td>$summa_NACHILS</td>
 </tr>
    
HTML;
$sum_proc = @$sum_proc +   $proc_row ;
$sum_row_ruble_sum = @$sum_row_ruble_sum  + $sum_row_ruble ;
$sum_k_prervodu_fact = @$sum_k_prervodu_fact  + $sum_row_perevod_fact ;
$i++;
}

    $sum_amount_temp = number_format($sum_amount,2, ',' , ' ');
    $sum_sale_commission_temp = number_format($sum_sale_commission,2, ',' , ' ');
    $sum_logistika_temp = number_format($sum_logistika,2, ',' , ' ');
    $sum_sborka_temp = number_format($sum_sborka,2, ',' , ' ');
    $sum_lastMile_temp = number_format($sum_lastMile,2, ',' , ' ');
    $sum_nas_all_temp = number_format($sum_nas_all,2, ',' , ' ');



    $sum_proc_temp = number_format($sum_proc,2);
    $sum_row_ruble_sum_temp = number_format($sum_row_ruble_sum,2);
    $sum_k_prervodu_fact_temp = number_format($sum_k_prervodu_fact,2);
echo <<<HTML
<tr>
    <td></td>
    <td></td>
    <td></td>
    <td>$sum_amount_temp</td>
    <td>$sum_proc_temp</td>
    <td>$sum_row_ruble_sum_temp</td>
    <td>$sum_k_prervodu_fact_temp</td>
    <td></td>
    <td>$sum_sale_commission_temp</td>
    <td>$sum_logistika_temp</td>
    <td>$sum_sborka_temp</td>
    <td>$sum_lastMile_temp</td>
    <td>$sum_nas_all_temp</td>
 </tr>
</table>
HTML;


