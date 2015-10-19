<?php ob_start();

?>


<?php
$ads_javascript	= ob_get_contents();
ob_end_clean();
include('header.php');

$additional_header_info = $ads_javascript;

 ?>
<script language="javascript">
			 
 var timer = null; 
 function openContent(trigger,divID){  	
	var circleractive = "<?php echo base_url('images/circler_active.png');?>";
	var circlernonactive = "<?php echo base_url('images/circler_nonactive.png');?>";
	
	$('.banner-nav a').each( 
		function(){
			$(this).find('img').attr("src", circlernonactive);			 	
		}
	);
	$('.banner div').hide();
	$('#'+divID).fadeIn('slow');
	
	$(trigger).find('img').attr("src", circleractive);
	
	if(timer != null) clearTimeout(timer);
	timer = setTimeout( 
	  function(){
		var nextAnchor = ($(trigger).next('a').text() == '') ? $('.banner-nav a:first') : $(trigger).next('a');
		nextAnchor.click();
	  }, 3000 
	);
 }	 
 $(document).ready(
	function(){
		openContent($('#firstSlide'),'div1');			
	}
 )
</script>
<div class="banner-container">
    <div class="banner">
        <?php 
			$banner_count	= 1;
			foreach ($banners as $banner)
			{
				echo '<div id="div'.$banner_count.'">';
				
					
				if($banner->link != '')
				{
					$target	= false;
					if($banner->new_window)
					{
						$target = 'target="_blank"';
					}
					echo '<a href="'.$banner->link.'" '.$target.' >';
				}
				echo '<img class="banners_img'.$banner_count.'" src="'.base_url('uploads/'.$banner->image).'"/>';
				
				if($banner->link != '')
				{
					echo '</a>';
				}
		
				echo '</div>';
		
				$banner_count++;
			}
		?>
    </div>
    
    <div class="banner-nav">
        <img src="<?php echo base_url('images/left_banner_nav.png');?>" style="float: left;"/>
        <a href="javascript:;" onClick="openContent(this,'div1')" id="firstSlide"><span style="display: none">2</span><img src="<?php echo base_url('images/circler_active.png');?>" /></a>&nbsp;
		<a href="javascript:;" onClick="openContent(this,'div2')"><span style="display: none">1</span><img src="<?php echo base_url('images/circler_nonactive.png');?>" /></a>&nbsp;
        <img src="<?php echo base_url('images/right_banner_nav.png');?>" style="float: right;"/>
    </div>
</div>

<div class="adv-container">
    <?php 
	$box_count = 1;
	foreach ($boxes as $box)
	{
		if($box_count == 1)
			$float = "left";
		else
			$float = "right";
			
		if($box->link != '')
		{
			$target	= false;
			if($box->new_window)
			{
				$target = 'target="_blank"';
			}
			echo '<a href="'.$box->link.'" '.$target.' >';
		}
		echo '<img src="'.base_url('uploads/'.$box->image).'" style="float: '.$float.'" />';
		
		if($box->link != '')
		{
			echo '</a>';
		}
		$box_count++;

	}
	?>
</div>

<?php include('footer.php'); ?>