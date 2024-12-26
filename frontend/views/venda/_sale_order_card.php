<?php use yii\helpers\Html;

$statusColor = $model->idestadoencomenda0->isFinalState() ? 'green' : 'grey';
?>

<div class="card">

        <div class="image-container bg-secondary position-relative">
        <?php
        $firstPhoto = $model->idartigo0->fotosartigos[0] ?? null;  // Alterado para usar idartigo0
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
        <div class="history-order-info mb-3">
            <h6>#<?=  $model->idvenda0->codigo ?></h6>
        </div>

        <p class="card-title text-black" style="font-weight: bold; color: black">
            BRAND: <span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->idartigo0->idmarca0->nome) ?></span>
        </p>


        <p class="card-title text-black" style="font-weight: bold; color: black">
            DATE OF SALE: <span class="text-secondary" style="font-weight: lighter"><?= Html::encode(Yii::$app->formatter->asDate($model->idvenda0->datavenda)) ?></span>
        </p>

        <p class="card-title text-black" style="font-weight: bold; color: black">
            ADDRESS OF BUYER: <span class="text-secondary" style="font-weight: lighter"><?= Html::encode($model->idvenda0->morada) ?></span>
        </p>


        <p class="card-title text-black" style="font-weight: bold; color: black">
            STATUS: <span style="font-weight: bold; color: <?= $statusColor ?>"><?= Html::encode($model->idestadoencomenda0->descricao) ?></span>
        </p>


        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex flex-column">
                <!-- Preço do artigo -->
                <span style="font-weight: normal; font-size: small"><?= Html::encode($model->idartigo0->precoanuncio) ?>€</span>
                <span style="font-weight: bolder; font-size: small">
                                <?= Html::encode($model->idartigo0->precoanuncio) ?>€
                                <span style="font-weight: bold">(inc.)
                                    <img src="<?= Yii::getAlias('@web/images/check_icon.svg') ?>" height="10">
                                </span>
                            </span>
            </div>

            <?php if ($model->idestadoencomenda0->isFirstState()): ?>
                <?= Html::a(
                    'I´VE ALREADY SENT MY ITEM',
                    ['linhavenda/ordersent', 'id' => $model->id], // Substitua 'venda' pelo controlador correto
                    [
                        'class' => 'history-view-details',
                        'style' => 'font-size: x-small; gap: 10px',
                        'data-confirm' => 'Are you sure you want to mark this item as sent?', // Mensagem de confirmação opcional
                    ]
                ) ?>
            <?php endif; ?>
        </div>


    </div>

</div>


