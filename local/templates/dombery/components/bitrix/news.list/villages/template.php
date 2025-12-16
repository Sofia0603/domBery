<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="row">
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $img = CFile::ResizeImageGet($arItem['PREVIEW_PICTURE']['ID'], ['width'=>494,'height'=>370], BX_RESIZE_IMAGE_EXACT)['src'];
    ?>
    <div class="col-12 col-md-4 mb-4">
        <div class="catalog-list-item">
            <img src="<?=$img?>" alt="<?=$arItem['NAME']?>" class="img-fluid">
            <h2><?=$arItem['NAME']?></h2>
            <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="btn btn-primary">Подробнее</a>
        </div>
    </div>
<?endforeach;?>
</div>
