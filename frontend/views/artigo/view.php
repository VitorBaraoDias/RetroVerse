<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var common\models\Artigo $model */

$this->title = $model->id;

\yii\web\YiiAsset::register($this);
?>
<div class="artigo-view container-lg">

    <!-- Linha principal -->
    <div class="row">
        <!-- Coluna para o carrossel -->
        <div class="col-md-6">
            <?php if (!empty($model->fotosartigos)): ?>
                <div id="articleCarousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicadores -->
                    <ol class="carousel-indicators">
                        <?php foreach ($model->fotosartigos as $index => $foto): ?>
                            <li data-bs-target="#articleCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                        <?php endforeach; ?>
                    </ol>

                    <!-- Slides do carrossel -->
                    <div class="carousel-inner">
                        <?php foreach ($model->fotosartigos as $index => $foto): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="../../../common/uploads/img-artigos/<?= $foto->caminhofoto ?>" class="d-block w-100" alt="Foto <?= $index + 1 ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Controles -->
                    <a class="carousel-control-prev" href="#articleCarousel" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#articleCarousel" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
            <?php else: ?>
                <p>Não há fotos disponíveis para este artigo.</p>
            <?php endif; ?>
        </div>
        <!-- Coluna de Informações -->
        <div class="col-md-6 d-flex flex-column">
            <h1 class="font-weight-bold" style="font-size: 48px"><strong><?= $model->nome ?></strong></h1>
            <h2><?= $model->precoanuncio ?>€</h2>
            <div class="d-flex">
                <h2 style="font-size: 20px; font-weight: bolder">Brand:</h2>
                <p style="font-size: 20px;"><?= $model->descricao ?></p>
            </div>

            <div class="d-flex">
                <h2 style="font-size: 20px; font-weight: bolder">Size:</h2>
                <p style="font-size: 20px;"><?= $model->idtamanho0->tamanho ?></p>
            </div>

            <div class="d-flex">
                <h2 style="font-size: 20px; font-weight: bolder">Condtion:</h2>
                <p style="font-size: 20px;"><?= $model->idestado0->descricao ?></p>
            </div>
            <span style="font-weight: bold">
              <img style="height: 30px" src="<?= Yii::getAlias('@web/images/check_icon.svg') ?>">

                This item is 100% autenthic.
(All items have been checked before selling)
            </span>
            <div class="d-flex align-items-center justify-content-between mt-5 gap-5">
                <?= Html::a('ADD TO CART', ['carrinho/create', 'id' => $model->id], [    'class' => 'retroverse-btn active',    'id' => 'retroverse-btn-active',    'style' => 'font-size: x-small; gap: 10px',]) ?>
                <img style="height: 30px" src="<?= Yii::getAlias('@web/images/icon_heart.svg') ?>">
            </div>
            <hr>
            <div class="bg-light outline p-2">
                (All items have been checked before selling)(All items have been checked before selling)(All items have been checked before selling)(All items have been checked before selling)
            </div>
            <hr>
            <h1 class="font-weight-bold" style="font-size: 42px"><strong>SHIPPING INFO</strong></h1>
            <h2 class="font-weight-bold" style="font-size: 20px"><strong>SHIPPING METHOD:</strong> CTT</h2>
            <h2 class="font-weight-bold" style="font-size: 20px"><strong>SHIPPING DATE:</strong> 3-5 working days</h2>
            <p>Shipping price calculated in check out</p>
            <!-- Adicione mais informações conforme necessário -->
        </div>
    </div>
    <hr>
    <div>
        <h2 class="mb-4"><strong>RELATED ITEMS</strong></h2>
        <?= ListView::widget([
            'dataProvider' => $relatedArticles,
            'itemView' => '_artigo_card',  // Especifica o arquivo de item que criamos
            'layout' => '<div class="row">{items}</div>{pager}',  // Layout com items e paginação
            'options' => ['class' => 'list-view'],  // Classe opcional para estilização adicional
            'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product'],  // Estilo para cada item
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]) ?>
    </div>
</div>
