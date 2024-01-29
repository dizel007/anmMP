<?php 

// CSS цепляем
echo "<link rel=\"stylesheet\" href=\"css/main_ozon_reports.css\">";



echo "<table class=\"fl-table\">";

// ШАПКА ТАблицы
echo "<tr>";
    // echo "<th style=\"width:10%\">Наименование</th>";
    echo "<th>Артикл</th>";
    echo "<th>Кол-во<br>продано<br>(шт)</th>";
    echo "<th>Цена<br>для пок-ля<br>(руб)</th>";
    echo "<th>Сумма<br>продаж<br>(руб)</th>";
    echo "<th>Комиссия<br>Озон<br>(руб)</th>";
    echo "<th>Логистика<br>(руб)</th>";
    echo "<th>Сборка<br>(руб)</th>";
    echo "<th>Посл.миля<br>(руб)</th>";

    echo "<th>Кол-во<br>продано<br>FBO(шт)</th>";
    echo "<th>Сумма<br>продаж<br>FBO(руб)</th>";
    echo "<th>Комиссия<br>Озон<br>FBO(руб)</th>";
    echo "<th>Логистика<br>FBO(руб)</th>";
    echo "<th>Сбор<br>FBO<br>(руб)</th>";
    echo "<th>Посл.миля<br>FBO(руб)</th>";



    echo "<th>Кол-во<br>продано<br>FBS(шт)</th>";
    echo "<th>Сумма<br>продаж<br>FBS(руб)</th>";
    echo "<th>Комиссия<br>Озон<br>FBS(руб)</th>";
    echo "<th>Логистика<br>FBS(руб)</th>";
    echo "<th>Сборка<br>FBS(руб)</th>";
    echo "<th>Посл.миля<br>FBS(руб)</th>";

    echo "<th>Хранение<br>утилизация<br>(руб)</th>";
    echo "<th>Удерж<br>за недовл<br>(руб)</th>";
    echo "<th>Эквайринг<br>(руб)</th>";
    echo "<th>Возвраты<br>(шт)</th>";
    echo "<th>Возвраты<br>(руб)</th>";



echo "</tr>";


foreach ($arr_article as $key=>$item) {
    $article = get_article_by_sku_fbs($ozon_sebest, $key); // получаем артикл по СКУ

   /// ОБЩИЕ СУММЫ 
    @$count +=$item['count']; // сумма продажи 
    @$amount +=$item['amount']; // сумма продажи 
    @$accruals_for_sale +=$item['accruals_for_sale']; // сумма продажи 
    @$one_shtuka = round($item['amount']/$item['count'],2); // цена за штуку нам в карман (минус эквайринг)
    @$one_shtuka_buyer = round($item['accruals_for_sale']/$item['count'],2); // цена за штуку для покупателя



    @$sale_commission +=$item['sale_commission']; // Общая стоимость 
    @$logistika +=$item['logistika']; // Общая стоимость 
    @$sborka +=$item['sborka']; // Общая стоимость 
    @$lastMile +=$item['lastMile']; // Общая стоимость 
   
/// СУММЫ ПО ФБО
    @$countFBO +=$item['countFBO']; // сумма продажи 
    @$amountFBO +=$item['amountFBO']; // сумма продажи 
    @$one_shtukaFBO = round($item['amountFBO']/$item['countFBO'],2); // цена за 1 штуку ФБО
    @$sale_commissionFBO +=$item['sale_commissionFBO']; // Общая стоимость 
    @$logistikaFBO +=$item['logistikaFBO']; // Общая стоимость 
    @$sborkaFBO +=$item['sborkaFBO']; // Общая стоимость 
    @$lastMileFBO +=$item['lastMileFBO']; // Общая стоимость 

    /// СУММЫ ПО ФБС
    @$countFBS +=$item['countFBS']; // сумма продажи 
    @$amountFBS +=$item['amountFBS']; // сумма продажи 
    @$one_shtukaFBS = round($item['amountFBS']/$item['countFBS'],2); // цена за 1 штуку ФБC
    @$sale_commissionFBS +=$item['sale_commissionFBS']; // Общая стоимость 
    @$logistikaFBS +=$item['logistikaFBS']; // Общая стоимость 
    @$sborkaFBS +=$item['sborkaFBS']; // Общая стоимость 
    @$lastMileFBS +=$item['lastMileFBS']; // Общая стоимость 



    @$amount_hranenie +=$item['amount_hranenie']; // общая стоимость хранения 
    @$amount_ecvairing +=$item['amount_ecvairing']; // Общая стоимость эквайринга
    @$compensation += $item['compensation'] ; // Общая стоимость недовлажений
    @$amount_vozrat +=$item['amount_vozrat']; // Общая стоимость возвратов
    


    echo "<tr>";

        // if (isset($item['name'])){echo "<td>".$item['name']."</td>";}else{echo "<td>"."</td>";}
        if (isset($article)){echo "<td><b>".$article."</b></td>";}else{echo "<td>"."</td>";}
        if (isset($item['count'])){echo "<td>".$item['count']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amount'])){echo "<td>".$item['accruals_for_sale']."<br>".$one_shtuka_buyer."</td>";}else{echo "<td>"."</td>";} // ценя для покупателья
        if (isset($item['amount'])){echo "<td>".$item['amount']."<br>".$one_shtuka."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sale_commission'])){echo "<td>".$item['sale_commission']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['logistika'])){echo "<td>".$item['logistika']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sborka'])){echo "<td>".$item['sborka']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['lastMile'])){echo "<td>".$item['lastMile']."</td>";}else{echo "<td>"."</td>";}

/// FBO 

        if (isset($item['countFBO'])){echo "<td>".$item['countFBO']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amountFBO'])){echo "<td>".$item['amountFBO']."<br>".$one_shtukaFBO."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sale_commissionFBO'])){echo "<td>".$item['sale_commissionFBO']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['logistikaFBO'])){echo "<td>".$item['logistikaFBO']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sborkaFBO'])){echo "<td>".$item['sborkaFBO']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['lastMileFBO'])){echo "<td>".$item['lastMileFBO']."</td>";}else{echo "<td>"."</td>";}

/// FBS
        if (isset($item['countFBS'])){echo "<td>".$item['countFBS']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amountFBS'])){echo "<td>".$item['amountFBS']."<br>".$one_shtukaFBS."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sale_commissionFBS'])){echo "<td>".$item['sale_commissionFBS']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['logistikaFBS'])){echo "<td>".$item['logistikaFBS']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sborkaFBS'])){echo "<td>".$item['sborkaFBS']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['lastMileFBS'])){echo "<td>".$item['lastMileFBS']."</td>";}else{echo "<td>"."</td>";}




        if (isset($item['amount_hranenie'])){echo "<td>".$item['amount_hranenie']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['compensation'])){echo "<td>".$item['compensation']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amount_ecvairing'])){echo "<td>".$item['amount_ecvairing']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['count_vozvrat'])){echo "<td>".$item['count_vozvrat']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amount_vozrat'])){echo "<td>".$item['amount_vozrat']."</td>";}else{echo "<td>"."</td>";}


    echo "</tr>";


}

