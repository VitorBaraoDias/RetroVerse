<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\Conversa;
use common\models\Listachats;
use common\models\Mensagemtexto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ChatController implements the CRUD actions for Chat model.
 */
class ChatController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'access' => [
                    'class' => AccessControl::class,
                    'rules' => [
                        [
                            'actions' => ['index','view', 'create'],
                            'allow' => true,
                            'roles' => ['membro'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        return Yii::$app->response->redirect(['site/login']);
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex()
    {
        if (Yii::$app->user->can('verChatFrontend')) {
            $idUser = Yii::$app->user->id;

            $query = Listachats::find()
                ->where(['idremetente' => $idUser])
                ->orWhere(['iddestinatario' => $idUser])
                ->orderBy('id DESC');

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);

            //buscar todos os chats do user
            return $this->render('index', [
                'dataProvider' => $dataProvider,
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    public function actionView($id)
    {
        if (Yii::$app->user->can('verDetalhesChatFrontend')) {
            $chatAtual = Listachats::findOne($id);
            $artigo = Artigo::findOne($chatAtual->idartigo);

            $idVisitante = Yii::$app->user->identity->id;


            if (is_null($chatAtual)) {
                die('erro');
            }
            $query = Listachats::find()
                ->where(['idremetente' => $idVisitante])
                ->orWhere(['iddestinatario' => $idVisitante])
                ->andWhere(['!=', 'id', $chatAtual->id])
                ->orderBy('id DESC');

            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);


            return $this->render('view', [
                'artigo' => $artigo,
                'chatAtual' => $chatAtual,
                'dataProvider' => $dataProvider,
                'modelConversa' => new Conversa(),
                'modelTexto' => new Mensagemtexto(),
            ]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }

    public function actionCreate($id)
    {
        if (Yii::$app->user->can('criarChatFrontend')) {
            $artigo = Artigo::findOne($id);

            if ($artigo === null) {
                throw new \yii\web\NotFoundHttpException('Item not found.');
            }

            $idVendedor = $artigo->idperfil;
            $idVisitante = Yii::$app->user->id;

            $chatAtual = Listachats::find()
                ->where([
                    'idremetente' => $idVisitante,
                    'iddestinatario' => $idVendedor,
                    'idartigo' => $artigo->id
                ])
                ->orWhere([
                    'idremetente' => $idVendedor,
                    'iddestinatario' => $idVisitante,
                    'idartigo' => $artigo->id
                ])
                ->one();

            if (is_null($chatAtual)) {
                $chatAtual = new Listachats();
                $chatAtual->idremetente = $idVisitante;
                $chatAtual->iddestinatario = $idVendedor;
                $chatAtual->idartigo = $artigo->id;
                $chatAtual->save();
            }

            return $this->redirect(['view', 'id' => $chatAtual->id]);
        } else {
            return Yii::$app->response->redirect(['site/login']);
        }
    }


    protected function findModel($id)
    {
        if (($model = Listachats::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
