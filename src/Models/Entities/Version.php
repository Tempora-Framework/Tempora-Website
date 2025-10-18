<?php

namespace App\Models\Entities;

class Version {
	private ?int $id = null;
	private ?string $name = null;

	/**
	 * Get the value of uid
	 *
	 * @return int | null
	 */
	public function getId(): int | null {
		return $this->id;
	}

	/**
	 * Set the value of uid
	 *
	 * @param int $uid
	 *
	 * @return self
	 */
	public function setId(int $id): self {
		$this->id = $id;

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
}
