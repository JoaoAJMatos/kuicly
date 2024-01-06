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
        $I->amOnPage('site/signup'); // Página de registro de usuário
        $I->fillField('Username', 'john_doe');
        $I->fillField('Name', 'John Doe') ;
        $I->fillField('Address', '123 Main St');
        $I->fillField('Phone Number', '123456789');
        $I->fillField('Email', 'john@example.com');
        $I->fillField('Password', 'userpassword');

        $I->click('Signup');

        $I->dontSee('Name cannot be blank.'); // Verifica se o formulário foi preenchido corretamente
        $I->see('Thank you for registration. Please check your inbox for verification email. '); // Verifica se o botão de logout está presente
    }

    public function tryToLogin(FunctionalTester $I)
    {
        $I->amOnPage('site/login'); // Página de login
        $I->fillField('Username', 'teste');
        $I->fillField('Password', '12345678');
        $I->click('Login');
        $I->seeCurrentUrlEquals('/index-test.php');
        $I->see('Logout'); // Verifica se o botão de logout está presente
    }

      public function tryToLogout(FunctionalTester $I)
      {
            $I->amOnPage('/index-test.php/site/logout'); // Página de logout
            $I->see('Login'); // Verifica se o botão de login está presente
      }
}
