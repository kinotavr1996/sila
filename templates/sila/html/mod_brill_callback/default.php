<?php 
defined('_JEXEC') or die;
$doc=JFactory::getDocument();
?>
<div class="ContactsForm">
<div id="modal2" class="modal_div">
<div class="modal_close Modal__close"></div>
	<div class="callback-popup ModalInner">
		<div class="Title_long _color _center _padding"><?php //echo JText::_('MOD_BRILL_CALLBACK_CALLBACK'); ?></div>
		<div class="Modal__desc"><?php //echo JText::_('MOD_BRILL_CALLBACK_DESCR'); ?></div>

		<div class="ModalForm">
			<form id = "contact_form" action="<?php echo JRoute::_('index.php?option=com_brillcallback&view=sendform'); ?>" method="post" >

				<div class="l-contacts-inner-col _form">
					<div class="l-form-item">
						<!--<label for="brillcallback_name"><?php //echo JText::_('MOD_BRILL_CALLBACK_NAME'); ?></label>-->
						<input type="text" name="name" class="c-form__field field_effect" id="brillcallback_name" placeholder="<?php echo JText::_('MOD_BRILL_CALLBACK_NAME'); ?>" required />
					</div>
					<div class="l-form-item">
						<!--<label for="brillcallback_phone"><?php //echo JText::_('MOD_BRILL_CALLBACK_PHONE'); ?></label>-->
						<input type="text" name="phone" class="c-form__field field_effect" id="brillcallback_phone" placeholder="<?php echo JText::_('MOD_BRILL_CALLBACK_PHONE'); ?>" required />
					</div>
					<div class="l-form-item">
						<!--<label for="brillcallback_phone"><?php //echo JText::_('MOD_BRILL_CALLBACK_PHONE'); ?></label>-->
						<input type="text" name="email" class="c-form__field field_effect" id="brillcallback_email" placeholder="<?php echo JText::_('MOD_BRILL_CALLBACK_EMAIL'); ?>" required />
					</div>
					<div class="l-form-item">
						<!--<label for="brillcallback_comment"><?php //echo JText::_('MOD_BRILL_CALLBACK_COMMENT'); ?></label>-->
						<textarea name="comment" class="c-form__field c-form__field_textarea field_effect" id="brillcallback_comment" placeholder="<?php echo JText::_('MOD_BRILL_CALLBACK_COMMENT'); ?>"></textarea>
					</div>
					<div class="l-form-item">
						<input type="submit" class="button _black _right" id = "btn-send" value="<?php echo JText::_('MOD_BRILL_CALLBACK_SUBMIT'); ?>">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>