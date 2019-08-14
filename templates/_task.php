<tr class="tasks__item task <?=$task['state'] === 'Да' ? "task--completed" : '';?>">
    <td class="task__select">
        <label class="checkbox task__checkbox">
            <input class="checkbox__input visually-hidden" type="checkbox">
            <span class="checkbox__text"><?=htmlspecialchars($task['nameTask']); ?></span>
        </label>
    </td>
    <td class="task__date"><?=htmlspecialchars($task['completeDate']); ?></td>
    <td class="task__controls"><?=htmlspecialchars($task['state']); ?></td>
</tr>
