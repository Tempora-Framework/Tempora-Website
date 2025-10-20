<?php

namespace App\Controllers\Dashboard\Category;

use App\Enums\Path;
use App\Enums\Role;
use App\Models\Repositories\CategoryRepository;
use Tempora\Attributes\RouteAttribute;
use Tempora\Controllers\Controller;

class DashboardCategoryController extends Controller {
	#[RouteAttribute(
		path: "/dashboard/category",
		name: "app_dashboard_category_get",
		method: "GET",
		description: "Category page",
		title: "DASHBOARD_CATEGORY_TITLE",
		translateTitle: true,
		needLoginToBe: true,
		accessRoles: [
			Role::ADMINISTRATOR
		]
	)]

	public function __invoke(): void {
		$pageData = $this->getPageData();

		$categoryList = CategoryRepository::getAllCategories();

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

		require Path::LAYOUT->value . "/dashboard/category/index.php";

		include Path::LAYOUT->value . "/footer.php";
	}
}
