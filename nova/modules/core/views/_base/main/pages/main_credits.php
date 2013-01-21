<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h1><?php echo $header;?></h1>

<div class="btn-group">
	<?php echo link_to_if($edit_valid, 'site/messages', img(Location::img('icon-edit.png', $this->skin, 'main')), array('class' => 'btn'));?>
</div>

<?php echo text_output($msg_credits_perm);?>

<hr>

<?php echo text_output($msg_credits);?>