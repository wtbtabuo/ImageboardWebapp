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
            $uploadFile = $uploadDir . $uid . '.png'; // ファイル名はuid.png
            echo $uploadFile;
            // 画像ファイルをassetsディレクトリに保存
            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                // 保存成功時の処理
                echo json_encode(['success' => true]);
            } else {
                // 保存失敗時の処理
                echo json_encode(['success' => false, 'message' => 'Failed to save image']);
            }
        }
        // IDの検証
        $title = $_POST['title'];
        $text = $_POST['text'];
        $uid = $_POST['uid'];
        $replyToId = $_POST['id'];

        $post = new Post(null, $replyToId, $uid, $title, $text, null, null);
        $postDao = new PostDAOImpl();

        $posts = $postDao->createOrUpdate($post);

        return new JSONRenderer(['posts'=>$posts]);
    },
    'update/part' => function(): HTMLRenderer {
        $part = null;
        $partDao = new ComputerPartDAOImpl();
        if(isset($_GET['id'])){
            $id = ValidationHelper::integer($_GET['id']);
            $part = $partDao->getById($id);
        }
        return new HTMLRenderer('component/update-computer-part',['part'=>$part]);
    },
    'form/update/part' => function(): HTTPRenderer {
        try {
            // リクエストメソッドがPOSTかどうかをチェックします
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Invalid request method!');
            }

            $required_fields = [
                'name' => ValueType::STRING,
                'type' => ValueType::STRING,
                'brand' => ValueType::STRING,
                'modelNumber' => ValueType::STRING,
                'releaseDate' => ValueType::DATE,
                'description' => ValueType::STRING,
                'performanceScore' => ValueType::INT,
                'marketPrice' => ValueType::FLOAT,
                'rsm' => ValueType::FLOAT,
                'powerConsumptionW' => ValueType::FLOAT,
                'lengthM' => ValueType::FLOAT,
                'widthM' => ValueType::FLOAT,
                'heightM' => ValueType::FLOAT,
                'lifespan' => ValueType::INT,
            ];

            $partDao = new ComputerPartDAOImpl();

            // 入力に対する単純なバリデーション。実際のシナリオでは、要件を満たす完全なバリデーションが必要になることがあります。
            $validatedData = ValidationHelper::validateFields($required_fields, $_POST);

            if(isset($_POST['id'])) $validatedData['id'] = ValidationHelper::integer($_POST['id']);

            // 名前付き引数を持つ新しいComputerPartオブジェクトの作成＋アンパッキング
            $part = new ComputerPart(...$validatedData);

            error_log(json_encode($part->toArray(), JSON_PRETTY_PRINT));

            // 新しい部品情報でデータベースの更新を試みます。
            // 別の方法として、createOrUpdateを実行することもできます。
            if(isset($validatedData['id'])) $success = $partDao->update($part);
            else $success = $partDao->create($part);

            if (!$success) {
                throw new Exception('Database update failed!');
            }

            return new JSONRenderer(['status' => 'success', 'message' => 'Part updated successfully']);
        } catch (\InvalidArgumentException $e) {
            error_log($e->getMessage()); // エラーログはPHPのログやstdoutから見ることができます。
            return new JSONRenderer(['status' => 'error', 'message' => 'Invalid data.']);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return new JSONRenderer(['status' => 'error', 'message' => 'An error occurred.']);
        }
    },
    'delete/part' => function(): HTMLRenderer {
        $part = null;
        $partDao = new ComputerPartDAOImpl();
        if(isset($_GET['id'])){
            $id = ValidationHelper::integer($_GET['id']);
            $part = $partDao->delete($id);
        }
        return new HTMLRenderer('component/delete-computer-part',['part'=>$part]);
    },
];