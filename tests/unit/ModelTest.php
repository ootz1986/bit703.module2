<?php
use \bit703\Models\UserModel as UserModel;

class ModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    private $model;
    
    protected function _before()
    {
        $this->model = new UserModel();
    }

    protected function _after()
    {
    }

    // tests
    public function testGetUser()
    {
        $user = $this->model->getUser(1);
        $this->assertInstanceOf('\bit703\Models\UserModel', $user);
    }
}