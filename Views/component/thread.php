<div class="container-2 d-flex flex-column align-items-center">
    <!-- 親スレッドの表示 -->
    <div class="card m-2" style="width: 18rem;" data-hash-id="<?= htmlspecialchars($thread->getHashId()) ?>">
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
                <?= htmlspecialchars($thread->getSubject()) ?>
            </h6>
            <p class="card-text">
                <strong>Text:</strong> <?= htmlspecialchars($thread->getText()) ?><br />
            </p>
            <p class="card-text">
                <small class="text-muted">Last updated on <?= htmlspecialchars($thread->getUpdated()->getUpdatedAt()) ?></small>
            </p>
        </div>
    </div>
</div>

<script src="/public/js/image-loader.js"></script>
<script type="module" src="/public/js/replies-loader.js"></script>
<script type="module" src="/public/js/post-thread.js"></script>
