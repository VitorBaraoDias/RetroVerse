<?php

namespace backend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{


    public function actionCreate()
    {
        $model = new User();

        // Receber os dados enviados no POST
        $data = Yii::$app->request->post();

        die($data);
        // Carregar os dados no modelo
        if ($model->load($data, '') && $model->save()) {
            // Se o modelo salvar com sucesso, retorne os dados
            return [
                'success' => true,
                'data' => $model,
            ];
        }

        // Se falhar, retornar os erros de validação
        Yii::$app->response->statusCode = 422;
        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }


}