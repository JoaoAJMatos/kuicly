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
        $I->amOnPage('/site/signup'); // Página de registro de usuário
        $I->fillField('Username', 'john_doe');
        $I->fillField('Email', 'john@example.com');
        $I->fillField('Password', 'password123');
        $I->click('Signup');
        $I->see('Registration successful.'); // Verifica se a mensagem de registro foi bem-sucedida
    }

    public function tryToLogin(FunctionalTester $I)
    {
        $I->amOnPage('/site/login'); // Página de login
        $I->fillField('Username', 'john_doe');
        $I->fillField('Password', 'password123');
        $I->click('Login');
        $I->see('Welcome, John!'); // Verifica se a mensagem de boas-vindas é exibida após o login
    }

      public function tryToLogout(FunctionalTester $I)
        {
            $I->amOnPage('/site/logout'); // Página de logout
            $I->see('Logout'); // Verifica se o botão de logout está presente
        }
}
