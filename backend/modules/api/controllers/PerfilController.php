<?php

namespace backend\modules\api\controllers;

use common\models\Favorito;
use common\models\Perfil;
use common\models\Artigo;
use common\models\Linhavenda;
use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;
use backend\modules\api\components\CustomAuth;
use yii\web\ForbiddenHttpException;

/**
 * Default controller for the `api` module
 */
class PerfilController extends ActiveController
{
    public $modelClass = 'common\models\Perfil';
    public $user = null;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CustomAuth::className(),
            'auth' => [$this, 'authCustom'],
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->request->method !== 'GET' && Yii::$app->request->method !== 'PUT') {

            Yii::$app->response->statusCode = 405;
            Yii::$app->response->data = [
                'message' => 'THIS METHOD IS NOT ALLOWED!'
            ];
            return false;
        }
        return true;
    }

    public function authCustom($token)
    {
        $user_ = \common\models\User::findIdentityByAccessToken($token);
        if($user_) {
            $this->user=$user_;
            return $user_;
        }
        throw new \yii\web\ForbiddenHttpException('No authentication');
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        if ($this->user) {
            if ($action === 'index' && $this->user->id != 1) {
                throw new ForbiddenHttpException('You don´t have permission to do this action!');
            }

            if ($action === 'update' && $model->id !== $this->user->id ) {
                throw new ForbiddenHttpException('You do not have permission to do this action!');
            }

        } else {
            throw new ForbiddenHttpException('User not authenticated.');
        }
    }

    public function actionVerperfiluser()
    {
        $perfil = Perfil::findOne($this->user->id);

        if (!$perfil) {
            throw new NotFoundHttpException('Profile not found.');
        }

        $artigosPublicados = $perfil->hasMany(Artigo::class, ['idperfil' => 'id'])
            ->andWhere(['ativo' => 1])
            ->all();

        $linhasVenda = \common\models\LinhaVenda::find()
            ->where(['idvendedor' => $perfil->id])
            ->all();

        $artigosVendidosData = [];
        foreach ($linhasVenda as $linhaVenda) {
            $artigo = $linhaVenda->idartigo0;

            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }

            if ($artigo) {
                $artigosVendidosData[] = [
                    'id' => $artigo->id,
                    'datacriacao' => Yii::$app->formatter->asDate($artigo->datacriacao, 'dd/MM/yyyy'),
                    'nome' => $artigo->nome,
                    'descricao' => $artigo->descricao,
                    'precoanuncio' => $artigo->precoanuncio,
                    'comissao' => $artigo->idcomissao0 ? $artigo->idcomissao0->comissao : null,
                    'estado' => $artigo->idestado0 ? $artigo->idestado0->descricao : null,
                    'marca' => $artigo->idmarca0 ? $artigo->idmarca0->nome : null,
                    'categoria' => $artigo->idcategoria0 ? $artigo->idcategoria0->nome : null,
                    'tamanho' => $artigo->idtamanho0 ? $artigo->idtamanho0->tamanho : null,
                    'tipoartigo' => $artigo->tipoartigo,
                    'fotos' => $fotos,
                ];
            }
        }

        $artigosPublicadosData = [];
        foreach ($artigosPublicados as $artigo) {

            $fotos = [];
            foreach ($artigo->fotosartigos as $foto) {
                $fotos[] = $foto->caminhofoto;
            }

            $artigosPublicadosData[] = [
                'id' => $artigo->id,
                'datacriacao' => Yii::$app->formatter->asDate($artigo->datacriacao, 'dd/MM/yyyy'),
                'nome' => $artigo->nome,
                'descricao' => $artigo->descricao,
                'precoanuncio' => $artigo->precoanuncio,
                'comissao' => $artigo->idcomissao0 ? $artigo->idcomissao0->comissao : null,
                'estado' => $artigo->idestado0 ? $artigo->idestado0->descricao : null,
                'marca' => $artigo->idmarca0 ? $artigo->idmarca0->nome : null,
                'categoria' => $artigo->idcategoria0 ? $artigo->idcategoria0->nome : null,
                'tamanho' => $artigo->idtamanho0 ? $artigo->idtamanho0->tamanho : null,
                'tipoartigo' => $artigo->tipoartigo,
                'fotos' => $fotos,
            ];
        }

        return [
            'id' => $perfil->id,
            'username' => $perfil->user->username,
            'descricao' => $perfil->descricao,
            'caminhofotoperfil' => $perfil->caminhofotoperfil,
            'morada' => $perfil->morada,
            'saldo' => $perfil->saldo,
            'saldopendente' => $perfil->saldopendente,
            'banido' => $perfil->banido,
            'artigospublicados' => !empty($artigosPublicadosData) ? $artigosPublicadosData : null,
            'artigosvendidos' => !empty($artigosVendidosData) ? $artigosVendidosData : null,
        ];
    }



    public function actionEditarperfil($id)
    {
        $perfil = Perfil::findOne($id);

        $this->checkAccess('update', $perfil);

        if (!$perfil) {
            throw new NotFoundHttpException('Profile not found.');
        }


        $perfil->setScenario('updateProfile');

        $perfil->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($perfil->save()) {
            return [
                'success' => true,
                'message' => 'Profile updated successfully!',
            ];
        } else {
            return $this->asJson(['errors' => $perfil->errors]);
        }
    }
}
