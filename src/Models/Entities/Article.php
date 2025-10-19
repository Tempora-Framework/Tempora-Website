<?php

namespace App\Models\Entities;

use App\Models\Repositories\CategoryRepository;
use App\Models\Repositories\UserRepository;

class Article {
	private ?string $uid = null;
	private ?string $uri = null;
	private ?CategoryRepository $categoryRepository = null;
	private ?string $content = null;
	private ?UserRepository $creatorRepository = null;
	private ?array $versions = [];
	private ?string $languageCode = null;

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
	 * @return static
	 */
	public function setUid(string $uid): static {
		$this->uid = $uid;

		return $this;
	}

	/**
	 * Get the value of name
	 *
	 * @return string | null
	 */
	public function getUri(): string | null {
		return $this->uri;
	}

	/**
	 * Set the value of name
	 *
	 * @param string $uri
	 *
	 * @return static
	 */
	public function setUri(string $uri): static {
		$this->uri = $uri;

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
	 * @return static
	 */
	public function setCategoryRepository(CategoryRepository $categoryRepository): static {
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
	 * @return static
	 */
	public function setContent(string $content): static {
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
	 * @return static
	 */
	public function setCreatorRepository(UserRepository $creatorRepository): static {
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
	 * @return static
	 */
	public function setVersions(array $versions): static {
		$this->versions = $versions;

		return $this;
	}

	/**
	 * Get the value of languageCode
	 *
	 * @return string
	 */
	public function getLanguageCode(): string {
		return $this->languageCode;
	}

	/**
	 * Set the value of languageCode
	 *
	 * @param string $languageCode
	 *
	 * @return static
	 */
	public function setLanguageCode(string $languageCode): static {
		$this->languageCode = $languageCode;

		return $this;
	}
}
