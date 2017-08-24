<?php

namespace app\controllers;
use yii\rest\ActiveController;
use app\models\Element;



class ElementController extends ActiveController{
    
    // задаем модель для редактирования данных с помощью REST
    public $modelClass = 'app\models\Element';
    

    
}
