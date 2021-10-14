<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->createFrame()->begin("Загрузка навигации");
?>
<?if($arResult["NavPageCount"] > 1):?>

<?if ($arResult["NavPageNomer"]+1 <= $arResult["nEndPage"]):?>
    <?
        $plus = $arResult["NavPageNomer"]+1;
        $url = $arResult["sUrlPathParams"] . "PAGEN_".$arResult["NavNum"]."=".$plus;

    ?>

    <div class="show__more__btn" data-url="<?=$url?>" data-type="more" data-page="<?=$arResult["sUrlPath"];?>">
        Еще <?=$arResult["NavTitle"];?>
    </div>

<?else:?>

    <div class="show__more__btn all">
        Загружено все
    </div>

<?endif?>

<?endif?>