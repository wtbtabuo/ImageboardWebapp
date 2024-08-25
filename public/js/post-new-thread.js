document.addEventListener('DOMContentLoaded', function () {
    const replyForm = document.getElementById('replyForm');
    
    replyForm.addEventListener('submit', async function (event) {
        event.preventDefault(); // デフォルトのフォーム送信を防ぐ

        const fileInput = document.getElementById('replyImage');
        const titleInput = document.getElementById('titleInput').value;
        const text = document.getElementById('replyText').value;
        const uid = uuid.v4();

        // フォームデータを取得
        const file = fileInput.files[0];
        const formData = new FormData();

        formData.append('image', file);
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
            window.location.href = "/home";
        })
        .catch(error => {
            console.error("Error posting reply:", error);
        });
    });
});
