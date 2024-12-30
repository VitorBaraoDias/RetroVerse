<?php

namespace frontend\controllers;

use common\models\Artigo;
use common\models\Conversa;
use common\models\Listachats;
use common\models\Mensagenstexto;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Chat models.
     *
     * @return string
     */
    public function actionIndex()
    {
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
    }

    /**
     * Displays a single Chat model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $chatAtual = Listachats::findOne($id);
        $artigo = Artigo::findOne($chatAtual->idartigo);

        $idVisitante = Yii::$app->user->identity->id;


        // Cria o chat se não existir
        if (is_null($chatAtual)) {
            die('erro');
        }
        $query = Listachats::find()
            ->where(['idremetente' => $idVisitante])
            ->orWhere(['iddestinatario' => $idVisitante])
            ->andWhere(['!=', 'id', $chatAtual->id]) // Exclui o chat atual da lista
            ->orderBy('id DESC'); // Mantém a ordem mais recente no topo

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // Renderiza a view passando o artigo, o chat e o DataProvider
        return $this->render('view', [
            'artigo' => $artigo,
            'chatAtual' => $chatAtual,
            'dataProvider' => $dataProvider, // DataProvider para as conversas
            'modelConversa' => new Conversa(),
            'modelTexto' => new Mensagenstexto(),
        ]);
    }

    /**
     * Creates a new Chat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
        $artigo = Artigo::findOne($id);

        if ($artigo === null) {
            throw new \yii\web\NotFoundHttpException('Artigo não encontrado.');
        }

        $idVendedor = $artigo->idperfil;
        $idVisitante = Yii::$app->user->id;

        // Verifica se já existe um chat entre o vendedor e o visitante
        $chatAtual = Listachats::find()
            ->where([
                'idremetente' => $idVisitante,
                'iddestinatario' => $idVendedor
            ])
            ->orWhere([
                'idremetente' => $idVendedor,
                'iddestinatario' => $idVisitante
            ])
            ->one();

        // Cria o chat se não existir
        if (is_null($chatAtual)) {
            $chatAtual = new Listachats();
            $chatAtual->idremetente = $idVisitante;
            $chatAtual->iddestinatario = $idVendedor;
            $chatAtual->idartigo = $artigo->id;
            $chatAtual->save();
        }

        //temos a certeza que possui um chato, entao redeciona para o actionView
        return $this->redirect(['view', 'id' => $chatAtual->id]);
    }

    /**
     * Updates an existing Chat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Chat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Chat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Listachats the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Listachats::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
