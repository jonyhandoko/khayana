<?php
$additional_header_info = '<style type="text/css">#gc_page_title {text-align:center;}</style>';
include('header.php'); ?>
<?php
$company	= array('id'=>'bill_company', 'class'=>'bill input', 'name'=>'company', 'value'=> set_value('company'));
$first		= array('class'=>'for140', 'id'=>'nome', 'maxlength'=>'30', 'name'=>'firstname', 'value'=> set_value('firstname'));
$last		= array('class'=>'for140', 'id'=>'nome', 'maxlength'=>'30', 'name'=>'lastname', 'value'=> set_value('lastname'));
$email		= array('class'=>'for140', 'id'=>'nome', 'maxlength'=>'40', 'name'=>'email', 'value'=>set_value('email'));
$phone		= array('class'=>'for140', 'id'=>'nome', 'maxlength'=>'30', 'name'=>'phone', 'value'=> set_value('phone'));
?>
<div class="register-form">
	<h1>ACCOUNT CREATION</h1>
    <hr/>
    <?php echo form_open('secure/register'); ?>
    <input type="hidden" name="submitted" value="submitted" />
	<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
    <div class="width540">
    	<h3>PERSONAL DATA</h3>
        <p>The fields marked with the asterisk ( <span class="obbligatorio">*</span> ) are required.</p><br/>
        <div class="width140">
            <label>First name <span class="obbligatorio">*</span></label>
            <?php echo form_input($first);?>
        </div>
        <div class="width140">
            <label>Last name <span class="obbligatorio">*</span></label>
            <?php echo form_input($last);?>
        </div>
        <div class="clear"></div>
         <div class="width140">
            <label>E-mail address <span class="obbligatorio">*</span></label>
            <?php echo form_input($email);?>
        </div>
        <div class="width140">
            <label>Telephone number <span class="obbligatorio">*</span></label>
            <?php echo form_input($phone);?>
        </div>
        <div class="clear"></div>
         <div class="width140">
            <label>Password <span class="obbligatorio">*</span></label>
            <input type="password" name="password" id="nome" value="" class="for140" maxlength="150" />
        </div>
        <div class="width140">
            <label>Password confirmation <span class="obbligatorio">*</span></label>
            <input type="password" name="confirm" id="nome" value="" class="for140" maxlength="150" />
        </div>
        <div class="clear"></div>
        
        <div class="width140">
        	<label>Gender</label>
            <input type="radio" name="gender" id="male" value="m" class=""> Male&nbsp;&nbsp;
            <input type="radio" name="gender" id="female" value="f" class=""> Female
        </div>
        <div class="width220">
            <label>Date of Birth</label>
            <select name="date" style="visibility: visible; "><option value="01">01</option><option value="02">02</option><option value="03">03</option><option value="04">04</option><option value="05">05</option><option value="06">06</option><option value="07">07</option><option value="08">08</option><option value="09">09</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23" selected="">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option></select>

<select name="month" style="visibility: visible; "><option value="01">Jan</option><option value="02">Feb</option><option value="03">Mar</option><option value="04">Apr</option><option value="05" selected="">May</option><option value="06">Jun</option><option value="07">Jul</option><option value="08">Aug</option><option value="09">Sep</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option></select>

<select name="year" style="visibility: visible; "><option value="1920">1920</option><option value="1921">1921</option><option value="1922">1922</option><option value="1923">1923</option><option value="1924">1924</option><option value="1925">1925</option><option value="1926">1926</option><option value="1927">1927</option><option value="1928">1928</option><option value="1929">1929</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012" selected="">2012</option></select>
        </div>
        <div class="clear"></div>
        <div class="width290">
        	<label>NEWSLETTER</label>
            <input type="checkbox" name="email_subscribe" id="newsletter" value="1" <?php echo set_radio('email_subscribe', '1', TRUE); ?>/>
                    I subscribe Scarlet's newsletter to revice latest news.
     	</div>
    </div>
    <div class="width540 last">
   		<h3>ADDRESS DELIVERY</h3>
        <p>The fields marked with the asterisk ( <span class="obbligatorio">*</span> ) are required.</p><br/>
        <div class="width140">
            <label>Address <span class="obbligatorio">*</span></label>
            <input type="text" name="address1" id="nome" value="" class="for300" maxlength="150">
            <input type="text" name="address2" id="nome" value="" class="for300" maxlength="150">
        </div>
        <div class="clear"></div>
        <div class="width140">
            <label>Province <span class="obbligatorio">*</span></label>
            <?php echo form_dropdown('province_id', $provinces_menu, set_value('province_id', $province_id), 'style="width:120px; display:block;" id="f_province_id" class="input for140"');?>
        </div>
        <div class="width140">
             <label>City <span class="obbligatorio">*</span></label>
            <?php echo form_dropdown('city_id', $cities_menu, set_value('city_id', $city_id), 'style="width:145px; display:block;" id="f_city_id" class="input for140"');?>
        </div>
        <div class="clear"></div>
        <div class="width140">
            <label>Postcode <span class="obbligatorio">*</span></label>
            <input type="text" name="postCode" id="nome" value="" class="for80" maxlength="150">
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear h20"></div>
    <div>
    	<input type="submit" id="SubmitLogin" name="SubmitLogin" class="button1 bold" value="SUBMIT">
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$('.button').button();
	
	$('#f_province_id').change(function(){
		$.post('<?php echo site_url('cart/get_cities_menu');?>',{provinceId:$('#f_province_id').val()}, function(data) {
		  $('#f_city_id').html(data);
		});

	});
});
</script>
<?php include('footer.php');