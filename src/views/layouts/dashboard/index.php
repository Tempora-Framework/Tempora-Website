<?php
	use App\Enums\Path;
	use Tempora\Utils\Cache\Route;
	use Tempora\Utils\Lang;

	include Path::COMPONENT_ACTIONS->value . "/navbar.php";
?>

<h1><?= Lang::translate(key: "DASHBOARD_TITLE") ?></h1>

<a href="<?= Route::getPath(name: "app_dashboard_category_get") ?>" class="button button_primary">
	<i class="ri-folder-add-line"></i> <?= Lang::translate(key: "DASHBOARD_CATEGORY_TITLE") ?>
</a>
<br>
<a href="<?= Route::getPath(name: "app_dashboard_article_get") ?>" class="button button_primary">
	<i class="ri-folder-add-line"></i> <?= Lang::translate(key: "DASHBOARD_ARTICLE_TITLE") ?>
</a>
