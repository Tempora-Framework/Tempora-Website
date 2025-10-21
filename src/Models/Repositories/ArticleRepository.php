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
				query: "INSERT INTO " . Table::ARTICLES->value . " (uid, uri) VALUES (:uid, :uri)",
				data: [
					"uid" => $this->getUid(),
					"uri" => $this->getUri()
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
			query: "SELECT a.uid, a.uri, c.uid_creator, a.uid_category, c.content FROM " . Table::ARTICLES->value . " a, " . Table::CONTENTS->value . " c WHERE a.uid = :uid AND a.uid = c.uid_article AND c.code_language = :code_language",
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
			if ($this->getCategoryRepository() == null) $this->setCategoryRepository(categoryRepository: (new CategoryRepository())->setUid(uid: $userData["uid_category"])->hydrate());
			if ($this->getContent() == null) $this->setContent(content: $userData["content"]);
			if ($this->getCreatorRepository() == null) $this->setCreatorRepository(creatorRepository: (new UserRepository())->setUid(uid: $userData["uid_creator"])->hydrate());
			if ($this->getVersions() == null) $this->setVersions(versions: $this->hydrateVersions());
		}

		return $this;
	}

	/**
	 * Get uid with names
	 *
	 * @param string $uri
	 * @param string $categoryUid
	 * @param string $versionId
	 *
	 * @return null | string
	 */
	public static function getUidByNames(string $uri, string $categoryUid, int $versionId): null | string {
		return ApplicationData::request(
			query: "SELECT a.uid FROM " . Table::ARTICLES->value . " a JOIN " . Table::ARTICLE_VERSIONS->value . " av ON a.uid = av.uid_article WHERE a.uri = :uri AND a.uid_category = :uid_category AND av.id_version = :id_version",
			data: [
				"uri" => $uri,
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
	public function hydrateVersions(): array {
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

	public static function getAllArticles(): array {
		return ApplicationData::request(
			query: "SELECT uid_article, code_language FROM " . Table::CONTENTS->value,
			returnType: PDO::FETCH_ASSOC
		) ?? [];
	}
}
