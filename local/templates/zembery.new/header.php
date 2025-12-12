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
//$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/fontawesome.css/all.min.css");
//$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/slick.css");
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
		<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/jquery-2.2.4.min.js" ></script>

		<?$APPLICATION->ShowHead();?>
		<title><?$APPLICATION->ShowTitle();?></title>

		<meta property="og:url" content="<?=SITE_SERVER_PROTOCOL . SITE_SERVER_NAME . $curPage?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?$APPLICATION->ShowProperty("title")?>">
		<meta property="og:description" content="<?=$APPLICATION->ShowProperty("description")?>">
		<meta property="og:image" content="<?=$APPLICATION->ShowProperty("og:image")?>">
		<link href="<?=SITE_TEMPLATE_PATH?>/css/pages/index.css?v=<?=rand()?>" type="text/css"  rel="stylesheet" />
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
        <link href="https://fonts.googleapis.com/css2?family=Inter+Tight&display=swap" rel="stylesheet">
		<meta name="google-site-verification" content="yZvx7YycJpIZuvMhS3hIsyLQQMzi_pxD-wIiMaZIJDA" />

	</head>
	<body class="<?$APPLICATION->ShowProperty("body_class")?> <?=$pageClass?>">
        <div class="page">
		<!-- Google Tag Manager (noscript) -->
		<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WC2MWQH"
		height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
		<!-- End Google Tag Manager (noscript) -->
	<? if ($USER->IsAdmin()) { ?>
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
	<? } ?>
<?php /*<style>

    header{padding-top:75px;}
	.topban{
		background: #000;
		text-align: center;
		display: block;
		position: fixed;
		height: 75px;
		width: 100%;
		z-index: 9999;
	}
	@media screen and (max-width:700px){
		header{padding-top:10vw;}
		.topban{height: auto;}
	}
</style>
<div class="topban">
    <a href="/sale/uchastvuy-v-rozygryshe-tsennykh-prizov-3/"><img style="max-width:100%" src="/images/topban.svg" /></a>
</div> */ ?>
        <header class="header">
            <div class="container">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <a href="/">
                            <img class="header__logo" src="<?=SITE_TEMPLATE_PATH?>/image/Logo-ZemBery.svg" alt="Картинка ZemBery" />
                        </a>
                    </div>
                    <div class="col d-md-none">
                        <div class="burger__menu">
                            <div class="burger__menu-overlay"></div>
                        </div>
                    </div>
                    <div class="col-auto d-md-none">
                        <div class="menu__trigger-wrapper">
                            <div class="menu__trigger">
                                <span class="menu__trigger-line"></span>
                            </div>
                        </div>
                        <div class="mobile-menu">
                            <ul class="burger__menu-elements">
                                <li class="burger__menu-element"><a href="/about/" class="burger__menu-link">О компании</a></li>
                                <li class="burger__menu-element"><a href="/cooperation/" class="burger__menu-link">Сотрудничество</a></li>
                                <li class="burger__menu-element"><a href="/personal/broker/" class="burger__menu-link">Личный кабинет</a></li>
                                <li class="burger__menu-element"><a href="/about/" class="burger__menu-link">Как купить?</a></li>
                                <li class="burger__menu-element"><a href="/catalog/" class="burger__menu-link">Поселки</a></li>
                                <!--<li class="burger__menu-element"><a href="/building/" class="burger__menu-link">Дома</a></li>-->
                                <li class="burger__menu-element"><a href="/sale/" class="burger__menu-link">Акции</a></li>
                                <li class="burger__menu-element"><a href="/news/" class="burger__menu-link">Новости</a></li>
                                <li class="burger__menu-element"><a href="/review/" class="burger__menu-link">Отзывы</a></li>
                                <li class="burger__menu-element"><a href="/contact/" class="burger__menu-link">Контакты</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col d-none d-md-block">
                        <div class="header__info">
                            <div class="header__about">
                                <div class="header__links">
                                    <a class="header__link" href="/about/">О компании</a>
                                    <a class="header__link" href="/cooperation/">Сотрудничество</a>
                                    <a class="header__link" href="/personal/broker/">Личный кабинет</a>
                                    <a class="header__link" href="/about/">Как купить?</a>
                                </div>
                                <div class="header__telephone">
                                    <div class="header__work">
                                        <a class="header__telephone__paragraph" href="tel:<?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>false))?>">
                                            <?$APPLICATION->IncludeFile('/local/include/inc-phone.php', array(), array('SHOW_BORDER'=>true))?>
                                        </a>
                                        <p class="header__telephone__time">
                                            <?$APPLICATION->IncludeFile('/local/include/inc-worktime.php', array(), array('SHOW_BORDER'=>true))?>
                                        </p>
                                    </div>
                                    <div class="header__social-networks">
                                        <a href="https://vk.com/club224391057" target="_blank"><img src="<?=SITE_TEMPLATE_PATH?>/image/Vk, Vkontakte.svg" alt="Лого VK" /></a>
                                        <a href="https://wa.me/+79163351130" target="_blank"><img src="<?=SITE_TEMPLATE_PATH?>/image/Group.svg" alt="Лого WhatsApp" /></a>
                                        <a href="https://t.me/zembery1" target="_blank"><img src="<?=SITE_TEMPLATE_PATH?>/image/telegram-2-app-circle.svg" alt="Лого TG" /></a>
                                    </div>
                                </div>
                            </div>

                            <div class="header__navigation">
                                <div class="header__navigation-links">
                                    <a class="header__navigation-link" href="/catalog/">Поселки</a>
                                    <!--<a class="header__navigation-link" href="/building/">Дома</a>-->
                                    <a class="header__navigation-link" href="/sale/">Акции</a>
                                    <a class="header__navigation-link" href="/news/">Новости</a>
                                    <a class="header__navigation-link" href="/review/">Отзывы</a>
                                    <a class="header__navigation-link" href="/contact/">Контакты</a>
                                </div>
                                <div class="header__contacts">
                                    <div>
                                        <a href="/search/"><img class="header__image" src="<?=SITE_TEMPLATE_PATH?>/image/search-loupe.svg" alt="Иконка лупа" /></a>
                                        <a href="/favorites/"><img class="header__image" src="<?=SITE_TEMPLATE_PATH?>/image/Path.svg" alt="Иконка сердце" /></a>
                                    </div>
                                    <button class="header__button" type="button" href="#callback" data-fancybox>Обратный звонок</button>
                                </div>
                            </div>
                        </div>
                    </div
                </div>
            </div>
            <script>
              $(document).ready(function () {
                $('.menu__trigger').click(function () {
                  $('.menu__trigger').toggleClass('menu__trigger--open');
                  $('.mobile-menu').toggleClass('mobile-menu--open');
                  $('body').toggleClass('body--no-scroll');

                });
              });
            </script>
        </header>

