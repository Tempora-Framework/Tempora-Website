<?php

namespace App\Controllers\Dashboard\Category;

use App\Enums\Path;
use App\Enums\Role;
use App\Models\Repositories\CategoryRepository;
use Tempora\Attributes\RouteAttribute;
use Tempora\Controllers\Controller;

class DashboardUpdateCategoryController extends Controller {
	#[RouteAttribute(
		path: '/dashboard/category/update/$language/$categoryUid',
		name: "app_dashboard_update_category_get",
		method: "GET",
		description: "Update category page",
		title: "DASHBOARD_UPDATE_CATEGORY_TITLE",
		translateTitle: true,
		needLoginToBe: true,
		accessRoles: [
			Role::ADMINISTRATOR
		]
	)]

	public function __invoke(): void {
		$pageData = $this->getPageData();

		$categoryRepository = (new CategoryRepository)
			->setUid(uid: $pageData["categoryUid"])
			->setLanguageCode(languageCode: $pageData["language"])
			->hydrate()
		;

		$pageData["form_category_name"] = $categoryRepository->getName();
		$pageData["form_category_uri"] = $categoryRepository->getUri();
		$pageData["form_category_position"] = $categoryRepository->getPosition();
		$pageData["form_category_language"] = $categoryRepository->getLanguageCode();

		$this->setStyles(styles: [
			"/assets/styles/main.css",
			"/assets/styles/remixicon.css"
		]);

		$this->setScripts(scripts: [
			"/assets/scripts/engine.js",
			"/assets/scripts/theme.js"
		]);

		require Path::LAYOUT->value . "/header.php";

		require Path::LAYOUT->value . "/dashboard/category/update.php";

		include Path::LAYOUT->value . "/footer.php";
	}
}
