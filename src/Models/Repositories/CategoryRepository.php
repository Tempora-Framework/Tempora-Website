<?php

namespace App\Models\Repositories;

use App\Enums\Table;
use App\Models\Entities\Article;
use App\Models\Entities\Category;
use Exception;
use PDO;
use Tempora\Utils\ApplicationData;
use Tempora\Utils\System;

class CategoryRepository extends Category {

	/**
	 * Create article
	 *
	 * @return Exception | string
	 */
	public function create(): Exception | string {
		$this->setUid(uid: System::uidGen(size: 16, table: Table::CATEGORIES->value));

		try {
			ApplicationData::request(
				query: "INSERT INTO " . Table::CATEGORIES->value . " (uid, name) VALUES (:uid, :name)",
				data: [
					"uid" => $this->getUid(),
					"name" => $this->getName()
				]
			);
		} catch (Exception $exception) {
			return $exception;
		}

		return $this->getUid();
	}

	/**
	 * Hydrate user data from database
	 *
	 * @return self
	 */
	public function hydrate(): self {
		$userData = ApplicationData::request(
			query: "SELECT uid, name FROM " . Table::ARTICLES->value . " WHERE uid = :uid",
			data: [
				"uid" => $this->getUid()
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);

		if ($userData != null) {
			if ($this->getUid() == null) $this->setUid(uid: $userData["uid"]);
			if ($this->getName() == null) $this->setName(name: $userData["name"]);
		}

		return $this;
	}

	/**
	 * Get uid with name
	 *
	 * @param string $name
	 *
	 * @return null | string
	 */
	public static function getUidByName(string $name): null | string {
		return ApplicationData::request(
			query: "SELECT uid FROM " . Table::CATEGORIES->value . " WHERE name = :name",
			data: [
				"name" => $name
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}
}
