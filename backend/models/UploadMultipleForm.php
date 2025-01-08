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
        if (!$this->backendUploadDir || !$this->frontendUploadDir) {
            throw new \Exception("Os diretórios de upload não foram configurados.");
        }

        if (!is_dir($this->backendUploadDir)) {
            mkdir($this->backendUploadDir, 0775, true);
        }
        if (!is_dir($this->frontendUploadDir)) {
            mkdir($this->frontendUploadDir, 0775, true);
        }

        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {
                $fileName = uniqid() . '.' . $file->extension;

                $backendFilePath = $this->backendUploadDir . DIRECTORY_SEPARATOR . $fileName;

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

        $result = true;

        if (file_exists($backendFilePath)) {
            if (!unlink($backendFilePath)) {
                Yii::error("Failed to delete backend file: " . $backendFilePath);
                $result = false;
            }
        } else {
            Yii::error("Backend file not found: " . $backendFilePath);
        }

        if (file_exists($frontendFilePath)) {
            if (!unlink($frontendFilePath)) {
                Yii::error("Failed to delete frontend file: " . $frontendFilePath);
                $result = false;
            }
        } else {
            Yii::error("Frontend file not found: " . $frontendFilePath);
        }

        return $result;
    }

}

