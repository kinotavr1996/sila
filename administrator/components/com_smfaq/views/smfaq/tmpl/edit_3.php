<?php
/**
 * SMFAQ
 *
 * @package		Component for Joomla 2.5.6+
 * @version		1.7.3
 * @copyright	(C)2009 - 2013 by SmokerMan (http://joomla-code.ru)
 * @license		GNU/GPL v.3 see http://www.gnu.org/licenses/gpl.html
 */

// защита от прямого доступа
defined('_JEXEC') or die('@-_-@'); 


JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
JHtml::_('formbehavior.chosen', 'select');

?>

<script type="text/javascript">
//<![CDATA[
           
if (typeof(SmFaq) === 'undefined') {var SmFaq = {};}  
SmFaq.delcomment = function(id, s) {
	s.className='sm-loader';
	row = 'comment-'+id;
    new Request({
        url: 'index.php?option=com_smfaq&task=smfaq.delcomment&format=raw',
        onSuccess: function(responseText, responseXML) {
        	s.set('class','');
        	s.set('html', responseText);
         	setTimeout("SMFAQ_highlight(row);",2000); 
        }
    }).send('id='+id);	
}        
	Joomla.submitbutton = function(task)
	{
		if (task == 'smfaq.cancel' || document.formvalidator.isValid(document.id('smfaq-form'))) {
			<?php echo $this->form->getField('answer')->save(); ?>
			Joomla.submitform(task, document.getElementById('smfaq-form'));
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}

	function SMFAQ_highlight(el) {
		el = $(el);
		var highlight = new Fx.Morph($(el), {
		    duration: 'long',
		    transition: Fx.Transitions.Sine.easeOut,
		    onComplete: function(){
		    	el.destroy();
		    }
		})
		highlight.start({
			'opacity': 0
		});
	}


	function resetvote(id, b) {
		var l = new Element('div', {
		    'class': 'sm-loader2'
			}
		);
		l.inject(b, 'after');
	    new Request({
	        url: 'index.php?option=com_smfaq&task=smfaq.resetvote&format=raw',
	        onSuccess: function(responseText, responseXML) {
	        	$('smfaq-votes').set('html', responseText);
	        }
	    }).send('id='+id);	
	}
// ]]>	
</script>
<form action="<?php echo JRoute::_('index.php?option=com_smfaq&layout=edit&id='. (int) $this->form->getValue('id')); ?>" method="post" name="adminForm" id="smfaq-form">
   	   <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
	       <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_SMFAQ_GENERAL')); ?>
	           <div class="row-fluid">
	               <div class="span10">
                       <fieldset class="smfaq">
                           <legend> <?php echo $this->form->getLabel('question'); ?></legend>
                           <?php echo $this->form->getInput('question'); ?>
                       </fieldset>
                       <fieldset class="smfaq">
                           <legend> <?php echo $this->form->getLabel('answer'); ?></legend>
                           <?php echo $this->form->getInput('answer'); ?>
                       </fieldset>
                    </div>
               </div>
       <?php echo JHtml::_('bootstrap.endTab'); ?> 
        
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('COM_SMFAQ_DETAILS')); ?>
            <div class="row-fluid">
                <div class="span10 form-horizontal">
                    <?php foreach ($this->form->getFieldset('details') as $field) : ?>
                        <div class="control-group">
                            <?php echo $field->label; ?>
                            <div class="controls">
                                <?php echo $field->input; ?>
                            </div>
                        </div>
                    <?php endforeach; ?> 
                </div>
            </div>            
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
       <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'comments', JText::_('COM_SMFAQ_FIELD_COMMENTS_LABEL')); ?>
            <?php echo $this->form->getInput('comments'); ?>     
       <?php echo JHtml::_('bootstrap.endTab'); ?>           
        
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'seo', JText::_('COM_SMFAQ_QUESTION_SEO_LABEL')); ?>
            <div class="row-fluid">
                <div class="span10 form-horizontal">
                    <?php echo JText::_('COM_SMFAQ_QUESTION_SEO_DESC'); ?>
                    <?php foreach ($this->form->getFieldset('seo') as $field) : ?>
                        <div class="control-group">
                            <?php echo $field->label; ?>
                            <div class="controls">
                                <?php echo $field->input; ?>
                            </div>
                        </div>
                    <?php endforeach; ?> 
                </div>
            </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?> 
        
        <?php echo JHtml::_('bootstrap.endTabSet'); ?>


	<input type="hidden" name="task" value="" />
	<?php echo JHTML::_('form.token'); ?>
</form>

