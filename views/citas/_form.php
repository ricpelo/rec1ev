<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Citas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="citas-form">

    <?= var_dump($model->errors) ?>

    <h3>
        La siguiente cita es <?= Yii::$app->formatter->asDatetime($model->instante) ?>
    </h3>

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton('Confirmar cita', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
