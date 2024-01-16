<?php

/**
 * Выводим на экран выбранные заказы 
 */

function show_orders ($new_array_orders){


echo <<<HTML
<div class = "table-wrapper">
<table class = "fl-table">
    <thead>
        <tr>
            <th>пп</th>
            <th>Артикул</th>
            <th>Количество</th>
            <th>цена</th>
        </tr>
    </thead>
<tbody>
HTML;


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
echo "</tbody></table></div>";
}
