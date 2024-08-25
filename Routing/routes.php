<?php

use Helpers\ValidationHelper;
use Models\Post;
use Models\DataTimeStamp;
use Response\HTTPRenderer;
use Response\Render\HTMLRenderer;
use Database\DataAccess\Implementations\PostDAOImpl;
use Response\Render\JSONRenderer;
use Types\ValueType;

return [
    'home'=>function(): HTTPRenderer{
        $offset = 0;
        $limit = 100;

        $postDao = new PostDAOImpl();
        $posts = $postDao->getAllThreads($offset, $limit);

        if($posts === null) throw new Exception('No posts here!');

        return new HTMLRenderer('component/home', ['posts'=>$posts]);
    },
    'thread' => function(): HTTPRenderer {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $hash_id = basename($uri); // URLからスレッドIDを取得
        $postDao = new PostDAOImpl();
        $thread = $postDao->getByHashId($hash_id);
        if ($thread === null) throw new Exception('指定されたスレッドは見つかりませんでした！');

        return new HTMLRenderer('component/thread', ['thread' => $thread]);
    },
    'replies'=>function(): HTTPRenderer{
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $hash_id = basename($uri); // URLからスレッドIDを取得
        $postDao = new PostDAOImpl();
        $thread = $postDao->getByHashId($hash_id);
        $offset = 0;
        $limit = 1000;
        $allReplies = $postDao->getReplies($thread, $offset, $limit);
        if($allReplies === null) throw new Exception('All replies were not found!');

        // $allRepliesを配列に変換する
        $allRepliesArray = [];
        foreach ($allReplies as $reply) {
            $allRepliesArray[] = $reply->toArray(); // 各Postオブジェクトを配列に変換
        }

        return new JSONRenderer(['replies' => $allRepliesArray]);
    },
    'newReply'=>function(): JSONRenderer{
        // 画像の保存
    // 画像ファイルがアップロードされているか確認
        if (isset($_FILES['image'])) {
            $uid = $_POST['uid']; // ユニークIDを受け取る
            $uploadDir = __DIR__ . '/..' . '/assets/'; // assetsディレクトリ
            $uploadFile = $uploadDir . $uid . '.jpg';
            // 画像ファイルをassetsディレクトリに保存
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
        }
        // IDの検証
        $title = $_POST['title'];
        $text = $_POST['text'];
        $uid = $_POST['uid'];
        if (isset($_POST['id'])){
            $replyToId = $_POST['id'];
        } else {
            $replyToId = null;
        }

        $post = new Post(null, $replyToId, $uid, $title, $text, null, null);
        $postDao = new PostDAOImpl();

        $posts = $postDao->createOrUpdate($post);

        return new JSONRenderer(['posts'=>[]]);
    },
    'newPost'=>function(): HTTPRenderer{
        return new HTMLRenderer('component/newPost', []);
    },
];