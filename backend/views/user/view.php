<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = "User details:" . $model->id;
?>
<div class="user-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
