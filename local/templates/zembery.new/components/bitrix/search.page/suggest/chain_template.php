<?
//Navigation chain template
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$item = end($arCHAIN);
if($item["LINK"] <> "")
    return '<a href="'.$item["LINK"].'">'.htmlspecialcharsex($item["TITLE"]).'</a>';
else
    return htmlspecialcharsex($item["TITLE"]);
