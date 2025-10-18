<?php
	use App\Enums\Path;
	use Tempora\Utils\Lang;

	include Path::COMPONENT_ACTIONS->value . "/navbar.php";
?>

<h1><?= Lang::translate(key: "DASHBOARD_TITLE") ?></h1>
