<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post" autocomplete="off">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="<?= buildProjectUrl(getParam($_GET, 'projectId'), getParam($_GET, 'showCompleted'), null) ?>"
           class="tasks-switch__item <?= (!getParam($_GET, 'timeRange')) ? 'tasks-switch__item--active' : '' ?> ">Все задачи</a>
        <a href="<?= buildProjectUrl(getParam($_GET, 'projectId'), getParam($_GET, 'showCompleted'), 'today') ?>"
           class="tasks-switch__item <?= (getParam($_GET, 'timeRange') == 'today') ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
        <a href="<?= buildProjectUrl(getParam($_GET, 'projectId'), getParam($_GET, 'showCompleted'), 'tommorrow') ?>"
           class="tasks-switch__item <?= (getParam($_GET, 'timeRange') == 'tommorrow') ? 'tasks-switch__item--active' : '' ?>">Завтра</a>
        <a href="<?= buildProjectUrl(getParam($_GET, 'projectId'), getParam($_GET, 'showCompleted'), 'expired') ?>"
           class="tasks-switch__item <?= (getParam($_GET, 'timeRange') == 'expired') ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a href="<?= (!getParam($_GET, 'showCompleted') || getParam($_GET, 'showCompleted') === 0) ?
            buildProjectUrl(getParam($_GET, 'projectId'), 1, getParam($_GET, 'timeRange')) :
            buildProjectUrl(getParam($_GET, 'projectId'), 0, getParam($_GET, 'timeRange')) ?> ">
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $showCompleteTasks ? 'checked' : '' ?> >
            <span class="checkbox__text">Показывать выполненные</span></a>

    </label>
</div>

<table class="tasks">

    <?php foreach ($tasks as $task) : ?>
        <?php if ($showCompleteTasks || !$task['status']) : ?>
            <tr class="tasks__item task <?= $task['status'] ? 'task--completed' : '' ?>
            <?= isImportant($task['expiration_time'], $task['status']) ? 'task--important' : '' ?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <a href=" <?=  buildProjectUrl(getParam($_GET, 'projectId'), getParam($_GET, 'showCompleted'), getParam($_GET, 'timeRange'), $task['id']) ?>">
                            <input class="checkbox__input visually-hidden" type="checkbox" <?= $task['status'] ? 'checked' : '' ?>>
                            <span class="checkbox__text"><?= htmlspecialchars($task['name']); ?></span>
                        </a>
                    </label>
                </td>
                <td class="task__file">
                    <a class=" <?= $task['file_link'] ? 'download-link' : '' ?>" href="<?= $task['file_link'] ?> ">
                        <?= basename($task['file_link']) ?></a>
                </td>
                <td class="task__date"><?= $task['expiration_time'] ? htmlspecialchars($task['expiration_time']) : 'Нет' ?></td>
                <td class="task__controls"></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

</table>