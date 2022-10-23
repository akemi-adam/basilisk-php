<?php

namespace AkemiAdam\Basilisk\App\Kernel;

class Route
{
    use Base;
    
    /** @var array $get stores the routes of type get */
    protected array $get;
    
    /** @var array $post stores the routes of type post */
    protected array $post;

    /** @var array $routes stores all routes of application */
    protected array $routes;

    /**
     * Instance the arrays and set a default error route
     * 
     * @return void
     */
    public function __construct()
    {
        $this->get = array();

        $this->post = array();

        $this->routes = array();

        $this->get('/404', '/errors/404')->name('error.404', 'get');
    }

    /**
     * Registers a route of type get
     * 
     * @param string $path
     * @param string $file
     * 
     * @return Route
     */
    public function get(string $path, string $file) : Route
    {
        $this->get[$path] = $file;

        return $this;
    }

    /**
     * Registers a route of type post
     * 
     * @param string $path
     * @param string $file
     * 
     * @return Route
     */
    public function post(string $path, string $file) : Route
    {
        $this->post[$path] = $file;

        return $this;
    }

    /**
     * Associate a route to a name (static version)
     * 
     * @param string $name
     * @param string $method
     * 
     * @return void
     */
    public function name(string $name, string $method) : void
    {
        $this->routes += [$name => end($this->$method)];
    }

    /**
     * Get routes
     * 
     * @return array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }

    /**
     * Get a specific route
     * 
     * @return string
     */
    public function getRoute(string $name)
    {
        return $this->routes[$name];
    }

    /**
     * Initializes and checks routes
     * 
     * @return void
     */
    public function boot() : void
    {
        $path = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {
            view($path, $this->post);
        }
        else if ($method === 'GET') {
            view($path, $this->get);
        }
    }

}
