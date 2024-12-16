<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile     */
    public $imageFile;
    public  $imagepath;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 4],
        ];
    }
    public function upload()
    {
        // Diretório para o frontend
        $frontendUploadDir = Yii::getAlias('@frontend/web/uploads/img-profile/');

        // Certificar-se de que o diretório existe, caso contrário, criá-lo
        if (!is_dir($frontendUploadDir)) {
            mkdir($frontendUploadDir, 0775, true);
        }
            $fileName = uniqid() . '.' . $this->imageFile->extension;
            $frontendFilePath = $frontendUploadDir . $fileName;

            if ($this->imageFile->saveAs($frontendFilePath)) {
                $this->imagepath = $fileName;
                return true;
            }


        // Se a validação falhar, retornar false
        return false;
    }
    public function deleteProfileImageIfExist($path){
        $filePath = Yii::getAlias('@frontend/web/uploads/img-profile/') . $path;
        if ($path && file_exists($filePath)) {
            unlink($filePath);
        }
    }
}

