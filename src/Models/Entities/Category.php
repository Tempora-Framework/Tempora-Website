<?php

namespace App\Models\Entities;

class Category {
	private ?string $uid = null;
	private ?string $uri = null;
	private ?string $name = null;
	private ?string $languageCode = null;
	private ?int $position = null;

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
	 * @return static
	 */
	public function setName(string $name): static {
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the value of languageCode
	 *
	 * @return string | null
	 */
	public function getLanguageCode(): string | null {
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

	/**
	 * Get the value of order
	 *
	 * @return int | null
	 */
	public function getPosition(): int | null {
		return $this->position;
	}

	/**
	 * Set the value of order
	 *
	 * @param int $position
	 *
	 * @return static
	 */
	public function setPosition(int $position): static {
		$this->position = $position;

		return $this;
	}
}
