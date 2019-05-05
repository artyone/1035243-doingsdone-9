<h2 class="content__main-heading">Регистрация аккаунта</h2>

<form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
    <div class="form__row">
        <label class="form__label" for="email">E-mail <sup>*</sup></label>

        <input class="form__input <?= array_key_exists('email', $errors) ? 'form__input--error' : '' ?>"
               type="text" name="email" id="email" value="<?= empty($userData['email']) ? '' : $userData['email'] ?>"
               placeholder="Введите e-mail">

        <p class="form__message"><?= array_key_exists('email', $errors) ? $errors['email'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="password">Пароль <sup>*</sup></label>

        <input class="form__input <?= array_key_exists('password', $errors) ? 'form__input--error' : '' ?>"
               type="password" name="password" id="password" value=""
               placeholder="Введите пароль">
        <p class="form__message"><?= array_key_exists('password', $errors) ? $errors['password'] : '' ?></p>
    </div>

    <div class="form__row">
        <label class="form__label" for="name">Имя <sup>*</sup></label>

        <input class="form__input <?= array_key_exists('name', $errors) ? 'form__input--error' : '' ?>"
               type="text" name="name" id="name" value="<?= empty($userData['name']) ? '' : $userData['name'] ?>" placeholder="Введите имя">
        <p class="form__message"><?= array_key_exists('name', $errors) ? $errors['name'] : '' ?></p>
    </div>

    <div class="form__row form__row--controls">
        <?= $errors ? '<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>' : '' ?>
        <input class="button" type="submit" name="" value="Зарегистрироваться">
    </div>
</form>
