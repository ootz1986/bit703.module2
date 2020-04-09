<?php 
require(dirname(__FILE__).'/../../src/App/bootstrap.php');
use \bit703\Classes\Router as Router;

class RouterTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $router;
    
    protected function _before()
    {
        $_GET['controller'] = '';
        $_GET['method'] = '';
        $request = [
            'get' => $_GET,
            'post' => $_POST,
            'file' => $_FILES
        ];
        $this->router = new Router($request);
    }

    protected function _after()
    {
    }

    // tests
    public function testRouter()
    {

        $this->assertInstanceOf('\bit703\Classes\Router', $this->router);
    }

    public function testHome()
    {
        $this->request['get']['controller'] = 'home';
        $this->request['get']['method'] = '';
        $router = new Router($this->request);
        $this->assertInstanceOf('\bit703\Controllers\HomeController', $router->getController());
    }
    // tests
    public function testUserLogin()
    {
        $this->request['get']['controller'] = 'user';
        $this->request['get']['method'] = 'login';
        $router = new Router($this->request);
        $this->assertInstanceOf('\bit703\Controllers\UserController', $router->getController());
    }
 
    // tests
    public function testUserRegister()
    {
        $this->request['get']['controller'] = 'user';
        $this->request['get']['method'] = 'register';
        $router = new Router($this->request);
        $this->assertInstanceOf('\bit703\Controllers\UserController', $router->getController());
    }

    // tests
    public function testImage()
    {
        $this->request['get']['controller'] = 'image';
        $this->request['get']['method'] = 'image';
        $router = new Router($this->request);
        $this->assertInstanceOf('\bit703\Controllers\ImageController', $router->getController());
    }

     // tests
     public function testImageAdd()
     {
         $this->request['get']['controller'] = 'image';
         $this->request['get']['method'] = 'add';
         $router = new Router($this->request);
         $this->assertInstanceOf('\bit703\Controllers\ImageController', $router->getController());
     }

     // tests
    public function testError404()
    {
        $this->expectException('\Exception');
        $this->request['get']['controller'] = 'notapage';
        $this->request['get']['method'] = '';
        $router = new Router($this->request);
        $this->assertInstanceOf('\bit703\Controllers\Error404Controller', $router->getController());
    }
 
}