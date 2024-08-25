export function initializeReplyFormHandling(Id) {
    // フォーム送信イベントをカスタマイズ
    const replyForm = document.getElementById("replyForm");
    replyForm.addEventListener("submit", function(event) {
        event.preventDefault(); // デフォルトのフォーム送信動作を防ぐ

        const fileInput = document.getElementById('replyImage');
        const titleInput = document.getElementById('titleInput').value;
        const text = document.getElementById('replyText').value;
        const uid = uuid.v4();
        
        // フォームデータを取得
        const file = fileInput.files[0];
        const formData = new FormData();
        console.log(titleInput)
        console.log(text)
        console.log(uid)
        console.log(Id)
        formData.append('image', file);
        formData.append('id', Id);
        formData.append('title', titleInput);
        formData.append('text', text);
        formData.append('uid', uid);
        // 非同期でデータを送信
        fetch(`/newReply/`, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            location.reload()
            // 必要に応じてUIを更新
        })
        .catch(error => {
            console.error("Error posting reply:", error);
        });
    });
}
