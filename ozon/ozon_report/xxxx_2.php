<?PHP
require_once '../../mp_sklad/functions/ozon_catalog.php';
require_once "libs_ozon/function_ozon_reports.php"; // массив с себестоимостью товаров
require_once "libs_ozon/sku_fbo_na_fbs.php"; // массив с себестоимостью товаров

// $ozon_catalog = get_catalog_ozon ();
$ozon_sebest = get_sebestiomost_ozon_with_sku_FBO ();

echo "<pre>";


// print_r($ozon_sebest);

// die();
// делаем один последовательный массив в операциями
foreach ($prod_array as $items) {
    foreach ($items as $item) {
        $new_prod_array[] = $item;
    }
}

// $new_prod_array = json_decode(file_get_contents('xxx.json'),true);



// file_put_contents('xxx.json', json_encode($new_prod_array, JSON_UNESCAPED_UNICODE));


foreach ($new_prod_array as $item) {
    
    if ($item['type'] == 'orders') { 
// Доставка и обработка возврата, отмены, невыкупа   
        $arr_orders[] = $item; 
    } elseif ($item['type'] == 'returns') {
// Доставка и обработка возврата, отмены, невыкупа
        $arr_returns[] = $item;
    } elseif ($item['type'] == 'other') { 
// эквайринг ;претензиям
        $arr_other[] = $item;
    } elseif ($item['type'] == 'services') { 
//продвижения товаров ;хранение/утилизацию ...... SERVICES **************************************
        $arr_services[] = $item;
    } elseif ($item['type'] == 'compensation') { 
//продвижения товаров ;хранение/утилизацию ...... SERVICES **************************************
                $arr_compensation[] = $item;
    } else {
// Если есть неучтенка то сюда
        $arr_index_job[] = $item; /// Проверить нужно будет на существование этого массива

    }
}


$i=0;

/**************************************************************************************************************
 **************************************  ЗАКАЗЫ ************************************************************
 *************************************************************************************************************/
