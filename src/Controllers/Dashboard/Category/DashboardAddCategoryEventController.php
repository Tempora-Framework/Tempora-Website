<?php

namespace App\Controllers\Dashboard\Category;

use App\Enums\Path;
use App\Enums\Role;
use App\Models\Entities\Language;
use App\Models\Repositories\CategoryRepository;
use App\Models\Repositories\LanguageRepository;
use App\Models\Repositories\UserRepository;
use Tempora\Attributes\RouteAttribute;
use Tempora\Controllers\Controller;
use Tempora\Utils\Cache\Route;
use Tempora\Utils\Cookie;
use Tempora\Utils\Lang;
use Tempora\Utils\System;

class DashboardAddCategoryEventController extends Controller {
	#[RouteAttribute(
		path: "/dashboard/category/add",
		name: "app_dashboard_add_category_post",
		method: "POST",
		needLoginToBe: true,
		accessRoles: [
			Role::ADMINISTRATOR
		]
	)]

	public function __invoke(): void {
		if (
			System::checkCSRF()
			&& isset($_POST["uri"])
			&& isset($_POST["name"])
			&& isset($_POST["language"])
			&& isset($_POST["position"])
		) {
			$notificationCookie = new Cookie;
			$notificationCookie->setName(name: "NOTIFICATION");

			$languageList = LanguageRepository::getAllLangs();
			if (in_array(needle: $_POST["language"], haystack: $languageList)) {
				$categoryRepository = new CategoryRepository;
				$categoryRepository
					->setUri(uri: $_POST["uri"])
					->setName(name: $_POST["name"])
					->setLanguageCode(languageCode: $_POST["language"])
					->setPosition(position: (int)$_POST["position"])
				;
				$categoryRepository->create();

				System::redirect(url: Route::getPath(name: "app_dashboard_get"));
			} else {
				$notificationCookie->setValue(value: Lang::translate(key: "REGISTER_UNIDENTICAL_PASSWORD"));
				$notificationCookie->send();
			}

			$_SESSION["page_data"] = [
				"form_category_name" => $_POST["name"],
				"form_category_uri" => $_POST["uri"],
				"form_category_language" => $_POST["language"],
				"form_category_position" => $_POST["position"]
			];
		}

		System::redirect();
	}
}
