<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
	<? $level=0 ?>
	<ul class="menu <?=$arParams['ROOT_MENU_TYPE']?>-menu">
		<?
		foreach($arResult as $key=>$arItem):
			$arItem["LINK"] = str_replace('/tel:', 'tel:', $arItem["LINK"]);
			//if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) continue;
			if ($key > 0 && $arItem['DEPTH_LEVEL'] > $arResult[$key-1]['DEPTH_LEVEL']) {
				//if ($arItem['DEPTH_LEVEL'] == $arParams['MAX_LEVEL']) echo '<a class="mainmenu-btn-sublevel"></a>';
				echo '<a class="mainmenu-btn-sublevel"></a>';
				echo '<ul class="level-'.$arItem['DEPTH_LEVEL'].'" >';
				$level++;
			} elseif ($key > 0 && $arItem['DEPTH_LEVEL'] < $arResult[$key-1]['DEPTH_LEVEL']) {
				echo str_repeat( '</li></ul></li>', $arResult[$key-1]['DEPTH_LEVEL'] - $arItem['DEPTH_LEVEL']);
				$level--;
			} elseif ($key>0) {
				echo '</li>';
			}
		?>
			<li><a href="<?=$arItem["LINK"]?>" class="<?=($arItem["SELECTED"] ? 'active':'')?> <?=$arItem["PARAMS"]['class']?>" <?=$arItem["PARAMS"]['params']?> ><?=$arItem["TEXT"]?></a>
		<?endforeach?>
		<?=str_repeat( '</ul></li>', $level); ?>
		</li>
	</ul>
<?endif?>
