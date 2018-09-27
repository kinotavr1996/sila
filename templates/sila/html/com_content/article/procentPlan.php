<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$doc = JFactory::getDocument();
$renderer = $doc->loadRenderer('modules');
$options = array('style' => 'xhtml');
$position = 'procent_calculator';
?>

<div class="item-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">
<div itemprop="articleBody">
<div class="steps_wrap_box clearfix ">
        <div class="wrap">
            <ul class="steps_name_box">
                <li  class="st_name step_one active">Выбранный план</li>
                <li class="st_name step_two">Паспорт проекта</li>
                <li class="st_name step_three">Чек Лист</li>
            </ul>
            <ul class="step_btn_wrap clearfix">
                <li id="step_1" data-step="step_one" class="step_link active current">
                    <div class="step_title">Шаг</div>
                    <div class="span_circle">1</div>
                </li>
                <li  id="step_2" data-step="step_two" class="step_link">
                    <div class="step_title">Шаг</div>
                    <div class="span_circle">2</div>
                </li>
                <li  id="step_3" data-step="step_three" class="step_link">
                    <div class="step_title">Шаг</div>
                    <div class="span_circle">3</div>
                </li>
            </ul>
        </div>
</div>
        </div>
		<div class="tab_window">
        <div class="wrap main_tap_wrap">
		<?php echo $this->item->text; ?>
        <?php echo $renderer->render($position, $options, null);	?>          
        </div>
        <div class="project_btn_wrap clearfix">
            <div class="project_btn plan">Сменить план</div>
            <div class="project_btn back"> <<Назад</div>
            <div class="project_btn next">Продолжить>></div>
        </div>
    </div>


    </div>
	</div>
    