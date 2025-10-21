<?php
	use App\Enums\Path;
	use Tempora\Utils\Cache\Route;
	use Tempora\Utils\Lang;

	include Path::COMPONENT_ACTIONS->value . "/navbar.php";

	$backPath = Route::getPath(name: "app_dashboard_get");
	include Path::COMPONENT_ACTIONS->value . "/back_button.php";
?>

<h1><?= Lang::translate(key: "DASHBOARD_CATEGORY_TITLE") ?></h1>

<table>
	<thead>
		<tr>
			<th><?= Lang::translate(key: "CATEGORY_NAME") ?></th>
			<th><?= Lang::translate(key: "CATEGORY_URI") ?></th>
			<th><?= Lang::translate(key: "CATEGORY_LANGUAGE") ?></th>
			<th><?= Lang::translate(key: "CATEGORY_POSITION") ?></th>
			<th><?= Lang::translate(key: "MAIN_UPDATE") ?></th>
			<th><?= Lang::translate(key: "MAIN_DELETE") ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($categoriesList as $category) { ?>
			<tr>
				<td><?= $category["name"] ?></td>
				<td><?= $category["uri"] ?></td>
				<td><?= $category["code_language"] ?></td>
				<td><?= $category["position"] ?></td>
				<td>
					<a href="<?= Route::getPath(name: "app_dashboard_update_category_get", options: ["language" => $category["code_language"], "categoryUid" => $category["uid"]]) ?>" class="button button_secondary"><i class="ri-edit-line"></i> <?= Lang::translate(key: "MAIN_UPDATE") ?></a>
				</td>
				<td>
					<button
						id="delete"
						date-uid="<?= $category["uid"] ?>"
						data-language-code="<?= $category["code_language"] ?>"
						data-csrf="<?= $_SESSION["csrf"] ?>"
					>
						<?= Lang::translate(key: "MAIN_DELETE")?>
					</button>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<a href="<?= Route::getPath(name: "app_dashboard_add_category_get") ?>" class="button button_primary">
	<i class="ri-add-line"></i> <?= Lang::translate(key: "DASHBOARD_ADD_CATEGORY_TITLE") ?>
</a>
