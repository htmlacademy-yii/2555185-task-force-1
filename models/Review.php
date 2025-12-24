<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property string|null $date_add
 * @property string $text
 * @property int $score
 * @property int $task_id
 * @property int $employer_id
 * @property int $performer_id
 * @property string|null $review_name
 * @property string|null $review_icon
 *
 * @property User $employer
 * @property User $performer
 * @property Task $task
 */
class Review extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['review_name', 'review_icon'], 'default', 'value' => null],
            [['date_add'], 'safe'],
            [['text', 'score', 'task_id', 'employer_id', 'performer_id'], 'required'],
            [['score', 'task_id', 'employer_id', 'performer_id'], 'integer'],
            [['text'], 'string', 'max' => 1000],
            [['review_name', 'review_icon'], 'string', 'max' => 125],
            [['task_id'], 'unique'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'task_id']],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employer_id' => 'user_id']],
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
            'text' => 'Text',
            'score' => 'Score',
            'task_id' => 'Task ID',
            'employer_id' => 'Employer ID',
            'performer_id' => 'Performer ID',
            'review_name' => 'Review Name',
            'review_icon' => 'Review Icon',
        ];
    }

    /**
     * Gets query for [[Employer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmployer()
    {
        return $this->hasOne(User::className(), ['user_id' => 'employer_id']);
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
