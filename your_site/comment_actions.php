<?php

session_start();

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'add_comment') {
    $post_id = $_POST['post_id'] ?? '';
    $author = trim($_POST['author'] ?? 'Anonymous');
    $text = trim($_POST['text'] ?? '');
    
    if (empty($post_id) || empty($text)) {
        echo 'ERROR: Missing required fields';
        exit;
    }
    
    $post_id = htmlspecialchars($post_id, ENT_QUOTES, 'UTF-8');
    $author = htmlspecialchars($author, ENT_QUOTES, 'UTF-8');
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    
    if (empty($author)) {
        $author = 'Anonymous';
    }
    
    $comments_file = 'comments.json';
    $comments = [];
    
    if (file_exists($comments_file)) {
        $json_content = file_get_contents($comments_file);
        $comments = json_decode($json_content, true);
        if (!is_array($comments)) {
            $comments = [];
        }
    }
    
    $new_comment = [
        'id' => 'comment_' . time() . '_' . rand(1000, 9999),
        'post_id' => $post_id,
        'author' => $author,
        'text' => $text,
        'date' => date('Y-m-d'),
        'timestamp' => time()
    ];
    
    $comments[] = $new_comment;
    
    $json_output = json_encode($comments, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    if (file_put_contents($comments_file, $json_output) === false) {
        echo 'ERROR: Could not save comment';
        exit;
    }
    
    echo json_encode($new_comment);
    exit;
}

echo 'ERROR: Invalid action';
exit;
?>