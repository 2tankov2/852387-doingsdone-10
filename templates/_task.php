<tr class="tasks__item task <?=$task['state'] === '1' ? "task--completed" : '';?> <?=hoursDiff($task['complete_date']) <= 24 ? "task--important" : '';?>">
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden" type="checkbox">
            <span class="checkbox__text"><?=htmlspecialchars($task['name']); ?></span>
        </label>
    </td>
    <td class="task__date"><?=htmlspecialchars($task['complete_date']); ?></td>
    <td class="task__controls"><?=htmlspecialchars($task['state']); ?></td>
</tr>
