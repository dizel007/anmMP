<?php

echo <<<HTML



<table>
<tr>
    <td class="main_screen"><h1>Сбор Заказов</h1></td>
    <td class="main_screen"><a href="wb/"><img src="pics/wb.jpg"></a></td>
    <td class="main_screen"><a href="ozon/"><img src="pics/ozon.jpg"></td>
    <td class="main_screen"><a href="leroy/"><img src="pics/leroy.jpg"></a></td>
    <td class="main_screen"><a href="vse_instrumenti/start.php"><img src="pics/vse_insrt.jpg"></a></td>
</tr>
<tr>
    <td class="main_screen"><h1>Отзывы </h1></td>
    <td class="main_screen">Ответ на полож отзывы<br><a href="wb/feedback/start.php?wb_feedback=wb"> Отзывы WB</a> -- <a href="wb/feedback/start.php?wb_feedback=wbip"> Отзывы WBIP </a></td>
    <td class="main_screen"> </td>
    <td class="main_screen"> </td>
    <td class="main_screen"> </td>
</tr>
<tr>
    <td class="main_screen"><h1>Доп инфо</h1></td>
    <td class="main_screen"></td>
    <td class="main_screen"><a href="ozon/ozon_get_stikers.php"><img src="pics/ozon_sklad.jpg"></a></td>
    <td class="main_screen"></td>
    <td class="main_screen"></td>
</tr>
<tr>
<td class="main_screen"><h1>Склад</h1></td>
<td class="main_screen"><a href="autosklad/start_mp.php"><img src="pics/sklad_ostatki.jpg"></a></td>
<td class="main_screen"></td>
<td class="main_screen"></td>
<td class="main_screen"></td>
</tr>
<tr>
<td class="main_screen"><h1>XML</h1></td>
<td class="main_screen"><a href="parce_xml_upd/take_data_wb.php"><img src="pics/xml.jpg"></a></td>
<td class="main_screen"></td>
<td class="main_screen"></td>
<td class="main_screen"></td>
</tr>

<tr>
<td class="main_screen"><h1>Отчеты</h1></td>
<td class="main_screen"><a href="wb/wb_reports/take_data_wb.php"><img src="pics/wb_reports.jpg"></a></td>
<td class="main_screen"><a href="ozon/ozon_report/ozon_get_trans.php"><img src="pics/ozon_reports.jpg"></td>
<td class="main_screen"></td>
<td class="main_screen"></td>
</tr> 
</table>

HTML;