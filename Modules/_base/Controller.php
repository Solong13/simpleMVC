<?php

namespace Modules\_base;

use System\Contracts\IController;
use System\Exceptions\Exc404;
use System\Template;

class Controller implements IController{
	protected string $title = '';
	protected string $content = '';
	protected array $env = [];

	public function setEnviroment(array $urlParams, array $get, array $post, array $server) : void{
		$this->env['params'] = $urlParams;
		//Зручно для написання тестів в майбутньому
		$this->env['get'] = $get; 
		$this->env['post'] = $post;
		$this->env['server'] = $server;
	}
	
	public function render() : string{
		return Template::render(__DIR__ . '/v_main.php', [
			'title' => $this->title,
			'content' => $this->content
		]);
	}

	public function __call(string $name, array $arguments){
		throw new Exc404("controller has not action = $name");
	}
}