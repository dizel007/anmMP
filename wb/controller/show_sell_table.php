<?php

/**
 * Выводим на экран выбранные заказы 
 */

function show_orders ($new_array_orders){


// echo "<pre>";
echo "<table class = \"prod_table\">";
echo "<tr>
<td>пп</td>
<td>Артикул</td>
<td>Количество</td>
<td>цена</td>


</tr>";
$i=1;
foreach ($new_array_orders as $key=>$item) {
//  print_r($item);
echo "<tr>";
echo "<td>$i</td>
<td>".$key."</td>
<td>".$item['count']."</td>
<td>".$item['price']."</td>";

 
$i++;
}
echo "</table>";
}
