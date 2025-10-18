<?php
	use App\Enums\Path;
	use Tempora\Utils\Lang;

	include Path::COMPONENT_ACTIONS->value . "/navbar.php";
?>

<div class="register_container">
	<h1><?= Lang::translate(key: "REGISTER_TITLE") ?></h1>

	<?php include Path::COMPONENT_FORMS->value . "/register_form.php"; ?>
</div>
