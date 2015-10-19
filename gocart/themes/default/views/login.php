<?php 

$additional_header_info = '<style type="text/css">#page_title {text-align:center;}</style>';
include('header.php'); ?>
	<div class="login_container_wrap">
    	<h1>ACCOUNT</h1>
    	<hr/>
        <div class="login-container">
            <div class="width340">
            	<?php echo form_open('secure/login') ?>
                    <h3>ALREADY REGISTERED CLIENT</h3>
                    <p>If you already have an account, and want to access to Scarlet, fill in the appropiate fields with your Username and Password</p><br/>
                    <div class="width140">
                        <label>EMAIL</label>
                        <input type="text" name="email" class="gc_login_input"/>
                    </div>
                    <div class="width140">
                        <label>PASSWORD</label>
                        <input type="password" name="password" class="gc_login_input"/>
                    </div>
                    <div class="clear">
                        <input type="hidden" value="<?php echo $redirect; ?>" name="redirect"/>
                        <input type="hidden" value="submitted" name="submitted"/>
                    </div><br/>
                    <a href="http://www.steveandco.com/retrieve_password.php">Forgot your password?</a>
                    <br/>
                    <br/>
                    <br/>
                    <input type="submit" value="LOG IN" name="submit" class="button1 bold"/>
                </form>
             </div>
             <div class="width340 last" style="margin-left: 200px;">
                <h3 class="enf">NEW CUSTOMER</h3>
                <p>Register yourself at Steve &amp; Co. and you will have the opportunity</p>
                <br/>
                <p>	- To purchase our products online.<br>
                    - To enter your reserved area to check the status of your order.<br>
                    - To always be updated on Steve &amp; Co.<br>
                </p>
                <br/><br/><br/><br/>
                <div class="button2"><a href="register">REGISTER</a></div>
             </div>
    	</div>
	</div>
<?php include('footer.php'); ?>