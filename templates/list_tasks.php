<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="/index.php" method="get" autocomplete="off">
    <input class="search-form__input" type="text" name="q" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item <?=isFilter() ? "tasks-switch__item--active" : ""; ?>">Все задачи</a>
        <a href="/index.php?task_filter=day" class="tasks-switch__item <?=isFilterTask('day') ? "tasks-switch__item--active" : ""; ?>">Повестка дня</a>
        <a href="/index.php?task_filter=tomorrow" class="tasks-switch__item <?=isFilterTask('tomorrow') ? "tasks-switch__item--active" : ""; ?>">Завтра</a>
        <a href="/index.php?task_filter=late" class="tasks-switch__item <?=isFilterTask('late') ? "tasks-switch__item--active" : ""; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?=isShowCompletedTask() ? "checked" : ""; ?>>
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<?php if (isSearch() && empty($task_list)) : ?>
    <p>По вашему запросу ничего не найдено</p>
<?php else : ?>
<table class="tasks">
    <?php foreach ($task_list as $task) :?>
        <?php if (isSearch() or isShowCompletedTask() or (!isShowCompletedTask() && $task['state'] === '0')) : ?>
            <?php if (isFilter() or (endDate($task['complete_date']))) :?>
                <?=include_template('_task.php', ['task' => $task]); ?>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
<?php endif; ?>
