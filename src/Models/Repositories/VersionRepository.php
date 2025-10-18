<?php

namespace App\Models\Repositories;

use App\Enums\Table;
use App\Models\Entities\Version;
use Exception;
use PDO;
use Tempora\Utils\ApplicationData;
use Tempora\Utils\System;

class VersionRepository extends Version {

	/**
	 * Create article
	 *
	 * @return Exception | int
	 */
	public function create(): Exception | int {
		$this->setId(
			id: ApplicationData::request(
				query: "SELECT MAX(id) + 1 FROM " . Table::VERSIONS->value,
				returnType: PDO::FETCH_COLUMN,
				singleValue: true
			)
		);

		try {
			ApplicationData::request(
				query: "INSERT INTO " . Table::VERSIONS->value . " (id, name) VALUES (:id, :name)",
				data: [
					"id" => $this->getId(),
					"name" => $this->getName()
				]
			);
		} catch (Exception $exception) {
			return $exception;
		}

		return $this->getId();
	}

	/**
	 * Hydrate user data from database
	 *
	 * @return self
	 */
	public function hydrate(): self {
		$userData = ApplicationData::request(
			query: "SELECT id, name FROM " . Table::VERSIONS->value . " WHERE id = :id",
			data: [
				"id" => $this->getId()
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);

		if ($userData != null) {
			if ($this->getId() == null) $this->setId(id: $userData["id"]);
			if ($this->getName() == null) $this->setName(name: $userData["name"]);
		}

		return $this;
	}

	/**
	 * Get id with name
	 *
	 * @param string $name
	 *
	 * @return null | int
	 */
	public static function getIdByName(string $name): null | int {
		return ApplicationData::request(
			query: "SELECT id FROM " . Table::VERSIONS->value . " WHERE name = :name",
			data: [
				"name" => $name
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Get latest version id
	 *
	 * @return int | null
	 */
	public static function getLatestVersion(): int | null {
		return ApplicationData::request(
			query: "SELECT MAX(id) FROM " . Table::VERSIONS->value,
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}
}
