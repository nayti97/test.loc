<?php
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;

?>

<h3>Список элементов:</h3>
<?php

// итерируем объект со списком элементов, который получили с контроллера и выводим содержание на экран
foreach( $obj_response_elements as $obj ){
    echo 'Элемент: ' . $obj->id . '<br>';
    echo 'Заголовок: ' . $obj->title . '<br><br>';
}
?>

<h3>Запрашиваемый элемент</h3>
<?php
    // выводим на экран информацию о запрашиваемом элементе
    echo 'Элемент ' . $obj_response_element->id . '<br>' . 'Заголовок: ' . $obj_response_element->title .  '<br> Контент: ' . $obj_response_element->content . '<br>';
?>

<h3>Добавление элемента в список</h3>
<?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'title')->label('Введите заголовок') ?>
    <?= $form->field($model, 'content')->label('Введите контент')->textarea(['rows' => 5]) ?>
    <?= Html::submitButton('Отправить') ?>
<?php $form = ActiveForm::end(); ?>


<?php
// получение post данных из формы
$request = Yii::$app->request;
$element_data = $request->post('NewElementForm');
$content = $element_data['content'];
$title = $element_data['title'];

// запрос на добавление данных в БД к api
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.test.loc/elements",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n\t\"title\":\"$title\",\n\t\"content\":\"$content\"\n}",
  CURLOPT_HTTPHEADER => array(
    "content-type: application/json",
  ),
));
// получаем ответ от сервера и ошибки(если они есть)
$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

// если пользователь еще не отправлял данных то ничего не выводим, в противном случае выводим уведомление об 
// ошибке или успешной отправке данных
if(!empty($element_data)){
    if ($err) {
      echo "Ошибка: " . $err;
    } else {
      echo "Данные успешно добавлены!";
    }
}

?>








