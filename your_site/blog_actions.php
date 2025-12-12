<?php


require_once __DIR__ . '/includes/config.php';
start_custom_session();

header('Content-Type: text/plain; charset=utf-8');

if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    http_response_code(403);
    echo 'Not authorized';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method not allowed';
    exit();
}

$action = $_POST['action'] ?? '';
$postId = $_POST['id'] ?? '';

if ($action !== 'delete' || $postId === '') {
    http_response_code(400);
    echo 'Invalid request';
    exit();
}

$postsFile = __DIR__ . '/blog_posts.json';
if (!file_exists($postsFile) || !is_readable($postsFile)) {
    http_response_code(500);
    echo 'Posts file not found';
    exit();
}

$json = file_get_contents($postsFile);
$data = json_decode($json, true);

if (!is_array($data) || !isset($data['posts']) || !is_array($data['posts'])) {
    http_response_code(500);
    echo 'Invalid JSON structure';
    exit();
}

// Filter out the post with matching id
$originalCount = count($data['posts']);
$data['posts'] = array_values(array_filter(
    $data['posts'],
    function ($post) use ($postId) {
        return !isset($post['id']) || $post['id'] !== $postId;
    }
));
$newCount = count($data['posts']);

if ($newCount === $originalCount) {
    // Nothing deleted (id not found)
    http_response_code(404);
    echo 'Post not found';
    exit();
}

// Save updated JSON
file_put_contents(
    $postsFile,
    json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
);

echo 'OK';