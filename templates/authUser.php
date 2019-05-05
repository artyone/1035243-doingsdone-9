<h2 class="content__main-heading">Вход на сайт</h2>

<form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
    <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>

        <input class="form__input <?= array_key_exists('email', $errors) ? 'form__input--error' : '' ?>"
               type="text" name="email" id="email" value="<?= empty($authData['email']) ? '' : $authData['email'] ?>"
               placeholder="Введите e-mail">

        <p class="form__message"><?= array_key_exists('email', $errors) ? $errors['email'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input <?= array_key_exists('password', $errors) ? 'form__input--error' : '' ?>"
               type="password" name="password" id="password" value="" placeholder="Введите пароль">
        <p class="form__message"><?= array_key_exists('password', $errors) ? $errors['password'] : '' ?></p>
    </div>
    <?= array_key_exists('error', $errors) ? '<p class="error-message">' . $errors['error'] . '</p>' : '' ?>
    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Войти">

    </div>
</form>