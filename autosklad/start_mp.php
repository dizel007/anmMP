<?php

echo <<<HTML


<form action="get_all_ostatki_skladov.php" method="post" enctype="multipart/form-data">



<span>Выберите файл</span>
	<input required type="file" name="file_excel" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">		
	
 	
        
<hr>

 <input type="submit" value="ЗАПУСК">	

</form>



HTML;