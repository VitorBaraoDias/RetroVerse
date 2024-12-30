<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Estadoencomenda;
?>
            <tr>
                <td><?= Html::encode($model->idvenda0->datavenda) ?></td>
                <td><?= Html::encode($model->idvendedor0->user->username) ?></td>
                <td><?= Html::encode($model->idartigo0->nome) ?></td>
                <td>1</td>
                <td><?= Html::encode($model->idartigo0->idtamanho0->tamanho ?? 'Unknown Size') ?></td>
                <td><?= Html::encode($model->idartigo0->precoanuncio ?? 'Unknown Price') ?>€</td>
            </tr>


