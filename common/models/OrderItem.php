<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property float|null $price
 * @property int $orders_id
 * @property int $courses_id
 * @property float|null $iva_price
 *
 * @property Course $courses
 * @property Order $orders
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'iva_price'], 'number'],
            [['orders_id', 'courses_id'], 'required'],
            [['orders_id', 'courses_id'], 'integer'],
            [['courses_id'], 'exist', 'skipOnError' => true, 'targetClass' => Course::class, 'targetAttribute' => ['courses_id' => 'id']],
            [['orders_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['orders_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price',
            'orders_id' => 'Orders ID',
            'courses_id' => 'Courses ID',
            'iva_price' => 'Iva Price',
        ];
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasOne(Course::class, ['id' => 'courses_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasOne(Order::class, ['id' => 'orders_id']);
    }
}
