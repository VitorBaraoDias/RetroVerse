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
$authManager = Yii::$app->authManager;

?>
<div class="user-index">

    <!-- Tabela personalizada -->
    <div class="d-flex justify-content-between align-items-center">
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
    <div class="row mt-4">
        <?php foreach ($users as $index => $user): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-column">
                            <?= Html::img(Yii::getAlias('@web/images/jordan.jpg'),
                                ['alt' => 'Example Image',
                                    'class' => 'rounded-circle img-thumbnail',
                                    'style' => 'width: 100px; height: 100px; object-fit: cover;',]) ?>
                            <h4><?= Html::encode($user->username) ?></h4>
                            <p class="text-secondary">Member ID: <?= Html::encode($user->id) ?></p>
                        </div>
                        <hr>
                        <!-- Mostra o papel do usuário -->
                        <p class="d-flex justify-content-between">
                            <strong>Role:</strong>
                            <?php
                            $roles = $authManager->getRolesByUser($user->id);
                            $roleNames = array_keys($roles); // Obtem apenas os nomes dos papéis
                            echo Html::tag('span', implode(', ', $roleNames), ['class' => 'badge bg-dark text-dark']);
                            ?>
                        </p>
                        <hr>

                        <p class="d-flex justify-content-between">
                            <strong>Items:</strong>
                            <?= Html::tag('span', Html::encode($user->email), ['class' => 'text-primary']) ?>
                        </p>
                        <hr>
                        <p class="d-flex justify-content-between">
                            <strong>Orders:</strong>
                            <?= Html::tag('span', Html::encode($user->email), ['class' => 'text-primary']) ?>
                        </p>
                        <hr>
                        <p class="d-flex justify-content-between">
                            <strong>Date:</strong>
                            <?= Html::tag('span', Html::encode($user->email), ['class' => 'text-primary']) ?>
                        </p>

                    </div>
                    <div class="card-footer">


                        <?php
                        $userRoles = array_keys($authManager->getRolesByUser($user->id));

                        // Se o usuário for um 'moderador'
                        if (in_array('moderador', $userRoles)): ?>
                            <?= Html::a('Remove', ['demote', 'id' => $user->id], [
                                'class' => 'btn btn-danger btn-sm w-100',
                                'data' => [
                                    'confirm' => 'Are you sure you want to demote this moderator?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php elseif (in_array('membro', $userRoles)): ?>
                            <?= Html::a('Promote', ['promote', 'id' => $user->id], [
                                'class' => 'btn btn-warning btn-sm w-100',
                                'data' => [
                                    'confirm' => 'Promote this member to moderator?',
                                    'method' => 'post',
                                ],
                            ]) ?>
                        <?php endif; ?>
                        <?= Html::a('Details', ['user/view', 'id' => $user->id], ['class' => 'btn btn-dark btn-sm w-100 mt-2']) ?>
                        <?= Html::a('Delete member', ['user/delete', 'id' => $user->id], ['class' => 'btn btn-danger btn-sm w-100 mt-2']) ?>
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
    <div class="pagination-container pagination pagination-sm">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'nextPageLabel' => 'Próxima',
            'prevPageLabel' => 'Anterior',
            'firstPageLabel' => 'Primeira',
            'lastPageLabel' => 'Última',
        ]) ?>
    </div>
</div>