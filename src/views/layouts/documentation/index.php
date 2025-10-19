<?php
	use App\Enums\Path;
	use Tempora\Utils\Lang;

	include Path::COMPONENT_ACTIONS->value . "/navbar.php";
	include Path::COMPONENT_ACTIONS->value . "/version_selection.php";

	include Path::COMPONENT_ACTIONS->value . "/drawer.php";
?>

<h1><?= Lang::translate(key: "DOCUMENTATION_TITLE") ?> - <?= $temporaVersion ?></h1>

<div class="documentation-content">
	<?= $markdown ?>
</div>
