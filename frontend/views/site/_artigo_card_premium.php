<?php
use yii\helpers\Html;
use yii\widgets\ListView;
?>

<!-- Card para cada artigo premium -->

    <div class="card">
        <div class="image-container">
            <!-- Verifica se o artigo premium tem foto -->
            <?php
            $artigo = $model->artigo; // Acessa o artigo relacionado
            $firstPhoto = $artigo->fotosartigos[0] ?? null;

            // Caminho para a imagem no frontend
            $imagePath = Yii::getAlias('@web/uploads/img-artigos/') . ($firstPhoto->caminhofoto ?? '');

            if ($firstPhoto && file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto)) {
                // Renderiza a imagem
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
            <!-- Marca do artigo -->
            <p class="card-title text-black" style="font-weight: bold; color: black">
                BRAND: <span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->artigo->idmarca0->nome) ?></span>
            </p>

            <!-- Tamanho do artigo -->
            <p class="card-title text-black" style="font-weight: bold; color: black">
                SIZE: <span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->artigo->idtamanho0->tamanho) ?></span>
            </p>

            <div class="d-flex align-items-center justify-content-between">
                <!-- Verifica se o usuário é premium -->
                <?php if ($isPremiumActive): ?>
                    <!-- Exibe o preço real e botão de "Comprar Agora" -->
                    <span class="" style="font-weight: bolder; color: black;"><?= Html::encode($artigo->precoanuncio) ?>€</span>
                    <?= Html::a('VIEW', ['artigo/view', 'id' => $model->id], [
                        'class' => 'outline-retroverse-btn',
                        'style' => 'font-size: x-small; gap: 10px',
                    ]) ?>
                <?php else: ?>
                    <!-- Exibe "???" no preço e botão de "Unlock With Premium" -->
                    <span class="" style="font-weight: bolder; color: black;">???</span>
                    <?= Html::a(
                        '<span>UNLOCK WITH PREMIUM</span> <img height="20px" src="' . Yii::getAlias('@web/img/lock.svg') . '" alt="Lock Icon">',
                        ['premium/index'],
                        [
                            'class' => 'outline-retroverse-btn d-flex justify-content-between align-items-center',
                            'style' => 'font-size: x-small; gap: 10px',
                            'encode' => false, // Permitir HTML no conteúdo
                        ]
                    ) ?>

                <?php endif; ?>
            </div>

        </div>
    </div>

