<?php
/**********************************************************************************************************
 *     ***************    Разбиваем массив по типу операции
*********************************************************************************************************/

foreach ($prod_array as $items) {
    foreach ($items as $item) {
        // $prod_arrae_new[] = $item;
       $nnnnn[$item['operation_type']] = $item['operation_type'];

    $index_name = $item['services'];  
        if ($item['type'] == 'orders') { 
            $arr_orders[] = $item;
            foreach ($index_name as $index) {
                $new_name = $index['name'];
                $arr_index_job['orders'][$new_name] = @$arr_index_job['orders'][$new_name]  + $index['price'];
            }
    
        
        } // Доставка и обработка возврата, отмены, невыкупа       

        if ($item['type'] == 'returns') { $arr_returns[] = $item;
            foreach ($index_name as $index) {
                $new_name = $index['name'];
                $arr_index_job['returns'][$new_name] = @$arr_index_job['returns'][$new_name]  + $index['price'];
            }
        } // Доставка и обработка возврата, отмены, невыкупа
        if ($item['type'] == 'services') { $arr_services[] = $item;
            foreach ($index_name as $index) {
                $new_name = $index['name'];
                $arr_index_job['services'][$new_name] = @$arr_index_job['services'][$new_name]  + $index['price'];
            }

        } //продвижения товаров ;хранение/утилизацию ......
        if ($item['type'] == 'other') { $arr_new[] = $item;
        
            foreach ($index_name as $index) {
                $new_name = $index['name'];
                $arr_index_job['other'][$new_name] = @$arr_index_job['other'][$new_name] + $index['price'];
            }
        
        } // эквайринг ;претензиям
      
    }
}


// print_r($arr_index_job) ;
