document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        const hashId = card.getAttribute("data-hash-id");

        // 画像URLを構築（サーバーで公開している画像ディレクトリから取得）
        const imageUrl = `/assets/${encodeURIComponent(hashId)}.jpg`;

        // 画像を設定
        const imgElement = document.createElement("img");
        imgElement.src = imageUrl;
        imgElement.className = "card-img-top";
        
        // 画像が存在するかを確認して、存在すれば表示
        imgElement.onload = function() {
            card.insertBefore(imgElement, card.firstChild);  // カードの最初に画像を挿入
        };

        // エラーハンドリング（画像が存在しない場合）
        imgElement.onerror = function() {
            console.error("Image not found for hash ID:", hashId);
        };
    });
});
