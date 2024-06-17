<?php

class App
{

	protected $controller = 'Login';
	protected $method = 'login';

	protected $params = [];

	public function __construct()
	{
		$url = $this->parseUrl();
		if (file_exists('./app/controllers/' . $url[0] . '.php')) {
			$this->controller = $url[0];
			unset($url[0]);
		}
		require_once './app/controllers/' . $this->controller . '.php';

		$this->controller = new $this->controller;

		if (isset($url[1])) {
			if (method_exists($this->controller, $url[1])) {
				$this->method = $url[1];
				unset($url[1]);
			}
		}
		$this->params = $url ? array_values($url) : [];

		call_user_func([$this->controller, $this->method], $this->params);
	}

	public function parseUrl()
	{
		if (isset($_SERVER['PATH_INFO'])) {
			$path = ltrim($_SERVER['PATH_INFO'], '/');
			$url = explode('/', filter_var($path, FILTER_SANITIZE_URL));
			return $url;
		}
	}
}