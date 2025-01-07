<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var \common\models\Faqs $model */

$this->title = $model->questao;

?>
<div class="faqs-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this FAQ?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'questao',
                'label' => 'Question'
            ],
            [
                'attribute' => 'resposta',
                'label' => 'Answer'
            ],
            [
                'attribute' => 'categoria',
                'label' => 'Category'
            ],
        ],
    ]) ?>

</div>
