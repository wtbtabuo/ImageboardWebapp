<div class="container d-flex flex-column align-items-center">
    <?php foreach ($posts as $post): ?>
        <?php $hashId = htmlspecialchars($post->getHashId()); ?>
        <!-- カード全体をリンクにする -->
        <a href="/thread/<?= $hashId ?>" class="text-decoration-none" style="width: 18rem;">
            <div class="card m-2" style="width: 100%;" data-hash-id="<?= $hashId ?>">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($post->getSubject()) ?></h6>
                    <p class="card-text">
                        <strong>Text:</strong> <?= htmlspecialchars($post->getText()) ?><br />
                    </p>
                    <p class="card-text"><small class="text-muted">Last updated on <?= htmlspecialchars($post->getUpdated()->getUpdatedAt()) ?></small></p>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<!-- image-loader.js を読み込む -->
<script src="public/js/image-loader.js"></script>
