<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Task;

class TasksController extends Controller
{
    public function actionIndex()
    {

        $tasks = Task::find()
            ->where(['status' => Task::NEW])
            ->with(['city', 'category'])
            ->orderBy(['date_add' => SORT_DESC])
            ->all();

        // Передаем задания в шаблон
        return $this->render('index', [
            'tasks' => $tasks
        ]);
    }
}
