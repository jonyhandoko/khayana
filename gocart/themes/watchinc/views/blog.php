<?php include('header.php');?>
<div class="container">
<?php if($blog_page=="home"):?>
	<style>
	.blog .banner img{
		width: 100%;
	}	
	.blog .excerpt a{
		color: white;
	}	
	
	.blog .excerpt a:hover{
		color: #f1a744 !important;
	}
	</style>
	<div class="row">
		<?php foreach($json as $key => $blog):?>
		<?php if($key != "msg"):?>
		<div class="col-sm-4 blog" style="margin-bottom: 50px;">
			<?php
				$whiteSpace = '\s';
				$pattern = '/[^a-zA-Z0-9'  . $whiteSpace . ']/u';
				$title = preg_replace($pattern, '', (string) $blog->title);
				$link = str_replace(" ", "-", $title)."--".$blog->ID;
			?>
			<div class="banner"style="position: relative;">
				<a class="blog-home" href="<?php echo base_url('/cart/blog/'.$link);?>"><img src="<?php echo $blog->thumb;?>"/></a>
				<div class="excerpt" style="position: absolute; bottom: 0; left: 0; width: 100%;height: 95px; background: rgba(0,0,0,0.5); padding: 12px 12px 12px;">
					<h3><a class="blog-home" href="<?php echo base_url('/cart/blog/'.$link);?>"><?php echo $blog->title;?></a></h3>
					<span style="font-size: 12px; color: white;	"><?php echo $blog->date;?></span><br/>
					<?php //echo $blog->excerpt;?>
					<br/>
					<!--<a href="<?php //echo base_url('/cart/blog/'.$link);?>">read more here</a>-->
				</div>
				
			</div>
		</div>
		<?php endif;?>
		<?php endforeach;?>
	</div>
<?php else:?>
	<div class="row">
		<div class="col-sm-8">
			<?php print_r($detail);?>
		</div>
	</div>
<?php endif;?>
</div>
<?php include('footer.php');?>