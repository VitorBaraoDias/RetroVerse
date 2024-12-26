<?php

use common\models\Perfil;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Perfils';

$query = $model->getArtigos();
$dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => [
        'pageSize' => 6, // Define o número de itens por página
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
                    <h3><?= $model->user->username?></h3>
                    <div class="rounded-circle" style="background-color: #0000FF; height: 7px; width: 20px"></div>
                    <h3>Reviews</h3>
                    <?= Html::a('EDIT PROFILE', ['perfil/update', 'id' => Yii::$app->user->id], [
                        'class' => 'btn retroverse-btn',
                        'id' => 'retroverse-btn-active',
                        'style' => 'font-size: x-small; gap: 10px; padding: 5px',
                    ]) ?>

                </div>
                <div class="mt-4" style="word-break: break-all;"><?= $model->descricao?></div>
                <div class="d-flex justify-content-between mt-4">
                    <?= Html::a('EDIT PROFILE', ['perfil/update'], [
                        'class' => 'outline-black-retroverse-btn',
                        'style' => 'font-size: x-small; margin-left: 0',
                    ]) ?>
                    <?= Html::a('EDIT PROFILE', ['perfil/update'], [
                        'class' => 'outline-black-retroverse-btn',
                        'style' => 'font-size: x-small; margin-left: 0',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-lg-4 p-4 card mt-5 mt-lg-0">
            <div class="d-flex justify-content-between" style="gap: 50px">
                <span>EARNINGS AND STATS</span>
                <?= Html::a('HISTORY', ['venda/index'], [
                    'class' => 'btn retroverse-btn',
                    'id' => 'retroverse-btn-active',
                    'style' => 'font-size: x-small; gap: 10px; padding: 10px',
                ]) ?>
            </div>
            <div class="d-flex justify-content-between px-4 mt-5">
                <div class="d-flex flex-column align-items-center">
                    <span>can earn up to</span>
                    <strong>5</strong>
                </div>
                <div class="d-flex flex-column align-items-center">
                    <span>total earnings</span>
                    <strong>5</strong>

                </div>
            </div>
        </div>
    </div>
    <div class="mx-5 mt-5" style="margin-left: 90px; margin-top:10px">
        <div class="d-flex justify-content-between">
            <h2><strong>MY ITENS</strong></h2>
                <?= Html::a('+ PUBLISH AN ITEM', ['perfil/update'], [
                'class' => 'btn retroverse-btn  w-auto px-3 py-2 rounded-0',
                'id' => 'retroverse-btn-active',
                'style' => 'font-size: x-small; gap: 10px',
            ]) ?>
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
