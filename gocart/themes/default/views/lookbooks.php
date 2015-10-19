<?php ob_start();

?>


<?php
$ads_javascript	= ob_get_contents();
ob_end_clean();
include('header.php');

$additional_header_info = $ads_javascript;

 ?>
	<div class="lookbooks-container">
    <?php 
		$lookbook_count = 1;
		foreach ($lookbooks as $lookbook)
		{
				
			if($lookbook->link != '')
			{
				$target	= false;
				if($lookbook->new_window)
				{
					$target = 'target="_blank"';
				}
				echo '<a href="'.$lookbook->link.'" '.$target.' >';
			}
			echo '<img src="'.base_url('uploads/'.$lookbook->image).'" />';
			
			if($lookbook->link != '')
			{
				echo '</a>';
			}
			$lookbook_count++;

		}
		?>
	</div>
<?php include('footer.php');?>