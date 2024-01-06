<?php
namespace frontend\tests;

use common\fixtures\CategoryFixture;
use common\fixtures\CourseFixture;
use common\fixtures\FileFixture;
use common\fixtures\UserFixture;
use common\models\Category;

class CategoryTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;
    public function _fixtures()
    {
        return [
            'category' => [
                'class' => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'category.php'
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
    public function testSomeFeature()
    {

    }

    public function testCreateCategoryUnsuccessfully()
    {


        $category = new Category();

        $category->category_name = 'q';
        $this->assertFalse($category->validate(['category_name']));
        $category->description = 12;
        $this->assertFalse($category->validate(['description']));

        $this->assertFalse($category->save());

    }

    public function testCreateCategorySuccessfully()
    {
        $category = new Category();

        $category->category_name = 'Programação';
        $this->assertTrue($category->validate(['category_name']));
        $category->description = 'C++,C#,Java,Python';
        $this->assertTrue($category->validate(['description']));

        $this->assertTrue($category->save());
    }

    public function testUpdateCategory()
    {
        $category = $this->tester->grabFixture('category', 'category1');

        $category->category_name = 'Programação';
        $category->description = 'descricao teste';


        $this->assertTrue($category->validate());

        $this->assertTrue($category->save());


        $updatedCategory = Category::findOne($category->id);

        $this->assertEquals('Programação', $updatedCategory->category_name);
        $this->assertEquals('descricao teste', $updatedCategory->description);

    }

    public function testDeleteCategory()
    {
        $category = new Category();

        $category->category_name = 'Programação';
        $category->description = 'descricao teste';

        $categoryId = $category->id;
        $category->delete();

        $deletedCategory = Category::findOne($categoryId);
        $this->assertNull($deletedCategory);
    }
}