<?php

namespace backend\models;

use common\models\Fotosartigo;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
        ];
    }

    public function upload($id)
    {
        // Diretório para o backend
        $backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');

        // Diretório para o frontend
        $frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');

        // Certificar-se de que as pastas existem, se não, criá-las
        if (!is_dir($backendUploadDir)) {
            mkdir($backendUploadDir, 0775, true);
        }
        if (!is_dir($frontendUploadDir)) {
            mkdir($frontendUploadDir, 0775, true);
        }

        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                // Gerar um nome único para o arquivo
                $fileName = uniqid() . '.' . $file->extension;

                // Caminho para salvar no backend
                $backendFilePath = $backendUploadDir . $fileName;

                // Caminho para salvar no frontend
                $frontendFilePath = $frontendUploadDir . $fileName;

                // Salvar nos dois locais
                if ($file->saveAs($backendFilePath)) {
                    copy($backendFilePath, $frontendFilePath);

                    // Salvar o registro no banco de dados
                    $fotoModel = new Fotosartigo();
                    $fotoModel->idartigo = $id;
                    $fotoModel->caminhofoto = $fileName;
                    $fotoModel->save(false);
                }
            }
            return true;
        }
        return false;
    }

    public function removeFoto($fileName)
    {
        $backendUploadDir = Yii::getAlias('@imageurl/img-artigos/');
        $frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-artigos/');

        $backendFilePath = $backendUploadDir . $fileName;
        $frontendFilePath = $frontendUploadDir . $fileName;

        // Remover a foto do backend
        if (file_exists($backendFilePath)) {
            unlink($backendFilePath);
        }

        // Remover a foto do frontend
        if (file_exists($frontendFilePath)) {
            unlink($frontendFilePath);
        }

        return true;
    }
}
