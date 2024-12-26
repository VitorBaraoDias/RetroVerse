<div class="conversa-form">

    <?php use yii\bootstrap5\ActiveForm;
    use yii\bootstrap5\Html;

    $form = ActiveForm::begin([
        'action' => ['conversa/create', 'id' => $idchat],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div id="mensagem-texto" style="display: block;">
        <?= $form->field($modelTexto, 'descricao')->textarea(['rows' => 3]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

