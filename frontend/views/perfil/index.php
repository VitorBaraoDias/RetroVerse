<?php

use common\models\Perfil;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Perfils';
?>
<div class="perfil-index container-md">
    <h1><strong>PROFILE</strong></h1>
    <div class="row mt-4">
        <div class="d-flex col-md-6">
            <img src="<?= Yii::getAlias('@web') ?>/img/icon-profile.svg" alt="" height="140">
            <div class="">
                <div class="d-flex gap-4 align-items-center">
                    <h3>Username</h3>
                    <h3>Reviews</h3>
                    <?= Html::a('EDIT PROFILE', ['perfil/update'], [
                        'class' => 'btn retroverse-btn',
                        'id' => 'retroverse-btn-active',
                        'style' => 'font-size: x-small; gap: 10px',
                    ]) ?>
                </div>
                <p class="text-wrap">descriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescription</p>
                <div>
                    <?= Html::a('EDIT PROFILE', ['perfil/update'], [
                        'class' => 'outline-black-retroverse-btn',
                        'style' => 'font-size: x-small; gap: 10px',
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6"></div>

    </div>

</div>
