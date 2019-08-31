<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>

        <input class="form__input <?=isset($errors['name']) ? "form__input--error" : ""; ?>" type="text" name="name" id="name" value="<?=getPostVal('name'); ?>" placeholder="Введите название">
        <?php if (isset($errors['name'])): ?>
            <p class="form__message"><?=$errors['name']; ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>

        <select class="form__input form__input--select <?=isset($errors['project_id']) ? "form__input--error" : ""; ?>" name="project_id" id="project">
            <option>Выбрать</option>
                <?php foreach ($projects as $project): ?>
                    <option value="<?=$project['id']; ?>"<?php if (isset($task) && $project['id'] == $task['project_id']): ?>selected<?php endif; ?>>
                        <?=$project['name']; ?>
                    </option>
                <?php endforeach; ?>
        </select>
        <?php if (isset($errors['project_id'])): ?>
            <p class="form__message"><?=$errors['project_id']; ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>

        <input class="form__input form__input--date <?=isset($errors['date']) ? "form__input--error" : ""; ?>" type="text" name="date" id="date" value="<?=getPostVal('date'); ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
        <?php if (isset($errors['date'])): ?>
            <p class="form__message"><?=$errors['date']; ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <label class="form__label" for="file">Файл</label>

        <div class="form__input-file">
            <input class="visually-hidden" type="file" name="file" id="file" value="">

            <label class="button button--transparent" for="file">
                <span>Выберите файл</span>
            </label>
        </div>
    </div>
    <?php if (isset($errors)): ?>
        <p class="form__message">«Пожалуйста, исправьте ошибки в форме»</p>
    <?php endif; ?>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
