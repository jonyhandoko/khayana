<?php
//$ads_javascript	= ob_get_contents();
//ob_end_clean();
include('header.php');

//$additional_header_info = $ads_javascript;

 ?>
     <div class="banner">
		<div class="container-fluid">
			<?php 
				$banner_count	= 1;
				foreach ($banners as $banner):
					$beforeTag = '';
					$afterTag = '';
					if($banner->link != '')
					{
						$target	= '';
						if($banner->new_window)
						{
							$target = 'target="_blank"';
						}
						$beforeTag = '<a href="'.$banner->link.'" '.$target.'>';
						$afterTag = '</a>';
					}
			?>
				<div class="row" style="margin-bottom: 50px">
					<?php echo $beforeTag;?>	
					<img class="image-responsive" src="<?php echo base_url('uploads/'.$banner->image);?>"/>
					<?php echo $afterTag;?>
				</div>
			<?php
				endforeach;
			?>
		</div>
	</div>
	<div class="journal" style="padding-bottom: 160px;">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12" style="margin-bottom: 80px;">
					<center>
						<img src="<?php echo base_url('gocart/themes/'.$this->config->item('theme').'/img/journal.jpg');?>"/>
					</center>
				</div>
			</div>
				
			<div class="row">
				<div class="col-xs-1 owl-carousel-arrows-prev" style="background-color: #3D4A5B; width: 3%; padding: 0;">
					<div class="owl-carousel-arrows prev">
						<span style="font-size: 14px; font-weight: bold; color: white;transform: translateY(-50%); top: 50%; left:40%; position: relative;">&lt;</span>
					</div>
				</div>
				<div class="col-xs-10" style="width: 94%; padding: 0;">
					<div class="owl-carousel">
						<?php foreach($json as $key => $blog):?>
						<?php if($key != "msg"):?>
							  <?php
								$whiteSpace = '\s';
								$pattern = '/[^a-zA-Z0-9'  . $whiteSpace . ']/u';
								$title = preg_replace($pattern, '', (string) $blog->title);
								$link = str_replace(" ", "-", $title)."--".$blog->ID;
							  ?>
							 
							  <div class="item">
								<img src="<?php echo $blog->thumb;?>"/>
								<div class="caption-line">
									<div class="date"><?php echo $blog->date;?></div>
									<div class="date"><?php echo $blog->title;?></div>
									<hr/>
									<div class="more"><a style="color: #46C4DD" href="<?php echo base_url('/cart/blog/'.$link);?>" class="thumb">READ MORE</a></div>
								</div>
							   </div>
							    <div class="item">
								<img src="<?php echo $blog->thumb;?>"/>
								<div class="caption-line">
									<div class="date"><?php echo $blog->date;?></div>
									<div class="date"><?php echo $blog->title;?></div>
									<hr/>
									<div class="more"><a style="color: #46C4DD" href="<?php echo base_url('/cart/blog/'.$link);?>" class="thumb">READ MORE</a></div>
								</div>
							   </div>
						<?php endif;?>
						<?php endforeach;?>	
					</div>
				</div>
				<div class="col-xs-1 owl-carousel-arrows-next" style="background-color: #3D4A5B; width: 3%; padding: 0;">
					<div class="owl-carousel-arrows next">
						<span style="font-size: 14px; font-weight: bold; color: white;transform: translateY(-50%); top: 50%; left:40%; position: relative;">&gt;</span>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
//$ads_javascript	= ob_get_contents();
//ob_end_clean();
include('footer.php');

//$additional_header_info = $ads_javascript;

 ?>