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

$isAjax = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$isAjax = (
		(isset($_POST['ajax_action']) && $_POST['ajax_action'] == 'Y')
		|| (isset($_POST['compare_result_reload']) && $_POST['compare_result_reload'] == 'Y')
	);
}

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => $arParams['TEMPLATE_THEME']
);

?>
<div class="catalog-compare mb-4 bx-<? echo $templateData['TEMPLATE_CLASS']; ?>" id="bx_catalog_compare_block"><?
	if ($isAjax)
	{
		$APPLICATION->RestartBuffer();
	}
    /*
	?>
	<div class="mb-3 d-flex align-items-center">
		<!-- div class="pr-2">
			<small class="text-muted"><?= GetMessage("CATALOG_SHOWN_CHARACTERISTICS") ?>:</small>
		</div -->
		<div class="pr-2">
			<a
				class="btn btn-sm <? echo (!$arResult["DIFFERENT"] ? 'btn-secondary' : 'btn-primary'); ?>"
				href="<? echo $arResult['COMPARE_URL_TEMPLATE'].'DIFFERENT=N'; ?>"
				rel="nofollow"><?=GetMessage("CATALOG_ALL_CHARACTERISTICS")?></a>
		</div>
		<div class="pr-2">
			<a
				class="btn btn-sm <? echo ($arResult["DIFFERENT"] ? 'btn-secondary' : 'btn-primary'); ?>"
				href="<? echo $arResult['COMPARE_URL_TEMPLATE'].'DIFFERENT=Y'; ?>"
				rel="nofollow"><?=GetMessage("CATALOG_ONLY_DIFFERENT")?></a>
		</div>
	</div>
	<? if (!empty($arResult["ALL_FIELDS"]) || !empty($arResult["ALL_PROPERTIES"]) || !empty($arResult["ALL_OFFER_FIELDS"]) || !empty($arResult["ALL_OFFER_PROPERTIES"]))
	{
		?>
		<div class="catalog-compare-filter p-3 mb-3" style="display: none;">
			<div class="catalog-compare-filter-title"><?=GetMessage("CATALOG_COMPARE_PARAMS")?></div>
			<div class="row">
				<? if (!empty($arResult["ALL_FIELDS"]))
				{
					foreach ($arResult["ALL_FIELDS"] as $propCode => $arProp)
					{
						if (!isset($arResult['FIELDS_REQUIRED'][$propCode]))
						{
							?>
							<div class="col-12 col-lg-3 col-md-4">
								<span class="form-check" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">
									<input type="checkbox" class="form-check-input" id="PF_<?=$propCode?>"<? echo ($arProp["IS_DELETED"] == "N" ? ' checked="checked"' : ''); ?>>
									<label class="form-check-label" for="PF_<?=$propCode?>"><?=GetMessage("IBLOCK_FIELD_".$propCode)?></label>
								</span>
							</div>
							<?
						}
					}
				}

				if (!empty($arResult["ALL_OFFER_FIELDS"]))
				{
					foreach($arResult["ALL_OFFER_FIELDS"] as $propCode => $arProp)
					{
						?>
						<div class="col-12 col-lg-3 col-md-4">
							<span class="form-check" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">
								<input type="checkbox" class="form-check-input" id="OF_<?=$propCode?>"<? echo ($arProp["IS_DELETED"] == "N" ? ' checked="checked"' : ''); ?>>
								<label class="form-check-label" for="OF_<?=$propCode?>"><?=GetMessage("IBLOCK_OFFER_FIELD_".$propCode)?></label>
							</span>
						</div>
						<?
					}
				}

				if (!empty($arResult["ALL_PROPERTIES"]))
				{
					foreach($arResult["ALL_PROPERTIES"] as $propCode => $arProp)
					{
						?>
						<div class="col-12 col-lg-3 col-md-4">
							<span class="form-check" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">
								<input type="checkbox" class="form-check-input" id="PP_<?=$propCode?>"<?echo ($arProp["IS_DELETED"] == "N" ? ' checked="checked"' : '');?>>
								<label class="form-check-label" for="PP_<?=$propCode?>"><?=$arProp["NAME"]?></label>
							</span>
						</div>
						<?
					}
				}

				if (!empty($arResult["ALL_OFFER_PROPERTIES"]))
				{
					foreach($arResult["ALL_OFFER_PROPERTIES"] as $propCode => $arProp)
					{
						?>
						<div class="col-12 col-lg-3 col-md-4">
							<span class="form-check" onclick="CatalogCompareObj.MakeAjaxAction('<?=CUtil::JSEscape($arProp["ACTION_LINK"])?>')">
								<input type="checkbox" class="form-check-input" id="OP_<?=$propCode?>"<? echo ($arProp["IS_DELETED"] == "N" ? ' checked="checked"' : ''); ?>>
								<label class="form-check-label" for="OP_<?=$propCode?>"><?=$arProp["NAME"]?></label>
							</span>
						</div>
						<?
					}
				}
				?>
			</div>
		</div>
		<?
	} */
	?>
	<div class="catalog-compare-table table-responsive">
		<table class="table">
			<? if (!empty($arResult["SHOW_FIELDS"]))
			{
				foreach ($arResult["SHOW_FIELDS"] as $code => $arProp)
				{
					$showRow = true;
					if ((!isset($arResult['FIELDS_REQUIRED'][$code]) || $arResult['DIFFERENT']) && count($arResult["ITEMS"]) > 1)
					{
						$arCompare = array();
						foreach($arResult["ITEMS"] as $arElement)
						{
							$arPropertyValue = $arElement["FIELDS"][$code];
							if (is_array($arPropertyValue))
							{
								sort($arPropertyValue);
								$arPropertyValue = implode(" / ", $arPropertyValue);
							}
							$arCompare[] = $arPropertyValue;
						}
						unset($arElement);
						$showRow = (count(array_unique($arCompare)) > 1);
					}
					if ($showRow)
					{
						?>
						<tr>
							<th data-code="<?="IBLOCK_FIELD_".$code?>">
                                <?=GetMessage("IBLOCK_FIELD_".$code)?>
                            </th>
							<? foreach($arResult["ITEMS"] as $arElement)
							{
								?>
								<td>
									<? switch($code)
									{
										case "NAME":
											?>
											<a class="catalog-compare-item-title" href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement[$code]?></a><!--
                                            --><a class="text-danger ms-3" onclick="CatalogCompareObj.delete('<?=CUtil::JSEscape($arElement['~DELETE_URL'])?>');" href="javascript:void(0)"><i class="fal fa-times"></i></a>
											<?
											break;
										case "PREVIEW_PICTURE":
										case "DETAIL_PICTURE":
											if (!empty($arElement["FIELDS"][$code]) && is_array($arElement["FIELDS"][$code])):?>
												<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
													<img
														border="0"
														src="<?=$arElement["FIELDS"][$code]["SRC"]?>"
														class="catalog-compare-item-image"
														alt="<?=$arElement["FIELDS"][$code]["ALT"]?>"
														title="<?=$arElement["FIELDS"][$code]["TITLE"]?>"
													/>
												</a>
											<?endif;
											break;
										default:
											echo $arElement["FIELDS"][$code];
											break;
									}
									?>
								</td>
								<?
							}
							unset($arElement);
							?>
						</tr>
						<?
					}
				}
			}

            if (!empty($arResult["SHOW_PROPERTIES"]))
			{
				foreach ($arResult["SHOW_PROPERTIES"] as $code => $arProperty)
				{
					$showRow = true;
					if ($arResult['DIFFERENT'])
					{
						$arCompare = array();
						foreach($arResult["ITEMS"] as $arElement)
						{
							$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
							if (is_array($arPropertyValue))
							{
								sort($arPropertyValue);
								$arPropertyValue = implode(" / ", $arPropertyValue);
							}
							$arCompare[] = $arPropertyValue;
						}
						unset($arElement);
						$showRow = (count(array_unique($arCompare)) > 1);
					}

					if ($showRow)
					{
						?>
						<tr>
							<th data-code="<?=$code?>">
                                <?=$arProperty["NAME"]?>
                                <?=($arProperty['HINT'] ? '<br><small>'.$arProperty['HINT'].'</small>':'')?>
                            </th>
							<?foreach($arResult["ITEMS"] as $arElement)
							{
								?>
								<td>
									<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["DISPLAY_VALUE"])?>
								</td>
							<?
							}
							unset($arElement);
							?>
						</tr>
					<?
					}
				}
			}

			?>

		</table>
</div>
<?
if ($isAjax)
{
	die();
}
?>
<script type="text/javascript">
	var CatalogCompareObj = new BX.Iblock.Catalog.CompareClass("bx_catalog_compare_block", '<?=CUtil::JSEscape($arResult['~COMPARE_URL_TEMPLATE']); ?>');
</script>