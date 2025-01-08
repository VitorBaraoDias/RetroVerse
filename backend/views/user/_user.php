<?php

use yii\helpers\Html;

?>
    <div class="card h-100">
        <div class="card-body">
            <div class="d-flex align-items-center flex-column">
                <?php

                if ($model->perfil && !is_null($model->perfil->caminhofotoperfil) && file_exists(Yii::getAlias('../../common/uploads/img-profile/') . $model->perfil->caminhofotoperfil)) {

                    echo Html::img(('../../../common/uploads/img-profile/') . $model->perfil->caminhofotoperfil, [
                        'alt' => 'User Image',
                        'class' => 'rounded-circle img-thumbnail',
                        'style' => 'width: 100px; height: 100px; object-fit: cover;',
                    ]);
                } else {
                    echo Html::tag('div', '', [
                        'class' => 'rounded-circle',
                        'style' => 'width: 100px; height: 100px; background-color: gray; display: flex; align-items: center; justify-content: center;',
                    ]);
                }
                ?>

                <h4><?= Html::encode($model->username) ?></h4>
                <p class="text-secondary">Member ID: <?= Html::encode($model->id) ?></p>
            </div>
            <hr>

            <p class="d-flex justify-content-between">
                <strong>Role:</strong>
                <?php
                $authManager = Yii::$app->authManager;

                $roles = $authManager->getRolesByUser($model->id);
                $roleNames = array_keys($roles);
                echo Html::tag('span', implode(', ', $roleNames), ['class' => 'badge bg-dark text-dark']);
                ?>
            </p>
            <hr>

            <p class="d-flex justify-content-between">
                <strong>Items:</strong>
                <?= Html::tag('span', Html::encode($model->email), ['class' => 'text-primary']) ?>
            </p>
            <hr>
            <p class="d-flex justify-content-between">
                <strong>Orders:</strong>
                <?= Html::tag('span', Html::encode($model->email), ['class' => 'text-primary']) ?>
            </p>
            <hr>
            <p class="d-flex justify-content-between">
                <strong>Date:</strong>
                <?= Html::tag('span', Html::encode($model->email), ['class' => 'text-primary']) ?>
            </p>

        </div>
        <div class="card-footer">


            <?php
            $authManager = Yii::$app->authManager;

            $userRoles = array_keys($authManager->getRolesByUser($model->id));

            if (in_array('moderador', $userRoles)): ?>
                <?= Html::a('Remove', ['demote', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm w-100',
                    'data' => [
                        'confirm' => 'Are you sure you want to demote this moderator?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php elseif (in_array('membro', $userRoles)): ?>
                <?= Html::a('Promote', ['promote', 'id' => $model->id], [
                    'class' => 'btn btn-warning btn-sm w-100',
                    'data' => [
                        'confirm' => 'Promote this member to moderator?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
            <?= Html::a('Details', ['user/view', 'id' => $model->id], ['class' => 'btn btn-dark btn-sm w-100 mt-2']) ?>
            <?= Html::a(
                'Ban member',
                ['ban', 'id' => $model->id],
                [
                    'class' => 'btn btn-danger btn-sm w-100 mt-2',
                    'data-confirm' => 'Are you sure you want to ban this user?',
                    'data-method' => 'post',
                ]
            ) ?>        </div>
    </div>

