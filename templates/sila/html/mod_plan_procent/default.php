<?php
defined('_JEXEC') or die;
jimport( 'joomla.application.module.helper' );
$module = JModuleHelper::getModule('mod_plan_procent');
$param = json_decode($module->params); // декодирует JSON с параметрами модуля
// echo '<pre>';
//     print_r(); // смотрим все параметры
// echo '</pre>';
?>
            <div class="tab_item passport_plan step_two clearfix" id="passport_plan">

                <div class="passport_text">

                    <p>С учетом сложившейся международной обстановки, высокое качество позиционных исследований требует
                        анализа глубокомысленных рассуждений. В своем стремлении улучшить пользовательский опыт мы
                        упускаем, что ключевые особенности структуры проекта превращены в посмешище, хотя само их
                        существование приносит несомненную пользу обществу. Некоторые особенности внутренней политики
                        разоблачены. Предварительные выводы неутешительны: консультация с широким активом требует
                        анализа как самодостаточных, так и внешне зависимых концептуальных решений. Некоторые
                        особенности внутренней политики могут быть подвергнуты целой серии независимых исследований.
                        Базовый вектор развития прекрасно подходит для реализации форм воздействия.</p>
                    <p>Предварительные выводы неутешительны: высокое качество позиционных исследований играет важную
                        роль в формировании вывода текущих активов. В своем стремлении улучшить пользовательский опыт мы
                        упускаем, что сделанные на базе интернет-аналитики выводы неоднозначны и будут своевременно
                        верифицированы.</p>

                </div>

                <div class="passport_title">Калькулятор прибыли</div>


                <div class="passport_cal_wrap">


                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title">Процент по вкладу</div>

                        <div class="pass_input_self"><input type="text"></div>
                    </div>

                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title">Ваше вложение</div>

                        <div class="pass_input_self"><input type="text"></div>
                    </div>

                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title">Ваш доход в год</div>

                        <div class="pass_input_self"><input type="text"></div>
                    </div>


                    <div class="pass_btn">Посчитать</div>


                </div>
                <div class="pass_sub_title">Ваше рещение</div>
                <div class="passport_cal_wrap decision">

                    <div class="pass_inpt_wrap">
                        <div class="pass_inpt_title">Ваша сумма Вложения</div>

                        <div class="pass_input_self"><input type="text"></div>
                    </div>
                    <div class="pass_btn">Посчитать</div>

                </div>
            </div>

            <div class="tab_item percentage_plan step_three clearfix" id="percentage_plan">

                <div class="image_bg"></div>


                <div class="perent_text_wrap">

                    <h2 class="h_two block_title">Процентный план</h2>

                    <div class="tab_txt">
                        <p> С учетом сложившейся международной обстановки, высокое качество позиционных исследований
                            требует
                            анализа глубокомысленных рассуждений. В своем стремлении улучшить пользовательский опыт мы
                            упускаем,
                            что ключевые особенности структуры проекта превращены в посмешище, хотя само их
                            существование
                            приносит несомненную пользу обществу. Некоторые особенности внутренней политики разоблачены.
                            Предварительные выводы неутешительны: консультация с широким активом требует анализа как
                            самодостаточных, так и внешне зависимых концептуальных решений. Некоторые особенности
                            внутренней
                            политики могут быть подвергнуты целой серии независимых исследований. Базовый вектор
                            развития
                            прекрасно подходит для реализации форм воздействия.</p>

                        <p>Предварительные выводы неутешительны: высокое качество позиционных исследований играет важную
                            роль в
                            формировании вывода текущих активов. В своем стремлении улучшить пользовательский опыт мы
                            упускаем,
                            что сделанные на базе интернет-аналитики выводы неоднозначны и будут своевременно
                            верифицированы.</p>

                    </div>

                    <div class="percent_invest_block clearfix">
                        <div class="invest_caption">Ваша сумма вложения</div>
                        <div class="invest_data">175 000</div>
                    </div>

                    <div class="percent_invest_block clearfix">
                        <div class="invest_caption">ДОХОДНОСТЬ В ГОД</div>
                        <div class="invest_data">28 00</div>
                    </div>

                    <div class="percent_agree">
                        <div class="agree_input"></div>
                        <div class="agree_self">Я согласен</div>
                    </div>

                </div>
                <div class="clearfix"></div>
                <div class="percent_payment clearfix">
                    <div class="pay_title">Выберите способ оплаты</div>

                    <div class="percent_pay_wrap">
                        <div class="image_pay master"></div>
                        <div class="image_pay yandex"></div>
                        <div class="image_pay paypal"></div>

                    </div>
                </div>
            </div>

