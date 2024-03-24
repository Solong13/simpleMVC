<?php

namespace Modules\Articles;

use System\Contracts\IModule;
use System\Contracts\IRouter;
use Modules\Articles\Controllers\Index as C;

class Module implements IModule{
	public function registerRoutes(IRouter $router) : void {
		$i = '[1-9]+\d*';// діапазон від 1 до 9, хоча б один знак, потім цифри скільки завгодно разів
		$map = [1 => 'id'];
		//якщо не превіряти на інт то такиий урл також пройде http://test/fonts/hw6w/article/4а
		$router->addRoute('/^$/', C::class);
		$router->addRoute("/^article\/($i$)/", C::class, 'item', $map);// в дужках ($i$) щоб preg_match помістив це значення в [1]
		$router->addRoute('/^article\/add$/', C::class, 'add');
		$router->addRoute("/^article\/delete\/($i$)/", C::class, 'remove', $map);
		$router->addRoute("/^article\/edit\/($i$)/", C::class, 'edit', $map);
	}
}