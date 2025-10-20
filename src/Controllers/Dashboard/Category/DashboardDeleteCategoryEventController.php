<?php

namespace App\Controllers\Dashboard\Category;

use App\Enums\Role;
use App\Models\Repositories\CategoryRepository;
use App\Models\Repositories\LanguageRepository;
use Tempora\Attributes\RouteAttribute;
use Tempora\Controllers\Controller;
use Tempora\Utils\Cache\Route;
use Tempora\Utils\Cookie;
use Tempora\Utils\Lang;
use Tempora\Utils\System;

class DashboardDeleteCategoryEventController extends Controller {
	#[RouteAttribute(
		path: '/dashboard/category/delete',
		name: "app_dashboard_delete_category_post",
		method: "POST",
		needLoginToBe: true,
		accessRoles: [
			Role::ADMINISTRATOR
		]
	)]

	public function __invoke(): void {
		$pageData = $this->getPageData();

		if (
			System::checkCSRF()
			&& isset($_POST["language"])
			&& isset($_POST["categoryUid"])
		) {
			$notificationCookie = new Cookie;
			$notificationCookie->setName(name: "NOTIFICATION");

			$languageList = LanguageRepository::getAllLangs();
			if (in_array(needle: $_POST["language"], haystack: $languageList)) {
				$categoryRepository = new CategoryRepository;
				$categoryRepository
					->setUid(uid: $_POST["categoryUid"])
					->setLanguageCode(languageCode: $_POST["language"])
				;
				$categoryRepository->delete();
			} else {
				$notificationCookie->setValue(value: Lang::translate(key: "REGISTER_UNIDENTICAL_PASSWORD"));
				$notificationCookie->send();
			}
		}

		System::redirect(url: Route::getPath(name: "app_dashboard_category_get"));
	}
}
