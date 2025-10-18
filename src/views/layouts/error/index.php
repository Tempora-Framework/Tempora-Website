<?php
	use App\Enums\Path;
	use Tempora\Utils\Cache\Route;

	include Path::COMPONENT_ACTIONS->value . "/navbar.php";
?>

<h1><?= $pageData["error_code"] ?></h1>

<p><?= $pageData["error_message"] ?></p>

<?php
	$backPath = Route::getPath(name: "app_index_get");
	include Path::COMPONENT_ACTIONS->value . "/back_button.php";
?>
