<?php
/** @var yii\web\View $this */
/** @var app\models\Task[] $tasks */
/** @var app\models\Category[] $availableCategories */
/** @var app\models\TaskFilterForm $filterForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>

<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main head-task">Новые задания</h3>

        <?php if (empty($tasks)): ?>
            <p>По вашему запросу задания не найдены</p>
        <?php else: ?>
            <?php foreach ($tasks as $task): ?>
                <div class="task-card">
                    <div class="header-task">
                        <a href="<?= Url::to(['tasks/view', 'id' => $task->task_id]) ?>" class="link link--block link--big">
                            <?= Html::encode($task->title) ?>
                        </a>
                        <p class="price price--task">
                            <?= Html::encode($task->budget) ?> ₽
                        </p>
                    </div>
                    <p class="info-text">
                        <span class="current-time">
                            <?= Yii::$app->formatter->asRelativeTime($task->date_add) ?>
                        </span>
                    </p>
                    <p class="task-text">
                        <?= Html::encode(mb_substr($task->description, 0, 200)) ?>...
                    </p>
                    <div class="footer-task">
                        <?php if ($task->city): ?>
                            <p class="info-text town-text">
                                <?= Html::encode($task->city->name) ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($task->category): ?>
                            <p class="info-text category-text">
                                <?= Html::encode($task->category->title ?? $task->category->name) ?>
                            </p>
                        <?php endif; ?>
                        <a href="#" class="button button--black">Смотреть Задание</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Правая колонка - форма фильтрации -->
    <div class="right-column">
        <div class="right-card black">
            <div class="search-form">
                <?php $form = ActiveForm::begin([
                    'method' => 'get',
                    'action' => ['tasks/index'],
                    'id' => 'search-form',
                    'fieldConfig' => [
                        'template' => "{input}",
                    ]
                ]); ?>

                <!-- Категории -->
                <h4 class="head-card">Категории</h4>
                <div class="checkbox-wrapper">
                    <?php foreach ($availableCategories as $category): ?>
                        <?php
                        $id = 'cat-' . $category->id;
                        $isChecked = !empty($filterForm->categories)
                            && in_array($category->id, $filterForm->categories);
                        ?>
                        <label class="control-label" for="<?= $id ?>">
                            <?= Html::checkbox(
                                'TaskFilterForm[categories][]',
                                $isChecked,
                                [
                                    'value' => $category->id,
                                    'id' => $id,
                                    'class' => 'checkbox-input',
                                ]
                            ) ?>
                            <?= Html::encode($category->title ?? $category->name) ?>
                        </label>
                    <?php endforeach; ?>
                </div>

                <!-- Дополнительно -->
                <h4 class="head-card">Дополнительно</h4>
                <div class="checkbox-wrapper">
                    <label class="control-label" for="without-performer">
                        <?= Html::checkbox(
                            'TaskFilterForm[withoutPerformer]',
                            $filterForm->withoutPerformer,
                            [
                                'value' => 1,
                                'id' => 'without-performer',
                                'class' => 'checkbox-input',
                            ]
                        ) ?>
                        Без исполнителя
                    </label>
                </div>

                <!-- Период -->
                <h4 class="head-card">Период</h4>
                <div class="filter-section">
                    <?= Html::dropDownList(
                        'TaskFilterForm[creationTime]',
                        $filterForm->creationTime,
                        ['' => 'Выберите период'] + $filterForm->periodOptions,
                        [
                            'class' => 'select',
                            'id' => 'creationTime'
                        ]
                    ) ?>
                </div>

                <!-- Кнопки -->
                <div class="filter-submit">
                    <?= Html::submitButton('Искать', [
                        'class' => 'button button--blue',
                    ]) ?>

                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</main>
