<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Estadoencomenda;

?>

            <tr>
                <td>1</td>
                <td><?= Html::encode($model->idartigo0->nome) ?></td>
                <td><?= Html::encode($model->idartigo0->idtamanho0->tamanho ?? 'Unknown Size') ?></td>
                <td><?= Html::encode($model->idartigo0->descricao ?? 'Unknown Description') ?></td>
                <td><?php if ($model->idartigo0->tipoartigo === 'MARKETPLACE'): ?>
                        <strong>
                            <?= $isPremium
                                ? Yii::$app->formatter->asCurrency($model->idartigo0->getPriceWithProposalIfExist(), 'EUR')
                                : $model->idartigo0->getPriceWithComissionFormated();
                            ?>€
                        </strong>
                    <?php endif; ?>
                </td>
            </tr>


