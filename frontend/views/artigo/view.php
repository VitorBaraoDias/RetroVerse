<?php
use yii\helpers\Html;
use yii\widgets\ListView;
?>
<div class="artigo-view container-lg">

    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($model->fotosartigos)): ?>
                <div id="articleCarousel" class="carousel slide" data-bs-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php foreach ($model->fotosartigos as $index => $foto): ?>
                            <li data-bs-target="#articleCarousel" data-bs-slide-to="<?= $index ?>" class="<?= $index === 0 ? 'active' : '' ?>"></li>
                        <?php endforeach; ?>
                    </ol>

                    <div class="carousel-inner">
                        <?php foreach ($model->fotosartigos as $index => $foto): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="../../../common/uploads/img-artigos/<?= $foto->caminhofoto ?>"
                                     style="max-height: 650px; object-fit: cover;"
                                     class="d-block w-100" alt="Foto <?= $index + 1 ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>

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
                <p>No images found for this item.</p>
            <?php endif; ?>
        </div>
        <div class="col-md-6 d-flex flex-column">
            <h1 class="font-weight-bold" style="font-size: 48px"><strong><?= $model->nome ?></strong></h1>
            <h2 style="font-weight: bold"><?= $model->precoanuncio ?>€</h2>
            <div class="d-flex mt-2">
                <h2 style="font-size: 20px; font-weight: bold"><strong>CATEGORY:</strong></h2>
                <p style="font-size: 20px; margin: 0px"><?= $model->idcategoria0->nome ?></p>
            </div>
            <div class="d-flex">
                <h2 style="font-size: 20px; font-weight: bolder">BRAND:</h2>
                <p style="font-size: 20px;; margin: 0;"><?= $model->idmarca0->nome ?></p>
            </div>
            <div class="d-flex">
                <h2 style="font-size: 20px; font-weight: bolder">SIZE:</h2>
                <p style="font-size: 20px; margin: 0px"><?= $model->idtamanho0->tamanho ?></p>
            </div>
            <div class="d-flex">
                <h2 style="font-size: 20px; font-weight: bolder">CONDITION:</h2>
                <p style="font-size: 20px;"><?= $model->idestado0->descricao ?></p>
            </div>
            <span style="font-weight: bold">
              <img src= "<?php echo Yii::getAlias('@web') ?>/img/check_icon.svg" height="20">
                This item is 100% autenthic.
                <p>(All items have been checked before selling)</p>
            </span>
            <div class="d-flex align-items-center justify-content-between mt-2 gap-5">

                <?php if ($model->idperfil !== Yii::$app->user->id) {
                    echo Html::a('ADD TO CART', ['carrinho/create', 'id' => $model->id], [
                        'class' => 'retroverse-btn active add-to-cart-button',
                        'id' => 'retroverse-btn-active',
                        'style' => 'font-size: x-small; gap: 10px',
                    ]);
                } else {
                    echo Html::a('EDIT ITEM', ['artigo/update', 'id' => $model->id], [
                        'class' => 'retroverse-btn active add-to-cart-button',
                        'id' => 'retroverse-btn-active',
                        'style' => 'font-size: x-small; gap: 10px',
                    ]);
                    }
                ?>

                <?php
                if ($model->idperfil !== Yii::$app->user->id) {
                    if ($isFavorito): ?>
                        <a class="favourite-button" href="<?= \yii\helpers\Url::to(['favorito/delete', 'id' => $model->id]) ?>">
                            <img height="40"
                                 src="<?= Yii::getAlias('@web/img/vector_liked.svg') ?>"
                                 alt="Remove from favorites">
                        </a>
                    <?php else: ?>
                        <a class="favourite-button" href="<?= \yii\helpers\Url::to(['favorito/create', 'id' => $model->id]) ?>">
                            <img height="40"
                                 src="<?= Yii::getAlias('@web/img/vector_like.svg') ?>"
                                 alt="Add to favorites">
                        </a>
                    <?php endif;
                } ?>
            </div>
            <hr>
            <div class="bg-light outline p-2">
                <?= $model->descricao ?>
            </div>
            <hr>
            <h1 class="font-weight-bold" style="font-size: 42px"><strong>SHIPPING INFO</strong></h1>
            <h2 class="font-weight-bold" style="font-size: 20px"><strong>SHIPPING METHOD:</strong> CTT</h2>
            <h2 class="font-weight-bold" style="font-size: 20px"><strong>SHIPPING DATE:</strong> 3-5 working days</h2>
            <p>Shipping price calculated in check out</p>
        </div>
    </div>
    <hr>
    <div>
        <h2 class="text-center fw-bolder mb-4 " style="font-weight: bold;">RELATED ITEMS</h2>
        <?= ListView::widget([
            'dataProvider' => $relatedDataProvider,
            'itemView' => '_related_items_card',
            'layout' => '<div class="row">{items}</div>{pager}',
            'options' => ['class' => 'list-view'],
            'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product'],

            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'pagination justify-content-center'],
            ],
        ]) ?>
    </div>
</div>
