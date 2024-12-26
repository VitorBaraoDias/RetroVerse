<?php use yii\helpers\Html;

$statusColor = $model->idestadoencomenda0->isFinalState() ? 'green' : 'grey';
?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center flex-column">
            <?php
            // Exibir a primeira foto do artigo, se disponível
            $firstPhoto = $model->idartigo0->fotosartigos[0] ?? null;
            if ($firstPhoto && file_exists('../../common/uploads/img-artigos/' . $firstPhoto->caminhofoto)) {
                echo Html::img(('../../../common/uploads/img-artigos/') . $firstPhoto->caminhofoto, [
                    'alt' => 'Article Image',
                    'class' => 'img-thumbnail',
                    'style' => 'width: 370px; height: 270px; object-fit: cover;',
                ]);
            } else {
                // Se não houver imagem, exibir uma div cinza
                echo Html::tag('div', '', [
                    'class' => 'img-thumbnail',
                    'style' => 'width: 150px; height: 150px; background-color: grey; display: flex; align-items: center; justify-content: center;',
                ]);
            }
            ?>
        </div>
        <hr>
        <!-- Nome do artigo -->
        <h5 class="text-start"><?= Html::encode($model->idartigo0->nome) ?></h5>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Order Number:</strong>
            <?= Html::tag('span', '#' . $model->idvenda0->codigo, ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4" style="font-weight: bold; color: black">
            Status: <span class="" style="font-weight: bold; color: <?= $statusColor ?>"><?= Html::encode($model->idestadoencomenda0->descricao) ?></span>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Date of Sale:</strong>
            <?= Html::tag('span', Yii::$app->formatter->asDate($model->idvenda0->datavenda), ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Address of the buyer:</strong>
            <?= Html::tag('span', $model->idvenda0->morada, ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <!-- Preço do artigo -->
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Price:</strong>
            <?= Html::tag('span', number_format($model->idartigo0->precoanuncio, 2) . '€', ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Size:</strong>
            <?= Html::tag('span', $model->idartigo0->idtamanho0->tamanho, ['class' => 'text-primary']) ?>
        </p>
        <hr>
        <p class="text-center d-flex justify-content-between mt-4">
            <strong>Brand:</strong>
            <?= Html::tag('span', $model->idartigo0->idmarca0->nome, ['class' => 'text-primary']) ?>
        </p>
    </div>


    <div class="card-footer">
        <?php if ($model->idestadoencomenda0->isFirstState()): ?>
            <?= Html::a(
                'ORDER ALREADY SHIPPED',
                ['linhavenda/ordersent', 'id' => $model->id], // Substitua 'venda' pelo controlador correto
                [
                    'class' => 'btn btn-primary history-order-details btn-sm w-100',
                    'style' => 'font-size: small; gap: 10px',
                    'data-confirm' => 'Are you sure you want to mark this item as sent?', // Mensagem de confirmação opcional
                ]
            ) ?>
        <?php endif; ?>
    </div>
</div>
