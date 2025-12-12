<?php
global $USER, $APPLICATION;

$curPage = $APPLICATION->GetCurPage();

if (!$USER->IsAuthorized()) {
	// Неавторизованные могут находиться только в /personal/
	if (strpos($curPage, '/personal/') !== 0) {
		LocalRedirect('/personal/');
		exit();
	}
} else {
	// Авторизованные перенаправляются в /personal/, если они вне его
	if (strpos($curPage, '/personal/') !== 0) {
		LocalRedirect('/personal/');
		exit();
	}
}
?>




<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

global $APPLICATION, $isHomePage, $pageClass;
$isHomePage = $APPLICATION->GetCurPage(false) === '/';
$curPage = $APPLICATION->GetCurPage(false);
define("SITE_SERVER_PROTOCOL", (CMain::IsHTTPS()) ? "https://" : "http://");

$pageClass = trim('page' . str_replace( array( '/', '.php', '.'), array('-'),  $curPage ), '-');
$APPLICATION->SetPageProperty("og:image", SITE_SERVER_PROTOCOL . SITE_SERVER_NAME . '/og_image.jpg');

CJSCore::Init(array("date", "ajax"));
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/bootstrap.min.css");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/fontawesome.css/all.min.css");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick.css");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick-theme.css");
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.min.css");

//$APPLICATION->AddHeadScript("/bitrix/js/main/jquery/jquery-1.8.3.min.js");
//$APPLICATION->AddHeadScript("//code.jquery.com/jquery-3.2.1.min.js");
//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-3.3.1.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/bootstrap.bundle.min.js");
//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/bootstrap.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.mask.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox.min.js");
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/slick.min.js");
//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui.min.js");
//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.mousewheel.min.js");
//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.kinetic.min.js");
//$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.smoothdivscroll-1.3-min.js");

$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/script.js");

?><!DOCTYPE html>
<html lang="ru">
	<head>
		<meta http-equiv="content-language" content="ru">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<? /* <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> */ ?>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-3.6.0.min.js" ></script>

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

        <script src="https://api-maps.yandex.ru/2.1?apikey=9de11a1c-9043-4a99-8850-a7a768469552&lang=ru_RU"></script>
		<link rel="preconnect" href="https://fonts.googleapis.com"> 
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight&display=swap" rel="stylesheet">
<script src='https://code.reffection.ru/pixel/tags/0d48d31c-641c-8b64-aba9-3033c0dd3a06'></script>
      <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "url": "https://zembery.ru/",
  "name": "Зембери",
  "description": "Компания «Зембери» – эксперты по продаже земельных участков в Московской области. Наш опыт в продаже земельных участков (земли) в Подмосковье – более 10 лет.",
  "publisher": {
    "@type": "Organization",
    "name": "Зембери",
    "logo": {
      "@type": "ImageObject",
      "url": "https://zembery.ru/images/logo110.svg"
    }
  },
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://zembery.ru/search/?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
<meta name="google-site-verification" content="yZvx7YycJpIZuvMhS3hIsyLQQMzi_pxD-wIiMaZIJDA" />
<meta name="facebook-domain-verification" content="lpw9jti3z0trpqlejho1z9yo93bktf" />
	</head>
	<body class=" <?$APPLICATION->ShowProperty("body_class")?> <?=$pageClass?>">
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WC2MWQH"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
	<? if ($USER->IsAdmin()) { ?>
		<div id="panel" class="d-none d-lg-block">
			<?$APPLICATION->ShowPanel();?>
		</div>
	<? } ?>

    <header class="header py-3"> <!--class: theme-ny theme-valentine theme-23feb theme-8mar -->
        <div class="container py-lg-1">
            <div class="row align-items-center justify-content-between">
                
                <a class="col-auto d-md-none" href="/personal/"><img src="/images/logo110.svg" width="53" /></a>
				
                <form class="header-search-form ajax-header-search-form d-block d-md-none p-0" style="width: 56%" action="/search/" method="get">
                	<input class="header-search-text form-control" type="text" name="q" placeholder="Поиск">
                    <button class="header-search-submit form-control" type="submit" ><i class="fal fa-search"></i></button>
                </form>

                <div class="d-none col-auto font-20">
                    <a class="text-nowrap me-2 me-lg-0" href="/favorites/"><i class="fal fa-heart"></i></a>

                    <a class="text-nowrap d-lg-none" href="#callback" data-fancybox><i class="fal fa-phone-alt"></i></a>
                </div>

                <!-- <a class="col-auto d-none d-md-block" href="/"><img src="/images/logo110.svg" /></a> -->
                <div class="d-md-none col-auto">
                    <a class="btn-mmenu " href="#"><span class="icon"></span></a>
                </div>
                <div class="col d-none d-md-block">

                    <div class="row align-items-center justify-content-between">
                    <a class="col-auto d-none d-md-block" href="/"><img style="max-height:36px;" src="/images/logo110.svg" /></a>
                        <div class="col-auto me-auto">
                            <ul class="menu top2-menu">
                                <li><a href="/personal/" class=" ">Кабинет брокера</a></li>
                                <li><a href="https://zembery.ru/" class=" ">Новый сайт</a>
                            </ul>
                        </div>
                        <!--<div class="col-auto me-auto">
                            <?/*$APPLICATION->IncludeComponent(
                                "bitrix:menu",
                                "simple",
                                array(
                                    "ROOT_MENU_TYPE" => "top2",
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
                            );*/?>
                        </div>-->


                        <!--<div class="col-auto border-right d-none d-lg-block">
                            <a class=" font-16 d-block" href="tel:<?/*$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))*/?>">
                                <?/*$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))*/?>
                            </a>
                            <div class="font-12 gray mt-n1">
                                <?/*$APPLICATION->IncludeFile('/local/include/inc-worktime.php', array(), array('SHOW_BORDER'=>true))*/?>
                            </div>
                        </div>
                        <div class="col-auto d-none d-lg-block">
                            <a class="btn btn-primary btn-header" href="#callback" data-fancybox>Обратный звонок</a>
                        </div>
                        <div class="col-auto font-20 d-flex align-items-center">-->
                            <!-- a class="text-nowrap me-2" href="/search/"><i class="fal fa-search"></i></a -->

							<!--<form class="fly-search-form ajax-header-search-form d-inline-block me-2" action="/search/" method="get" style="display: none" >
                                <input class="fly-search-text form-control" type="text" name="q">
                                <button class="fly-search-submit form-control" type="submit" ><i class="fal fa-search"></i></button>
							</form>

                            <a class="text-nowrap me-2 me-lg-0" href="/favorites/"><i class="fal fa-heart"></i></a>

                            <a class="text-nowrap d-lg-none" href="#callback" data-fancybox><i class="fal fa-phone-alt"></i></a>
                        </div>
                        <div class="col-auto d-lg-none d-xl-block">
                            <?/*$APPLICATION->IncludeFile('/local/include/inc-socnet.php', array(), array('SHOW_BORDER'=>true))*/?>
                        </div>-->
                    </div>
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

		<section class="page-main pt-3">
			<div class="container">
                
                <?$APPLICATION->IncludeComponent(
                    "bitrix:breadcrumb",
                    ".default",
                    array(
                        "START_FROM" => "0",
                        "PATH" => "",
                        "SITE_ID" => "s1",
                        "COMPONENT_TEMPLATE" => ".default"
                    ),
                    false
                );?>