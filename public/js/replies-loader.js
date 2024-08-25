import { initializeReplyFormHandling } from '/public/js/post-thread.js';

document.addEventListener("DOMContentLoaded", function() {
    // 親スレッドのhash_idを取得
    const threadElement = document.querySelector("[data-hash-id]");
    const hashId = threadElement.getAttribute("data-hash-id");
    const Id = threadElement.getAttribute("id");

    // /replies/{hash_id} にリクエストを送信
    fetch(`/replies/${hashId}`)
        .then(response => response.json())
        .then(data => {
            // 子スレッドを表示するためのコンテナを取得
            const container = document.querySelector(".container-2");

            // 子スレッドデータをループして表示
            const replies = data.replies;
            if (replies.length > 0) {
                replies.forEach(reply => {
                    const replyCard = document.createElement("div");
                    replyCard.classList.add("card", "m-2");
                    replyCard.style.width = "18rem"; // 親スレッドと同じ幅に設定
                    replyCard.setAttribute("data-hash-id", reply.hash_id);

                    replyCard.innerHTML = `
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">${reply.subject}</h6>
                            <p class="card-text">
                                <strong>Text:</strong> ${reply.text}<br />
                            </p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Created at: ${reply.created_at.createdAt}<br />
                                    Last updated at: ${reply.updated_at.updatedAt}
                                </small>
                            </p>
                        </div>
                    `;

                    // 親スレッドのカードの後に子スレッドのカードを追加
                    container.appendChild(replyCard);
                });
            } else {
                // 子スレッドが存在しない場合のメッセージ
                const noRepliesMessage = document.createElement("p");
                noRepliesMessage.textContent = "No replies found.";
                container.appendChild(noRepliesMessage);
            }

            // 入力フォームのHTMLを作成
            const replyFormContainer = document.createElement("div");
            replyFormContainer.classList.add("card", "m-2"); // カードと同じスタイルを適用
            replyFormContainer.style.width = "18rem"; // 親スレッドと同じ幅に設定
            replyFormContainer.innerHTML = `
                <div class="card-body">
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
            `;

            // 最後にフォームをコンテナに追加
            container.appendChild(replyFormContainer);

            // 別ファイルの関数を使ってフォーム送信イベントを初期化
            initializeReplyFormHandling(Id);
        })
        .catch(error => {
            console.error("Error fetching replies:", error);
        });
});