foreach ($arr_orders as $items) {
    $i++;
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
    foreach ($our_item as $item) {
///// ТУТ мы меняет SKU ФБО на СКУ ФБС, чтобы в таблице вывести их в одной строке
            $new_sku = change_SKU_fbo_fbs($ozon_sebest, $item['sku']);
        
            // echo "<br>NEW_SKU = ".$new_sku."|||| OLD SKU = ".$item['sku']."<br>";
        $arr_article[$new_sku]['name'] = $item['name'];
        $arr_article[$new_sku]['sku'] = $new_sku;
     // количество товаров в заказе 
       $arr_article[$new_sku]['count'] = @$arr_article[$new_sku]['count'] + 1;
     // Суммируем суммы операции
       $arr_article[$new_sku]['amount'] = @$arr_article[$new_sku]['amount'] + $items['amount']/count($our_item); 
     // Суммируем Комиссию за продажу     
      $arr_article[$new_sku]['sale_commission'] = @$arr_article[$new_sku]['sale_commission'] + $items['sale_commission']/count($our_item);
//***************************** РАЗБИВАЕМ ТОВАРЫ ПО СХЕМЕ ПОСТАВКИ ************************ */
        if ($items['posting']['delivery_schema'] == 'FBO') {
            // количество товаров в заказе 
            $arr_article[$new_sku]['countFBO'] = @$arr_article[$new_sku]['countFBO'] + 1;
            // Суммируем суммы операции
            $arr_article[$new_sku]['amountFBO'] = @$arr_article[$new_sku]['amountFBO'] + $items['amount']/count($our_item); 
       // Суммируем Комиссию за продажу     
       $arr_article[$new_sku]['sale_commissionFBO'] = @$arr_article[$new_sku]['sale_commissionFBO'] + $items['sale_commission']/count($our_item);
        } elseif ($items['posting']['delivery_schema'] == 'FBS') {
            // количество товаров в заказе 
            $arr_article[$new_sku]['countFBS'] = @$arr_article[$new_sku]['countFBS'] + 1;
            // Суммируем суммы операции
            $arr_article[$new_sku]['amountFBS'] = @$arr_article[$new_sku]['amountFBS'] + $items['amount']/count($our_item); 

               // Суммируем Комиссию за продажу     
      $arr_article[$new_sku]['sale_commissionFBS'] = @$arr_article[$new_sku]['sale_commissionFBS'] + $items['sale_commission']/count($our_item);
        } else {
            // количество товаров в заказе 
            $arr_article[$new_sku]['countXXX'] = @$arr_article[$new_sku]['countXXX'] + 1;
            // Суммируем суммы операции
            $arr_article[$new_sku]['amountXXX'] = @$arr_article[$new_sku]['amountXXX'] + $items['amount']/count($our_item);   
            // Суммируем Комиссию за продажу     
      $arr_article[$new_sku]['sale_commissionXXX'] = @$arr_article[$new_sku]['sale_commissionXXX'] + $items['sale_commission']/count($our_item);
        }
//*************************************************** */

    }



    foreach ($items['services'] as $services) { // перебираем массив services 
            if ($services['name'] == 'MarketplaceServiceItemDirectFlowLogistic') {
//логистика
                $arr_article[$new_sku]['logistika'] = @$arr_article[$new_sku]['logistika'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDropoffSC') {
// обработка отправления
                $arr_article[$new_sku]['sborka'] = @$arr_article[$new_sku]['sborka'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDelivToCustomer') {
//последняя миля.
                $arr_article[$new_sku]['lastMile'] = @$arr_article[$new_sku]['lastMile'] + $services['price']; // суммма логистики
            }
    }

////////////////////////////// Разбираем массив Севисы по типу поставки ФБО или ФБС //////////////////////////////////////
    if ($items['posting']['delivery_schema'] == 'FBO') {
        foreach ($items['services'] as $services) { // перебираем массив services 
            if ($services['name'] == 'MarketplaceServiceItemDirectFlowLogistic') {
    //логистика
                $arr_article[$new_sku]['logistikaFBO'] = @$arr_article[$new_sku]['logistikaFBO'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDropoffSC') {
    // обработка отправления
                $arr_article[$new_sku]['sborkaFBO'] = @$arr_article[$new_sku]['sborkaFBO'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDelivToCustomer') {
    //последняя миля.
                $arr_article[$new_sku]['lastMileFBO'] = @$arr_article[$new_sku]['lastMileFBO'] + $services['price']; // суммма логистики
            }
    }
    } elseif ($items['posting']['delivery_schema'] == 'FBS') {
        foreach ($items['services'] as $services) { // перебираем массив services 
            if ($services['name'] == 'MarketplaceServiceItemDirectFlowLogistic') {
    //логистика
                $arr_article[$new_sku]['logistikaFBS'] = @$arr_article[$new_sku]['logistikaFBS'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDropoffSC') {
    // обработка отправления
                $arr_article[$new_sku]['sborkaFBS'] = @$arr_article[$new_sku]['sborkaFBS'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDelivToCustomer') {
    //последняя миля.
                $arr_article[$new_sku]['lastMileFBS'] = @$arr_article[$new_sku]['lastMileFBS'] + $services['price']; // суммма логистики
            }
    }
    } else {
        foreach ($items['services'] as $services) { // перебираем массив services 
            if ($services['name'] == 'MarketplaceServiceItemDirectFlowLogistic') {
    //логистика
                $arr_article[$new_sku]['logistikaXXX'] = @$arr_article[$new_sku]['logistikaXXX'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDropoffSC') {
    // обработка отправления
                $arr_article[$new_sku]['sborkaXXX'] = @$arr_article[$new_sku]['sborkaXXX'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDelivToCustomer') {
    //последняя миля.
                $arr_article[$new_sku]['lastMileXXX'] = @$arr_article[$new_sku]['lastMileXXX'] + $services['price']; // суммма логистики
            }
    } 
}








}

/**************************************************************************************************************
 **************************************  ВОЗВРАТЫ
 *************************************************************************************************************/
foreach ($arr_returns as $items) {
    $i++;
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
        foreach ($our_item as $item) {

///// ТУТ мы меняет SKU ФБО на СКУ ФБС, чтобы в таблице вывести их в одной строке
            $new_sku = change_SKU_fbo_fbs($ozon_sebest, $item['sku']);

            $arr_article[$new_sku]['name'] = $item['name'];
            $arr_article[$new_sku]['sku'] = $new_sku;
    // количество товаров в заказе, которые вернули
            $arr_article[$new_sku]['count_vozvrat'] = @$arr_article[$new_sku]['count_vozvrat'] + 1;
  // Суммируем суммы операции, которые возвраты
  $arr_article[$new_sku]['amount_vozrat'] = @$arr_article[$new_sku]['amount_vozrat'] + $items['amount']/count($our_item);  
        }

    
 
}

/**************************************************************************************************************
 * Эквайринг 
 *************************************************************************************************************/


foreach ($arr_other as $items) {
    $i++;
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)

// [MarketplaceRedistributionOfAcquiringOperation] => Оплата эквайринга
// [OperationClaim] => Начисления по претензиям

if ($items['operation_type'] == 'MarketplaceRedistributionOfAcquiringOperation') //Оплата эквайринга
    { 
        foreach ($our_item as $item) 
            {

 ///// ТУТ мы меняет SKU ФБО на СКУ ФБС, чтобы в таблице вывести их в одной строке
        $new_sku = change_SKU_fbo_fbs($ozon_sebest, $item['sku']);

                $arr_article[$new_sku]['name'] = $item['name'];
                $arr_article[$new_sku]['sku'] = $new_sku;
           // количество товаров в заказе, Эквайринг
                $arr_article[$new_sku]['count_ecvairing'] = @$arr_article[$new_sku]['count_ecvairing'] + 1;
                $arr_article[$new_sku]['amount_ecvairing'] = @$arr_article[$new_sku]['amount_ecvairing'] + round($items['amount']/count($our_item),2);
            }
    }
// СУмма претензий (ОНа не привязана к артикулу) /Начисления по претензиям
if ($items['operation_type'] == 'OperationClaim') 
    {
        $Summa_pretensii = @$Summa_pretensii  + $items['amount']; // сумма начислений по претензиям
    }
    
}

/**************************************************************************************************************
 * Удержание за недовложение товара
 *************************************************************************************************************/
if (isset($arr_compensation)){
foreach ($arr_compensation as $items) {
    $i++;
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
        foreach ($our_item as $item) {

 ///// ТУТ мы меняет SKU ФБО на СКУ ФБС, чтобы в таблице вывести их в одной строке
 $new_sku = change_SKU_fbo_fbs($ozon_sebest, $item['sku']);

            $arr_article[ $new_sku]['name'] = $item['name'];
            $arr_article[ $new_sku]['sku'] =  $new_sku;
    
        }
// количество товаров в заказе, которые вернули
    $arr_article[ $new_sku]['count_compensation'] = @$arr_article[ $new_sku]['count_compensation'] + count($our_item);
// Суммируем суммы операции, которые возвраты
    $arr_article[ $new_sku]['compensation'] = @$arr_article[ $new_sku]['compensation'] + $items['amount']; 
}
}
/**************************************************************************************************************
 ***********************  Сервисы ******************************************************
 *************************************************************************************************************/

foreach ($arr_services as $items) {
    $i++;
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
        foreach ($our_item as $item) {

  ///// ТУТ мы меняет SKU ФБО на СКУ ФБС, чтобы в таблице вывести их в одной строке
  $new_sku = change_SKU_fbo_fbs($ozon_sebest, $item['sku']);
  
  
            $arr_article[$new_sku]['name'] = $item['name'];
            $arr_article[$new_sku]['sku'] = $new_sku;
        if (($items['operation_type'] == 'OperationMarketplaceReturnStorageServiceAtThePickupPointFbs')  OR 
            ($items['operation_type'] == 'OperationMarketplaceReturnDisposalServiceFbs') )
            {
                // Начисление за хранение/утилизацию возвратов
                $arr_article[$new_sku]['count_hranenie'] = @$arr_article[$new_sku]['count_hranenie'] + 1;
                $arr_article[$new_sku]['amount_hranenie'] = @$arr_article[$new_sku]['amount_hranenie'] + $items['amount']/count($our_item);
            }
        }
// СУмма по сервисами
if ($items['operation_type'] == 'MarketplaceMarketingActionCostOperation') 
    { // Услуги продвижения товаров
        $Summa_uslugi_prodvizhenia_tovara = @$Summa_uslugi_prodvizhenia_tovara  + $items['amount']; 
    } 
elseif ($items['operation_type'] == 'MarketplaceSaleReviewsOperation')
    {  //Приобретение отзывов на платформе
        $Summa_buy_otzivi = @$Summa_buy_otzivi  + $items['amount']; 
    }
elseif ($items['operation_type'] == 'OperationMarketplaceDefectRate')
    {  //Услуга по изменению условий отгрузки
        $Summa_izmen_uslovi_otgruzki = @$Summa_izmen_uslovi_otgruzki  + $items['amount']; 
    }
}








// (
//        [MarketplaceMarketingActionCostOperation] => Услуги продвижения товаров
//        [OperationMarketplaceReturnStorageServiceAtThePickupPointFbs] => Начисление за хранение/утилизацию возвратов
//        [MarketplaceSaleReviewsOperation] => Приобретение отзывов на платформе
//        [OperationMarketplaceReturnDisposalServiceFbs] => Начисление за хранение/утилизацию возвратов
//        [OperationMarketplaceDefectRate] => Услуга по изменению условий отгрузки
// )

// CSS цепляем
echo "<link rel=\"stylesheet\" href=\"css/main_ozon_reports.css\">";



echo "<table class=\"fl-table\">";

// ШАПКА ТАблицы
echo "<tr>";
    // echo "<th style=\"width:10%\">Наименование</th>";
    echo "<th>Артикл</th>";
    echo "<th>Кол-во<br>продано<br>(шт)</th>";
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
    @$one_shtuka = round($item['amount']/$item['count'],2);


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

//////////////////////////////////////////////////////////////////////////////////////////////////////
echo "<br>";
echo "ВЫПЛАТА С СЕВРИСНЫМИ СБОРАМ : $amount<br>";
echo "СТОИМОСТЬ ХРАНЕНИЯ          : $amount_hranenie<br>";
echo "СТОИМОСТЬ ЭКВАЙРИНГА        : $amount_ecvairing<br>";

echo "СТОИМОСТЬ ВОЗВРАТОВ         : $amount_vozrat<br>";

echo "КОММИССИЯ                   : $sale_commission<br>";
echo "Логистика                   : $logistika<br>";
echo "Сборка                      : $sborka<br>";
echo "Посл.миля                   : $lastMile<br>";

$summa_NACHILS = $amount - $logistika - $sborka - $lastMile;
echo "<br>";
echo "НАЧИСЛЕННО                  : $summa_NACHILS<br>";

echo "<br>";
echo "Услуги продвижения товаров : $Summa_uslugi_prodvizhenia_tovara<br>";
echo "Приобретение отзывов на платформе : $Summa_buy_otzivi<br>";

if (isset($Summa_izmen_uslovi_otgruzki)){echo "Услуга по изменению условий отгрузки : $Summa_izmen_uslovi_otgruzki<br>";}
if (isset($Summa_pretensii)){echo "сумма начислений по претензиям : $Summa_pretensii<br>";}


echo "Кол-во обработанных итэмс : $i<br>";


print_r($arr_article);