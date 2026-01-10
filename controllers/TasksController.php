<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\Task;
use app\models\TaskFilterForm;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $filterForm = new TaskFilterForm();


        if (Yii::$app->request->get()) {
            $filterForm->load(Yii::$app->request->get());
        }


        $query = Task::find()
            ->where(['status' => 'new'])
            ->with('category', 'city')
            ->orderBy(['date_add' => SORT_DESC]);

        if ($filterForm->categories) {
            $query->andWhere(['in', 'category_id', $filterForm->categories]);
        }

        if ($filterForm->withoutPerformer) {
            $query->andWhere(['performer_id' => null]);
        }

        if ($filterForm->creationTime) {
            $fromTime = date('Y-m-d H:i:s', time() - $filterForm->creationTime * 3600);
            $query->andWhere(['>=', 'date_add', $fromTime]);
        }

        $tasks = $query->all();

        $availableCategories = Category::find()
            ->joinWith('tasks')
            ->where(['task.status' => 'new'])
            ->groupBy('category.id')
            ->all();

        return $this->render('index', [
            'tasks' => $tasks,
            'availableCategories' => $availableCategories,
            'filterForm' => $filterForm,
        ]);
    }

    public function actionView($id)
    {
        // Получаем модель задания по ID
        $task = Task::findOne($id);

        // Если задание не найдено - 404
        if (!$task) {
            throw new \yii\web\NotFoundHttpException('Задание не найдено');
        }

        return $this->render('view', [
            'task' => $task,
        ]);
    }


    public function actionExecutor($id)
    {
        // Получаем модель исполнителя по ID
        $executor = User::findOne($id);

        // Если исполнитель не найден - 404
        if (!$executor) {
            throw new \yii\web\NotFoundHttpException('Исполнитель не найден');
        }

        return $this->render('executor', [
            'executor' => $executor,
        ]);
    }
}
