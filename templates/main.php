<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="../index.php" method="get" autocomplete="off">
    <input class="search-form__input" type="text" name="search" value="<?= $search ?>" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" value="">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="<?= buildProjectUrl($projectId, $showCompleted, null) ?>"
           class="tasks-switch__item <?= !$timeRange ? 'tasks-switch__item--active' : '' ?> ">Все задачи</a>
        <a href="<?= buildProjectUrl($projectId, $showCompleted, RANGE_TODAY) ?>"
           class="tasks-switch__item <?= ($timeRange === RANGE_TODAY) ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
        <a href="<?= buildProjectUrl($projectId, $showCompleted, RANGE_TOMORROW) ?>"
           class="tasks-switch__item <?= ($timeRange === RANGE_TOMORROW) ? 'tasks-switch__item--active' : '' ?>">Завтра</a>
        <a href="<?= buildProjectUrl($projectId, $showCompleted, RANGE_EXPIRED) ?>"
           class="tasks-switch__item <?= ($timeRange === RANGE_EXPIRED) ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a class="link_task" href="<?= (!$showCompleted || $showCompleted === 0) ?
            buildProjectUrl($projectId, 1, $timeRange) :
            buildProjectUrl($projectId, 0, $timeRange) ?> ">
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $showCompleted ? 'checked' : '' ?> >
            <span class="checkbox__text">Показывать выполненные</span></a>

    </label>
</div>

<table class="tasks">
    <?= !$tasks && $search ? '<p class="error-message">По вашему запросу ничего не найдено</p>' : '' ?>
    <?php foreach ($tasks as $task) : ?>
        <?php if ($showCompleted || !$task['status']) : ?>
            <tr class="tasks__item task <?= $task['status'] ? 'task--completed' : '' ?>
            <?= isImportant($task['expiration_time'], $task['status']) ? 'task--important' : '' ?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <a class="link_task" href=" <?=  buildProjectUrl($projectId, $showCompleted, $timeRange, $task['id']) ?>">
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
