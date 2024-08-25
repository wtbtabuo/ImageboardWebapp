export function initializeReplyFormHandling() {
    // フォーム送信イベントをカスタマイズ
    const replyForm = document.getElementById("replyForm");
    replyForm.addEventListener("submit", function(event) {
        event.preventDefault(); // デフォルトのフォーム送信動作を防ぐ

        // フォームデータを取得
        const formData = new FormData(replyForm);

        // 非同期でデータを送信
        fetch(`/newReplies/`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Reply posted successfully:", data);
            // 必要に応じてUIを更新
        })
        .catch(error => {
            console.error("Error posting reply:", error);
        });
    });
}
