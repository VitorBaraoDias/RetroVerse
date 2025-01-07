<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var \common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

    $this->title = 'Users';


?>
<div class="user-index">

    <!-- Tabela personalizada -->
    <div class="d-flex align-items-center" style="gap:30px;">
        <h1>List <?= Html::encode($this->title) ?></h1>

        <?= Html::a('Create User', ['user/create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['class' => 'mb-4'],
    ]); ?>
    <div class="input-group" style="gap:30px;">
        <?= Html::textInput('searchQuery', $searchQuery, [
            'class' => 'form-control',
            'placeholder' => 'Search by name...',
        ]) ?>
        <button class="btn btn-primary" type="submit">Search</button>
    </div>
    <?php ActiveForm::end(); ?>


    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_user',
        'layout' => '<div class="row">{items}</div>{pager}',
        'options' => ['class' => 'list-view'],
        'itemOptions' => ['class' => 'col-md-4 mb-4'],
        'pager' => [
            'class' => \yii\bootstrap5\LinkPager::class,
            'options' => ['class' => 'pagination justify-content-center'],
        ],
    ]) ?>

</div>