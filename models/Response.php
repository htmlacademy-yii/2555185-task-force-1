<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "response".
 *
 * @property int $id
 * @property string|null $date_add
 * @property int|null $budget
 * @property string|null $comment
 * @property int $task_id
 * @property int $performer_id
 * @property int|null $is_rejected
 *
 * @property User $performer
 * @property Task $task
 */
class Response extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'response';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['budget', 'comment'], 'default', 'value' => null],
            [['is_rejected'], 'default', 'value' => 0],
            [['date_add'], 'safe'],
            [['budget', 'task_id', 'performer_id', 'is_rejected'], 'integer'],
            [['comment'], 'string'],
            [['task_id', 'performer_id'], 'required'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'task_id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date_add' => 'Date Add',
            'budget' => 'Budget',
            'comment' => 'Comment',
            'task_id' => 'Task ID',
            'performer_id' => 'Performer ID',
            'is_rejected' => 'Is Rejected',
        ];
    }

    /**
     * Gets query for [[Performer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformer()
    {
        return $this->hasOne(User::className(), ['user_id' => 'performer_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['task_id' => 'task_id']);
    }

}
