<?PHP


// делаем один последовательный массив в операциями
// foreach ($prod_array as $items) {
//     foreach ($items as $item) {
//         $new_prod_array[] = $item;
//     }
// }

$new_prod_array = json_decode(file_get_contents('xxx.json'),true);

// file_put_contents('xxx.json', json_encode($new_prod_array, JSON_UNESCAPED_UNICODE));
echo "<pre>";

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

        $arr_article[$item['sku']]['name'] = $item['name'];
        $arr_article[$item['sku']]['sku'] = $item['sku'];
     // количество товаров в заказе 
       $arr_article[$item['sku']]['count'] = @$arr_article[$item['sku']]['count'] + 1;
     // Суммируем суммы операции
       $arr_article[$item['sku']]['amount'] = @$arr_article[$item['sku']]['amount'] + $items['amount']/count($our_item); 
     // Суммируем Комиссию за продажу     
      $arr_article[$item['sku']]['sale_commission'] = @$arr_article[$item['sku']]['sale_commission'] + $items['sale_commission']/count($our_item);

    }



    foreach ($items['services'] as $services) { // перебираем массив services 
            if ($services['name'] == 'MarketplaceServiceItemDirectFlowLogistic') {
//логистика
                $arr_article[$item['sku']]['logistika'] = @$arr_article[$item['sku']]['logistika'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDropoffSC') {
// обработка отправления
                $arr_article[$item['sku']]['sborka'] = @$arr_article[$item['sku']]['sborka'] + $services['price']; // суммма логистики
            }
            if ($services['name'] == 'MarketplaceServiceItemDelivToCustomer') {
//последняя миля.
                $arr_article[$item['sku']]['lastMile'] = @$arr_article[$item['sku']]['lastMile'] + $services['price']; // суммма логистики
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
            $arr_article[$item['sku']]['name'] = $item['name'];
            $arr_article[$item['sku']]['sku'] = $item['sku'];
    // количество товаров в заказе, которые вернули
            $arr_article[$item['sku']]['count_vozvrat'] = @$arr_article[$item['sku']]['count_vozvrat'] + 1;
  // Суммируем суммы операции, которые возвраты
  $arr_article[$item['sku']]['amount_vozrat'] = @$arr_article[$item['sku']]['amount_vozrat'] + $items['amount']/count($our_item);  
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
                $arr_article[$item['sku']]['name'] = $item['name'];
                $arr_article[$item['sku']]['sku'] = $item['sku'];
           // количество товаров в заказе, Эквайринг
                $arr_article[$item['sku']]['count_ecvairing'] = @$arr_article[$item['sku']]['count_ecvairing'] + 1;
                $arr_article[$item['sku']]['amount_ecvairing'] = @$arr_article[$item['sku']]['amount_ecvairing'] + round($items['amount']/count($our_item),2);
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
foreach ($arr_compensation as $items) {
    $i++;
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
        foreach ($our_item as $item) {
            $arr_article[$item['sku']]['name'] = $item['name'];
            $arr_article[$item['sku']]['sku'] = $item['sku'];
    
        }
// количество товаров в заказе, которые вернули
    $arr_article[$item['sku']]['count_compensation'] = @$arr_article[$item['sku']]['count_compensation'] + count($our_item);
// Суммируем суммы операции, которые возвраты
    $arr_article[$item['sku']]['compensation'] = @$arr_article[$item['sku']]['compensation'] + $items['amount']; 
}

/**************************************************************************************************************
 ***********************  Сервисы ******************************************************
 *************************************************************************************************************/

foreach ($arr_services as $items) {
    $i++;
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
        foreach ($our_item as $item) {
            $arr_article[$item['sku']]['name'] = $item['name'];
            $arr_article[$item['sku']]['sku'] = $item['sku'];
        if (($items['operation_type'] == 'OperationMarketplaceReturnStorageServiceAtThePickupPointFbs')  OR 
            ($items['operation_type'] == 'OperationMarketplaceReturnDisposalServiceFbs') )
            {
                // Начисление за хранение/утилизацию возвратов
                $arr_article[$item['sku']]['count_hranenie'] = @$arr_article[$item['sku']]['count_hranenie'] + 1;
                $arr_article[$item['sku']]['amount_hranenie'] = @$arr_article[$item['sku']]['amount_hranenie'] + $items['amount']/count($our_item);
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




// print_r($arr_article);
// echo  $Summa_pretensii;
// echo "<br>";

// echo count($new_prod_array)."***".count($arr_orders)."***".count($arr_returns)."***".count($arr_other);

// echo "<br>";
// $ggg = count($new_prod_array)-count($arr_orders)-count($arr_returns)-count($arr_other)-count($arr_index_job);
// echo $ggg;

echo "<table width=100%>";
echo "<tr>";
echo "<td>Наименование</td>";
echo "<td>Кол-во продано</td>";
echo "<td>Сумма продаж</td>";
echo "<td>Хранение<br>утилизация</td>";
echo "<td>Удержание<br>за недовложение</td>";
echo "<td>Эквайринг</td>";
echo "<td>Возвраты(шт)</td>";
echo "<td>Возвраты(руб)</td>";

echo "<td>Комиссия Озон</td>";

echo "<td>Логистика</td>";
echo "<td>Сборка</td>";
echo "<td>Посл.миля(руб)</td>";

echo "</tr>";


foreach ($arr_article as $key=>$item) {
    @$amount +=$item['amount']; // сумма продажи 
    @$amount_hranenie +=$item['amount_hranenie']; // общая стоимость хранения 
    @$amount_ecvairing +=$item['amount_ecvairing']; // Общая стоимость эквайринга

    @$amount_vozrat +=$item['amount_vozrat']; // Общая стоимость возвратов
    
    @$sale_commission +=$item['sale_commission']; // Общая стоимость 
    @$logistika +=$item['logistika']; // Общая стоимость 
    @$sborka +=$item['sborka']; // Общая стоимость 
    @$lastMile +=$item['lastMile']; // Общая стоимость 
   

    echo "<tr>";

        if (isset($item['name'])){echo "<td>".$item['name']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['count'])){echo "<td>".$item['count']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amount'])){echo "<td>".$item['amount']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amount_hranenie'])){echo "<td>".$item['amount_hranenie']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['compensation'])){echo "<td>".$item['compensation']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amount_ecvairing'])){echo "<td>".$item['amount_ecvairing']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['count_vozvrat'])){echo "<td>".$item['count_vozvrat']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['amount_vozrat'])){echo "<td>".$item['amount_vozrat']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sale_commission'])){echo "<td>".$item['sale_commission']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['logistika'])){echo "<td>".$item['logistika']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['sborka'])){echo "<td>".$item['sborka']."</td>";}else{echo "<td>"."</td>";}
        if (isset($item['lastMile'])){echo "<td>".$item['lastMile']."</td>";}else{echo "<td>"."</td>";}

    echo "</tr>";


}

echo "</table>";
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
echo "Услуга по изменению условий отгрузки : $Summa_izmen_uslovi_otgruzki<br>";
echo "сумма начислений по претензиям : $Summa_pretensii<br>";

echo "Кол-во обработанных итэмс : $i<br>";


print_r($arr_article);