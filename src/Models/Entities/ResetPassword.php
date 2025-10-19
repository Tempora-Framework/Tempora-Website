<?php

namespace App\Models\Entities;

use PDO;
use Tempora\Enums\Table;
use Tempora\Utils\ApplicationData;

class ResetPassword {
	private ?string $uid;
	private ?string $link;
	private ?string $email;

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
	public function setUid(?string $uid = null): static {
		if ($uid) {
			$this->uid = $uid;
		} else {
			$this->uid = ApplicationData::request(
				query: "SELECT uid_user FROM " . Table::USER_RESET_PASSWORD->value . " WHERE link = :link",
				data: [
					"link" => $this->link
				],
				returnType: PDO::FETCH_COLUMN,
				singleValue: true
			);
		}

		return $this;
	}

	/**
	 * Get the value of link
	 *
	 * @return string
	 */
	public function getLink(): string {
		return $this->link;
	}

	/**
	 * Set the value of link
	 *
	 * @param string $link
	 *
	 * @return static
	 */
	public function setLink(string $link): static {
		$this->link = $link;

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
}
