<?php

namespace backend\models;

use common\models\Fotosartigo;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadMultipleForm extends Model
{
    /**
     * @var UploadedFile[]
     */

    public $imageFiles;

    /**
     * Diretórios de destino
     */
    public $backendUploadDir;
    public $frontendUploadDir;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
        ];
    }

    public function upload($id = null, $saveToDatabase = true)
    {
        // validar os diretórios de upload
        if (!$this->backendUploadDir || !$this->frontendUploadDir) {
            throw new \Exception("Os diretórios de upload não foram configurados.");
        }

        // verificar existencia
        if (!is_dir($this->backendUploadDir)) {
            mkdir($this->backendUploadDir, 0775, true);
        }
        if (!is_dir($this->frontendUploadDir)) {
            mkdir($this->frontendUploadDir, 0775, true);
        }

        // validar as imagens
        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                // Gerar um nome único para o arquivo
                $fileName = uniqid() . '.' . $file->extension;

                // dir salvar back
                $backendFilePath = $this->backendUploadDir . DIRECTORY_SEPARATOR . $fileName;

                // dir salvar front
                $frontendFilePath = $this->frontendUploadDir . DIRECTORY_SEPARATOR . $fileName;

                if ($file->saveAs($backendFilePath)) {
                    copy($backendFilePath, $frontendFilePath);

                    if ($saveToDatabase && $id !== null) {
                        $fotoModel = new Fotosartigo();
                        $fotoModel->idartigo = $id;
                        $fotoModel->caminhofoto = $fileName;
                        $fotoModel->save(false);
                    }
                }
            }
            return true;
        }
        return false;
    }

    public function removeFoto($fileName)
    {
        if (!$this->backendUploadDir || !$this->frontendUploadDir) {
            throw new \Exception("Os diretórios de upload não foram configurados.");
        }

        $backendFilePath = $this->backendUploadDir . DIRECTORY_SEPARATOR . $fileName;
        $frontendFilePath = $this->frontendUploadDir . DIRECTORY_SEPARATOR . $fileName;

        if (file_exists($backendFilePath)) {
            unlink($backendFilePath);
        }

        if (file_exists($frontendFilePath)) {
            unlink($frontendFilePath);
        }

        return true;
    }
}

