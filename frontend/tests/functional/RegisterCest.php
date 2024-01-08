<?php
namespace frontend\tests\functional;
use frontend\tests\FunctionalTester;
class RegisterCest
{
    public function _before(FunctionalTester $I)
    {
    }

    // tests

    public function tryToRegister(FunctionalTester $I)
    {
        $I->amOnPage('site/signup');
        $I->fillField('Username', 'john_doe');
        $I->fillField('Name', 'John Doe') ;
        $I->fillField('Address', '123 Main St');
        $I->fillField('Phone Number', '123456789');
        $I->fillField('Email', 'john@example.com');
        $I->fillField('Password', 'userpassword');

        $I->click('Signup');

        $I->dontSee('Name cannot be blank.');
        $I->see('Thank you for registration. Please check your inbox for verification email. ');
    }

    public function tryToEmptyRegister(FunctionalTester $I)
    {
        $I->amOnPage('site/signup');
        $I->fillField('Username', '');
        $I->fillField('Name', '') ;
        $I->fillField('Address', '');
        $I->fillField('Phone Number', '');
        $I->fillField('Email', '');
        $I->fillField('Password', '');

        $I->click('Signup');

        $I->See('Name cannot be blank.'); // Verifica se o formulário foi preenchido corretamente

    }


}
