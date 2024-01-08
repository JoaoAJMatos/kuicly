<?php
namespace frontend\tests\functional;
use common\fixtures\CategoryFixture;
use common\fixtures\CourseFixture;
use common\fixtures\FileFixture;
use common\fixtures\UserFixture;
use common\models\Course;
use common\models\User;
use frontend\tests\FunctionalTester;
class CourseCest
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
        $I->seeRecord(User::className(), ['username'=>'Instrutor']);
        $I->amLoggedInAs(User::findOne(['username' => 'Instrutor']));
    }

    public function tryToCreateCourse(FunctionalTester $I)
    {
        $I->amOnPage('/course/create'); // Rota para a página de criação de curso

        $I->see('Create Course'); // Verifica se está na página de criação de curso

        $I->fillField('Title', 'Teste Curso'); // Preenche o campo de título do curso
        $I->fillField('Description', 'Descrição do meu curso'); // Preenche o campo de descrição do curso
        $I->fillField('Price', '30');
        $I->selectOption('Skill Level', '1');
        $I->attachFile('File', 'curso.jpg'); // Anexa uma imagem para o curso
        $I->selectOption('Category Name', 'Design');
        $I->click('Save'); // Submete o formulário

        $I->see('Create Lesson', 'h1'); // Verifica se está na página de criação de aula

        $I->seeRecord(Course::className(), ['title' => 'Teste Curso']); // Verifica se o curso foi criado no banco de dados
    }

    public function tryToUpdateCourse(FunctionalTester $I)
    {
        $I->amOnPage('/course/create'); // Rota para a página de criação de curso

        $I->see('Create Course', 'h1'); // Verifica se está na página de criação de curso

        $I->fillField('Title', 'Teste Curso'); // Preenche o campo de título do curso
        $I->fillField('Description', 'Descrição do meu curso'); // Preenche o campo de descrição do curso
        $I->fillField('Price', '30');
        $I->selectOption('Skill Level', '1');
        $I->attachFile('File', 'curso.jpg'); // Anexa uma imagem para o curso
        $I->selectOption('Category Name', 'Design');
        $I->click('Save'); // Submete o formulário

        $I->see('Create Lesson', 'h1'); // Verifica se está na página de criação de aula

        $I->amOnPage('/course/mycourse');
        $I->see('Courses', 'h1');
        $I->click('Update');
        $I->see('Update Course', 'h1');
        $I->fillField('Title', 'Teste Curso Update'); // Preenche o campo de título do curso
        $I->fillField('Description', 'Descrição do meu curso Update'); // Preenche o campo de descrição do curso

        $I->click('Save'); // Submete o formulário
        $I->seeRecord(Course::className(), ['title' => 'Teste Curso Update']); // Verifica se o curso foi criado no banco de dados

    }

    public function tryToDeleteCourse(FunctionalTester $I)
    {
        $I->amOnPage('/course/create'); // Rota para a página de criação de curso

        $I->see('Create Course', 'h1'); // Verifica se está na página de criação de curso

        $I->fillField('Title', 'Teste Curso'); // Preenche o campo de título do curso
        $I->fillField('Description', 'Descrição do meu curso'); // Preenche o campo de descrição do curso
        $I->fillField('Price', '30');
        $I->selectOption('Skill Level', '1');
        $I->attachFile('File', 'curso.jpg'); // Anexa uma imagem para o curso
        $I->selectOption('Category Name', 'Design');
        $I->click('Save'); // Submete o formulário

        $I->amOnPage('/course/mycourse');
        $I->see('Courses', 'h1');
        $I->click('.bi-x','.float-end'); // Apaga o curso

        $I->click('OK');
        $I->dontSeeRecord(Course::className(), ['title' => 'Teste Curso']); // Verifica se o curso foi criado no banco de dados


    }
}