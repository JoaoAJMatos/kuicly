<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property string|null $payment_method
 * @property string|null $date
 * @property string|null $status
 * @property float|null $amout
 * @property string|null $gateway_response
 * @property int $orders_id
 *
 * @property Order $orders
 */
class Transaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['payment_method', 'status', 'gateway_response'], 'string'],
            [['date'], 'safe'],
            [['amout'], 'number'],
            [['orders_id'], 'required'],
            [['orders_id'], 'integer'],
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
            'payment_method' => 'Payment Method',
            'date' => 'Date',
            'status' => 'Status',
            'amout' => 'Amout',
            'gateway_response' => 'Gateway Response',
            'orders_id' => 'Orders ID',
        ];
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
