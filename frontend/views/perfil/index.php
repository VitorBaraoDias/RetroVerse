<?php

use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Perfis';

$query = $model->getArtigos()->where(['ativo' => '1']);
$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 8, // Define o número de itens por página
    ],
]);

?>
<div class="perfil-index">
    <h1 style="margin-left: 90px; margin-top:30px"><strong>PROFILE</strong></h1>
    <div class="row justify-content-between mt-4 mx-5">
        <div class="d-flex col-lg-6 row">
            <?php if (!empty($model->caminhofotoperfil)): ?>
                <img class="col-md-3 rounded-circle" style="object-fit: cover" src="<?= Yii::getAlias('@web') ?>/uploads/img-profile/<?= $model->caminhofotoperfil ?>" alt="Foto de Perfil" height="140">
            <?php else: ?>
                <img class="col-md-3" src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="Ícone de Perfil" height="140">
            <?php endif; ?>
            <div class="col-md-9">
                <div class="d-flex gap-4 align-items-center">
                    <h3 class="position-relative"><?= $model->user->username ?>
                        <?php if ($model->hasActivePremiumPlano()): ?>
                            <img class="" style="position: absolute; object-fit: cover; right: -15px; top: -11px;" src="<?= Yii::getAlias('@web') ?>/img/premium-user-verified.svg" alt="Verified Premium Badge">
                        <?php endif; ?>
                    </h3>
                    <?php if (Yii::$app->user->id === $model->user->id): ?>
                        <?= Html::a('EDIT PROFILE', ['perfil/update', 'id' => Yii::$app->user->id], [
                            'class' => 'btn retroverse-btn w-auto px-5',
                            'id' => 'retroverse-btn-active',
                            'style' => 'font-size: x-small; gap: 10px; padding: 5px',
                        ]) ?>
                        <?php if ($model->hasActivePremiumPlano()): ?>
                            <?= Html::a('MY PLAN', ['clientesplano/view', 'id' => $model->clientesplano->id], [
                                'class' => 'outline-retroverse-btn rounded-2',
                                'style' => 'font-size: x-small; margin-left: 0',
                            ]) ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="mt-1" style="word-break: break-all;"><?= $model->morada ?></div>
                <div class="mt-1" style="word-break: break-all;"><?= $model->descricao ?></div>
                <?= Html::a(
                    $model->getCountRates() . ' Reviews',
                    ['avaliacao/index', 'id' => $model->id],
                    ['class' => 'font-size: x-small text-warning cursor']
                ) ?>
            </div>
        </div>
        <?php if (Yii::$app->user->id === $model->user->id): ?>
            <div class="col-lg-4 p-4 card mt-5 mt-lg-0">
                <div class="d-flex justify-content-between" style="gap: 50px">
                    <span>EARNINGS AND STATS</span>
                    <?= Html::a('HISTORY', ['venda/index'], [
                        'class' => 'btn retroverse-btn',
                        'id' => 'retroverse-btn-active',
                        'style' => 'font-size: x-small; gap: 10px; padding: 10px',
                    ]) ?>
                </div>
                <div class="d-flex justify-content-between mt-5">
                    <div class="d-flex flex-column align-items-center">
                        <p><b>MY BALANCE: </b><?= $model->saldo ?>€</p>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <p><b>BALANCE ON HOLD: </b><?= $model->saldopendente ?>€</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="mx-5 mt-5" style="margin-left: 90px; margin-top:10px">
        <div class="d-flex justify-content-between">
            <h2><strong>MY ITEMS</strong></h2>
            <?php if (Yii::$app->user->id === $model->user->id): ?>
                <?= Html::a('+ PUBLISH AN ITEM', ['perfil/update'], [
                    'class' => 'btn retroverse-btn w-auto px-3 py-2 rounded-0',
                    'id' => 'retroverse-btn-active',
                    'style' => 'font-size: x-small; gap: 10px',
                ]) ?>
            <?php endif; ?>
        </div>
        <hr>
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => 'my_items',
            'layout' => '<div class="row">{items}</div>{pager}',
            'options' => ['class' => 'list-view'],
            'itemOptions' => ['class' => 'col-lg-3 col-md-6 col-sm-6 col-md-6 col-sm-6 card-product'],
            'pager' => [
                'class' => \yii\bootstrap5\LinkPager::class,
                'options' => ['class' => 'mt-4 pagination justify-content-center'],
            ],
        ]) ?>
    </div>
</div>
