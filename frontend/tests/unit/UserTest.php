<?php
namespace frontend\tests;

use common\fixtures\UserFixture;
use common\models\User;

class UserTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests

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
        $user->username = 'john_dEEEEEEEEEEEEEEEeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeerrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr';
        $this->assertFalse($user->validate(['username']));
        $user->email = 'john23232';
        $this->assertFalse($user->validate(['email']));
        $user->setPassword('22');
        $user->generateAuthKey();
        $this->assertFalse($user->validate());

        $this->assertFalse($user->save());
    }

    public function testCreateUserSuccessfully()
    {
        $user = new User();
        $user->username = 'john_de';
        $this->assertTrue($user->validate(['username']));
        $user->email = 'john@gmail.com';
        $this->assertTrue($user->validate(['email']));
        $user->setPassword('12345678');
        $user->generateAuthKey();
        $this->assertTrue($user->validate());

        $this->assertTrue($user->save());
    }

    public function testUpdateUser()
    {
        $user = $this->tester->grabFixture('user', 'user1');

        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->setPassword('12345679');
        $user->generateAuthKey();

        $this->assertTrue($user->validate());

        $this->assertTrue($user->save());
    }

    public function testDeleteUser()
    {
        $user = new User();
        $user->username = 'testuser';
        $user->email = 'test@example.com';
        $user->setPassword('12345678');
        $user->generateAuthKey();
        $user->save();

        $userId = $user->id;
        $user->delete();

        $deletedUser = User::findOne($userId);
        $this->assertNull($deletedUser);
    }
}