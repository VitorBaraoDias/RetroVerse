<?php
?>
<div class="artigo-view container-lg">
</div>
<?php

use common\models\Favorito;
use yii\helpers\Html;

$userId = Yii::$app->user->id;
$artigoId = $model->id;

$isFavorito = Favorito::isFavorito($userId, $artigoId);

?>
<div class="artigo-view container-lg">

    <!-- Linha principal -->
    <div class="row">
        <!-- Coluna para o carrossel -->
        <div class="col-md-6">
            <div class="d-flex mt-2 align-items-center justify-content-between gap-2 mb-2">
                <div class="d-flex gap-2 align-items-center">
                    <?php if (!empty($model->idperfil0->caminhofotoperfil)): ?>
                        <img class=" rounded-circle" style="object-fit: cover; width: 60px"
                             src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $model->idperfil0->caminhofotoperfil ?>"
                             alt="Foto de Perfil" height="60">
                    <?php else: ?>
                        <img class="" src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Ícone de Perfil"
                             height="70">
                    <?php endif; ?>
                    <h2 class="text-uppercase"><strong> <?= $model->idperfil0->user->username ?> </strong></h2>
                    <div class="d-flex">
                        <span><?= $model->idperfil0->getAvgRates() ?></span>
                        <img src="<?= Yii::getAlias('@web/img/star.svg') ?>" alt="Star Icon" style="height: 20px; margin-left: 10px;">
                        <span>(<?= $model->idperfil0->getCountRates() ?>)</span>
                    </div>
                </div>

                <?= Html::a('REPORT AD', ['denuncia/create', 'id' => $model->id],
                    ['class' => 'btn btn-danger w-auto py-2', 'id' => 'retroverse-btn-active',
                        'style' => 'font-size: 14px !important; font-weight: bold']) ?>
            </div>
            <?php if (!empty($model->fotosartigos)): ?>
                <div id="articleCarousel" class="carousel slide" data-bs-ride="carousel">
                    <!-- Indicadores -->
                    <ol class="carousel-indicators">
                        <?php foreach ($model->fotosartigos as $index => $foto): ?>
                            <li data-bs-target="#articleCarousel" data-bs-slide-to="<?= $index ?>"
                                class="<?= $index === 0 ? 'active' : '' ?>"></li>
                        <?php endforeach; ?>
                    </ol>

                    <!-- Slides do carrossel -->
                    <div class="carousel-inner">
                        <?php foreach ($model->fotosartigos as $index => $foto): ?>
                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                <img src="../../../common/uploads/img-artigos/<?= $foto->caminhofoto ?>"
                                     class="d-block w-100"
                                     style="max-height: 650px; object-fit: cover;"
                                     alt="Foto <?= $index + 1 ?>">
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
        <div class="col-md-6 d-flex flex-column align-self-lg-center">
            <div class="row">
                <div class="col-md-12 row">
                    <h1 class="font-weight-bold text-uppercase pl-0" style="font-size: 48px"><strong><?= $model->nome ?></strong></h1>
                    <hr>
                    <div class="d-flex mt-2 align-items-end pl-0">
                        <h2 style="font-weight: bold"><?= $model->getPrecoComComissaoFormatado() ?>€</h2>
                        <span style="font-weight: ; padding-bottom:3px">(inc.)
                           <img src="/RetroVerse/frontend/web/images/check_icon.svg" height="15">
                        </span>
                        <h4 style="font-weight: bolder; color: #0000FF; margin-left: 10px"><?= $model->precoanuncio ?>
                            €</h4>
                    </div>
                    <div class="d-flex pl-0">
                        <h2 style="font-size: 20px; font-weight: bolder">BRAND:</h2>
                        <p style="font-size: 20px;; margin: 0;"><?= $model->descricao ?></p>
                    </div>
                    <div class="d-flex pl-0">
                        <h2 style="font-size: 20px; font-weight: bold"><strong>CATEGORY:</strong></h2>
                        <p style="font-size: 20px; margin: 0px"><?= $model->idcategoria0->nome ?></p>
                    </div>
                    <div class="d-flex pl-0">
                        <h2 style="font-size: 20px; font-weight: bolder">SIZE:</h2>
                        <p style="font-size: 20px; margin: 0px"><?= $model->idtamanho0->tamanho ?></p>
                    </div>
                    <div class="d-flex pl-0">
                        <h2 style="font-size: 20px; font-weight: bolder">CONDITION:</h2>
                        <p style="font-size: 20px;"><?= $model->idestado0->descricao ?></p>
                    </div>
                    <span class="pl-0" style="font-weight: bold">
                      <img src="<?php echo Yii::getAlias('@web') ?>/img/check_icon.svg" height="20">
                        This item will be shipped to our HQ in order to be autenticated before being shipped to you.
                    </span>

                    <div class="mt-4 row d-flex flex-column justify-content-center p-0 m-0">
                        <?= Html::a('ADD TO CART', ['carrinho/create', 'id' => $model->id],
                            [
                                'class' => 'retroverse-btn active col-md-9',
                                'id' => 'retroverse-btn-active',
                                'style' => 'font-size: x-small; font-weight: bold',
                            ]) ?>

                        <?php if ($isFavorito): ?>
                            <!-- Artigo está nos favoritos -->
                            <a class="w-auto" href="<?= \yii\helpers\Url::to(['favorito/delete', 'id' => $artigoId]) ?>">
                                <img height="40"
                                     src="<?= Yii::getAlias('@web/img/vector_liked.svg') ?>"
                                     alt="Remover dos Favoritos">
                            </a>
                        <?php else: ?>
                            <!-- Artigo não está nos favoritos -->
                            <a class="w-auto" href="<?= \yii\helpers\Url::to(['favorito/create', 'id' => $artigoId]) ?>">
                                <img height="40"
                                     src="<?= Yii::getAlias('@web/img/vector_like.svg') ?>"
                                     alt="Adicionar aos Favoritos">
                            </a>
                        <?php endif; ?>
                    </div>

                    <?= Html::a('MAKE AN OFFER', ['carrinho/create', 'id' => $model->id],
                        ['class' => 'outline-retroverse-btn active w-100 col-md-9 m-0 mb-2 ', 'id' => 'retroverse-btn-active',
                            'style' => 'font-size: x-small; font-weight: bold',]) ?>
                    <?= Html::a('SEND MESSAGE TO SELLER', ['chat/create', 'id' => $model->id],
                        [    'class' => 'btn history-button  w-100 col-md-9 mb-2 text-white rounded-0 ',    'id' => 'retroverse-btn-active',
                            'style' => 'font-size: x-small; background: #121619; font-weight: bold',]) ?>
                    <hr>
                    <div class="bg-light outline p-2 mb-4" style="max-height: 200px">
                        <?= $model->descricao ?>
                    </div>
                    <hr>
                    <h1 class="font-weight-bold" style="font-size: 42px"><strong>SHIPPING INFO</strong></h1>
                    <h2 class="font-weight-bold" style="font-size: 20px"><strong>SHIPPING METHOD:</strong> CTT</h2>
                    <h2 class="font-weight-bold" style="font-size: 20px"><strong>SHIPPING DATE:</strong> 3-5 working
                        days</h2>
                    <p>Shipping price calculated in check out</p>
                    <!-- Adicione mais informações conforme necessário -->
                </div>
            </div>
        </div>
    </div>
    <h2 class="mt-4"><strong>OTHER MEMBER ITEMS</strong></h2>
    <hr>
</div>

