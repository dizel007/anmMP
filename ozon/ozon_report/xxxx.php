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
// print_r($new_prod_array[2]);
// print_r($new_prod_array[2975]);
// print_r($new_prod_array[2977]);
// print_r($new_prod_array[2982]);

unset($item);

foreach ($new_prod_array as $item) {
    
    if ($item['type'] == 'orders') { 
// Доставка и обработка возврата, отмены, невыкупа   
        $arr_orders[] = $item; 
    } elseif ($item['type'] == 'returns') {
// Доставка и обработка возврата, отмены, невыкупа
        $arr_returns[] = $item;
    } elseif ($item['type'] == 'other') { 
// эквайринг ;претензиям
        $arr_banks[] = $item;
    } elseif ($item['type'] == 'services') { 
//продвижения товаров ;хранение/утилизацию ...... SERVICES **************************************
$arr_services[] = $item;
    } else {
// Если есть неучтенка то сюда
        $arr_index_job['XXX'] = $item; /// Проверить нужно будет на существование этого массива
    }
}

/// перебираем наш массив заказов /////////////////////////////////////////////////////////////
foreach ($arr_orders as $items) {
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
    foreach ($our_item as $item) {

        $arr_article[$item['sku']]['name'] = $item['name'];
        $arr_article[$item['sku']]['sku'] = $item['sku'];

    }
// количество товаров в заказе 
    $arr_article[$item['sku']]['count'] = @$arr_article[$item['sku']]['count'] + count($our_item);
// Суммируем суммы операции
    $arr_article[$item['sku']]['amount'] = @$arr_article[$item['sku']]['amount'] + $items['amount']; 
// Суммируем Комиссию за продажу или возврат комиссии за продажу.    
    $arr_article[$item['sku']]['sale_commission'] = @$arr_article[$item['sku']]['sale_commission'] + $items['sale_commission'];

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


foreach ($arr_returns as $items) {
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)
        foreach ($our_item as $item) {
            $arr_article[$item['sku']]['name'] = $item['name'];
            $arr_article[$item['sku']]['sku'] = $item['sku'];
    
        }
// количество товаров в заказе, которые вернули
    $arr_article[$item['sku']]['count_vozvrat'] = @$arr_article[$item['sku']]['count_vozvrat'] + count($our_item);
// Суммируем суммы операции, которые возвраты
    $arr_article[$item['sku']]['amount_vovrat'] = @$arr_article[$item['sku']]['amount_vovrat'] + $items['amount']; 



}




foreach ($arr_banks as $items) {
    $our_item = $items['items'];
// перебираем список товаров в этом заказе (Там где одиночные борды. Остальные отправления мы разбиваем по 1 штуке)

if ($items['operation_type'] == 'MarketplaceRedistributionOfAcquiringOperation') { //Оплата эквайринга
    foreach ($our_item as $item) {
        $arr_article[$item['sku']]['name'] = $item['name'];
        $arr_article[$item['sku']]['sku'] = $item['sku'];
        // количество товаров в заказе, Эквайринг
        $arr_article[$item['sku']]['count_ecvairing'] = @$arr_article[$item['sku']]['count_ecvairing'] + 1;
        $arr_article[$item['sku']]['amount_ecvairing'] = @$arr_article[$item['sku']]['amount_ecvairing'] + $items['amount']/count($our_item);
}
}
// СУмма претензий (ОНа не привязана к артикулу) /Начисления по претензиям
if ($items['operation_type'] == 'OperationClaim') {
    $Summa_pretensii = @$Summa_pretensii  + $items['amount']; // сумма начислений по претензиям
    }

// echo "<br>*******************************************************<br>";
// echo $items['amount']."<br>";
// echo count($our_item)."<br>";
// echo $items['amount']/count($our_item)."<br>";
// print_r($items);
// echo "<br>*******************************************************<br>";
    

// Суммируем суммы операции, которые возвраты
    
}

// [MarketplaceRedistributionOfAcquiringOperation] => Оплата эквайринга
// [OperationClaim] => Начисления по претензиям
print_r($arr_article);
echo  $Summa_pretensii;