<?php
// Verifica se o id do usuário logado é o mesmo do id do usuário da mensagem
if (Yii::$app->user->identity && Yii::$app->user->identity->id === $model->iduser): ?>
    <div class="chat outgoing">
        <div class="details">
            <p><?=$model->mensagem->descricao ?></p>
        </div>
    </div>
<?php else: ?>
    <div class="chat incoming">
        <div class="details">
            <p><?=$model->mensagem->descricao ?></p>
        </div>
    </div>
<?php endif; ?>
