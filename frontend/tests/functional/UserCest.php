<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
class UserCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests
    public function tryToTest(FunctionalTester $I)
    {

    }

    public function tryToRegister(FunctionalTester $I)
    {
        $I->amOnPage('/site/signup'); // Página de registo
        $I->fillField('Username', 'john_doe');
        $I->fillField('Name', 'João');
        $I->fillField('Address', 'Rua do João');
        $I->fillField('Phone Number', '912345678');
        $I->fillField('Email', 'joao@gmail.com');
        $I->fillField('Password', 'password123');
        $I->click('Signup');
        $I->see('Logout'); // Verifica se o botão de logout está presente
    }

    public function tryToLogin(FunctionalTester $I)
    {
        $I->amOnPage('/site/login'); // Página de login
        $I->fillField('Username', 'john_doe');
        $I->fillField('Password', 'password123');
        $I->click('Login');
        $I->see('Logout'); // Verifica se o botão de logout está presente
    }

      public function tryToLogout(FunctionalTester $I)
        {
            $I->amOnPage('/site/logout'); // Página de logout
            $I->see('Login'); // Verifica se o botão de login está presente
        }
}
