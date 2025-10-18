<?php

namespace App\Models\Entities;

use App\Models\Repositories\CategoryRepository;
use App\Models\Repositories\UserRepository;

class Article {
	private ?string $uid = null;
	private ?string $name = null;
	private ?CategoryRepository $categoryRepository = null;
	private ?string $content = null;
	private ?UserRepository $creatorRepository = null;
	private ?array $versions = [];

	/**
	 * Get the value of uid
	 *
	 * @return string | null
	 */
	public function getUid(): string | null {
		return $this->uid;
	}

	/**
	 * Set the value of uid
	 *
	 * @param string $uid
	 *
	 * @return self
	 */
	public function setUid(string $uid): self {
		$this->uid = $uid;

		return $this;
	}

	/**
	 * Get the value of name
	 *
	 * @return string | null
	 */
	public function getName(): string | null {
		return $this->name;
	}

	/**
	 * Set the value of name
	 *
	 * @param string $name
	 *
	 * @return self
	 */
	public function setName(string $name): self {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the value of categoryRepository
	 *
	 * @return CategoryRepository | null
	 */
	public function getCategoryRepository(): CategoryRepository | null {
		return $this->categoryRepository;
	}

	/**
	 * Set the value of categoryRepository
	 *
	 * @param CategoryRepository $categoryRepository
	 *
	 * @return self
	 */
	public function setCategoryRepository(CategoryRepository $categoryRepository): self {
		$this->categoryRepository = $categoryRepository;

		return $this;
	}

	/**
	 * Get the value of content
	 *
	 * @return string | null
	 */
	public function getContent(): string | null {
		return $this->content;
	}

	/**
	 * Set the value of content
	 *
	 * @param string $content
	 *
	 * @return self
	 */
	public function setContent(string $content): self {
		$this->content = $content;

		return $this;
	}

	/**
	 * Get the value of creatorRepository
	 *
	 * @return UserRepository | null
	 */
	public function getCreatorRepository(): UserRepository | null {
		return $this->creatorRepository;
	}

	/**
	 * Set the value of creatorRepository
	 *
	 * @param UserRepository $creatorRepository
	 *
	 * @return self
	 */
	public function setCreatorRepository(UserRepository $creatorRepository): self {
		$this->creatorRepository = $creatorRepository;

		return $this;
	}

	/**
	 * Get the value of versions
	 *
	 * @return array
	 */
	public function getVersions(): array {
		return $this->versions;
	}

	/**
	 * Set the value of versions
	 *
	 * @param array $versions
	 *
	 * @return self
	 */
	public function setVersions(array $versions): self {
		$this->versions = $versions;

		return $this;
	}
}
