<?php include('header.php');?>
<div class="container">
<div class="row">
<div class="col-sm-2">
<?php include('left_content_help.php');?>
</div>
<div class="col-sm-10">
	<?php 
		$arg = explode(' ', $page->title);
	?>
	<h3 class="checkoutTitle" style="font-size: 16px;"><span class="grey"><?php echo $arg['0'];?></span> <?php if(isset($arg['1'])) echo $arg['1'];?> <?php if(isset($arg['2'])) echo $arg['2']?></h3>
    <hr style="border: 1px solid #e9e9e9;">
    <br/>
<?php echo html_entity_decode($page->content); ?>
</div>
</div>
</div>
<?php include('footer.php');?>