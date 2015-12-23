<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Employee', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Employees tree', ['tree'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin();?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'parent_id',
            'full_name',
            'position',
            'date',
             'salary',
            [
                'format' => ['image',['width'=>'100','height'=>'100']],
                'value'=>function($data) { return $data->photo; },

            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
   <?php Pjax::end();?>
</div>
