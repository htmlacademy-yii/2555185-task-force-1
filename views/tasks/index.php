<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<main class="main-content container">
    <div class="left-column left-column--task">
        <h3 class="head-main head-regular">Новые задания</h3>

        <?php if (empty($tasks)): ?>
            <p>Новых заданий пока нет.</p>
        <?php endif; ?>

        <?php foreach ($tasks as $task): ?>
            <div class="task-card">
                <div class="header-task">
                    <a href="#" class="link link--block link--big">
                        <h2><?= Html::encode($task->title) ?></h2>
                    </a>
                    <p class="price price--task"><?= Html::encode($task->budget) ?> ₽</p>
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
                        <p class="info-text town-text"><?= Html::encode($task->city->name) ?></p>
                    <?php endif; ?>
                    <?php if ($task->category): ?>
                        <!-- ИСПРАВЛЕНО: было ->name, стало ->title -->
                        <p class="info-text category-text"><?= Html::encode($task->category->title) ?></p>
                    <?php endif; ?>
                    <a href="#" class="button button--black">Смотреть Задание</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
