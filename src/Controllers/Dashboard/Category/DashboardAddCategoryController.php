<?php

namespace App\Controllers\Dashboard\Category;

use App\Enums\Path;
use App\Enums\Role;
use Tempora\Attributes\RouteAttribute;
use Tempora\Controllers\Controller;

class DashboardAddCategoryController extends Controller {
	#[RouteAttribute(
		path: "/dashboard/category/add",
		name: "app_dashboard_add_category_get",
		method: "GET",
		description: "Add category page",
		title: "DASHBOARD_ADD_CATEGORY_TITLE",
		translateTitle: true,
		needLoginToBe: true,
		accessRoles: [
			Role::ADMINISTRATOR
		]
	)]

	public function __invoke(): void {
		$pageData = $this->getPageData();

		$this->setStyles(styles: [
			"/assets/styles/main.css",
			"/assets/styles/remixicon.css"
		]);

		$this->setScripts(scripts: [
			"/assets/scripts/engine.js",
			"/assets/scripts/theme.js"
		]);

		require Path::LAYOUT->value . "/header.php";

		require Path::LAYOUT->value . "/dashboard/category/add.php";

		include Path::LAYOUT->value . "/footer.php";
	}
}
