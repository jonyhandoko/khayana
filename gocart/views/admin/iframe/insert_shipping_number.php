<?php include('header.php');?>

<?php if(isset($finished)) : ?>

<script type="text/javascript"> $(function() { parent.location.reload(); }); </script>

<?php else : ?>

<div style="text-align:left">
<form id="number_form" action="<?php echo site_url($this->config->item('admin_folder').'/orders/insert_number/'.$order_id);?>" method="post" />
<input type="hidden" name="send" value="true">

<table cellspacing="10">
    <tr>
        <th align="left">Insert Shipping Number</th>
    </tr>
    <tr>
        <td><input type="text" name="shipping_number" size="20" id="msg_subject" class="gc_tf1"/></td>
    </tr>
    <tr>
        <td><a onclick="$('#number_form').trigger('submit');" class="button"><?php echo lang('send_message');?></a></td>
    </tr>
</table>


</form>
<?php endif; ?>
<?php include('footer.php');?>