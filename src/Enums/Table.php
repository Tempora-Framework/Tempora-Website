<?php

namespace App\Enums;

enum Table: string {
	case ARTICLES = "articles";
	case CATEGORIES = "categories";
	case VERSIONS = "versions";
	case ARTICLE_VERSIONS = "article_versions";
}
