<?php 
defined('_JEXEC') or die;
$doc=JFactory::getDocument();
?>
<div class="makeOrderForm">
	<div class = "makeOrderHead"><?php echo JText::_('TPL_FOREST_MAKE_ORDER'); ?></div>
		<div class="orderForm">
			<form id = "order_form" action="<?php echo JRoute::_('index.php?option=com_brillcallback&view=sendform'); ?>" method="post" >

				<div class="order-row-left">
					<div class="order-item">
						<label for="brillcallback_name_of_product"><?php echo JText::_('MOD_BRILL_CALLBACK_NAME_OF_PRODUCT'); ?>:</label>
						<input type="text" name="name_of_product" class="order-field field_effect" id="brillcallback_name_of_product" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_NAME_OF_PRODUCT'); ?>" required />
					</div>
					<div class="order-item">
						<label for="brillcallback_diametr"><?php echo JText::_('MOD_BRILL_CALLBACK_DIAMETR'); ?>:</label>
						<input type="text" name="diametr" class="order-field _cm field_effect" id="brillcallback_diametr" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_DIAMETR'); ?>" required /><span class = "cm"><?php echo JText::_('TPL_FOREST_CM'); ?></span>
					</div>
					<div class="order-item">
						<label for="brillcallback_thick"><?php echo JText::_('MOD_BRILL_CALLBACK_THICK'); ?>:</label>
						<input type="text" name="thick" class="order-field _cm field_effect" id="brillcallback_thick" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_THICK'); ?>" required /><span class = "cm"><?php echo JText::_('TPL_FOREST_CM'); ?></span>
					</div>
					<div class="order-item">
						<label for="brillcallback_sort"><?php echo JText::_('MOD_BRILL_CALLBACK_SORT'); ?>:</label>
						<input type="text" name="sort" class="order-field field_effect" id="brillcallback_sort" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_SORT'); ?>" required />
					</div>
					<div class="order-item">
						<label for="brillcallback_dopusk"><?php echo JText::_('MOD_BRILL_CALLBACK_DOPUSK'); ?>:</label>
						<input type="text" name="dopusk" class="order-field field_effect" id="brillcallback_dopusk" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_DOPUSK'); ?>" required />
					</div>
					<div class="order-item">
						<label for="brillcallback_proparka"><?php echo JText::_('MOD_BRILL_CALLBACK_PROPARKA'); ?>:</label>
						<input type="text" name="proparka" class="order-field field_effect" id="brillcallback_proparka" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_PROPARKA'); ?>" required />
					</div>
				</div>
				<div class="order-row-right">	
					<div class="order-item">
						<label for="brillcallback_poroda"><?php echo JText::_('MOD_BRILL_CALLBACK_PORODA'); ?>:</label>
						<input type="text" name="poroda" class="order-field field_effect" id="brillcallback_poroda" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_PORODA'); ?>" required />
					</div>
					<div class="order-item">
						<label for="brillcallback_width"><?php echo JText::_('MOD_BRILL_CALLBACK_WIDTH'); ?>:</label>
						<input type="text" name="width" class="order-field _cm field_effect" id="brillcallback_width" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_WIDTH'); ?>" required /><span class = "cm"><?php echo JText::_('TPL_FOREST_CM'); ?></span>
					</div>
					<div class="order-item">
						<label for="brillcallback_length"><?php echo JText::_('MOD_BRILL_CALLBACK_LENGTH'); ?>:</label>
						<input type="text" name="length" class="order-field _cm field_effect" id="brillcallback_length" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_LENGTH'); ?>" required /><span class = "cm"><?php echo JText::_('TPL_FOREST_CM'); ?></span>
					</div>
					<div class="order-item">
						<label for="brillcallback_quality"><?php echo JText::_('MOD_BRILL_CALLBACK_QUALITY'); ?>:</label>
						<input type="text" name="quality" class="order-field field_effect" id="brillcallback_quality" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_QUALITY'); ?>" required />
					</div>
					<div class="order-item">
						<label for="brillcallback_humidity"><?php echo JText::_('MOD_BRILL_CALLBACK_HUMIDITY'); ?>:</label>
						<input type="text" name="humidity" class="order-field field_effect" id="brillcallback_humidity" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_HUMIDITY'); ?>" required />
					</div>
					<div class="order-item">
						<label for="brillcallback_email"><?php echo JText::_('MOD_BRILL_CALLBACK_EMAIL'); ?></label>
						<input type="text" name="email" class="order-field field_effect" id="brillcallback_email" placeholder="<?php //echo JText::_('MOD_BRILL_CALLBACK_EMAIL'); ?>" required />
					</div>	
				</div>
				<div class = "clear"></div>
				<div class="order-item">
					<label for="brillcallback_email"><?php echo JText::_('MOD_BRILL_CALLBACK_COMMENT'); ?></label>
					<textarea name="comment" class="order-field order-field field_effect" id="brillcallback_comment" placeholder="<?php echo JText::_('MOD_BRILL_CALLBACK_COMMENT'); ?>"></textarea>
				</div>
				<button type="submit" class="button _black" id = "btn-send" value=""><?php echo JText::_('MOD_BRILL_CALLBACK_SUBMIT'); ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
			</form>
		</div>

</div>