<?php
	use App\Models\Repositories\LanguageRepository;
	use Tempora\Utils\ElementBuilder\ElementBuilder;
	use Tempora\Utils\ElementBuilder\Form;
	use Tempora\Utils\ElementBuilder\Select;
	use Tempora\Utils\Lang;
?>

<?php
	$form = new Form;
	$form
		->setAttributs(
			attributs: [
				"method" => "POST",
				"class"	=> "add_category_form"
			]
		)
		->setCsrf(csrf: true)
	;

	$input = new ElementBuilder;
	$input
		->setElement(element: "input")
		->setAttributs(
			attributs: [
				"type" => "text",
				"name" => "uri",
				"value" => $pageData["form_category_uri"] ?? "",
				"placeholder" => Lang::translate(key: "MAIN_URI"),
				"required" => "",
				"autofocus" => ""
			]
		)
	;
	$form->addInput(input: $input);

	$input = new ElementBuilder;
	$input
		->setElement(element: "input")
		->setAttributs(
			attributs: [
				"type" => "text",
				"name" => "name",
				"value" => $pageData["form_category_name"] ?? "",
				"placeholder" => Lang::translate(key: "MAIN_NAME"),
				"required" => ""
			]
		)
	;
	$form->addInput(input: $input);

	$langs = [];
	foreach (LanguageRepository::getAllLangs() as $lang) {
		$langs[$lang] = $lang;
	}

	$selectLang = new Select;
	$selectLang
		->setAttributs(
			attributs: [
				"name" => "language",
				"required" => ""
			]
		)
		->setOptions(options: $langs)
		->setSelected(selected: $pageData["form_category_language"] ?? 1)
		->setTranslate(translate: false)
	;
	$form->addInput(input: $selectLang);

	$input = new ElementBuilder;
	$input
		->setElement(element: "input")
		->setAttributs(
			attributs: [
				"type" => "number",
				"min" => "1",
				"name" => "position",
				"value" => $pageData["form_category_position"] ?? 1,
				"placeholder" => Lang::translate(key: "CATEGORY_POSITION")
			]
		)
	;
	$form->addInput(input: $input);

	$submit = new ElementBuilder;
	$submit
		->setElement(element: "button")
		->setAttributs(
			attributs: [
				"type" => "submit"
			]
		)
		->setContent(content: Lang::translate(key: "CATEGORY_SUBMIT"))
	;
	$form->addInput(input: $submit);

	echo $form->build();
?>
