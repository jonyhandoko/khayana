<div class="leftMenu">
    <!--<h3 class="listTitle"><a href="/collections">Collections</a></h3>-->
    <h4 class="sub-listTitle"><img src="<?php echo base_url();?>images/arrow.png" class="mright5"><a href="/collections">All Collections</a></h4>
    <div class="blockNav">
        <h4 class="sub-listTitle"><img src="<?php echo base_url();?>images/arrow.png" class="mright5"><a href="/clothing">Clothing</a></h4>
        <ul>
            <li><a href="/top">Top</a></li>
            <li><a href="/bottom">Bottom</a></li>
            <li><a href="/dresses">Dresses</a></li>
            <li><a href="/outwear">Outwear</a></li>
        </ul>	
    </div>
    <h4 class="sub-listTitle"><img src="<?php echo base_url();?>images/arrow.png" class="mright5"><a href="/accessories">Accessories</a></h4>
    <!--<h4 class="sub-listTitle"><img src="<?php echo base_url();?>images/arrow.png" class="mright5"><a href="/shoes">Shoes</a></h4>-->
	<h4 class="sub-listTitle"><img src="<?php echo base_url();?>images/arrow.png" class="mright5"><a href="/sale">Sale</a></h4>
    
    <div class="blockNav" style="margin-top: 20px">
	<h2 class="sub-listTitle" style="font-weight: bold; color: #333; ">Social</h2>
	<a class="fright" style="margin-top: 4px; margin-right: 115px;" target="_blank" href="http://instagram.com/scarlet_collection"><img height="20" src="<?php echo base_url();?>images/instagramLogo.png"></a>
	<a class="fright" style="margin-top: 4px; margin-right: 15px;" target="_blank" href="https://twitter.com/Scarletshops"><img src="<?php echo base_url();?>images/twtgrey.png"></a>
	<a class="fright" style="margin-top: 4px; margin-right: 15px;" target="_blank" href="https://www.facebook.com/pages/Scarlet-house/196144370427638"><img src="<?php echo base_url();?>images/fbgrey.jpg"></a>
    </div>
    
    <script>
	function submitNewsletter(){
			
		if($('#newsletter').val()==""){
			alert("Please fill the field");
		}else{
			$('#submitNewsletter').html('<img src="http://www.scarletcollection.com/images/ajax-loader.gif"/>');
			$.post('<?php echo site_url("/cart/newsletter"); ?>',{newsletter:$('#newsletter').val()}, function(data){
				$('.newsletter-message').html(data);
				$('#newsletter').val("");
				$('#submitNewsletter').html('<input class="button2 mright10" type="submit" value="Submit" onclick="return submitNewsletter();"/>');
					//$('input:button, input:submit, button').button();		
			});
		}	
	}
    </script>
    <span style="float: right; margin-top: 25px;">
    	<p class="newsletter-message"></p>
		<?php //echo form_open('secure/newsletter'); ?>
        <input type="text" class="input1" placeholder="subscribe newsletter" accesskey="0" name="newsletter" id="newsletter" autocomplete="off"/>
        <span id="submitNewsletter"><input class="button2 mright10" type="submit" value="Submit" onclick="return submitNewsletter();"/></span>
        <!--</form>-->
    </span>
</div>

<style>
	.input1{
		width: 150px;
	}
</style>