<?php

namespace Modules\Articles\Models;

use System\Model;

class Index extends Model{
	protected static $instance;
	protected string $table = 'oop_articles_index';
	protected string $pk = 'id_article';

	protected array $validationRules = [
		'id_article' => ['locked'],
		'title' => ['not_empty'],
		'content' => ['not_empty'],
		'dt' => ['locked'],
	];
}