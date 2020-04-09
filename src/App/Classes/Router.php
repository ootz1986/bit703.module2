<?php
namespace bit703\Classes;

use bit703\Controllers\Error404Controller;

/*
 * Class to process requests.
 *
 * @package bit703
 * @license GPL
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author Open Polytechnic <info@openpolytechnic.ac.nz>
 * @copyright Open Polytechnic, 2018
 */
class Router
{

    /*
     * The controller 
     * being called.
     *
     * @var object
     */
    private $controller;

    /*
     * The method 
     * being requested.
     *
     * @var object
     */
    private $method;

    /*
     * The GET Request 
     *
     * @var object
     */
    private $request;

    /*
     * Assigns the matching $_GET parameters 
     * passed in via the .htaccess file like so:
     * 
     * /user/login is passed on the $_GET string as
     *      $_GET['controller'] = 'user',
     *      $_GET['method'] = 'user'
     * 
     * @return void
     */
    public function __construct(array $request)
    {
        try
        {
            /**
             * First, let's make sure we have a $_GET request
             */
            if (!isset($request['get'])) {
                /**
                 * Throw an exception with a clear explanation
                 */
                throw new \Exception('You have failed to include a $_GET request');
            }
            /**
             * Proceed with the request
             */
            $this->processRequest($request['get']);
            $controller = $this->getController();
            $controller->executeMethod($request);
        }
        catch (\Exception $e)
        {
            
            $controller = new Error404Controller('baseMethod');
            $controller->executeMethod($this->request);
        }
        return;
        
    }

    /*
     * Assigns the matching $_GET parameters 
     * passed in via the .htaccess file like so:
     * 
     * @param array $get the $_GET array
     * @return void
     */
    public function processRequest(array $get)
    {
        /**
         * We have a $_GET request so extract the controller and method
         */
        $this->controller = "bit703\\Controllers\\";
        if (!isset($get['controller']) || $get['controller'] == ""){
            $this->controller .= 'Home';
        } else {
            $this->controller .= ucfirst($get['controller']);
        }
        $this->controller .= 'Controller';
        if (!isset($get['method'])){
            $this->method = '';
        } else {
            $this->method = $get['method'];
        }
    }
    
    /*
     * Assigns the matching $_GET parameters 
     * passed in via the .htaccess file like so:
     * 
     * @throws \Exception
     * @return object $this->controller Instance of Controller
     */
    public function getController()
    {
        // Attempts to locate the controller
        if (class_exists($this->controller)) {
            if (method_exists($this->controller, $this->method) || $this->method === "") {
                return new $this->controller($this->method);
            } else {
                throw new \Exception(sprintf("Method '%s' has not been implemented in '%s'.", $this->method, $this->controller));
            }
        } else {
            throw new \Exception(sprintf("A '%s' controller is not defined.", $this->controller));
        }
    }
}
