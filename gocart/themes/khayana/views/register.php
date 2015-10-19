<?php 

$additional_header_info = '<style type="text/css">#page_title {text-align:center;}</style>';
include('header.php'); ?>
<style>
	.def-content{background-color: #263647;}
</style>
<div class="container-fluid" style="padding-left: 44px; padding-right: 44px; padding-bottom: 200px;">
	<div class="row register">
		<div class="col-sm-6">
			<div class="reg-box-1" style="padding-top: 30px;">
				<p style="color: white; letter-spacing: 2px; font-size: 18px;">WELCOME TO <span class="light-blue">KHANAYA</span></p>
				<br/><br/>
				<form class="form-horizontal">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">First Name</label>
						<div class="col-sm-9">
							<input type="text" class="inputEmail" name="firstname" placeholder="first name">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Last Name</label>
						<div class="col-sm-9">
							<input type="text" class="inputEmail" name="lastname" placeholder="last name">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="text" class="inputEmail" name="email" placeholder="email">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Password</label>
						<div class="col-sm-9">
							<input type="text" class="inputEmail" name="password" placeholder="paswword">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Confirm Password</label>
						<div class="col-sm-9">
							<input type="text" class="inputEmail" name="confirm" placeholder="confirm password">
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="reg-box-1" style="padding-top: 30px;">
				<p style="color: white; letter-spacing: 2px; font-size: 18px;">CONTACT <span class="light-blue">INFORMATION</span></p>
				<br/><br/>
				<form class="form-horizontal">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Province / State</label>
						<div class="col-sm-9">
							<?php echo form_dropdown('province_id', $provinces_menu,  set_value('province_id', ''), 'style="width:200px; display:block;"  id="f_province_id" class="form-control"');?>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Address 1</label>
						<div class="col-sm-9">
							<input type="email" class="inputEmail" name="address1" placeholder="address 1">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Address 2</label>
						<div class="col-sm-9">
							<input type="email" class="inputEmail" name="address1" placeholder="address 1">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Postal Code</label>
						<div class="col-sm-9">
							<input type="email" class="inputEmail" name="zip" placeholder="postal code">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label"></label>
						<div class="col-sm-9" style="text-align: left">
							<input type="checkbox" class="inputEmail" placeholder="" style="width: 35px; padding-left: 0;">
							<label  style="width: 84%;">
								Yes, I would like to receive all news, special offers and promotions from Khanaya
							</label>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="col-sm-12">
			<center>
				<br/><br/>
				<button class="btn" style="width: 300px; border-radius: 0; background-color: #DAC0A6; color: #1F445B; font-size: 12px; letter-spacing: 1px;font-family: CenturyGothicStd;">SAVE MY DETAILS</button>
			</center>
		</div>
	</div>
</div>
<?php include('footer.php'); ?>