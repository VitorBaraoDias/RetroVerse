<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

$users = $dataProvider->getModels(); // Obtém os modelos de usuários

?>
<div class="user-index">
<h1><?= Html::encode($this->title) ?></h1>

<!-- Tabela personalizada -->
    <div>
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
    <div class="row">
        <?php foreach ($users as $index => $user): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-column">
                            <?=Html::img(Yii::getAlias('@web/images/jordan.jpg'),
                                ['alt' => 'Example Image',
                                    'class' => 'rounded-circle img-thumbnail',
                                    'style' => 'width: 100px; height: 100px; object-fit: cover;',])?>
                            <h2><?= Html::encode($user->username) ?></h2>
                        </div>
                        <p class="card-text">
                            <strong>Email:</strong> <?= Html::encode($user->email) ?><br>
                            <strong>ID:</strong> <?= Html::encode($user->id) ?>
                        </p>
                    </div>
                    <div class="card-footer text-end">
                        <?= Html::a('Delete member', ['user/view', 'id' => $user->id], ['class' => 'btn btn-danger btn-sm w-100']) ?>
                    </div>
                </div>
            </div>

            <!-- Adiciona um div clearfix a cada 3 cards para quebrar a linha -->
            <?php if (($index + 1) % 3 == 0): ?>
                <div class="w-100"></div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<!-- Paginacao -->
<div class="pagination-container">
    <?= LinkPager::widget([
        'pagination' => $dataProvider->pagination,
        'nextPageLabel' => 'Próxima',
        'prevPageLabel' => 'Anterior',
        'firstPageLabel' => 'Primeira',
        'lastPageLabel' => 'Última',
    ]) ?>
</div>
</div>