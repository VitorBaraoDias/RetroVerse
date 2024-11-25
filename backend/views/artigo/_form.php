<?php

use common\models\Comissao;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Artigo $model */
/** @var yii\widgets\ActiveForm $form */


$defaultComissao = Comissao::find()->where(['comissao' => 0])->one();
$defaultComissaoId = $defaultComissao ? $defaultComissao->id : null;
?>

<div class="artigo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput() ?>

    <?= $form->field($model, 'descricao')->textInput() ?>

    <?= $form->field($model, 'precoanuncio')->textInput() ?>

    <?= $form->field($model, 'idcomissao')->dropDownList(
        ArrayHelper::map(Comissao::find()->all(), 'id', 'comissao'),
        [
            'prompt' => 'Selecione a comissão',
            'value' => $model->idcomissao ?? $defaultComissaoId // Definir valor padrão
        ]
    )->label('Selecione a comissão', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'idestado')->dropDownList(ArrayHelper::map(\common\models\Estado::find()->all(), 'id', 'descricao'), ['prompt' => 'Selecione o estado']
    )->label('Selecione o estado do artigo', ['class' => 'custom-label-class']) ?>


    <?= $form->field($model, 'idmarca')->dropDownList(ArrayHelper::map(\common\models\Marca::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione a marca']
    )->label('Selecione a marca', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'idcategoria')->dropDownList(ArrayHelper::map(\common\models\Categoriaartigo::find()->all(), 'id', 'nome'), ['prompt' => 'Selecione a categoria']
    )->label('Selecione a categoria', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'idtamanho')->dropDownList(ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'), ['prompt' => 'Selecione o tamanho']
    )->label('Selecione o tamanho', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'ativo')->checkbox([
        'label' => 'Active',
        'uncheck' => 0,
        'checked' => 1,
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
