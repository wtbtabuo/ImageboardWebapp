document.addEventListener("DOMContentLoaded", function() {
    // 親スレッドのhash_idを取得
    const threadElement = document.querySelector("[data-hash-id]");
    const hashId = threadElement.getAttribute("data-hash-id");

    // /replies/{hash_id} にリクエストを送信
    fetch(`/replies/${hashId}`)
        .then(response => response.json())
        .then(data => {
            // 子スレッドを表示するためのコンテナを取得
            const container = document.querySelector(".container");

            // 子スレッドデータをループして表示
            if (data.length > 0) {
                data.forEach(reply => {
                    const replyCard = document.createElement("div");
                    replyCard.classList.add("card", "m-2");
                    replyCard.style.width = "16rem";
                    replyCard.setAttribute("data-hash-id", reply.hash_id);

                    replyCard.innerHTML = `
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">${reply.subject}</h6>
                            <p class="card-text">
                                <strong>Text:</strong> ${reply.text}<br />
                            </p>
                            <p class="card-text"><small class="text-muted">Last updated on ${reply.updated_at}</small></p>
                        </div>
                    `;

                    // コンテナに追加
                    container.appendChild(replyCard);
                });
            } else {
                // 子スレッドが存在しない場合のメッセージ
                const noRepliesMessage = document.createElement("p");
                noRepliesMessage.textContent = "No replies found.";
                container.appendChild(noRepliesMessage);
            }
        })
        .catch(error => {
            console.error("Error fetching replies:", error);
        });
});
