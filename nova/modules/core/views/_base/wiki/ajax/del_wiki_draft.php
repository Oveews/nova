<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('wiki/managepages/deletedraft');?>
	<?php echo form_hidden('id', $id);?>