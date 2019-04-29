<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?= array_key_exists('name', $error) ? 'form__input--error' : '' ?>
        " type="text" name="name" id="name" value="<?= empty($taskData['name']) ? '' : $taskData['name'] ?>" placeholder="Введите название">
        <p class="form__message"><?= array_key_exists('name', $error) ? $error['name'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select <?= array_key_exists('project', $error) ? 'form__input--error' : '' ?>"
                name="project" id="project">
            <?php foreach($projects as $project) : ?>
                <option value="<?= $project['id'] ?>" <?= array_key_exists('project', $taskData) && $taskData['project'] == $project['id'] ? 'selected' : ''  ?>>
                    <?= $project['name'] ?></option>
            <?php endforeach ?>
        </select>
        <p class="form__message"><?= array_key_exists('project', $error) ? $error['project'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?= array_key_exists('date', $error) ? 'form__input--error' : '' ?>"
               type="text" name="date" id="date" value="<?= empty($taskData['date']) ? '' : $taskData['date'] ?>"
               placeholder="Введите дату в формате ГГГГ-ММ-ДД">
        <p class="form__message"><?= array_key_exists('date', $error) ? $error['date'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="file" id="file" value="">

            <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
            </label>
        </div>
        <p class="form__message"><?= array_key_exists('file', $error) ? $error['file'] : '' ?></p>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>

</form>

