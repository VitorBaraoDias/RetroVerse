<?php

use common\models\Comissao;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var \common\models\Artigo $model */
/** @var yii\widgets\ActiveForm $form */


$defaultComissao = Comissao::find()->where(['comissao' => 0])->one();
$defaultComissaoId = $defaultComissao ? $defaultComissao->id : null;
?>

<div class="artigo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput()->label("Name") ?>

    <?= $form->field($model, 'descricao')->textInput()->textInput()->label("Description") ?>

    <?= $form->field($model, 'precoanuncio')->textInput()->textInput()->label("Price") ?>

    <?= $form->field($model, 'idcomissao')->dropDownList(
        ArrayHelper::map(Comissao::find()->all(), 'id', 'comissao'),
        [
            'prompt' => 'Select the comission',
            'value' => $model->idcomissao ?? $defaultComissaoId
        ]
    )->label('Comission', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'idestado')->dropDownList(ArrayHelper::map(\common\models\Estado::find()->all(), 'id', 'descricao'), ['prompt' => 'Select the condition']
    )->label('Condition', ['class' => 'custom-label-class']) ?>


    <?= $form->field($model, 'idmarca')->dropDownList(
        ArrayHelper::map(\common\models\Marca::find()->where(['ativo' => 1])->all(), 'id', 'nome'),
        ['prompt' => 'Select the brand']
    )->label('Brand', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'idcategoria')->dropDownList(
        ArrayHelper::map(\common\models\Categoriaartigo::find()->where(['ativo' => 1])->all(), 'id', 'nome'),
        ['prompt' => 'Select the category']
    )->label('Category', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'idtamanho')->dropDownList(ArrayHelper::map(\common\models\Tamanho::find()->all(), 'id', 'tamanho'), ['prompt' => 'Select the size']
    )->label('Size', ['class' => 'custom-label-class']) ?>

    <?= $form->field($model, 'ativo')->checkbox([
        'label' => 'Active',
        'uncheck' => 0,
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
