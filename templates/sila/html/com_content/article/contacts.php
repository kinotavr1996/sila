<?php

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

// Create shortcuts to some parameters.
$params  = $this->item->params;
$images  = json_decode($this->item->images);
$urls    = json_decode($this->item->urls);
$canEdit = $params->get('access-edit');
$user    = JFactory::getUser();
$info    = $params->get('info_block_position', 0);
JHtml::_('behavior.caption');
$doc = JFactory::getDocument();
$tmpl_need = JUri::base()."templates/brilliant_new/";
$renderer = $doc->loadRenderer('modules');
$options = array('style' => 'xhtml');
$position = 'position_bread';
?>

<body class="l-contacts">

    <div id="footer-pusher">
    <div class="l-content">

        <div class="l-wrap">

            <h1 class="c-title-big"><?php echo $this->item->title;?></h1>

            <?php	echo $renderer->render($position, $options, null);	?>

        </div>

        <div class="l-content-inner">

            <div class="l-contacts-wrap">
                <div class="l-contacts-col _img"></div><!--col-->
                <div class="l-contacts-col _form"></div><!--col-->

                <div class="clear"></div>

                <div class="l-wrap l-contacts-inner">
                    <div class="l-contacts-inner-col _img">
                        <div class="c-who-box _contacts">
                            <div class="c-who-box__txt"><?php echo JText::_('CONTACT'); ?></div>
                            <div class="c-who-box__txt _color"><?php echo JText::_('WITH_US'); ?></div>
                        </div>
                        <!--who box-->

                        <div class="clear"></div>

                        <div class="l-contacts-list-wrap">
                            <div class="l-contacts-list">
                                <div class="c-contacts-list__title">Email</div>
                                <ul class="c-contacts-list__spisok">
                                    <li><a href="mailto:info@forest-service.com">info@timber-way.com</a></li>
                                </ul>
                            </div>
                            <!--list-->
                            <div class="l-contacts-list">
                                <div class="c-contacts-list__title"><?php echo JText::_('COM_VIRTUEMART_SHOPPER_FORM_PHONE'); ?></div>
                                <ul class="c-contacts-list__spisok">
                                    <li>+380 (633) 387 888</li>
                                </ul>
                            </div>
                            <!--list-->
                            <div class="l-contacts-list">
                                <div class="c-contacts-list__title"><?php echo JText::_('COORDINATE'); ?></div>
                                <ul class="c-contacts-list__spisok">
                                    <li>48.298882, 25.253709</li>
                                </ul>
                            </div>
                            <!--list-->
                        </div>
                        <!--wrap-->
                    </div>
                    <!--col-->

                    <?php	echo $renderer->render('callback', $options, null);	?>
                    <!--col-->

                </div>
                <!--inner-->

            </div>
            <!--l-wrap-->
            <?php	echo $renderer->render('position_map', $options, null);	?>
        </div>
        <!--/ ContentInner -->

    </div>    <!--/ Content -->
<div class="push"></div>
    </div>

    </div>