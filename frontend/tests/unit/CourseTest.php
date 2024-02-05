<?php
namespace frontend\tests;

use common\fixtures\CategoryFixture;
use common\fixtures\CourseFixture;
use common\fixtures\FileFixture;
use common\fixtures\UserFixture;
use common\models\Course;

class CourseTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'course' => [
                'class' => CourseFixture::class,
                'dataFile' => codecept_data_dir() . 'course.php'
            ],
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'category.php'
            ],
            'file' => [
                'class' => FileFixture::class,
                'dataFile' => codecept_data_dir() . 'file.php'
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


    public function testCreateCourseUnsuccessfully()
    {


        $course = new Course();
        $course->title = 'q';
        $this->assertFalse($course->validate(['title']));
        $course->description = 'e';
        $this->assertFalse($course->validate(['description']));
        $course->price = 'qwe';
        $this->assertFalse($course->validate(['price']));
        $course->skill_level ='qwe';
        $this->assertFalse($course->validate(['skill_level']));
        $course->user_id = null;
        $this->assertFalse($course->validate(['user_id']));
        $course->category_id = null;
        $this->assertFalse($course->validate(['category_id']));
        $course->file_id = null;
        $this->assertFalse($course->validate(['file_id']));

        $this->assertFalse($course->save());

    }

    public function testCreateCourseSuccessfully()
    {
        $course = new Course();
        $user = $this->tester->grabFixture('user', 'user1');
        $file = $this->tester->grabFixture('file', 'file1');
        $category = $this->tester->grabFixture('category', 'category1');


        $course->title = 'Best course';
        $this->assertTrue($course->validate(['title']));
        $course->description = 'descricao teste';
        $this->assertTrue($course->validate(['description']));
        $course->price = '21';
        $this->assertTrue($course->validate(['price']));
        $course->skill_level = '2';
        $this->assertTrue($course->validate(['skill_level']));
        $course->user_id = $user->id;
        $this->assertTrue($course->validate(['user_id']));
        $course->category_id = $category->id;
        $this->assertTrue($course->validate(['category_id']));
        $course->file_id = $file->id;
        $this->assertTrue($course->validate(['file_id']));

        $this->assertTrue($course->save());
    }

    public function testUpdateCourse()
    {
        $course = $this->tester->grabFixture('course', 'course1');

        $course->title = 'panquecca';
        $course->description = 'descricao teste';
        $course->price = '23';
        $course->skill_level = '3';


        $this->assertTrue($course->validate());

        $this->assertTrue($course->save());


        $updatedCourse = Course::findOne($course->id);

        $this->assertEquals('panquecca', $updatedCourse->title);
        $this->assertEquals('descricao teste', $updatedCourse->description);
        $this->assertEquals(23, $updatedCourse->price);
        $this->assertEquals(3, $updatedCourse->skill_level);
    }

    public function testDeleteCourse()
    {
        $course = new Course();

        $course->title = 'panquecca';
        $course->description = 'decsc';
        $course->price = '23';
        $course->skill_level = '3';
        $course->user_id = '2';
        $course->category_id = '2';
        $course->file_id = '2';

        $courseId = $course->id;
        $course->delete();

        $deletedCourse = Course::findOne($courseId);
        $this->assertNull($deletedCourse);
    }
}