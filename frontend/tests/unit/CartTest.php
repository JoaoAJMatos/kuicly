<?php
namespace frontend\tests;

use common\fixtures\CartFixture;
use common\fixtures\UserFixture;
use common\models\Cart;

class CartTest extends \Codeception\Test\Unit
{
    /**
     * @var \frontend\tests\UnitTester
     */
    protected $tester;

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
            'cart' => [
                'class' => CartFixture::class,
                'dataFile' => codecept_data_dir() . 'cart.php'
            ],
        ];
    }
    protected function _before()
    {
    }

    protected function _after()
    {
    }

    public function testCreateCartUnsuccessfully()
    {

        $cart = new Cart();

        $cart->num_courses = 1.1;
        $this->assertFalse($cart->validate(['num_courses']));
        $cart->user_id = null;
        $this->assertFalse($cart->validate(['user_id']));

        $this->assertFalse($cart->save());

    }

    public function testCreateCartSuccessfully()
    {
        $cart = new Cart();
        $user = $this->tester->grabFixture('user', 'user1');

        $cart->num_courses = 1;
        $this->assertTrue($cart->validate(['num_courses']));
        $cart->user_id = $user->id;
        $this->assertTrue($cart->validate(['user_id']));

        $this->assertTrue($cart->save());
    }

    public function testUpdateCart()
    {
        $cart = $this->tester->grabFixture('cart', 'cart1');

        $cart->num_courses = 13;
        $cart->user_id = 2;


        $this->assertTrue($cart->validate());

        $this->assertTrue($cart->save());


        $updatedCart = Cart::findOne($cart->id);

        $this->assertEquals(13, $updatedCart->num_courses);
        $this->assertEquals(2, $updatedCart->user_id);

    }

    public function testDeleteCart()
    {
        $cart = new Cart();

        $cart->num_courses = 13;
        $cart->user_id = 2;

        $cartId = $cart->id;
        $cart->delete();

        $deletedCart = Cart::findOne($cartId);
        $this->assertNull($deletedCart);
    }
}