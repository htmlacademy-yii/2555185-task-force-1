<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $file_id
 * @property string $path
 * @property int|null $id_task
 *
 * @property Task $task
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
            [['id_task'], 'default', 'value' => null],
            [['path'], 'required'],
            [['id_task'], 'integer'],
            [['path'], 'string', 'max' => 255],
            [['id_task'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['id_task' => 'task_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'file_id' => 'File ID',
            'path' => 'Path',
            'id_task' => 'Id Task',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['task_id' => 'id_task']);
    }

}
