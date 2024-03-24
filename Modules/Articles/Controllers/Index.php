<?php

namespace Modules\Articles\Controllers;

use System\Contracts\IStorage;
use Modules\_base\Controller as BaseController;
use Modules\Articles\Models\Index as ModelsIndex;
use System\Exceptions\ExcValidation;
use System\FileStorage;
use System\Template;

class Index extends BaseController{
	protected ModelsIndex $model;

	public function __construct(){
		$this->model = ModelsIndex::getInstance();
	}

	public function index(){
		$articles = $this->model->all();
		
		$this->title = 'Home page';
		$this->content = Template::render(__DIR__ . '/../Views/v_all.php', [
			'articles' => $articles
		]);
	}

	public function item(){
		$this->title = 'Article page';
		$id = $this->env['params']['id'];
		$article = $this->model->get($id);
		var_dump($this->env);
		$this->content = Template::render(__DIR__ . '/../Views/v_item.php', [
			'article' => $article
		]);
	}

	public function add(){
		$this->title = 'Article add';
var_dump($_SERVER['REQUEST_METHOD']);
		if($this->env['server']['REQUEST_METHOD'] == 'POST'){
			var_dump($_SERVER['REQUEST_METHOD']);
			try{
				$this->model->add([
					'title' => $this->env['post']['title'],
					'content' => $this->env['post']['content']
				]);

				$this->content = 'Added';
			}
			catch(ExcValidation $e){
				$this->content = 'cant add article, error';
			}
		}

		$this->content .= Template::render(__DIR__ . '/../Views/v_add.php');
	}

	public function remove($id) : int 
	{
		$this->model->remove(5);
	}

	public function edit(){
		$this->title = '';
		$this->content = 'VkarmaneDvaTT2';
		
		try{
			$this->model->edit(2, ['title' => $this->title, 'content' => $this->content]);
		}
		catch(ExcValidation $e){
			$this->content = 'cant edit article';
		}
	}
}