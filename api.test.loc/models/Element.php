<?php

namespace app\models;
use yii\db\ActiveRecord;



class Element extends ActiveRecord{
    
    
    
    public static function tableName(){
        // прописываем какой именно таблице будет соотвтествовать модель
        return 'elements';
    }
    
    
    public function rules(){
        return [
            // поля которые должны быть обязательно отправлены
            [['content', 'title'], 'required'],
            
        ];
    }
    
  
  
    
    
    

}
