<?php

use yii\helpers\Html;
use yii\grid\GridView;

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CitasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Citas';
$this->params['breadcrumbs'] = [$this->title];
?>
<div class="citas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?php if ($actual === null): ?>
        <p>
            <?= Html::a('Reservar una cita', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php else: ?>
        <h2>Cita actual</h2>
        <?= DetailView::widget([
            'model' => $actual,
            'attributes' => [
                'instante:datetime',
            ],
        ]) ?>
        <?= Html::a('Anular cita', ['delete', 'id' => $actual->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Seguro que desea anular la cita?',
                'method' => 'post',
            ],
        ]) ?>
    <?php endif ?>

    <h2>Histórico de citas anteriores</h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'instante:datetime',
        ],
    ]); ?>
</div>
