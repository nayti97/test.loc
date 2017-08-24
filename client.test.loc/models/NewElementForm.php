<?php

namespace app\models;

use yii\db\ActiveRecord;

class NewElementForm extends ActiveRecord
{
    // что будем отправлять с формы
    public $content;
    public $title;

    public function rules()
    {
        return [
            // ajax валидация на заполнение полей
            [['content','title'], 'required'],
        ];
    }
    
   
}
