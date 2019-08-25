<tr class="tasks__item task <?=$task['state'] === '1' ? "task--completed" : '';?> <?=isExpiringTask($task['complete_date']) ? "task--important" : ''; ?>">
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden" type="checkbox">
            <span class="checkbox__text"><?=htmlspecialchars($task['name']); ?></span>
        </label>
    </td>
    <td class="task__date"><?=htmlspecialchars($task['complete_date']); ?></td>
</tr>
