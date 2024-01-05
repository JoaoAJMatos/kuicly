<?php
namespace frontend\tests;

use common\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testSomeFeature()
    {

    }

    public function testValidation()
    {
        $user = new User();

        $user->username = null;
        $this->assertFalse($user->validate(['username']));

        $user->username = 'tooooloooooooongnaaaaaaameeeeeeewwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww';
        $this->assertFalse($user->validate(['username']));

        $user->username = 'davert';
        $this->assertTrue($user->validate(['username']));
    }

    public function testCreateUserUnsuccessfully()
    {
        $user = new User();
        $user->username = 'john_doe';
        $user->email = 'john@example.com';
        $user->password = 'password';

        $this->assertTrue($user->save());
    }

    public function testCreateUserUnsuccessfully()
    {
        $user = new User();
        $user->username = 'john_doe';
        $user->email = 'john@example.com';
        $user->password = 'password';

        $this->assertTrue($user->save());
    }

    public function testUpdateUser()
    {
        $user = new User();

        // Não definir campos obrigatórios
        $this->assertFalse($user->validate());

        // Definir campos obrigatórios
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->password = 'password';

        $this->assertTrue($user->validate());
    }

    public function testDeleteUser()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->password = 'password';
        $user->save();

        $userId = $user->id;
        $user->delete();

        $deletedUser = User::findOne($userId);
        $this->assertNull($deletedUser);
    }
}