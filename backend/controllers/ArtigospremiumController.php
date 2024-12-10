<?php

namespace backend\controllers;

<<<<<<< HEAD
use Yii;
=======
>>>>>>> 6981a9ceabea1ba976ed3fb9ae0ff498a4f6d5df
use common\models\Artigospremium;
use common\models\Plano;
use common\models\Artigo;
use app\models\SearchArtigopremium;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

<<<<<<< HEAD

=======
>>>>>>> 6981a9ceabea1ba976ed3fb9ae0ff498a4f6d5df
/**
 * ArtigospremiumController implements the CRUD actions for Artigospremium model.
 */
class ArtigospremiumController extends Controller
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
     * Lists all Artigospremium models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchArtigopremium();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Artigospremium model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Artigospremium model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate($id)
    {
<<<<<<< HEAD
=======
        $model = new Artigospremium();

        $planos = Plano::find()->all();

>>>>>>> 6981a9ceabea1ba976ed3fb9ae0ff498a4f6d5df
        // Verificar se o artigo com o ID existe
        $artigo = Artigo::findOne($id);
        if (!$artigo) {
            // Se o artigo não existir, retornar erro ou redirecionar
            Yii::$app->session->setFlash('error', 'Artigo não encontrado.');
<<<<<<< HEAD
            return $this->redirect(['artigo/index']);
        }

        // Obter um plano ativo (se houver)
        $planoAtivo = Plano::find()->where(['ativo' => 1])->one();
        if (!$planoAtivo) {
            Yii::$app->session->setFlash('error', 'Nenhum plano ativo encontrado para associação.');
            return $this->redirect(['artigo/index']);
        }

        // Criar o registro de Artigospremium
        $model = new Artigospremium();
        $model->id = $id;
        $model->idPlano = $planoAtivo->id; // Associar ao plano ativo

        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Plano associado ao artigo com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao associar o plano ao artigo.');
        }

        // Redirecionar para artigo/index
        return $this->redirect(['artigo/index']);
    }



=======
            return $this->redirect(['artigo/index']); // Ou qualquer outra ação
        }

        // Preencher o ID do artigo no modelo de Artigospremium
        $model->id = $id;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['artigo/index']);
        }

        return $this->render('create', [
            'model' => $model,
            'idartigo' => $id,
            'planos' => $planos
        ]);
    }


>>>>>>> 6981a9ceabea1ba976ed3fb9ae0ff498a4f6d5df
    /**
     * Updates an existing Artigospremium model.
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
     * Deletes an existing Artigospremium model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['artigo/index']);
    }

    /**
     * Finds the Artigospremium model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Artigospremium the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Artigospremium::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
