<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

    $this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="user-index">

    <!-- Tabela personalizada -->
    <div class="d-flex align-items-center" style="gap:30px;">
        <h1>List <?= Html::encode($this->title) ?></h1>

        <?= Html::a('Create User', ['user/create'], ['class' => 'btn btn-success']) ?>
    </div>

    <!--    <table class="table table-bordered table-striped table-hover table-condensed table-responsive">-->
    <!--        <thead>-->
    <!--        <tr>-->
    <!--            <th>#</th>-->
    <!--            <th>Nome</th>-->
    <!--            <th>Email</th>-->
    <!--            <th>Data de Cadastro</th>-->
    <!--            <th>Actions</th>-->
    <!---->
    <!--        </tr>-->
    <!--        </thead>-->
    <!--        <tbody>-->
    <!--        --><?php //foreach ($dataProvider->models as $user): ?>
    <!--            <tr>-->
    <!--                <td>--><?php //= Html::encode($user->id) ?><!--</td>-->
    <!--                <td>--><?php //= Html::encode($user->username) ?><!--</td>-->
    <!--                <td>--><?php //= Html::encode($user->email) ?><!--</td>-->
    <!--                <td>--><?php //= Html::encode($user->created_at) ?><!--</td>-->
    <!--                <td>--><?php //= Html::a('Edit', ['user/view'], ['class' => 'btn btn-success']) ?>
    <!--                    --><?php //= Html::a('Edit', ['user/view'], ['class' => 'btn btn-warning']) ?>
    <!--                    --><?php //= Html::a('Delete', ['user/delete'], ['class' => 'btn btn-danger']) ?>
    <!--                </td>-->
    <!--            </tr>-->
    <!--        --><?php //endforeach; ?>
    <!--        </tbody>-->
    <!--    </table>-->
    <!-- Formulário de Pesquisa -->
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['index'],
        'options' => ['class' => 'mb-4'],
    ]); ?>
    <div class="input-group" style="gap:30px;">
        <?= Html::textInput('searchQuery', $searchQuery, [
            'class' => 'form-control',
            'placeholder' => 'Search by name or email...',
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