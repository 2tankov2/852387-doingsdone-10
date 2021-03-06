
<tr class="tasks__item task <?=$task['state'] ? "task--completed" : '';?> <?=isExpiringTask($task['complete_date']) ? "task--important" : ''; ?>">
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden" type="checkbox" <?=$task['state'] ? "checked" : '';?> value="<?=$task['id']; ?>">
            <span class="checkbox__text"><?=deleteHtmlSpecialChars($task['name']); ?></span>
        </label>
    </td>
    <td class="task__file">
        <?php if ($task['file_url']) : ?>
            <a class="download-link" href="/uploads/<?=$task['file_url']; ?>"><?=$task['file_url']; ?></a>
        <?php endif; ?>
    </td>
    <td class="task__date"><?=deleteHtmlSpecialChars($task['complete_date']); ?></td>
</tr>

