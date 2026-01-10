<?php

namespace app\models;

use yii\base\Model;

class TaskFilterForm extends Model
{
    public $categories = [];
    public $withoutPerformer = false;
    public $creationTime;

    public function rules()
    {
        return [
            ['categories', 'each', 'rule' => ['integer']],
            ['withoutPerformer', 'boolean'],
            ['creationTime', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'categories' => 'Категории',
            'withoutPerformer' => 'Без исполнителя',
            'creationTime' => 'Период',
        ];
    }

    public function getPeriodOptions()
    {
        return [
            1 => '1 час',
            12 => '12 часов',
            24 => '24 часа',
        ];
    }
}
