<?php

namespace app\models;

use yii\base\Model;

class SearchAddressForm extends Model
{
    public $address;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [
                ['address'], 'required'
            ],
        ];
    }

    public function search()
    {
        if ($this->validate()) {
            return $this->address;
        }
        return false;
    }
}