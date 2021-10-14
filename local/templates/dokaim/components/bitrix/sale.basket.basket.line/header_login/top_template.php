<?if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
/**
 * @global array $arParams
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global string $cartId
 */

$compositeStub = (isset($arResult['COMPOSITE_STUB']) && $arResult['COMPOSITE_STUB'] == 'Y');
$avatar = SITE_TEMPLATE_PATH . NO_AVATAR_IMG;
?>

<?if (!$compositeStub && $arParams['SHOW_AUTHOR'] == 'Y'):?>

		<?if ($USER->IsAuthorized()):
			$firstName = trim($USER->GetFirstName());
			$LastName = trim($USER->GetLastName());
			$name = '<span>' . htmlspecialcharsbx($firstName) . '</span><span>' . htmlspecialcharsbx($LastName) . '</span>'; 

			if (!$firstName && !$LastName)
				$name = htmlspecialcharsbx(trim($USER->GetLogin()));
			// if (mb_strlen($name) > 15)
				// $name = mb_substr($name, 0, 12).'...';
			
			$photoID = CUser::GetByID($USER->GetID())->Fetch()['PERSONAL_PHOTO']; //Получаем ID Фотографии по ID пользователя.
			if ($photoID) {
				$avatar = CFile::GetPath($photoID); //Получаем путь к файлу.
			}
		?>

			<a href="<?=$arParams['PATH_TO_PROFILE']?>" class="login__link"><?=$name;?></a>
			<a href="<?=$arParams['PATH_TO_PROFILE']?>" class="img__link"><img src="<?=$avatar;?>" alt="avatar"></a>
		<?else:
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
			if ($arParams['AJAX'] == 'N')
			{
				?><script type="text/javascript"><?=$cartId?>.currentUrl = '<?=$currentUrl?>';</script><?
			}
			else
			{
				$currentUrl = '#CURRENT_URL#';
			}
			
			$pathToAuthorize = $arParams['PATH_TO_AUTHORIZE'];
			$pathToAuthorize .= (mb_stripos($pathToAuthorize, '?') === false ? '?' : '&');
			$pathToAuthorize .= 'login=yes&backurl='.$currentUrl;
			?>
			<a href="<?=$pathToAuthorize?>" class="login__link"><?=GetMessage('TSB1_LOGIN')?></a>
			<a href="<?=$pathToAuthorize?>" class="img__link"><img src="<?=$avatar;?>" alt="avatar"></a>
			<?
			if ($arParams['SHOW_REGISTRATION'] === 'Y')
			{
				$pathToRegister = $arParams['PATH_TO_REGISTER'];
				$pathToRegister .= (mb_stripos($pathToRegister, '?') === false ? '?' : '&');
				$pathToRegister .= 'register=yes&backurl='.$currentUrl;
				?>
				<a href="<?=$pathToRegister?>"  class="login__link"><?=GetMessage('TSB1_REGISTER')?></a>
				<?
			}
			?>
		<?endif?>
<?endif?>
