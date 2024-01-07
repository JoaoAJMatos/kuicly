<?php
namespace frontend\tests;

use common\fixtures\FileFixture;
use common\fixtures\Lesson_typeFixture;
use common\fixtures\LessonFixture;
use common\fixtures\QuizFixture;
use common\fixtures\SectionFixture;
use common\models\Lesson;

class LessonTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'file' => [
                'class' => FileFixture::class,
                'dataFile' => codecept_data_dir() . 'file.php'
            ],
            'section' => [
                'class' => SectionFixture::class,
                'dataFile' => codecept_data_dir() . 'section.php'
            ],
            'quiz' => [
                'class' => QuizFixture::class,
                'dataFile' => codecept_data_dir() . 'quiz.php'
            ],
            'lesson_type' => [
                'class' => Lesson_typeFixture::class,
                'dataFile' => codecept_data_dir() . 'lesson_type.php'
            ],
            'lesson' => [
                'class' => LessonFixture::class,
                'dataFile' => codecept_data_dir() . 'lesson.php'
            ],
        ];
    }
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testCreateLessonUnsuccessfully()
    {
        $lesson = new Lesson();

        $lesson->title = '';
        $this->assertFalse($lesson->validate(['title']));
        $lesson->context = '';
        $this->assertFalse($lesson->validate(['context']));
        $lesson->sections_id = null;
        $this->assertFalse($lesson->validate(['sections_id']));
        $lesson->quizzes_id = null;
        $this->assertFalse($lesson->validate(['quizzes_id']));
        $lesson->file_id = null;
        $this->assertFalse($lesson->validate(['file_id']));
        $lesson->lesson_type_id = null;
        $this->assertFalse($lesson->validate(['lesson_type_id']));


        $this->assertFalse($lesson->save());

    }

    public function testCreateLessonSuccessfully()
    {
        $lesson = new Lesson();
        $file = $this->tester->grabFixture('file', 'file1');
        $section = $this->tester->grabFixture('section', 'section1');
        $quiz = $this->tester->grabFixture('quiz', 'quiz1');
        $lesson_type = $this->tester->grabFixture('lesson_type', 'lesson_type1');

        $lesson->title = 'Introdução';
        $this->assertTrue($lesson->validate(['title']));
        $lesson->context = 'Introdução ao curso';
        $this->assertTrue($lesson->validate(['context']));
        $lesson->sections_id = $section->id;
        $this->assertTrue($lesson->validate(['sections_id']));
        $lesson->quizzes_id = $quiz->id;
        $this->assertTrue($lesson->validate(['quizzes_id']));
        $lesson->file_id = $file->id;
        $this->assertTrue($lesson->validate(['file_id']));
        $lesson->lesson_type_id = $lesson_type->id;
        $this->assertTrue($lesson->validate(['lesson_type_id']));

        $this->assertTrue($lesson->save());
    }

    public function testUpdateLesson()
    {
        $lesson = $this->tester->grabFixture('lesson', 'lesson1');

        $lesson->title = 'Introdução';
        $lesson->context = 'Introdução ao curso';


        $this->assertTrue($lesson->validate());

        $this->assertTrue($lesson->save());


        $updatedLesson = Lesson::findOne($lesson->id);

        $this->assertEquals('Introdução', $updatedLesson->title);
        $this->assertEquals('Introdução ao curso', $updatedLesson->context);

    }

    public function testDeleteLesson()
    {
        $lesson = new Lesson();

        $lesson->title = 'Introdução';
        $lesson->context = 'Introdução ao curso';
        $lesson->sections_id = 2;
        $lesson->quizzes_id = 2;
        $lesson->file_id = 2;

        $lessonId = $lesson->id;
        $lesson->delete();

        $deletedLesson = Lesson::findOne($lessonId);
        $this->assertNull($deletedLesson);
    }
}