<?php

namespace app\controllers;
use app\models\NewElementForm;
use Yii;
use \yii\web\Controller;

class ContentController extends Controller
{
    
    //метод получения списка элементов или 1 элемента, номер которого передан в функцию
    public function getElements($id = 0){
        if($id == 0)
            $url = "api.test.loc/elements";
        else
            $url = "api.test.loc/elements/" . $id;
        // в зависимости от сформированной ссылки отправляем запрос к api
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);
        // т.к. получаем данные в формате json, то декодируем и и отправляем
        return $obj_response = json_decode($response);
    }
    
    public function actionIndex () {
        //проверяем есть ли кэш и получаем данные из него
        $response_elements = Yii::$app->cache->get('response_elements');
        if(!empty($response_elements)) 
            $obj_response_elements = $response_elements;
        else{
            // если кэш пустой - вызываем нужный метод и записываем данные в кэш с временем хранения - 60с
            $obj_response_elements = $this->getElements();
            Yii::$app->cache->set('response_elements', $obj_response_elements, 60);
        }      
        // аналогично с получением одного элемента
        $response_element = Yii::$app->cache->get('response_element');
        if(!empty($response_element)) 
            $obj_response_element = $response_element;
        else{
            // если кэш пустой - вызываем нужный метод и записываем данные в кэш с временем хранения - 60с
            $obj_response_element = $this->getElements(78);
            Yii::$app->cache->set('response_element', $obj_response_element, 60);
        }
        // создаем модель формы
        $model = new NewElementForm();
        // возвращаем список элементов, запрошенный элемент и модель формы
        return $this->render('index', compact('obj_response_elements', 'obj_response_element', 'model')); 
    }
    
   
    
    
}