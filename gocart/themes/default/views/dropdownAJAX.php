<?php
	$check = $_REQUEST['check'];

	if($check > 10)
		$val = 10;
	else
		$val = $check;
		
	
	
	echo '<select class="quantity" name="quantity" >';
	for($i=1;$i<=$val;$i++){
		echo '<option value="'.$i.'">'.$i.'</option>';
	}
	echo '</select>';
?>