<?php

namespace App\Models\Repositories;

use App\Enums\Table;
use App\Models\Entities\Article;
use Exception;
use PDO;
use Tempora\Utils\ApplicationData;
use Tempora\Utils\System;

class ArticleRepository extends Article {

	/**
	 * Create article
	 *
	 * @return Exception | string
	 */
	public function create(): Exception | string {
		$this->setUid(uid: System::uidGen(size: 16, table: Table::ARTICLES->value));

		try {
			ApplicationData::request(
				query: "INSERT INTO " . Table::ARTICLES->value . " (uid, name) VALUES (:uid, :name)",
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
			query: "SELECT uid, name, uid_creator, uid_category, content FROM " . Table::ARTICLES->value . " WHERE uid = :uid",
			data: [
				"uid" => $this->getUid()
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		);

		if ($userData != null) {
			if ($this->getUid() == null) $this->setUid(uid: $userData["uid"]);
			if ($this->getName() == null) $this->setName(name: $userData["name"]);
			if ($this->getCategoryRepository() == null) $this->setCategoryRepository(categoryRepository: (new CategoryRepository())->setUid(uid: $userData["uid_category"])->hydrate());
			if ($this->getContent() == null) $this->setContent(content: $userData["content"]);
			if ($this->getCreatorRepository() == null) $this->setCreatorRepository(creatorRepository: (new UserRepository())->setUid(uid: $userData["uid_category"])->hydrate());
			if ($this->getVersions() == null) $this->setVersions(versions: $this->hydrateVersions());
		}

		return $this;
	}

	/**
	 * Get uid with names
	 *
	 * @param string $name
	 * @param string $categoryUid
	 * @param string $versionId
	 *
	 * @return null | string
	 */
	public static function getUidByNames(string $name, string $categoryUid, string $versionId): null | string {
		return ApplicationData::request(
			query: "SELECT a.uid FROM " . Table::ARTICLES->value . " a JOIN " . Table::ARTICLE_VERSIONS->value . " av ON a.uid = av.uid_article WHERE a.name = :name AND a.uid_category = :uid_category AND av.id_version = :id_version",
			data: [
				"name" => $name,
				"uid_category" => $categoryUid,
				"id_version" => $versionId
			],
			returnType: PDO::FETCH_COLUMN,
			singleValue: true
		);
	}

	/**
	 * Get versions associated with the article
	 *
	 * @return array
	 */
	function hydrateVersions(): array {
		return ApplicationData::request(
			query: "SELECT v.id, v.name FROM " . Table::VERSIONS->value . " v
			JOIN " . Table::ARTICLE_VERSIONS->value . " av ON v.id = av.id_version
			WHERE av.uid_article = :uid_article",
			data: [
				"uid_article" => $this->getUid()
			],
			returnType: PDO::FETCH_ASSOC,
			singleValue: true
		) ?? [];
	}
}
