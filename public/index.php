<?php

// Path
define(constant_name: "APP_DIR", value: $_SERVER["DOCUMENT_ROOT"] . "/..");

// Composer
require APP_DIR . "/vendor/autoload.php";

// Tempora's kernel
$options = [
	"remove_whitespace_between_tags",
	// "remove_trailing_whitespace",
	"remove_empty_lines",
	// "remove_new_lines",
	"remove_comments",
	// "collapsed_spaces",
];

new Tempora\Tempora(options: $options);
