<?php 
defined('_JEXEC') or die;
//Callback window

//echo('<div class="description">'.JText::_('MOD_BRILL_FEEDBACK_DESCR').'</div>');
$id_pref='brillfb_';

?>


<div class="ContactsForm">
	<form <!--action="<?php echo JRoute::_('index.php?option=com_brillcallback&view=sendform')?>--> method="post">
	<div class="ContactsFormColumn">
		<div class="ContactsFormColumnInner _left">
			<div class="FormItem">
				<input type="text" name="name" id="<?php echo '.$id_pref.'?>name"  placeholder="<?php echo JText::_('INPUT_NAME');?>" class="Form__field field_effect">
			</div>
			<div class="FormItem">
				<input type="text" name="phone" id="<?php echo '.$id_pref.'?>phone" placeholder="<?php echo JText::_('INPUT_PHONE');?>" class="Form__field field_effect" >
			</div>
			<div class="FormItem">
				<input type="text" name="email" id="<?php echo '.$id_pref.'?>email" placeholder="<?php echo JText::_('INPUT_EMAIL');?>*" class="Form__field field_effect" >
			</div>
		</div>
	</div>
	<div class="ContactsFormColumn">
		<div class="ContactsFormColumnInner _right">
			<div class="FormItem">
				<textarea name="comment" class="Form__field Form__field_textarea field_effect" value="" placeholder="<?php echo JText::_('INPUT_TEXT');?>" id="<?php echo '.$id_pref.'?> comment" ></textarea>
			</div>
			<div class="FormItem">
				<input type="submit" class="button submit" value="<?php echo JText::_('MOD_BRILL_CALLBACK_FEEDBACK_SUBMIT') ?>">
			</div>
		</div>
	</div>
	</form>
</div>
