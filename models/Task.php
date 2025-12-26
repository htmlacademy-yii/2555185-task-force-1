<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $task_id
 * @property string $title
 * @property string $description
 * @property int|null $budget
 * @property string|null $date_add
 * @property string|null $due_date
 * @property string|null $status
 * @property int $employer_id
 * @property int|null $performer_id
 * @property int|null $city_id
 * @property int|null $category_id
 *
 * @property Category $category
 * @property Cities $city
 * @property User $employer
 * @property File[] $files
 * @property User $performer
 * @property Response[] $responses
 * @property Review $review
 */
class Task extends \yii\db\ActiveRecord
{
    const NEW = 'new';
    const CANCELED = 'canceled';
    const IN_PROGRESS = 'in_progress';
    const COMPLETED = 'completed';
    const FAILED = 'failed';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['budget', 'due_date', 'status', 'performer_id', 'city_id', 'category_id'], 'default', 'value' => null],
            [['title', 'description', 'employer_id'], 'required'],
            [['description'], 'string'],
            [['budget', 'employer_id', 'performer_id', 'city_id', 'category_id'], 'integer'],
            [['date_add', 'due_date'], 'safe'],
            [['title', 'status'], 'string', 'max' => 128],
            [['employer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['employer_id' => 'user_id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_id' => 'user_id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'title' => 'Title',
            'description' => 'Description',
            'budget' => 'Budget',
            'date_add' => 'Date Add',
            'due_date' => 'Due Date',
            'status' => 'Status',
            'employer_id' => 'Employer ID',
            'performer_id' => 'Performer ID',
            'city_id' => 'City ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
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
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id_task' => 'task_id']);
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
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Response::className(), ['task_id' => 'task_id']);
    }

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['task_id' => 'task_id']);
    }

}
