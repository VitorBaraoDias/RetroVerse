<?php

namespace backend\controllers;

use backend\models\UserForm;
use common\models\User;
use common\models\Perfil;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
                            'actions' => ['index','create','view','delete', 'demote','promote', 'ban'],
                            'allow' => true,
                            'roles' => ['admin'],
                        ],
                    ],
                    'denyCallback' => function ($rule, $action) {
                        throw new \yii\web\ForbiddenHttpException('You do not have permission to access this page.');
                    },
                ],
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'logout' => ['post'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchQuery = Yii::$app->request->get('searchQuery', null);

        $query = User::find()
            ->joinWith('perfil')
            ->where(['banido' => 0]);


        if (!empty($searchQuery)) {
            $query->andFilterWhere(['or',
                ['like', 'username', $searchQuery],
                ['like', 'email', $searchQuery],
            ]);
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 6,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchQuery' => $searchQuery,
        ]);
    }

    /**
     * Displays a single User model.
     * @param int $id
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new UserForm();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->createUser()) {
                return $this->redirect('index');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
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
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDemote($id){
        $model = $this->findModel($id);
        $auth = Yii::$app->authManager;

        $auth->revokeAll($model->id);
        $moderator = $auth->getRole('membro');

        // Atribui o papel 'moderador' ao utilizador
        $auth->assign($moderator, $model->id);

        return $this->redirect('index');
    }


    public function actionPromote($id){
        $model = $this->findModel($id);
        $auth = Yii::$app->authManager;

        $auth->revokeAll($model->id);
        $moderator = $auth->getRole('moderador');

        $auth->assign($moderator, $model->id);

        return $this->redirect('index');
    }

    public function actionBan($id)
    {
        $perfil = Perfil::findOne(['id' => $id]);

        if (!$perfil) {
            Yii::$app->response->statusCode = 404;
            return [
                'status' => 'error',
                'message' => 'User profile not found',
            ];
        }

        $perfil->banido = 1;

        if ($perfil->save()) {
            return $this->redirect('index');
        } else {
            Yii::$app->response->statusCode = 500;
            return [
                'status' => 'error',
                'message' => 'Error banning user',
                'errors' => $perfil->errors,
            ];
        }
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
