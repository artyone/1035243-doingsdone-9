<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?= array_key_exists('name', $errors) ? 'form__input--error' : '' ?>
        " type="text" name="name" id="name" value="<?= empty($taskData['name']) ? '' : $taskData['name'] ?>" placeholder="Введите название">
        <p class="form__message"><?= array_key_exists('name', $errors) ? $errors['name'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select <?= array_key_exists('projectId', $errors) ? 'form__input--error' : '' ?>"
                name="projectId" id="project">
            <?php foreach($projects as $project) : ?>
                <option value="<?= $project['id'] ?>" <?= array_key_exists('projectId', $taskData) && $taskData['projectId'] == $project['id'] ? 'selected' : ''  ?>>
                    <?= $project['name'] ?></option>
            <?php endforeach ?>
        </select>
        <p class="form__message"><?= array_key_exists('projectId', $errors) ? $errors['projectId'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?= array_key_exists('expirationDate', $errors) ? 'form__input--error' : '' ?>"
               type="text" name="expirationDate" id="date" value="<?= empty($taskData['expirationDate']) ? '' : $taskData['expirationDate'] ?>"
               placeholder="Введите дату в формате ГГГГ-ММ-ДД">
        <p class="form__message"><?= array_key_exists('expirationDate', $errors) ? $errors['expirationDate'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="file" id="file" value="">

            <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
            </label>
        </div>
        <p class="form__message"><?= array_key_exists('file', $errors) ? $errors['file'] : '' ?></p>
    </div>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>