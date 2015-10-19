<?php 

$additional_header_info = '<style type="text/css">#page_title {text-align:center;}</style>';
include('header.php'); ?>
<!-- Container -->
<div class="container">
	<div class="greet">
	  <h3>HELLO VALUE CUSTOMER</h3>
	  <p>It Looks Like you wish to order without creating an account. So complete the form address below</p>
	</div>
	<div class="thing">
	  <div class="row">
		<div class="col-sm-2 col-md-4"></div>
		<div class="col-sm-8 col-md-4">
			<?php echo form_open('secure/login', array('class'=>'form-horizontal form-clean', 'role'=>'form'))?>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control" name="email" placeholder="username">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="password" class="form-control" name="password" placeholder="password">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="hidden" value="<?php echo $redirect;?>" name="redirect"/>
                <input type="hidden" value="submitted" name="submitted"/>
				<button type="submit" class="btn btn-block btn-maroon">LOG IN</button>
			  </div>
			</div>
			</form>
		</div>
	  </div>
	  <div class="greet">
		  <h3>NEW CUSTOMER</h3>
		  <p>It Looks Like you wish to order without creating an account. So complete the form address below</p>
	  </div>
	  <div class="row">
		<div class="col-sm-2 col-md-4"></div>
		<div class="col-sm-8 col-md-4">
		  <?php echo form_open('secure/register', array('class'=>'form-horizontal form-clean', 'role'=>'form')); ?>
		    <div class="form-group">
			  <div class="col-sm-12">
				<input type="email" class="form-control" name="email" placeholder="email">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-6">
				<input type="password" class="form-control" name="password" placeholder="password">
			  </div>
			  <div class="col-sm-6">
				<input type="password" class="form-control" name="confirm" placeholder="confirm password">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-6">
				<input type="text" class="form-control" name="firstname" placeholder="first name">
			  </div>
			  <div class="col-sm-6">
				<input type="text" class="form-control" name="lastname" placeholder="last name">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control" name="address1" placeholder="address">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control number" name="zip" placeholder="zip code">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-6 col-sm-offset-3">
				<?php echo form_dropdown('province_id', $provinces_menu,  set_value('province_id', ''), 'style="width:200px; display:block;"  id="f_province_id" class="form-control"');?>
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<input type="text" class="form-control number" name="phone" placeholder="phone number">
			  </div>
			</div>
			<div class="form-group">
			  <div class="col-sm-12">
				<button type="submit" class="btn btn-block btn-maroon">CONTINUE</button>
			  </div>
			</div>
		  </form>
		</div>
		<div class="col-sm-2 col-md-4"></div>
	  </div>
	</div>
</div>
<!-- ./Container -->
	
<script type="text/javascript">
$(document).ready(function(){												
	$('#country_id').change(function(){
		$('#f_province_id').html("");
		$.post('<?php echo site_url('/places/get_jne_one_cities_menu');?>',{country:$('#country_id').val()}, function(data) {
		  $('#f_province_id').html(data);
		});

	});
});
</script>
<?php include('footer.php'); ?>