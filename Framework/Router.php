<?php 

namespace Framework;
use App\Controllers\ErrorController;
class Router {

    protected $routes = [];

    /**
     * Add a new route
     * 
     * @param string $method 
     * @param string $uri
     * @param string $action
     * @return void
     */

    public function  registerRoute($method,$uri,$action){

        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method'=> $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     * Add a GET route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function get($uri,$controller){
        $this->registerRoute('GET', $uri,$controller);
    }

    /**
     * Add a POST route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function post($uri,$controller){
        $this->registerRoute('POST', $uri,$controller);
    }

    /**
     * Add a PUT route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function put($uri,$controller){
        $this->registerRoute('PUT', $uri,$controller);
    }

    /**
     * Add a DELETE route
     * 
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public function delete($uri,$controller){
        $this->registerRoute('DELETE', $uri,$controller);
    }
    /**
     * Route the request
     * 
     * @param string $uri
     * @param string $method
     * @return void
     */
    public function route($uri) {

        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach($this->routes as $route){

            //Split the current URI to segment
            $uriSegments = explode('/', trim($uri, '/'));

            $routeSegments = explode('/', trim($route['uri'], '/'));

            inspect($routeSegments);

            $match = true;

            //Check if number of segments is matches

            if(count($uriSegments) === count($routeSegments) && strtoupper($route['method'] === $requestMethod)){

                $params = [];

                $match = true;

                for ($i=0; $i < count($uriSegments); $i++) { 
                    // if the uri's dont match and there is no param
                    if($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/',$routeSegments[$i]))
                    {
                        $match = false;
                        break;
                    }
                    // check for the param and add to $param to array
                    if(preg_match('/\{(.+?)\}/',$routeSegments[$i], $matches)){
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }
                if($match){
                    $controller = 'App\\Controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
            /*
            if($route['uri'] === $uri && $route['method'] === $method) {
                $controller = 'App\\Controllers\\' . $route['controller'];
                $controllerMethod = $route['controllerMethod'];
                $controllerInstance = new $controller();
                $controllerInstance->$controllerMethod();
                return;
            }
            */
        }
        ErrorController::notFound();   
    }
}
