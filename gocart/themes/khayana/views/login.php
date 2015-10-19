<?php 

$additional_header_info = '<style type="text/css">#page_title {text-align:center;}</style>';
include('header.php'); ?>
<?php $image_bg = base_url('gocart/themes/'.$this->config->item('theme').'/img/login-bg.jpg');?>
<div class="container-fluid" style="background-image: url('<?php echo $image_bg;?>'); background-repeat: no-repeat; min-height: 1100px;">
	<div class="row">
		<center>
			<div style="background-color: white; width: 500px; height: 300px; margin-top: 100px; padding: 30px;">
				<?php echo form_open('secure/login', array('class'=>'form-horizontal form-clean', 'role'=>'form'))?>
				<span style="letter-spacing: 3px; font-size: 16px; color: #271917">EXISTING CUSTOMER</span>
				<hr/>
				<p style="font-family: 'Roboto', sans-serif; font-size: 12px;color: #A79A9A;">
					Please sign in by entering your details below
					<br/><br/>
				</p>
				<p>
					 <div class="left-inner-addon">
						<i class="fa fa-envelope-o"></i>
						<input type="hidden" value="<?php echo $redirect;?>" name="redirect"/>
						<input type="hidden" value="submitted" name="submitted"/>
						<input type="text" name="email" value="" id="email" placeholder="email" style="width: 80%"/>
					</div>
					
				</p>
				<p>
					<div class="left-inner-addon">
						<i class="fa fa-lock" style="padding-left: 14px;"></i>
						<input type="password" name="password" value="" placeholder="password" style="width: 80%"/>
					</div>
				</p>
				<p>
					<br/>
					<button type="submit" class="btn" style="width: 80%; border-radius: 0; background-color: #00C4E0; color: white; font-size: 12px; letter-spacing: 1px;font-family: CenturyGothicStd;">SIGN IN</button>
				</p>
				</form>
			</div>
			<div style="background-color: #EBCBA5; width: 500px; height: 200px; padding: 30px;">
				<span style="letter-spacing: 3px; font-size: 16px; color: #271917;">NEW TO KHAYANA</span>
				<hr style="border-color: #736354"/>
				<p style="font-family: 'Roboto', sans-serif; font-size: 12px;color: #271917;">
					Claritas est etiam processus dynamicus, qui sequitur mutationem consuetudium lectorum. 
					<br/><br/>
					<button class="btn" style="width: 80%; border-radius: 0; background-color: #30465A; color: white; font-size: 12px; letter-spacing: 1px;font-family: CenturyGothicStd;">CREATE ACCOUNT</button>
				</p>
			</div>
		</center>
	</div>
</div>
</div>
<?php include('footer.php'); ?>