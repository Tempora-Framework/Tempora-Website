<?php
	use App\Models\Repositories\VersionRepository;
	use Tempora\Utils\ElementBuilder\Select;
	use Tempora\Utils\Lang;
?>

<?php
	$options = [];
	$versionsList = VersionRepository::getAllVersions();
	foreach ($versionsList as $version) {
		$options[$version["id"]] = "v" . $version["name"];
	}

	$select = new Select;
	$select
		->setAttributs(
			attributs: [
				"class" => "version_selection",
				"id" => "version_selection",
				"aria-label" => Lang::translate(key: "VERSION_SELECTION"),
			]
		)
		->setOptions(options: $options)
		->setSelected(selected: $temporaVersionId ?? null)
		->setTranslate(translate: false)
	;
?>

<?= $select->build() ?>
