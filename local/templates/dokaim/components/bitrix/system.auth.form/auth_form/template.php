<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$avatar = SITE_TEMPLATE_PATH . NO_AVATAR_IMG;
$avatarWebp = makeWebp($avatar);
?>

<div class="header-login">
<?if($arResult["FORM_TYPE"] == "login"):?>
	<?
		$arParamsToDelete = array(
			"login",
			"login_form",
			"logout",
			"register",
			"forgot_password",
			"change_password",
			"confirm_registration",
			"confirm_code",
			"confirm_user_id",
			"logout_butt",
			"auth_service_id",
			"clear_cache",
			"backurl",
		);
		$currentUrl = urlencode($APPLICATION->GetCurPageParam("", $arParamsToDelete));
		$pathToAuthorize = $arParams["REGISTER_URL"];
		$pathToAuthorize .= (mb_stripos($pathToAuthorize, '?') === false ? '?' : '&');
		$pathToAuthorize .= 'login=yes&backurl='.$currentUrl;
	?>
	<a href="<?=$pathToAuthorize?>" class="login__link">ВХОД</a>
	<a href="<?=$pathToAuthorize?>" class="img__link">
		<picture>
			<source srcset="<?=$avatarWebp;?>" type="image/webp">
			<img src="<?=$avatar;?>" alt="avatar">
		</picture>
	</a>
<? else: ?>
	<?php
		$firstName = trim($USER->GetFirstName());
		$LastName = trim($USER->GetLastName());
		$name = '<span>' . htmlspecialcharsbx($firstName) . '</span><span>' . htmlspecialcharsbx($LastName) . '</span>'; 

		if (!$firstName && !$LastName)
			$name = htmlspecialcharsbx(trim($USER->GetLogin()));
		
		$photoID = CUser::GetByID($USER->GetID())->Fetch()['PERSONAL_PHOTO']; //Получаем ID Фотографии по ID пользователя.
		if ($photoID) {
			$avatar = CFile::GetPath($photoID); //Получаем путь к файлу.
			$avatarWebp = makeWebp($avatar);
		}
	?>
	<a href="<?=$arParams['PROFILE_URL']?>" class="login__link"><?=$name;?></a>
	<a href="<?=$arParams['PROFILE_URL']?>" class="img__link">
		<picture>
			<source srcset="<?=$avatarWebp;?>" type="image/webp">
			<img src="<?=$avatar;?>" alt="avatar">
		</picture>
	</a>
<?endif?>
</div>
