<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

global $APPLICATION;
define("SITE_SERVER_PROTOCOL", (CMain::IsHTTPS()) ? "https://" : "http://");

$APPLICATION->SetPageProperty("og:image", SITE_SERVER_PROTOCOL . SITE_SERVER_NAME . '/og_image.jpg');

//CJSCore::Init(array("date", "ajax"));
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap.min.css");
//$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/fontawesome.css/all.min.css");
//$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick.css");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.min.css");

//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/bootstrap.bundle.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.mask.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/slick.min.js");

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/script.js");

?><!DOCTYPE html>
<html lang="ru">
	<head>
		<meta http-equiv="content-language" content="ru">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="robots" content="noindex" />

		<? /* <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> */ ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-2.2.4.min.js" ></script>

		<?$APPLICATION->ShowHead();?>
		<title><?$APPLICATION->ShowTitle();?></title>

		<meta property="og:url" content="<?=SITE_SERVER_PROTOCOL . SITE_SERVER_NAME . $curPage?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?$APPLICATION->ShowProperty("title")?>">
		<meta property="og:description" content="<?=$APPLICATION->ShowProperty("description")?>">
		<meta property="og:image" content="<?=$APPLICATION->ShowProperty("og:image")?>">
		<link href="<?=SITE_TEMPLATE_PATH?>/media.css?v=<?=rand()?>" type="text/css"  rel="stylesheet" />
		<link rel="apple-touch-icon" sizes="57x57" href="/images/fav/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/images/fav/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/images/fav/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/images/fav/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/images/fav/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/images/fav/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/images/fav/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/images/fav/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/images/fav/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="/images/fav/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/images/fav/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/images/fav/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/images/fav/favicon-16x16.png">
		<link rel="manifest" href="/images/fav/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="/images/fav/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-WC2MWQH');</script>
		<!-- End Google Tag Manager -->
		<!--envybox--><link rel="stylesheet" href="https://cdn.envybox.io/widget/cbk.css">
		<script type="text/javascript" src="https://cdn.envybox.io/widget/cbk.js?wcb_code=67e0c4cdfb81a3ecefc07c6399933c55" charset="UTF-8" async></script>
		<link rel="preconnect" href="https://fonts.googleapis.com"> 
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight&display=swap" rel="stylesheet">

	</head>
	<body >
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WC2MWQH"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->

        <? if ($USER->IsAdmin()) { ?>
            <div id="panel" class="d-none d-lg-block">
                <?$APPLICATION->ShowPanel();?>
            </div>
        <? } ?>

    <header class="header">
        <div class="container py-3">
            <div class="row align-items-center justify-content-between">
                <div class="d-md-none col-auto">
                    <a class="btn-mmenu " href="#"><span class="icon"></span></a>
                </div>

                <div class="col d-none d-md-block">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "simple",
                        array(
                            "ROOT_MENU_TYPE" => "landing",
                            "MAX_LEVEL" => "1",
                            "USE_EXT" => "N",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "N",
                            "MENU_CACHE_GET_VARS" => array(),
                            "COMPONENT_TEMPLATE" => "simple",
                            "CHILD_MENU_TYPE" => "left",
                        ),
                        false
                    );?>
                </div>


                <div class="col-auto d-none d-lg-block">
                    <a class="weight-600 font-16 space02 d-block" href="tel:<?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))?>">
                        <?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))?>
                    </a>
                    <div class="font-14 gray mt-n1">
                        <?$APPLICATION->IncludeFile('/local/include/inc-worktime.php', array(), array('SHOW_BORDER'=>true))?>
                    </div>
                </div>

                <div class="col-auto">
                    <?$APPLICATION->IncludeFile('/local/include/inc-socnet.php', array(), array('SHOW_BORDER'=>true))?>
                </div>

            </div>
        </div>
    </header>

    <div class="mobile-menu">
        <div class="container">
            <form class="header-search-form ajax-header-search-form d-none d-md-block" action="/search/" method="get">
                <input class="header-search-text form-control" type="text" name="q" placeholder="Поиск по названию">
                <button class="header-search-submit form-control" type="submit" ><i class="fal fa-search"></i></button>
            </form>
        </div>

        <div class="container my-4">
            <?$APPLICATION->IncludeComponent(
                "bitrix:menu",
                "simple",
                array(
                    "ROOT_MENU_TYPE" => "top",
                    "MAX_LEVEL" => "5",
                    "USE_EXT" => "Y",
                    "DELAY" => "N",
                    "ALLOW_MULTI_SELECT" => "N",
                    "MENU_CACHE_TYPE" => "A",
                    "MENU_CACHE_TIME" => "3600",
                    "MENU_CACHE_USE_GROUPS" => "N",
                    "MENU_CACHE_GET_VARS" => array(),
                    "COMPONENT_TEMPLATE" => "simple",
                    "CHILD_MENU_TYPE" => "left",
                    "URL_PATH" => $APPLICATION->GetCurPage()
                ),
                false
            );?>
        </div>

        <div class="mt-auto border-top py-4">
            <div class="container">
                <div class="">
                    <a class="weight-600 font-24 space02 d-block " href="tel:<?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))?>">
                        <?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))?>
                    </a>
                    <div class="font-14 gray mt-n1">
                        <?$APPLICATION->IncludeFile('/local/include/inc-worktime.php', array(), array('SHOW_BORDER'=>true))?>
                    </div>
                </div>

                <div class="my-3">
                    <a class="btn btn-primary btn-lg btn-block" href="#callback" data-fancybox>Обратный звонок</a>
                </div>


                <?$APPLICATION->IncludeFile('/local/include/inc-socnet.php', array(), array('SHOW_BORDER'=>true))?>
            </div>
        </div>
    </div>
