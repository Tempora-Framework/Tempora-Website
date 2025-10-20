<?php

namespace App\Controllers\Documentation;

use App\Controllers\ErrorController;
use App\Enums\Path;
use App\Models\Repositories\ArticleRepository;
use App\Models\Repositories\CategoryRepository;
use App\Models\Repositories\VersionRepository;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;
use Tempora\Attributes\RouteAttribute;
use Tempora\Controllers\Controller;
use Tempora\Utils\Lang;

class DocumentationController extends Controller {
	#[RouteAttribute(
		path: '/documentation/$language/$category/$article',
		name: "app_documentation_get",
		method: "GET",
		description: "Documentation page",
	)]

	public function __invoke(): void {
		$pageData = $this->getPageData();

		$temporaLatestVersion = (new VersionRepository())->setId(id: VersionRepository::getLatestVersion())->hydrate()->getName();
		$temporaVersion = $_GET["version"] ?? $temporaLatestVersion;
		$temporaVersionId = VersionRepository::getIdByName(name: $temporaVersion);

		if ($pageData["language"] === null) {
			$this->notFound(message: Lang::translate(key: "DOCUMENTATION_NOT_FOUND_LANGUAGE"));

			return;
		}

		if ($temporaVersionId === null) {
			$this->notFound(message: Lang::translate(key: "DOCUMENTATION_NOT_FOUND_VERSION"));

			return;
		}

		$categoryUid = CategoryRepository::getUidByName(uri: $pageData["category"]);

		if ($categoryUid === null) {
			$this->notFound(message: Lang::translate(key: "DOCUMENTATION_NOT_FOUND_CATEGORY"));

			return;
		}

		$articleUid = ArticleRepository::getUidByNames(uri: $pageData["article"], categoryUid: $categoryUid, versionId: $temporaVersionId);

		if (
			$articleUid == null
			|| $categoryUid == null
			|| $temporaVersionId == null
		) {
			$this->notFound(message: Lang::translate(key: "DOCUMENTATION_NOT_FOUND_ARTICLE"));

			return;
		}

		$categoryRepository = new CategoryRepository();
		$categoryRepository
			->setUid(uid: $categoryUid)
			->setLanguageCode(languageCode: $pageData["language"])
			->hydrate()
		;

		$articleRepository = new ArticleRepository();
		$articleRepository
			->setUid(uid: $articleUid)
			->setCategoryRepository(categoryRepository: $categoryRepository)
			->setLanguageCode(languageCode: $pageData["language"])
			->hydrate()
		;

		if ($articleRepository->getContent() == null) {
			$this->notFound(message: Lang::translate(key: "DOCUMENTATION_NOT_FOUND_ARTICLE"));

			return;
		}

		// Markdown conversion
		$environment = new Environment(config: [
				'html_input' => 'strip',
				'allow_unsafe_links' => false
			]
		);
		$environment->addExtension(extension: new CommonMarkCoreExtension());

		$converter = new MarkdownConverter(environment: $environment);

		$markdown = $converter->convert(input: $articleRepository->getContent())->getContent();

		$this->setStyles(styles: [
			"/assets/styles/main.css",
			"/assets/styles/remixicon.css",
			"/assets/styles/prism.css",
		]);

		$this->setScripts(scripts: [
			"/assets/scripts/engine.js",
			"/assets/scripts/theme.js",
			"/assets/scripts/prism.js",
		]);

		require Path::LAYOUT->value . "/header.php";

		require Path::LAYOUT->value . "/documentation/index.php";

		include Path::LAYOUT->value . "/footer.php";
	}

	/**
	 * Return notFound
	 *
	 * @return void
	 */
	public function notFound(string $message): void {
		(new ErrorController())->setPageData(pageData: [
			"page_title" => APP_NAME . " - " . Lang::translate(key: "MAIN_ERROR"),
			"error_code" => 404,
			"error_message" => $message
		])();
	}
}
