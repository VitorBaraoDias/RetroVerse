<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use common\models\Favorito;

$userId = Yii::$app->user->id;
$artigoId = $model->id;

$isFavorito = Favorito::isFavorito($userId, $artigoId);
?>
        <div class="card">
            <div class="image-container bg-secondary position-relative">
                <div class="container-info-type-item"><?= $model->tipoartigo ?></div>

                <div class="rounded-circle container-like d-flex justify-content-center align-items-center">
                    <?php if ($isFavorito): ?>
                        <a href="<?= \yii\helpers\Url::to(['favorito/delete', 'id' => $artigoId]) ?>">
                            <img class="icon-like"
                                 src="<?= Yii::getAlias('@web/img/vector_liked.svg') ?>"
                                 alt="Remove from favorites">
                        </a>
                    <?php else: ?>
                        <a href="<?= \yii\helpers\Url::to(['favorito/create', 'id' => $artigoId]) ?>">
                            <img class="icon-like"
                                 src="<?= Yii::getAlias('@web/img/vector_like.svg') ?>"
                                 alt="Add to favorites">
                        </a>
                    <?php endif; ?>
                </div>


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
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex flex-column">
                        <span style="font-weight: normal; font-size: small"><?= Html::encode($model->precoanuncio) ?>€</span>
                        <span style="font-weight: bolder; font-size: small">
                                <?= Html::encode($model->precoanuncio) ?>€
                                <span style="font-weight: bold">(inc.)
                                    <img src="<?= Yii::getAlias('@web/images/check_icon.svg') ?>" height="10">
                                </span>
                            </span>
                    </div>

                    <?= Html::a(
                        'VIEW',
                        [
                            $model->tipoartigo === 'MARKETPLACE' ? 'artigo/view-marketplace' : 'artigo/view',
                            'id' => $model->id
                        ],
                        [
                            'class' => 'retroverse-btn',
                            'style' => 'font-size: x-small; gap: 10px',
                        ]
                    ) ?>
                </div>
            </div>
        </div>
