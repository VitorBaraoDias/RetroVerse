<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */


$this->title = 'Faqs';
?>

<div class="faqs-index">
    <div class="faqs-banner">
        <img src="<?= Yii::getAlias('@web') ?>/img/breadcrumb-bg.jpg">
    </div>

    <div class="faqs-container">
        <div class="py-5 text-center container-fluid">
            <h2 class="text-center"><strong>FAQS</strong></h2>
            <h5 class="text-center">FREQUENTLY ASKED QUESTIONS</h5>

        <div class="accordion-faqs">
            <div class="d-flex justify-content-center">
                <div class="accordion w-50" id="accordionFaqs">
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
</div>





