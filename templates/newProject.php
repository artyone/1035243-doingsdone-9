<h2 class="content__main-heading">Добавление проекта</h2>

        <form class="form"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
          <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input class="form__input <?= array_key_exists('name', $errors) ? 'form__input--error' : '' ?>"
                   type="text" name="name" id="project_name" value="<?= empty($projectData['name']) ? '' : $projectData['name'] ?>"
                    placeholder="Введите название проекта">
              <p class="form__message"><?= array_key_exists('name', $errors) ? $errors['name'] : '' ?></p>
          </div>

          <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
          </div>
        </form>