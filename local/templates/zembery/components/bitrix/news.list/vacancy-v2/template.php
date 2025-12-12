<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
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

?>
<style>
    .vac-tip {
        background: #fff;
        display: inline-block;
        padding: 3px 16px 4px;
        margin-bottom: 12px;
        border-radius: 24px;
        width: fit-content;
        box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1);
        font-family: "Jost", sans-serif;
    }
</style>
<div class="row align-items-stretch mb-5" data-navnum="<?= $arResult['NAV_RESULT']->NavNum ?>">
    <? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <div class="col-12 col-lg-12 mb-4">
            <div class="vacancy-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">

                <? if (!empty($arItem['PREVIEW_TEXT'])) { ?>
                    <div class="vac-tip font-14 weight-500"><?= $arItem['PREVIEW_TEXT'] ?></div>
                <? } ?>

                <div class="row mb-3">
                    <h2 class="col"><?= $arItem['NAME'] ?></h2>
                    <div class="col-auto font-14 gray"><?= sprintf("%02d", ($key + 1)) ?></div>
                </div>

                <div class="font-14 mb-4 pb-3"
                     style="display:none;"><?= $arItem['DISPLAY_PROPERTIES']['LOCATION']['DISPLAY_VALUE'] ?></div>

                <div class="row flex-grow-1 mb-sm-4" style="display:none;">
                    <div class="col-12 col-sm mb-3">
                        <? if ($arItem['DISPLAY_PROPERTIES']['TYPE']) { ?>
                            <div class="font-14 gray mb-2"><?= $arItem['DISPLAY_PROPERTIES']['TYPE']['NAME'] ?>:</div>
                            <div class="font-14 "><?= $arItem['DISPLAY_PROPERTIES']['TYPE']['DISPLAY_VALUE'] ?></div>
                        <? } ?>
                    </div>

                    <div class="col-12 col-sm-auto mb-3">
                        <? if ($arItem['DISPLAY_PROPERTIES']['PAY']) { ?>
                            <div class="font-14 gray mb-2"><?= $arItem['DISPLAY_PROPERTIES']['PAY']['NAME'] ?>:</div>
                            <div class="font-14 "><?= $arItem['DISPLAY_PROPERTIES']['PAY']['DISPLAY_VALUE'] ?></div>
                        <? } ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-sm mb-3 mb-sm-0" style="display:none;">
                        <? if ($arItem['DISPLAY_PROPERTIES']['EXPERIENCE']) { ?>
                            <div class="font-14 gray mb-2"><?= $arItem['DISPLAY_PROPERTIES']['EXPERIENCE']['NAME'] ?>:
                            </div>
                            <div class="font-14 "><?= $arItem['DISPLAY_PROPERTIES']['EXPERIENCE']['DISPLAY_VALUE'] ?></div>
                        <? } ?>
                    </div>

                    <div class="col12 col-sm-auto">
                        <a class="btn btn-primary btn-lg btn-block"
                           href="<?= $arItem['DETAIL_PAGE_URL'] ?>">Подробнее</a>
                    </div>
                </div>
            </div>
        </div>
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>

<script type="application/ld+json">
    [
    <? foreach ($arResult["ITEMS"] as $key => $arItem):
        if ($key > 0) echo ','; ?>
      {
        "@context": "https://schema.org",
        "@type": "JobPosting",
        "title": "<?=$arItem['NAME']?>",
        "description": "<?=($arItem['DETAIL_TEXT'] ? $arItem['DETAIL_TEXT'] : $arItem['NAME'])?>",
        "identifier": {
          "@type": "PropertyValue",
          "name": "Zembery",
          "value": "<?=$arItem['ID']?>"
        },
        "datePosted": "<?=ConvertDateTime( $arItem['TIMESTAMP_X'], "YYYY-MM-DD HH:MI:SS", "ru")?>",
        "validThrough": "2024-12-31",
        "employmentType": "FULL_TIME",
        "hiringOrganization": {
          "@type": "Organization",
          "name": "ООО \"Зембери\"",
          "sameAs": "https://zembery.ru/",
          "logo": "https://zembery.ru/images/logo110.svg"
        },
        "jobLocation": {
          "@type": "Place",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "улица Садовники, 6",
            "addressLocality": "Москва",
            "addressCountry": "RU"
          }
        }

      <? if ($arItem['DISPLAY_PROPERTIES']['PAY']) { ?>
            ,
            "baseSalary": {
              "@type": "MonetaryAmount",
              "currency": "RUB",
              "value": {
                "@type": "QuantitativeValue",
                "value": "<?=$arItem['DISPLAY_PROPERTIES']['PAY']['VALUE']?>",
                "unitText": "MONTH"
              }
          },
      <? } ?>
      }
  <? endforeach; ?>
]

</script>