// СТРОКА ИТОГО ТАблицы
echo "<tr>";
    echo "<td></td>"; // Наименование
    echo "<td>$count</td>"; // Количество
    echo "<td>$accruals_for_sale</td>"; // общая сумма
    echo "<td>$amount</td>"; // общая сумма
    if (isset($sale_commission)){echo "<td>".$sale_commission."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($logistika)){echo "<td>".$logistika."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($sborka)){echo "<td>".$sborka."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($lastMile)){echo "<td>".$lastMile."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий


    if (isset($countFBO)){echo "<td>".$countFBO."</td>";}else{echo "<td>"."</td>";} // Количество
    if (isset($amountFBO)){echo "<td>".$amountFBO."</td>";}else{echo "<td>"."</td>";} // общая сумма
    if (isset($sale_commissionFBO)){echo "<td>".$sale_commissionFBO."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($logistikaFBO)){echo "<td>".$logistikaFBO."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($sborkaFBO)){echo "<td>".$sborkaFBO."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($lastMileFBO)){echo "<td>".$lastMileFBO."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий


    
    echo "<td>$countFBS</td>"; // Количество
    if (isset($amountFBS)){echo "<td>".$amountFBS."</td>";}else{echo "<td>"."</td>";} // общая сумма
    if (isset($sale_commissionFBS)){echo "<td>".$sale_commissionFBS."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($logistikaFBS)){echo "<td>".$logistikaFBS."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($sborkaFBS)){echo "<td>".$sborkaFBS."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий
    if (isset($lastMileFBS)){echo "<td>".$lastMileFBS."</td>";}else{echo "<td>"."</td>";} // сумма коммиссий


    if (isset($amount_hranenie)){echo "<td>".$amount_hranenie."</td>";}else{echo "<td>"."</td>";} // сумма хранения
    if (isset($compensation)){echo "<td>".$compensation."</td>";}else{echo "<td>"."</td>";} // сумма эквайринга
    if (isset($amount_ecvairing)){echo "<td>".$amount_ecvairing."</td>";}else{echo "<td>"."</td>";} // сумма эквайринга
    echo "<td></td>";
    if (isset($amount_vozrat)){echo "<td>".$amount_vozrat."</td>";}else{echo "<td>"."</td>";} // сумма возвратов



echo "</tr>";

echo "</table>";
