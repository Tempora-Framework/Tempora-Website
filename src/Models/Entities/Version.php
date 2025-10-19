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
	 * @return static
	 */
	public function setId(int $id): static {
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
	 * @return static
	 */
	public function setName(string $name): static {
		$this->name = $name;

		return $this;
	}
}
