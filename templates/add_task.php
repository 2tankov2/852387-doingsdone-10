<h2 class="content__main-heading">Добавление задачи</h2>

<form class="form" action="" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="form__row">
        <label class="form__label" for="name">Название <sup>*</sup></label>
            <?php $class_name = isset($errors['name']) ? "form__input--error" : ""; ?>

        <input class="form__input <?=$class_name; ?>" type="text" name="name" id="name" value="<?=getPostVal('name'); ?>" placeholder="Введите название">
    </div>

    <div class="form__row">
        <label class="form__label" for="project">Проект <sup>*</sup></label>
            <?php $class_name = isset($errors['project_id']) ? "form__input--error" : ""; ?>
        <select class="form__input form__input--select <?=$class_name; ?>" name="project_id" id="project">
            <option>Выбрать</option>
                 <?php foreach ($projects as $project): ?>
                    <option value="<?=$project['id']; ?>"
                      <?php if ($project['id'] == $task['project_id']): ?>selected<?php endif; ?>><?=$project['name']; ?></option>
                 <?php endforeach; ?>
        </select>
    </div>

    <div class="form__row">
        <label class="form__label" for="date">Дата выполнения</label>
            <?php $class_name = isset($errors['date']) ? "form__input--error" : ""; ?>
        <input class="form__input form__input--date <?=$class_name; ?>" type="text" name="date" id="date" value="<?=getPostVal('date'); ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
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

           <p>Пожалуйста, исправьте следующие ошибки:</p>
             <?php foreach ($errors as $val): ?>
                <p class="form__message"><strong><?=$val; ?></strong></p>
             <?php endforeach; ?>
     <?php endif; ?>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Добавить">
    </div>
</form>
