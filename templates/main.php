<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="../index.php" method="get" autocomplete="off">
    <input class="search-form__input" type="text" name="search" value="<?= $searchFromGet ?>" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" value="">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="<?= buildProjectUrl($projectIdFromGet, $showCompletedFromGet, null) ?>"
           class="tasks-switch__item <?= !$timeRangeFromGet ? 'tasks-switch__item--active' : '' ?> ">Все задачи</a>
        <a href="<?= buildProjectUrl($projectIdFromGet, $showCompletedFromGet, RANGE_TODAY) ?>"
           class="tasks-switch__item <?= ($timeRangeFromGet == RANGE_TODAY) ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
        <a href="<?= buildProjectUrl($projectIdFromGet, $showCompletedFromGet, RANGE_TOMORROW) ?>"
           class="tasks-switch__item <?= ($timeRangeFromGet == RANGE_TOMORROW) ? 'tasks-switch__item--active' : '' ?>">Завтра</a>
        <a href="<?= buildProjectUrl($projectIdFromGet, $showCompletedFromGet, RANGE_EXPIRED) ?>"
           class="tasks-switch__item <?= ($timeRangeFromGet == RANGE_EXPIRED) ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a class="link_task" href="<?= (!$showCompletedFromGet || $showCompletedFromGet === 0) ?
            buildProjectUrl($projectIdFromGet, 1, $timeRangeFromGet) :
            buildProjectUrl($projectIdFromGet, 0, $timeRangeFromGet) ?> ">
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $showCompletedFromGet ? 'checked' : '' ?> >
            <span class="checkbox__text">Показывать выполненные</span></a>

    </label>
</div>

<table class="tasks">
    <?= !$tasks && $searchFromGet ? '<p class="error-message">По вашему запросу ничего не найдено</p>' : '' ?>
    <?php foreach ($tasks as $task) : ?>
        <?php if ($showCompletedFromGet || !$task['status']) : ?>
            <tr class="tasks__item task <?= $task['status'] ? 'task--completed' : '' ?>
            <?= isImportant($task['expiration_time'], $task['status']) ? 'task--important' : '' ?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <a class="link_task" href=" <?=  buildProjectUrl($projectIdFromGet, $showCompletedFromGet, $timeRangeFromGet, $task['id']) ?>">
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
