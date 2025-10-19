<?php

namespace App\Models\Entities;

class Language {
	private ?string $code = null;

	/**
	 * Get the value of code
	 *
	 * @return string | null
	 */
	public function getCode(): string | null {
		return $this->code;
	}

	/**
	 * Set the value of code
	 *
	 * @param string $code
	 *
	 * @return static
	 */
	public function setCode(string $code): static {
		$this->code = $code;

		return $this;
	}
}
