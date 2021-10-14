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
$current_year = (new DateTime())->format("Y");

if ($_REQUEST["year"]) 
	$select_year = $_REQUEST["year"];
else
	$select_year = $current_year;
?>
<div class="events-filter">
	<div class="filter__item">
		<a href="/events" class="filter__btn" data-load="all">ВСЕ</a>
		<a href="/events/upcoming/" class="filter__btn<?if(is_current_page('upcoming')) echo ' active';?>" data-load="after">предстоящие</a>
		<a href="/events/past/" class="filter__btn<?if(is_current_page('past')) echo ' active';?>" data-load="before">прошедшие</a>
	</div>
	<div class="filter__item">
		<?if($years && count($years) > 0):?>
			<?foreach($years as $year):?>
				<?if(is_current_page('past') && $current_year >= $year["YEAR"]):?>
					<a href="<?=$year["YEAR"];?>" class="filter__text<?if($select_year == $year["YEAR"]) echo ' active';?>" data-year="<?=$year["YEAR"];?>"><?=$year["YEAR"];?></a>
				<?elseif(is_current_page('upcoming') && $current_year <= $year["YEAR"]):?>
					<a href="<?=$year["YEAR"];?>" class="filter__text<?if($select_year == $year["YEAR"]) echo ' active';?>" data-year="<?=$year["YEAR"];?>"><?=$year["YEAR"];?></a>
				<?endif;?>
			<?endforeach;?>	
		<?endif;?>
	</div>
</div>
