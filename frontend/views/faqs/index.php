<?php

use common\models\Faqs;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Faqs';
?>
<div class="container-fluid bg-light p-3">

<div class="faqs-index">

    <h2 class="text-center"><strong>FAQS</strong></h2>
    <h4 class="text-center">FREQUENTLY ASKED QUESTIONS</h4>


        <div class="d-flex justify-content-center">
            <div class="accordion" id="accordionFaqs">
                <?php foreach ($dataProvider->models as $index => $model): ?>
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header" id="heading-<?= $index ?>">
                            <button class="accordion-button collapsed bg-light text-dark fw-bold" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse-<?= $index ?>"
                                    aria-expanded="false"
                                    aria-controls="collapse-<?= $index ?>">
                                <?= Html::encode($model->questao) ?>
                            </button>
                        </h2>
                        <div id="collapse-<?= $index ?>"
                             class="accordion-collapse collapse"
                             aria-labelledby="heading-<?= $index ?>"
                             data-bs-parent="#accordionFaqs">
                            <div class="accordion-body">
                                <?= Html::encode($model->resposta) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>


</div>



</div>
