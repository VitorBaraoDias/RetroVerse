<div class="conversa-form">

    <?php use yii\bootstrap5\ActiveForm;
    use yii\bootstrap5\Html;

    $form = ActiveForm::begin([
        'action' => ['conversa/create', 'id' => $idchat],
        'options' => [
            'enctype' => 'multipart/form-data',
            'class' => ''
        ],
    ]); ?>
    <div class="input-details m-0" style="display: relative;">
        <?= $form->field($modelTexto, 'descricao')->textInput([
            'placeholder' => 'Send me a message...',
        ])->label(false) ?>
        <?= Html::submitButton('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
      <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z"/>
    </svg>', [
            'class' => 'btn retroverse-btn active w-auto mt-3 px-3 py-1 rounded-3',
            'id' => "retroverse-btn-active",
            'style' => '    position: absolute;
    right: 8px;
    top: -10px;'
        ]) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>

