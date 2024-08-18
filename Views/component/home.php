<?php foreach ($posts as $post): ?>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($post->getSubject()) ?></h6>
            <p class="card-text">
                <strong>Text:</strong> <?= htmlspecialchars($post->getText()) ?><br />
            </p>
            <p class="card-text"><small class="text-muted">Last updated on <?= htmlspecialchars($post->getUpdated()->getUpdatedAt()) ?></small></p>
        </div>
    </div>
<?php endforeach; ?>
