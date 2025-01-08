<?php
use yii\helpers\Html;
use yii\widgets\ListView;
?>


    <div class="card">
        <div class="image-container">

            <?php
            $artigo = $model->artigo;
            $firstPhoto = $artigo->fotosartigos[0] ?? null;

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
                BRAND: <span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->artigo->idmarca0->nome) ?></span>
            </p>

            <p class="card-title text-black" style="font-weight: bold; color: black">
                SIZE: <span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->artigo->idtamanho0->tamanho) ?></span>
            </p>

            <div class="d-flex align-items-center justify-content-between">
                <?php if ($isPremiumActive): ?>
                    <span class="" style="font-weight: bolder; color: black;"><?= Html::encode($artigo->precoanuncio) ?>€</span>
                    <?= Html::a('VIEW', ['artigo/view', 'id' => $model->id], [
                        'class' => 'outline-retroverse-btn',
                        'style' => 'font-size: x-small; gap: 10px',
                    ]) ?>
                <?php else: ?>
                    <span class="" style="font-weight: bolder; color: black;">???</span>
                    <?= Html::a(
                        '<span>UNLOCK WITH PREMIUM</span> <img height="20px" src="' . Yii::getAlias('@web/img/lock.svg') . '" alt="Lock Icon">',
                        ['plano/index'],
                        [
                            'class' => 'outline-retroverse-btn d-flex justify-content-between align-items-center',
                            'style' => 'font-size: x-small; gap: 10px',
                            'encode' => false,
                        ]
                    ) ?>

                <?php endif; ?>
            </div>

        </div>
    </div>

