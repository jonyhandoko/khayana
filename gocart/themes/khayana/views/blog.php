<?php include('header.php');?>
<div class="container" style="background: url('images/khayana/journal_bg.jpg') fixed;
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover; padding: 0 150px; min-height: 500px; padding-bottom: 100px;">
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
	.banner p{font-family: CenturyGothicStd}
	</style>
		<div class="row" style="background-color: white;">
		<?php foreach($json as $key => $blog):?>
		<?php if($key != "msg"):?>
		<div class="col-sm-12 blog" style="margin-bottom: 50px; padding: 0;">
			<?php
				$whiteSpace = '\s';
				$pattern = '/[^a-zA-Z0-9'  . $whiteSpace . ']/u';
				$title = preg_replace($pattern, '', (string) $blog->title);
				$link = str_replace(" ", "-", $title)."--".$blog->ID;
			?>
			<div class="banner" style="position: relative;">
				<center>
				<a class="blog-home" href="<?php echo base_url('/cart/blog/'.$link);?>"><img src="<?php echo $blog->thumb;?>"/></a>
				<br/><br/>
				<p><?php echo $blog->date;?></p>
				<h2><?php echo strtoupper($blog->title);?></h2>
				<br/>
				<div style="width: 70%; text-align: center;">
					<p>
						<?php echo $blog->excerpt;?>
					</p>
					<p></p>
					<p>
						<br/>
						<a href="<?php echo base_url('blog/'.$link);?>" style="color: black">READ MORE</a>
					</p>
				</div>
				</center>
			</div>
		</div>
		
		<?php endif;?>
		<?php endforeach;?>
		</div>
<?php else:?>
	<div class="row" style="background-color: white;">
		<div class="col-sm-12 blog" style="margin-bottom: 50px; padding: 0;">
			<div class="banner" style="position: relative;">
				<center>
				<a class="blog-home" href="<?php echo base_url('/cart/blog/'.$link);?>"><img src="<?php echo $blog->thumb;?>"/></a>
				<br/><br/>
				<p><?php echo $blog->date;?></p>
				<h2><?php echo strtoupper($blog->title);?></h2>
				<br/>
				<div style="width: 70%; text-align: center;">
					<p>
						<?php echo $detail;?>
					</p>
				</div>
				</center>
			</div>
		</div>
		</div>
	</div>
<?php endif;?>
</div>
<?php include('footer.php');?>