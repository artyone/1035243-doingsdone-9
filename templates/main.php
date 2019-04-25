<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post" autocomplete="off">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= $showCompleteTasks ? 'checked' : '' ?> >
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>

<table class="tasks">

    <?php foreach ($tasks as $task) : ?>
        <?php if ($showCompleteTasks || !$task['status']) : ?>
            <tr class="tasks__item task <?= $task['status'] ? 'task--completed' : '' ?>
            <?= isImportant($task['expiration_time'], $task['status']) ? 'task--important' : '' ?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox" <?= $task['status'] ? 'checked' : '' ?>>
                        <span class="checkbox__text"><?= htmlspecialchars($task['name']); ?></span>
                    </label>
                </td>
                <td class="task__file">
                    <a class="download-link" href="#">Home.psd</a>
                </td>
                <td class="task__date"><?= $task['expiration_time'] ? htmlspecialchars($task['expiration_time']) : 'Нет' ?></td>
                <td class="task__controls"></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>

</table>