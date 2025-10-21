<?php

namespace App\Models\Repositories;

use App\Enums\Table;
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
				query: "INSERT INTO " . Table::CATEGORIES->value . " (uid, uri, position) VALUES (:uid, :uri, :position)",
				data: [
					"uid" => $this->getUid(),
					"uri" => $this->getUri(),
					"position" => $this->getPosition()
				]
			);

			$uidCategoryName = System::uidGen(size: 16, table: Table::CATEGORY_NAMES->value);
			ApplicationData::request(
				query: "INSERT INTO " . Table::CATEGORY_NAMES->value . " (uid, uid_category, name, code_language) VALUES (:uid, :uid_category, :name, :code_language)",
				data: [
					"uid" => $uidCategoryName,
					"uid_category" => $this->getUid(),
					"name" => $this->getName(),
					"code_language" => $this->getLanguageCode()
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
	 * @return static
	 */
	public function hydrate(): static {
		$userData = ApplicationData::request(
			query: "SELECT c.uri, c.position, cn.name, cn.code_language FROM " . Table::CATEGORIES->value . " c JOIN " . Table::CATEGORY_NAMES->value . " cn ON c.uid = cn.uid_category WHERE c.uid = :uid AND cn.code_language = :code_language",
			data: [
				"uid" => $this->getUid(),
				"code_language" => $this->getLanguageCode()
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);

		if ($userData != null) {
			if ($this->getUid() == null) $this->setUid(uid: $userData["uid"]);
			if ($this->getUri() == null) $this->setUri(uri: $userData["uri"]);
			if ($this->getPosition() == null) $this->setPosition(position: $userData["position"]);
			if ($this->getName() == null) $this->setName(name: $userData["name"]);
			if ($this->getLanguageCode() == null) $this->setLanguageCode(languageCode: $userData["code_language"]);
		}

		return $this;
	}

	public function update(string $categoryNameUid): Exception | bool {
		try {
			ApplicationData::request(
				query: "UPDATE " . Table::CATEGORIES->value . " SET uri = :uri, position = :position WHERE uid = :uid",
				data: [
					"uid" => $this->getUid(),
					"uri" => $this->getUri(),
					"position" => $this->getPosition()
				]
			);

			ApplicationData::request(
				query: "UPDATE " . Table::CATEGORY_NAMES->value . " SET name = :name, code_language = :code_language WHERE uid = :uid",
				data: [
					"uid" => $categoryNameUid,
					"name" => $this->getName(),
					"code_language" => $this->getLanguageCode()
				]
			);
		} catch (Exception $exception) {
			return $exception;
		}

		return true;
	}

	public function delete(): Exception | bool {
		try {
			$categoryNameUid = $this->getCategoryNameUid(
				categoryUid: $this->getUid(),
				languageCode: $this->getLanguageCode()
			);

			ApplicationData::request(
				query: "DELETE FROM " . Table::CATEGORY_NAMES->value . " WHERE uid = :uid",
				data: [
					"uid" => $categoryNameUid
				]
			);

			ApplicationData::request(
				query: "DELETE FROM " . Table::CATEGORIES->value . " WHERE uid = :uid",
				data: [
					"uid" => $this->getUid()
				]
			);
		} catch (Exception $exception) {
			return $exception;
		}

		return true;
	}

	/**
	 * Get uid with name
	 *
	 * @param string $uri
	 *
	 * @return null | string
	 */
	public static function getUidByName(string $uri): null | string {
		return ApplicationData::request(
			query: "SELECT uid FROM " . Table::CATEGORIES->value . " WHERE uri = :uri",
			data: [
				"uri" => $uri
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Get all categories
	 *
	 * @return array
	 */
	public static function getAllCategories(): array {
		return ApplicationData::request(
			query: "SELECT c.uid, c.uri, c.position, cn.name, cn.code_language FROM " . Table::CATEGORIES->value . " c JOIN " . Table::CATEGORY_NAMES->value . " cn ON c.uid = cn.uid_category ORDER BY c.position ASC",
			returnType: PDO::FETCH_ASSOC
		) ?? [];
	}

	/**
	 * Get category name uid
	 *
	 * @param string $categoryUid
	 * @param string $languageCode
	 *
	 * @return string | null
	 */
	public static function getCategoryNameUid(string $categoryUid, string $languageCode): null | string {
		return ApplicationData::request(
			query: "SELECT uid FROM " . Table::CATEGORY_NAMES->value . " WHERE uid_category = :uid_category AND code_language = :code_language",
			data: [
				"uid_category" => $categoryUid,
				"code_language" => $languageCode
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}
}
