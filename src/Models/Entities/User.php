<?php

namespace App\Models\Entities;

class User {
	private ?string $uid;
	private ?string $name;
	private ?string $surname;
	private ?string $email;
	private ?string $password;
	private bool $toModify = false;

	/**
	 * Get the value of uid
	 *
	 * @return string
	 */
	public function getUid(): string {
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
	 * @return string
	 */
	public function getName(): string {
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
	 * Get the value of surname
	 *
	 * @return string
	 */
	public function getSurname(): string {
		return $this->surname;
	}

	/**
	 * Set the value of surname
	 *
	 * @param string $surname
	 *
	 * @return static
	 */
	public function setSurname(string $surname): static {
		$this->surname = $surname;

		return $this;
	}

	/**
	 * Get the value of email
	 *
	 * @return string
	 */
	public function getEmail(): string {
		return $this->email;
	}

	/**
	 * Set the value of email
	 *
	 * @param string $email
	 *
	 * @return static
	 */
	public function setEmail(string $email): static {
		$this->email = $email;

		return $this;
	}

	/**
	 * Get the value of password
	 *
	 * @return string
	 */
	public function getPassword(): string {
		return $this->password;
	}

	/**
	 * Set the value of password
	 *
	 * @param string $password
	 *
	 * @return static
	 */
	public function setPassword(string $password): static {
		$this->password = $password;

		return $this;
	}

	/**
	 * Get the value of toModify
	 *
	 * @return bool
	 */
	public function isToModify(): bool {
		return $this->toModify;
	}

	/**
	 * Set the value of toModify
	 *
	 * @param bool $toModify
	 *
	 * @return static
	 */
	public function setToModify(bool $toModify): static {
		$this->toModify = $toModify;

		return $this;
	}
}
