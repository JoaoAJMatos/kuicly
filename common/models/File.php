<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $file_type_id
 *
 * @property Course[] $courses
 * @property FileType $fileType
 * @property Lesson[] $lessons
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'path', 'file_type_id'], 'required'],
            [['file_type_id'], 'integer'],

            //[['name', 'path'], 'string', 'max' => 45],
            [['file_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FileType::class, 'targetAttribute' => ['file_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'path' => 'Path',
            'file_type_id' => 'File Type ID',
        ];
    }

    /**
     * Gets query for [[Courses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::class, ['file_id' => 'id']);
    }

    /**
     * Gets query for [[FileType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFileType()
    {
        return $this->hasOne(FileType::class, ['id' => 'file_type_id']);
    }

    /**
     * Gets query for [[Lessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLessons()
    {
        return $this->hasMany(Lesson::class, ['file_id' => 'id']);
    }

    /*public function upload()
    {
        if ($this->validate()) {
            $this->path->saveAs(\Yii::getAlias('@webroot').'/uploads/' . $this->path->baseName . '.' . $this->path->extension);

            return true;
        } else {
            return false;
        }
    }*/
}
