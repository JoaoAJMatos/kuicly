<?php

namespace backend\tests\functional;

use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }
    public function _before(FunctionalTester $I)
    {
        //  Check the content of fixtures in db
        $I->seeRecord(User::className(), ['username'=>'Admin']);
    }
    /**
     * @param FunctionalTester $I
     */
    public function tryToLogin(FunctionalTester $I)
    {
        $I->amOnPage('site/login');
        $I->fillField('LoginForm[username]', 'Admin');
        $I->fillField('LoginForm[password]', '12345678');
        $I->click('Sign in');
        $I->seeCurrentUrlEquals('/index-test.php');
        $I->see('Admin','.d-block');
    }

    public function tryToEmptyLogin(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->fillField('LoginForm[username]', '');
        $I->fillField('LoginForm[password]', '');
        $I->click('Sign in');
        $I->see('Username cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    public function tryToWrongDataLogin(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
        $I->fillField('LoginForm[username]', 'Admin');
        $I->fillField('LoginForm[password]', '12345678');
        $I->click('Sign in');
        $I->see('Incorrect username or password.');
    }

}
