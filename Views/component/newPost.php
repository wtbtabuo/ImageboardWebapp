<div class="card-body" style="max-width: 50%; margin: auto;">
    <h6 class="card-subtitle mb-2 text-muted">Reply to this thread</h6>
    <form id="replyForm" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="replyTitle" class="form-label">Title</label>
            <input id="titleInput" type="text" class="form-control" id="replyTitle" name="title" required>
        </div>
        <div class="mb-3">
            <label for="replyText" class="form-label">Your Reply</label>
            <textarea class="form-control" id="replyText" name="text" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="replyImage" class="form-label">Attach Image</label>
            <input class="form-control" type="file" id="replyImage" name="image" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Post Reply</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/uuid/8.3.2/uuid.min.js"></script>
<script type="module" src="/public/js/post-new-thread.js"></script>