<?php

use common\models\Artigo;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Artigos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artigo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Artigo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'datacriacao',
            'nome',
            'descricao',
            'precoanuncio',
            //'idcomissao',
            //'idestado',
            //'idmarca',
            //'idcategoria',
            //'idtamanho',
            //'idperfil',
            //'tipoartigo',
            //'ativo',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Artigo $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
