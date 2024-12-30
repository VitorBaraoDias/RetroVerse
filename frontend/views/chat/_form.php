<div class="chat-form">

    <?php use yii\bootstrap5\ActiveForm;
    use yii\bootstrap5\Html;

     $form = ActiveForm::begin([
        'action' => ['chat/create', 'id' => $idchat],
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <div id="input-details" style="display: block;">
        <?= $form->field($modelTexto, 'descricao')->textInput(['rows' => 3]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script>
    document.getElementById('conversa-tipo').addEventListener('change', function() {
        var tipo = this.value;
        document.getElementById('mensagem-texto').style.display = (tipo === 'texto') ? 'block' : 'none';
        document.getElementById('mensagem-imagem').style.display = (tipo === 'imagem') ? 'block' : 'none';
        document.getElementById('mensagem-proposta').style.display = (tipo === 'proposta') ? 'block' : 'none';
    });
</script>
