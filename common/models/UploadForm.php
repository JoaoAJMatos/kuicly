<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $videoFile;
    public $fileName;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, mp4, mkv','maxSize' => 500 * 1024 * 1024],
            //[['videoFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, mp4, mkv'],
            [['fileName'], 'string', 'max' => 255],

        ];
    }

    public function upload()
    {


        if ($this->validate()) {
            if (function_exists('com_create_guid') === true) {
                $this->fileName = trim(com_create_guid(), '{}') . '.' . $this->imageFile->extension;
            }
            $this->imageFile->saveAs(\Yii::getAlias('@webroot').'/uploads/' . $this->fileName);

            return true;
        } else {

            return false;
        }
    }
}