<?php

class Router
{

	protected $uri;
	protected $route;
	protected $function;
	protected $controller;
	protected $args = [];

	private static $_routes = [
		'GET'     => [],
		'POST'    => [],
		'PUT'     => [],
		'DELETE'  => [],
		'HEAD'    => [],
		'OPTIONS' => [],
		'CONNECT' => [],
	];

	public function __construct()
	{
		$this->uri = $this->_parseUri();
		$this->registerController();
		return $this;
	}

	public function registerController()
	{
		$routes = self::$_routes[$this->uri['method']];
		if ($route = $this->_matchCurrentRoute($routes))
		{
			$namespace = isset($route['namespace']) ? trim($route['namespace'], '\\') : 'Controllers';
			$controller_name = "$namespace\\{$route['controller']}";

			$this->controller = new $controller_name;
			$this->function = $route['function'];
			$this->route = $route;
			$this->args = $this->_args();

			return $this;
		}
		else
		{
			exit("Route Not Found");
		}
	}

	public function go()
	{
		call_user_func_array([$this->controller, $this->function], $this->args);
	}

	private function _parseUri()
	{
		$uri = [
			'scheme'       => $_SERVER['REQUEST_SCHEME'],
			'host'         => rtrim($_SERVER['HTTP_HOST'], "/") . "/",
			'path'         => trim(str_replace($_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']), "/?"),
			'method'       => $_SERVER['REQUEST_METHOD'],
			'query_string' => $_SERVER['QUERY_STRING'],
		];
		parse_str($uri['query_string'], $uri['query_args']);
		$uri['url'] = $this->_url($uri);
		return $uri;
	}

	private function _url($uri)
	{
		$url = "{$uri['scheme']}://{$uri['host']}{$uri['path']}";
		if ( ! empty($uri['query_string'])) $url .= "?{$uri['query_string']}";
		return $url;
	}

	private function _args()
	{
		$args = [];
		$path_parts = explode("/", $this->uri['path']);
		$route_parts = explode("/", $this->route['route']);
		foreach ($route_parts as $i => $part)
		{
			if (preg_match('/\{[^}]+\}/', $part) === 1)
			{
				$key = trim($part, "{}");
				$args[$key] = $path_parts[$i];
			}
		}
		return $args;
	}

	private function _matchCurrentRoute($routes)
	{
		foreach ($routes as $route => &$options)
		{
			$pattern = "/^" . preg_replace('/(\{[^\}]*\})/', '[^\/]+', str_replace("/", "\/", $route)) . "$/";
			$options['route'] = $route;
			if (preg_match($pattern, $this->uri['path']) === 1) return $routes[$route];
		}
		return FALSE;
	}

	public static function register($path, $options = [])
	{
		$path = trim($path, "/");
		$method = (isset($options['method']) && array_key_exists(strtoupper($options['method']), self::$_routes)) ? strtoupper($options['method']) : 'GET' ;
		self::$_routes[$method][$path] = $options;
	}

}