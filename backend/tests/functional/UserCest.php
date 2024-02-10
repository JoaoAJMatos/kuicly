<?php
namespace backend\tests\functional;
use backend\tests\FunctionalTester;
use common\fixtures\UserFixture;
use common\models\User;

class UserCest
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

    public function _before(\frontend\tests\FunctionalTester $I)
    {
        $I->seeRecord(User::className(), ['username'=>'Admin']);
        $I->amLoggedInAs(User::findOne(['username' => 'Admin']));
    }

    // tests
    public function tryToCreateAdminEmpty(FunctionalTester $I)
    {
        $I->amOnPage('user/create');
        $I->see('Create User');
        $I->fillField('Username', '');
        $I->fillField('Name', '');
        $I->fillField('Address', '');
        $I->fillField('Phone Number', '');
        $I->fillField('Email', '');
        $I->fillField('Password', '');

        $I->click('Save');

        $I->see('Username cannot be blank.');
        $I->see('Name cannot be blank.');
        $I->see('Address cannot be blank.');
        $I->see('Phone Number cannot be blank.');
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');


    }

    public function tryToCreateAdmin(FunctionalTester $I)
    {
        $I->amOnPage('user/create');
        $I->see('Create User');
        $I->fillField('Username', 'Admin Teste');
        $I->fillField('Name', 'Joao');
        $I->fillField('Address', 'Rua do Teste');
        $I->fillField('Phone Number', '910733587');
        $I->fillField('Email', 'Admin123@gmail.com');
        $I->fillField('Password', '12345678');

        $I->click('Save');

        $I->Dontsee('Username cannot be blank.');

        $I->seeRecord(User::className(), ['username' => 'Admin Teste']);

    }

    public function tryToUpdateAdmin(FunctionalTester $I)
    {
        $I->amOnPage('user/create');
        $I->see('Create User');
        $I->fillField('Username', 'Admin Teste');
        $I->fillField('Name', 'Joao');
        $I->fillField('Address', 'Rua do Teste');
        $I->fillField('Phone Number', '910733587');
        $I->fillField('Email', 'Admin123@gmail.com');
        $I->fillField('Password', '12345678');

        $I->click('Save');

        $I->seeRecord(User::className(), ['username' => 'Admin Teste']);

        $I->click('Update');
        $I->fillField('Username', 'Admin Teste Update');
        $I->fillField('Name', 'Joao Update');

        $I->click('Save');

        $I->seeRecord(User::className(), ['username' => 'Admin Teste Update']);

    }

    public function tryToDeleteAdmin(FunctionalTester $I)
    {
        $I->amOnPage('user/create');
        $I->see('Create User');
        $I->fillField('Username', 'Admin Teste');
        $I->fillField('Name', 'Joao');
        $I->fillField('Address', 'Rua do Teste');
        $I->fillField('Phone Number', '910733587');
        $I->fillField('Email', 'Admin123@gmail.com');
        $I->fillField('Password', '12345678');

        $I->click('Save');

        $I->seeRecord(User::className(), ['username' => 'Admin Teste']);

        $I->click('Delete');

        $I->DontseeRecord(User::className(), ['username' => 'Admin Teste']);
    }
}
