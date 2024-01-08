<?php
namespace frontend\tests\functional;
use common\fixtures\UserFixture;
use common\models\User;
use frontend\tests\FunctionalTester;
class CartCest
{
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
        $I->seeRecord(User::className(), ['username'=>'estudante']);
        $I->amLoggedInAs(User::findOne(['username' => 'estudante']));
    }

    public function tryToAddItemToCart(FunctionalTester $I)
    {
        $I->amOnPage('/course/index');
        $I->see('Buy');

        $I->click('Buy');

        $I->click('Cart','.navbar-nav.ms-auto.p-4.p-lg-0');

        $I->see('Checkout');
        $I->see('1','.boxed-1');


    }

    public function tryToBuyCourse(FunctionalTester $I)
    {
        $I->amOnPage('/course/index');
        $I->see('Buy');

        $I->click('Buy');

        $I->click('Cart','.navbar-nav.ms-auto.p-4.p-lg-0');

        $I->see('Checkout');
        $I->see('1','.boxed-1');
        $I->fillField('Card Holder', 'JoaoFernandes'); // Preenche o campo de descrição do curso
        $I->fillField('Card Number', '4333342323581842');
        $I->fillField('Card Expiry', '25/12');
        $I->fillField('Card CVC', '123');
        $I->click('PURCHASE','.btn-primary');

        $I->see('Factura');

    }

    public function tryToDeleteItemOfCart(FunctionalTester $I)
    {
        $I->amOnPage('/course/index');
        $I->see('Buy');

        $I->click('Buy');

        $I->click('Cart','.navbar-nav.ms-auto.p-4.p-lg-0');

        $I->see('Checkout');
        $I->see('1','.boxed-1');

        $I->click('.bi-x','.float-end'); // Apaga o curso

        $I->dontSee('1','.boxed-1');

    }


}
