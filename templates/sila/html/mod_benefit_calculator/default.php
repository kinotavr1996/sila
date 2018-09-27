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
<div class="tab_item  project_plan step_three clearfix" id="project_plan">
                <div class="proj_plan_top clearfix">
                    <div class="image_bg"></div>
                    <div class="project_plan_txt">
                        <div class="project_plan_title">Мудрый гриб</div>
                        <p>С учетом сложившейся международной обстановки, высокое качество позиционных исследований
                            требует анализа глубокомысленных рассуждений. В своем стремлении улучшить пользовательский
                            опыт мы упускаем, что ключевые особенности структуры проекта превращены в посмешище, хотя
                            само их существование приносит несомненную пользу обществу. Некоторые особенности внутренней
                            политики разоблачены. Предварительные выводы неутешительны: консультация с широким активом
                            требует анализа как самодостаточных, так и внешне зависимых концептуальных решений.
                            Некоторые особенности внутренней политики могут быть подвергнуты целой серии независимых
                            исследований. Базовый вектор развития прекрасно подходит для реализации форм
                            воздействия.</p>
                        <p>Предварительные выводы неутешительны: высокое качество позиционных исследований играет важную
                            роль в формировании вывода текущих активов. В своем стремлении улучшить пользовательский
                            опыт мы упускаем, что сделанные на базе интернет-аналитики выводы неоднозначны и будут
                            своевременно верифицированы.</p>
                    </div>
                </div>
                <div class="project_subtitle">В зависимости от готовности проекта определяется минимальная сумма
                    вложения
                </div>


                <div class="project_banner one">

                </div>

                <div class="project_calc">Калькулятор прибыли</div>
                <div class="project_scale"></div>

                <div class="project_cal_wrap">
                <input class="project-cost" type="hidden" value="<?php echo $project_cost?>">
                <input class="project-percent" type="hidden" value="<?php echo $procent?>">


                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title">Предпологаемая доходность проекта</div>

                        <div class="pass_input_self "><input class='profit' type="text" value="<?php echo $param->estimated_profitability_of_the_project?>"></div>
                    </div>

                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title ">Ваше вложение</div>

                        <div class="pass_input_self"><input class='decision' type="text"></div>
                    </div>

                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title ">Ваш доход в год</div>

                        <div class="pass_input_self"><input class='yourProfit' type="text"></div>
                    </div>
                    <div class="pass_btn">Посчитать</div>
                </div>
                <div class="project_sub_title">Ваше решение</div>
                <div class="project_cal_wrap decision">

                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title">Ваша сумма Вложения</div>

                        <div class="pass_input_self"><input class='yourProfit' type="text"></div>
                    </div>
                    <div class="pass_btn">Посчитать</div>

                </div>
            </div>