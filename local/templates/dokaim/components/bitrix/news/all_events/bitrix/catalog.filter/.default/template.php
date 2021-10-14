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
$years = get_events_years($arParams["IBLOCK_ID"]);
?>
<div class="events-filter">
	<div class="filter__item">
		<a href="/events" class="filter__btn active" data-load="all">ВСЕ</a>
		<a href="/events/upcoming/" class="filter__btn" data-load="after">предстоящие</a>
		<a href="/events/past/" class="filter__btn" data-load="before">прошедшие</a>
	</div>
	<div class="filter__item">
		<?if($years && count($years) > 0):?>
			<?foreach($years as $year):?>
				<a href="?year=<?=$year["YEAR"];?>" class="filter__text<?if($GLOBALS["current_year"] == $year["YEAR"]) echo ' active';?>" data-year="<?=$year["YEAR"];?>"><?=$year["YEAR"];?></a>
			<?endforeach;?>	
		<?endif;?>
	</div>
</div>
