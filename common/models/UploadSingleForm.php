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
        // Certifica-se de que os diretórios estão configurados
        if (!$this->backendUploadDir || !$this->frontendUploadDir) {
            throw new \Exception('Os diretórios de upload não foram configurados.');
        }

        // Certifica-se de que os diretórios existem
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
                $this->imagePaths[] = $fileName; // Adiciona o caminho ao array de imagens
            } else {
                return false; // Se qualquer upload falhar, retorna falso
            }
        }

        return true; // Todos os uploads foram bem-sucedidos
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

