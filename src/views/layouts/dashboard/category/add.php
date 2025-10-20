<?php
	use App\Enums\Path;
	use Tempora\Utils\Cache\Route;
	use Tempora\Utils\Lang;

	include Path::COMPONENT_ACTIONS->value . "/navbar.php";
?>

<?php
	$backPath = Route::getPath(name: "app_dashboard_category_get");
	include Path::COMPONENT_ACTIONS->value . "/back_button.php";
?>

<h1><?= Lang::translate(key: "DASHBOARD_ADD_CATEGORY_TITLE") ?></h1>

<?php include Path::COMPONENT_FORMS->value . "/add_category_form.php"; ?>
