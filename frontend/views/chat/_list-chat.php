<?php
$perfil = $model->getDestinatarioOuRemetente();

use yii\helpers\Url;
use yii\bootstrap5\Html;
?>

<?= Html::a(
// Conteúdo interno do link
    '<div>
        ' . (!empty($perfil->caminhofotoperfil) ?
        '<img class="rounded-circle" style="object-fit: cover; width: 60px" 
              src="' . Yii::getAlias('@web') . '/uploads/img-profile/' . $perfil->caminhofotoperfil . '" 
              alt="Foto de Perfil" height="60">' :
        '<img class="" src="' . Yii::getAlias('@web') . '/img/icon-profile.svg" alt="Ícone de Perfil" height="70">') . '
    </div>
    <div class="d-flex flex-column">
        <h4><strong>' . Html::encode($perfil->user->username) . '</strong></h4>
        <p>Comentário</p>
        ' . (
    ($firstPhoto = $model->artigo->fotosartigos[0] ?? null) &&
    file_exists(Yii::getAlias('@frontend/web/uploads/img-artigos/') . $firstPhoto->caminhofoto) ?
        Html::img(Yii::getAlias('@web/uploads/img-artigos/') . $firstPhoto->caminhofoto, [
            'alt' => 'Article Image',
            'class' => '',
            'style' => 'width: 40px; height: 60px; object-fit: contain;',
        ]) :
        Html::tag('div', '', [
            'class' => 'img-thumbnail',
            'style' => 'width: 40px; height: 40px; background-color: grey; display: flex; align-items: center; justify-content: center;',
        ])
    ) . '
    </div>',
    // URL do link
    ['chat/view', 'id' => $model->id],
    // Opções do link
    ['class' => 'w-100 d-flex px-4 py-3 gap-3', 'style' => 'background: #F5F5F5; text-decoration: none; color: inherit;']
) ?>
