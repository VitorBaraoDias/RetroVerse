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
        $uploadDir = Yii::getAlias('@imageurl/img-artigos/');

        if ($this->validate()) {
            foreach ($this->imageFiles as $file) {

                //idunico
                $fileName = uniqid()  . '.' . $file->extension;
                $filePath = $uploadDir .  $fileName;

                if ($file->saveAs($filePath)) {
                    $fotoModel = new Fotosartigo();
                    $fotoModel->idartigo = $id;
                    $fotoModel->caminhofoto =  $fileName;
                    $fotoModel->save(false);
                }
            }
            return true;
        }
        return false;
    }
    public function removeFoto($fileName)
    {
        $uploadDir = Yii::getAlias('@imageurl/img-artigos/');
        $filePath = $uploadDir . $fileName;
        if (file_exists($filePath)) {
            return unlink($filePath);
        }
        return false;
    }
}