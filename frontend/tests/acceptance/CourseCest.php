<?php
namespace frontend\tests\acceptance;
use common\fixtures\UserFixture;
use common\models\Course;
use common\models\User;
use frontend\tests\AcceptanceTester;
use MongoDB\Driver\Cursor;
use Codeception\Module\WebDriver;

class CourseCest
{
    public function tryToCreateCourse(AcceptanceTester $I)
    {
        $I->amOnPage('site/login');
        $I->wait(3);
        $I->fillField('Username', 'Instrutor');
        $I->fillField('Password', '12345678');
        $I->click('Login');
        $I->wait(3);
        $I->amOnPage('/course/create'); // Rota para a página de criação de curso
        $I->wait(3);
        $I->see('Create Course'); // Verifica se está na página de criação de curso

        $I->fillField('Title', 'Teste Curso'); // Preenche o campo de título do curso
        $I->fillField('Description', 'Descrição do meu curso'); // Preenche o campo de descrição do curso
        $I->fillField('Price', '30');
        $I->selectOption('Skill Level', '1');
        $I->attachFile('File', 'curso.jpg'); // Anexa uma imagem para o curso
        $I->selectOption('Category', 'teste1');
        $I->click('Save'); // Submete o formulário
        $I->wait(3);

        $I->see('Create Lesson'); // Verifica se está na página de criação de aula
        $I->wait(3);
        $I->click('Create Section');
        $I->fillField('Title', 'Section Teste'); // Preenche o campo de título da aula
        $I->fillField('Order', '1'); // Preenche o campo de descrição da aula
        $I->click('Save'); // Submete o formulário
        $I->wait(3);

        $I->click('Create Quiz');
        $I->fillField('Title', 'Quiz Teste'); // Preenche o campo de título da aula
        $I->fillField('Description', 'Teste Quiz'); // Preenche o campo de descrição da aula
        $I->fillField('Time Limit', '10');
        $I->fillField('Number Questions', '10');
        $I->fillField('Max Points', '10');
        $I->click('Save'); // Submete o formulário
        $I->wait(3);

        $I->see('Create Question');
        $I->fillField('Text', 'Question Teste');
        $I->fillField('Option One', 'Teste Question');
        $I->fillField('Option Two', 'Teste Question');
        $I->fillField('Option Three', 'Teste Question');
        $I->fillField('Option Four', 'Teste Question');
        $I->selectOption('Correct Answer', 'Option 1');
        $I->click('Save');
        $I->wait(3);

        $I->see('Create Lesson'); // Verifica se está na página de criação de aula
        $I->fillField('Title', 'Teste Aula'); // Preenche o campo de título da aula
        $I->fillField('Context', 'Descrição da minha aula'); // Preenche o campo de descrição da aula
        $I->selectOption('Section', 'Section Teste'); // Seleciona a seção criada anteriormente
        $I->selectOption('Lesson Type', 'video'); // Seleciona o curso criado anteriormente
        $I->attachFile('File', 'curso.jpg'); // Anexa um vídeo para a aula
        $I->selectOption('Quiz', 'Quiz Teste');
        $I->click('Save'); // Submete o formulário
        $I->wait(3);

        $I->amOnPage('/course/mycourse'); // Rota para a página de cursos
        $I->see('Courses');
        $I->click('.bi-x','.float-end','Teste Curso'); // Apaga o curso
        $I->wait(3);
        $I->acceptPopup();
        $I->wait(3);
    }



}
