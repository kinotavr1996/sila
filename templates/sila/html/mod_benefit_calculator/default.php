<?php
defined('_JEXEC') or die;
jimport( 'joomla.application.module.helper' );
$module = JModuleHelper::getModule('mod_benefit_calculator');
$param = json_decode($module->params); // декодирует JSON с параметрами модуля
$procent = $param->procent_for_investor_from_the_project;
$project_cost = $param->project_cost;
// echo '<pre>';
//     print_r($param); // смотрим все параметры
// echo '</pre>';
?>
<!-- <div class="wrap">
    
</div> -->
<div class="tab_item  project_plan step_three clearfix" id="project_plan">
<h1 class="h_two t_align">Мудрый гриб</h1>

<div class="tab_txt">

    <p> С учетом сложившейся международной обстановки, высокое качество позиционных исследований требует анализа
        глубокомысленных рассуждений. В своем стремлении улучшить пользовательский опыт мы упускаем, что ключевые
        особенности структуры проекта превращены в посмешище, хотя само их существование приносит несомненную пользу
        обществу. Некоторые особенности внутренней политики разоблачены. Предварительные выводы неутешительны:
        консультация с широким активом требует анализа как самодостаточных, так и внешне зависимых концептуальных
        решений. Некоторые особенности внутренней политики могут быть подвергнуты целой серии независимых
        исследований. Базовый вектор развития прекрасно подходит для реализации форм воздействия.
    </p>
    <p>В рамках спецификации современных стандартов, реплицированные с зарубежных источников, современные
        исследования могут быть превращены в посмешище, хотя само их существование приносит несомненную пользу
        обществу. Элементы политического процесса являются только методом политического участия и рассмотрены
        исключительно в разрезе маркетинговых и финансовых предпосылок.

    </p>
    <p>В частности, современная методология разработки влечет за собой процесс внедрения и модернизации прогресса
        профессионального сообщества. Семантический разбор внешних противодействий предоставляет широкие возможности
        для системы обучения кадров, соответствующей насущным потребностям. Идейные соображения высшего порядка, а
        также сплоченность команды профессионалов обеспечивает широкому кругу (специалистов) участие в формировании
        прогресса профессионального сообщества. Высокий уровень вовлечения представителей целевой аудитории является
        четким доказательством простого факта: современная методология разработки однозначно фиксирует необходимость
        стандартных подходов.
    </p>
</div>
<script>

    jQuery(document).ready(function () {

        var cnt = 40;
        var bar = "";
        for (i = 0; i < 40; i++) {
            bar += '<span class="bar"></span>';
        }
        jQuery('.scale_bar').append(bar);
        var
            percent = parseInt(jQuery('.scale_num').text()),

            cntr = 0;

        percent = Math.floor(cnt * (percent / 100));

        jQuery('.scale_bar').find('.bar').each(function () {
            if (cntr >= percent) {
                return;
            }
            jQuery(this).addClass('active');

            cntr = cntr + 1;
        });
    });
</script>
<div class="mash_calc">

    <img class="mash_img" src="/sila/templates/sila/images/wise_mash.png" alt="">
    <div class="mash_caption">
        окончание сбора средств
        <div class="change_date">30.05.2019</div>
    </div>
</div>

<div class="benefit_scale_box">
    <div class="scale_bar clearfix">

    </div>
    <div class="scale_num">65%</div>
</div>

<div class="passport_title">Калькулятор прибыли</div>

<div class="spec_box">

    <div class="title">предпологаемая доходность от проекта</div>
    <div class="spec_percent">
        <?php echo $procent?>
    </div>
</div>

<div class="invest_block">
    <div class="title"> ваше вложение</div>

    <div class="invest-rate">
    <span class="rate_self">
            <span class="rate">5000</span>
            <span class="rate">рублей</span>
        </span>
        <span class="rate_self">
            <span class="rate">25000</span>
            <span class="rate">рублей</span>
        </span>
        <span class="rate_self">
            <span class="rate">50000</span>
            <span class="rate">рублей</span>
        </span>
        <span class="rate_self">
            <span class="rate">100000</span>
            <span class="rate">рублей</span>
        </span>
        <span class="rate_self">
            <span class="rate">200000</span>
            <span class="rate">рублей</span>
        </span>
        <span class="rate_self">
            <span class="rate">350000</span>
            <span class="rate">рублей</span>
        </span>
    </div>

</div>
<div class="fututer_benefit_block">
    <div class="title">предпологаемый доход + сумма ваших вложений через 15 месяцев</div>
    <div class="fututer_benefit_data">
        248.000
    </div>
    <div class="title"><Рублей></Рублей></div>
</div>
            </div>