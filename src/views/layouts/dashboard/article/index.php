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
			<th><?= Lang::translate(key: "ARTICLE_NAME") ?></th>
			<th><?= Lang::translate(key: "ARTICLE_URI") ?></th>
			<th><?= Lang::translate(key: "ARTICLE_CATEGORY") ?></th>
			<th><?= Lang::translate(key: "ARTICLE_LANGUAGE") ?></th>
			<th><?= Lang::translate(key: "ARTICLE_CREATOR") ?></th>
			<th><?= Lang::translate(key: "ARTICLE_VERSIONS") ?></th>
			<th><?= Lang::translate(key: "MAIN_UPDATE") ?></th>
			<th><?= Lang::translate(key: "MAIN_DELETE") ?></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($articlesList as $article) { ?>
			<tr>
				<td><?= $article->getUid() ?></td>
				<td><?= $article->getUri() ?></td>
				<td><?= $article->getCategoryRepository()->getName() ?></td>
				<td><?= $article->getLanguageCode() ?></td>
				<td><?= $article->getCreatorRepository()->getName() ?></td>
				<td><?= print_r($article->getVersions()) ?></td>
				<td>
					<a href="<?= Route::getPath(name: "app_dashboard_update_category_get", options: ["language" => $article->getLanguageCode(), "categoryUid" => $article->getUid()]) ?>" class="button button_secondary"><i class="ri-edit-line"></i> <?= Lang::translate(key: "MAIN_UPDATE") ?></a>
				</td>
				<td>
					<button
						id="delete"
						date-uid="<?= $article->getUid() ?>"
						data-language-code="<?= $article->getLanguageCode() ?>"
						data-csrf="<?= $_SESSION["csrf"] ?>"
					>
						<?= Lang::translate(key: "MAIN_DELETE")?>
					</button>
				</td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<a href="<?= Route::getPath(name: "app_dashboard_add_article_get") ?>" class="button button_primary">
	<i class="ri-add-line"></i> <?= Lang::translate(key: "DASHBOARD_ADD_ARTICLE_TITLE") ?>
</a>
