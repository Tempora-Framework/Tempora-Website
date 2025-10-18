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
		path: '/documentation/$category/$article',
		name: "app_documentation_get",
		method: "GET",
		description: "Documentation page",
	)]

	public function __invoke(): void {
		$pageData = $this->getPageData();

		$temporaLatestVersion = (new VersionRepository())->setId(id: VersionRepository::getLatestVersion())->hydrate()->getName();
		$temporaVersion = $_GET["version"] ?? $temporaLatestVersion;
		$temporaVersionId = VersionRepository::getIdByName(name: $temporaVersion);

		if ($temporaVersionId === null) {
			$this->notFound(Lang::translate(key: "DOCUMENTATION_NOT_FOUND_VERSION"));

			return;
		}

		$cartegoryUid = CategoryRepository::getUidByName(name: $pageData["category"]);

		if ($cartegoryUid === null) {
			$this->notFound(Lang::translate(key: "DOCUMENTATION_NOT_FOUND_CATEGORY"));

			return;
		}

		$articleUid = ArticleRepository::getUidByNames(name: $pageData["article"], categoryUid: $cartegoryUid, versionId: $temporaVersionId);

		if (
			$articleUid == null
			|| $cartegoryUid == null
			|| $temporaVersionId == null
		) {
			$this->notFound(Lang::translate(key: "DOCUMENTATION_NOT_FOUND_ARTICLE"));

			return;
		}

		$categoryRepository = new CategoryRepository();
		$categoryRepository
			->setUid(uid: $cartegoryUid)
			->hydrate()
		;

		$articleRepository = new ArticleRepository();
		$articleRepository
			->setUid(uid: $articleUid)
			->setCategoryRepository(categoryRepository: $categoryRepository)
			->hydrate()
		;

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
			"/assets/styles/prism-tomorrow.css",
		]);

		$this->setScripts(scripts: [
			"/assets/scripts/engine.js",
			"/assets/scripts/theme.js",
			"/assets/scripts/prism/prism-core.js",
			"/assets/scripts/prism/prism-autoloader.js",
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
