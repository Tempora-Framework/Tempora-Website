<?php

namespace App\Controllers\Dashboard\Article;

use App\Enums\Path;
use App\Enums\Role;
use App\Models\Repositories\ArticleRepository;
use App\Models\Repositories\LanguageRepository;
use Tempora\Attributes\RouteAttribute;
use Tempora\Controllers\Controller;

class DashboardArticleController extends Controller {
	#[RouteAttribute(
		path: "/dashboard/article",
		name: "app_dashboard_article_get",
		method: "GET",
		description: "Article page",
		title: "DASHBOARD_ARTICLE_TITLE",
		translateTitle: true,
		needLoginToBe: true,
		accessRoles: [
			Role::ADMINISTRATOR
		]
	)]

	public function __invoke(): void {
		$pageData = $this->getPageData();

		$articlesList = ArticleRepository::getAllArticles();
		$languages = LanguageRepository::getAllLangs();

		foreach ($articlesList as &$article) {
			$article = (new ArticleRepository())->setUid(uid: $article["uid_article"])->setLanguageCode($article["code_language"])->hydrate();
		}

		if (!isset($_SESSION["csrf"])) {
			$_SESSION["csrf"] = bin2hex(string: random_bytes(length: 50));
		}

		$this->setStyles(styles: [
			"/assets/styles/main.css",
			"/assets/styles/remixicon.css"
		]);

		$this->setScripts(scripts: [
			"/assets/scripts/engine.js",
			"/assets/scripts/theme.js",
			"/assets/scripts/category/delete.js"
		]);

		require Path::LAYOUT->value . "/header.php";

		require Path::LAYOUT->value . "/dashboard/article/index.php";

		include Path::LAYOUT->value . "/footer.php";
	}
}
