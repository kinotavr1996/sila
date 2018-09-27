<?php 
defined('_JEXEC') or die;
//Callback window
//echo('<div class="description">'.JText::_('MOD_BRILL_FEEDBACK_DESCR').'</div>');
$id_pref='brillfb_';
$url = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
//var_dump($url);
?>

<div class="ModalForm">
	<form action="<?php echo JRoute::_('index.php?option=com_brillcallback&view=sendform'); ?>" method="post" onsubmit="ga('send','event','knopka_cityformprodukt','knopka_cityformprodukt','knopka_cityformprodukt_yarlyk');return true;" >
		<div class="ModalFormInner">
			<div class="ModalFormItem">
				<input type="text" name="name" id="<?php echo $id_pref.'name' ?>" class="field_effect Form__field" value="" placeholder="<?php echo JText::_('MOD_BRILL_CALLBACK_NAME');?>" required />
			</div>
			<div class="ModalFormItem">
				<input type="phone" name="phoneСonsultation" id="<?php echo $id_pref.'phone' ?>" class="field_effect Form__field" value="" placeholder="<?php echo JText::_('MOD_BRILL_CALLBACK_PHONE');?>" required />
			</div>
		</div>
	<input type="submit" class="button submit Button Button_radius" value="<?php echo JText::_('MOD_BRILL_CALLBACK_FEEDBACK_SUBMIT'); ?>" />
	</form>
</div>



