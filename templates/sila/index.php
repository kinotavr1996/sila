<?php

defined('_JEXEC') or die;
// ------------ Start Canonical-Mod
$document = JFactory::getDocument();


$mainmenu =& JSite::getMenu();
if($mainmenu->getActive() == $mainmenu->getDefault()) :
    $livesite = substr_replace(JURI::root(), '', -1, 1);
    $docpagenr = '';
    $docstart = JRequest::getInt('start',0);
    if($docstart>0) :
        // Если хотим чтобы в канонической ссылке прописывалась постраничная разбивка типа start=10..., то раскомментируем сроку ниже.
        //$docpagenr = '?start='.$docstart;
    endif;
    //$docroute = JRoute::_('index.php?Itemid='.$mainmenu->getDefault()->id);
    // Если в качестве канонической ссылки хотим использовать системную ссылку Joomla типа http://мойсайт.рф/home.html , то раскомментируем сроку выше, и закомментируем строку ниже.
    $docroute = '/';
    $document->addHeadLink( $livesite . $docroute . $docpagenr, 'canonical', 'rel', '' );
endif;

///////////////////////////////////////////////////////////////////////////
//Pathes
////////////////////////////////////////////////////////////////////////////
$css_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR;
$tmpl_path = $this->baseurl . 'templates' . DIRECTORY_SEPARATOR . $this->template . DIRECTORY_SEPARATOR;
$tmpl_need = JUri::base() . "templates/fermasila/";

////////////////////////////////////////////////////////////////////////////
//Set css file and adding php less compiler and compile less with creating unique file like 'style.X.css'
////////////////////////////////////////////////////////////////////////////
$css_file_name = 'style.css'; //set base name
////////////////////////////////////////////////////////////////////////////
//PHP Error reporting
////////////////////////////////////////////////////////////////////////////
if ($this->params->get('show_php_errors')) {//if we use php less-compiler
    error_reporting(1);
    ini_set('display_errors', 'on');
} else {
    error_reporting(E_COMPILE_ERROR);
    ini_set('display_errors', 'off');
}

////////////////////////////////////////////////////////////////////////////
//HTML HEAD
////////////////////////////////////////////////////////////////////////////
$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$this->language = $doc->language;
$this->direction = $doc->direction;
$menu = $app->getMenu();

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>"
      lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100i,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="<?php echo $tmpl_path . 'css' . DIRECTORY_SEPARATOR . $css_file_name; ?>"/>
    <?php //Font awesome ?>


    <?php // Some global js vars start  ?>
    <script type="text/javascript">
        var local = {
            incart: "<?php echo JText::_(''); ?>",
            showcart: "<?php echo JText::_(''); ?>",
        };
        var validation_message = "";
        //var REQUIRED = <?php echo JText::_('REQUIRED'); ?>;

        var host_root = "<?php echo JURI::root(); ?>";
        var server_name = "<?php echo $_SERVER['SERVER_NAME']; ?>";
    </script>
    <script>
       var REQUIRED = "<?php echo JText::_('REQUIRED'); ?>";
       var COR_LOGIN = "<?php echo JText::_('COR_LOGIN'); ?>";
       var COR_LOGIN_MAX = "<?php echo JText::_('COR_LOGIN_MAX'); ?>";
       var DIGIT_NUMBER = "<?php echo JText::_('DIGIT_NUMBER'); ?>";
       var CORRECT_ADDRESS = "<?php echo JText::_('CORRECT_ADDRESS'); ?>";
       var host_root = "<?php echo JURI::root(); ?>";
       var server_name = "<?php echo $_SERVER['SERVER_NAME']; ?>";
       var local = {
           incart: "<?php echo JText::_(''); ?>",
           showcart: "<?php echo JText::_(''); ?>",
       };
       var validation_message = "";
    </script>
    <?php // jQuery file  ?>
    <script src="<?php echo $tmpl_path . '/js/jquery.min.js'; ?>" type="text/javascript"></script>

    <?php // wow file ?>
    <?php // Main javascript of web page. ?>
    <script src="<?php echo $tmpl_path . '/js/main.js?v.1.0.3'; ?>" type="text/javascript"></script>

    <script src="<?php echo $tmpl_path . '/js/jquery.validate.min.js'; ?>" type="text/javascript"></script>

    <script src="<?php echo $tmpl_path . '/js/jquery.validationEngine.js'; ?>" type="text/javascript"></script>




    <jdoc:include type="head"/>
</head>

<body <?php echo ($menu->getActive() == $menu->getDefault('en-GB') || $menu->getActive() == $menu->getDefault('ru-RU')) ? 'class="l-main"' : '' ?>>
<div id="main_content clearfix">
    <header id="header">
        <div class="wrap clearfix">

            <a href="/" class="logo" ></a>

            <div class="header_menu_box">
                <div class="menu_top_box clearfix">
                    <div class="free_call_box">
                        <div class="free_title">бесплатный звонок</div>
                        <a class="free_num" href="">8 (800) 555 777 15</a>1
                        <?php if ($this->countModules('header-call')): ?>
                            <jdoc:include type="modules" name="header-call"/>
                        <?php endif; ?>
                    </div>

                    <a href="#" class="order_call_box">
                        Заказать звонок
                    </a>
                </div>

                <div class="menu_bot_box clearfix">

                    <div class="menu_wrap_self">
                    <?php if ($this->countModules('header-main')): ?>
                    <ul class="menu_wrap_self clearfix">
                        <jdoc:include type="modules" name="header-main"/>
                    </ul>
                     <?php endif; ?>
                    </div>
                    <div class="HeaderLang">
                        <span class="active_lang">Ru</span>
                        <div class="lang_box" >
                            <jdoc:include type="modules" name="position_header_lang"/>
                        </div>
                    </div>
                  
                </div>

            </div>

        </div>
    </header>
    <div class="header-pusher"></div>
    <div class="main_slider">
        <?php if ($this->countModules('header-banner')): ?>
            <jdoc:include type="modules" name="header-banner"/>
        <?php endif; ?>
    </div>
    <jdoc:include type="message"/>

    <jdoc:include type="component"/>
  
    <footer id="footer">
        <div class="wrap">
            <div class="footer_header">Структрура сайта</div>
            <?php if ($this->countModules('position_footer')): ?>
                <div class="l-footer-menu">
                    <ul class="footer_menu">
                        <jdoc:include type="modules" name="position_footer"/>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </footer>
</div>

</body>
</html>