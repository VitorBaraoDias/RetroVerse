<?php
use yii\helpers\Html;
use yii\widgets\ListView;

$userId = Yii::$app->user->id;
?>
        <div class="card">
            <div class="image-container bg-secondary position-relative">

                <?php
                $firstPhoto = $model->fotosartigos[0] ?? null;

                $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

                if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
                    echo Html::img($imagePath, [
                        'alt' => 'Article Image',
                        'class' => 'w-100',
                        'style' => 'width: 370px; height: 270px; object-fit: cover;',
                    ]);
                } else {
                    echo Html::tag('div', '', [
                        'class' => 'img-thumbnail',
                        'style' => 'width: 370px; height: 270px; background-color: grey; display: flex; align-items: center; justify-content: center;',
                    ]);
                }
                ?>


            </div>
            <div class="card-body">
                <p class="card-title text-black" style="font-weight: bold; color: black">
                    BRAND:<span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->idmarca0->nome) ?></span>
                </p>
                <p class="card-title text-black" style="font-weight: bold; color: black">
                    SIZE:<span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->idtamanho0->tamanho) ?></span>
                </p>

                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
            <span style="font-weight: bolder; font-size: small">
                <?= Html::encode($model->precoanuncio) ?>€
            </span>
                    </div>
                   <?php
                   if (!Yii::$app->user->isGuest) {
                       if ($model->idperfil === $userId) {
                           echo '<div class="d-flex gap-2">';
                           echo Html::a('EDIT NOW', ['artigo/update', 'id' => $model->id], [
                               'class' => 'retroverse-btn',
                               'style' => 'font-size: x-small; padding: 5px 10px;',
                           ]);
                           echo Html::a('DISABLE NOW', ['artigo/disable', 'id' => $model->id], [
                               'class' => 'btn-disable',
                               'style' => 'font-size: x-small; padding: 5px 10px;',
                           ]);
                           echo '</div>';
                       } else {
                           echo Html::a('VIEW', ['artigo/view-marketplace', 'id' => $model->id], [
                               'class' => 'retroverse-btn',
                               'style' => 'font-size: x-small; padding: 5px 10px;',
                           ]);
                       }
                   }
                   ?>
                </div>
            </div>

        </div>
