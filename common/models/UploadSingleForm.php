<?php

namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadSingleForm extends Model
{
    /**
     * @var UploadedFile     */
    public $imageFile;
    public $imagePaths = [];
    public $backendUploadDir;
    public $frontendUploadDir;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
        ];
    }
    public function upload()
    {
        if (!$this->backendUploadDir || !$this->frontendUploadDir) {
            throw new \Exception('Os diretórios de upload não foram configurados.');
        }

        if (!is_dir($this->backendUploadDir)) {
            mkdir($this->backendUploadDir, 0775, true);
        }
        if (!is_dir($this->frontendUploadDir)) {
            mkdir($this->frontendUploadDir, 0775, true);
        }

        $files = is_array($this->imageFile) ? $this->imageFile : [$this->imageFile];
        foreach ($files as $file) {
            $fileName = uniqid() . '.' . $file->extension;
            $frontendFilePath = $this->frontendUploadDir . $fileName;
            $backendFilePath = $this->backendUploadDir . $fileName;

            if ($file->saveAs($frontendFilePath)) {
                copy($frontendFilePath, $backendFilePath);
                $this->imagePaths[] = $fileName;
            } else {
                return "O PROBLEMA ESTA AQUI";
            }
        }

        return true;
    }

    /**
     * Deleta imagens antigas, se existirem.
     *
     * @param array|string $paths Caminho(s) para deletar.
     */
    public function deleteImageIfExist($paths)
    {
        $paths = (array)$paths; // Garante que sempre seja um array

        foreach ($paths as $path) {
            $filePathFrontend = $this->frontendUploadDir . $path;
            $filePathBackend = $this->backendUploadDir . $path;

            if ($path && file_exists($filePathFrontend)) {
                unlink($filePathFrontend);
            }

            if ($path && file_exists($filePathBackend)) {
                unlink($filePathBackend);
            }
        }
    }
}

