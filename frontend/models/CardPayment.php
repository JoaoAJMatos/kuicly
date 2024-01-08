<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

class CardPayment extends Model
{
    public $card_number;
    public $card_holder;
    public $card_expiry;
    public $card_cvc;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_number', 'card_holder', 'card_expiry', 'card_cvc'], 'required'],
            [['card_number'], 'integer'],
            [['card_holder'], 'string', 'max' => 75],
            [['card_expiry'], 'string', 'max' => 5],
            [['card_cvc'], 'string', 'max' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'card_number' => 'Card Number',
            'card_holder' => 'Card Holder',
            'card_expiry' => 'Card Expiry',
            'card_cvc' => 'Card CVC',
        ];
    }

    public function pay()
    {
        if ($this->validate()) {

            return true;
        } else {
            return false;
        }
    }
}