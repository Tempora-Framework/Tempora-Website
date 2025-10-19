<?php

namespace App\Models\Repositories;

use App\Enums\Table;
use App\Models\Entities\Language;
use Exception;
use PDO;
use Tempora\Utils\ApplicationData;

class LanguageRepository extends Language {

	/**
	 * Create article
	 *
	 * @return Exception | string
	 */
	public function create(): Exception | string {
		try {
			ApplicationData::request(
				query: "INSERT INTO " . Table::LANGUAGES->value . " (code) VALUES (:code)",
				data: [
					"code" => $this->getCode()
				]
			);
		} catch (Exception $exception) {
			return $exception;
		}

		return $this->getCode();
	}

	/**
	 * Get all versions
	 *
	 * @return array
	 */
	public static function getAllLangs(): array {
		return ApplicationData::request(
			query: "SELECT code FROM " . Table::LANGUAGES->value,
			returnType: PDO::FETCH_COLUMN
		);
	}
}
