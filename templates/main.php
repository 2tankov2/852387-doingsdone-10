<section class="content__side">
    <h2 class="content__side-heading">Проекты</h2>
    <nav class="main-navigation">
        <ul class="main-navigation__list">
            <?php foreach ($projects as $project): ?>
                <li class="main-navigation__list-item <?=($_GET['id'] === $project['id']) ? 'main-navigation__list-item--active' : ''; ?>">
                    <a class="main-navigation__list-item-link" href="/index.php?id=<?=$project['id']; ?>">
                        <?=htmlspecialchars($project['name']); ?>
                    </a>
                    <span class="main-navigation__list-item-count"><?=$project['tasks_count']; ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <a class="button button--transparent button--plus content__side-button" href="pages/form-project.html" target="project_add">Добавить проект</a>
</section>

<main class="content__main"><?=$content_tasks; ?></main>
