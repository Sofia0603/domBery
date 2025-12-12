<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

if ($arParams['IS_SLYDER'] == "Y") {
	$wrapStyle = 'news-slider';
} else {
	$wrapStyle = '';
}

?>
<div class="sale-list <?=$wrapStyle?>" data-navnum="<?=$arResult['NAV_RESULT']->NavNum	?>" <?=($arParams['IS_SLYDER'] == "Y" ? 'data-slick=\'{"slidesToShow": 2, "responsive": [{"breakpoint": 992, "settings": {"slidesToShow": 1}}] }\'' : '')?>>
	<?foreach($arResult["ITEMS"] as $key => $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div>
			<div class="sale-list-item <?=($arItem['DISPLAY_PROPERTIES']['ACTION_EXPIRED'] ? 'is-expired':'')?> "  id="<?=$this->GetEditAreaId($arItem['ID']);?>" >
				<?
				echo '<style>#'. $this->GetEditAreaId($arItem['ID']).' {';
				echo 'background-image: url('.$arItem['FIELDS']['PREVIEW_PICTURE']['SRC'].');';
				if ($arItem['DISPLAY_PROPERTIES']['BG_COLOR']) {
					echo 'background-color: #'.$arItem['DISPLAY_PROPERTIES']['BG_COLOR']['DISPLAY_VALUE'].';';
				}
				if ($arItem['DISPLAY_PROPERTIES']['TEXT_COLOR']) {
					echo 'color: #'.$arItem['DISPLAY_PROPERTIES']['TEXT_COLOR']['DISPLAY_VALUE'].';';
				}
				echo '}</style>';

                if ($arItem['DISPLAY_PROPERTIES']['ACTION_EXPIRED']) {
                    echo '<div class="sale-list-item-expired">'.$arItem['DISPLAY_PROPERTIES']['ACTION_EXPIRED']['NAME'].'</div>';
                }
				?>

				<div class="sale-list-item-name"><?=$arItem['FIELDS']['NAME']?></div>

				<div class="sale-list-item-text"><?=$arItem['FIELDS']['PREVIEW_TEXT']?></div>

				<a class="stretched-link btn btn-light font-18 weight-500 btn-lg" href="<?=$arItem['DETAIL_PAGE_URL']?>">Подробнее</a>
			</div>
		</div>
	<?endforeach;?>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
</div>
