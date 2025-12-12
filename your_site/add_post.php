<?php


require_once __DIR__ . '/includes/config.php';
start_custom_session();

$is_logged_in = !empty($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;

if (!$is_logged_in) {
 
    header('Location: login.php');
    exit();
}

$postsFile = __DIR__ . '/blog_posts.json';

$posts = [];
if (file_exists($postsFile) && is_readable($postsFile)) {
    $json = file_get_contents($postsFile);
    $data = json_decode($json, true);
    if (is_array($data) && isset($data['posts']) && is_array($data['posts'])) {
        $posts = $data['posts'];
    }
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title'] ?? '');
    $date     = trim($_POST['date'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $content  = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        $error = 'Title and content are required.';
    } else {
        $lines = preg_split('/\r\n|\r|\n/', $content);
        $paragraphs = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '') {
                $paragraphs[] = htmlentities($line, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
            }
        }

        if (empty($paragraphs)) {
            $error = 'Please write at least one non-empty line of content.';
        } else {
            $newPost = [
                'id'         => uniqid('p', true), // unique id for post
                'date'       => $date !== '' ? htmlentities($date, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') : '',
                'title'      => htmlentities($title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                'category'   => htmlentities($category, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'),
                'paragraphs' => $paragraphs
            ];

            $posts[] = $newPost;

            $payload = ['posts' => $posts];

            file_put_contents(
                $postsFile,
                json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

            header('Location: blog.php');
            exit();
        }
    }
}

$today = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Fashion Week Post</title>
    <link rel="stylesheet" href="my_style.css">
    <script src="js/nav.js" defer></script>
	<script src="js/add_post.js" defer></script>
</head>
<body>
<header>
    <?php require_once 'nav.php'; ?>
</header>

<main class="blog-add-main">
    <section class="blog-add-card">
        <h1>Add a new Fashion Week post</h1>
        <p>Use this form to document another moment from Fashion Week.</p>

        <?php if ($error): ?>
            <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post" action="add_post.php" class="blog-add-form">
            <div class="form-row">
                <label for="title">Title *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    required
                    maxlength="200"
                >
            </div>

            <div class="form-row">
                <label for="date">Date</label>
                <input
                    type="date"
                    id="date"
                    name="date"
                    value="<?php echo htmlspecialchars($today); ?>"
                >
            </div>

            <div class="form-row">
                <label for="category">Category (e.g. Paris, Milan, Street Style)</label>
                <input
                    type="text"
                    id="category"
                    name="category"
                    maxlength="100"
                >
            </div>

            <div class="form-row">
                <label for="content">Post content *</label>
                <textarea
                    id="content"
                    name="content"
                    rows="8"
                    required
                    placeholder="Write your Fashion Week story. Separate paragraphs with line breaks."
                ></textarea>
            </div>
			
			<div id="draft-status" class="draft-status" style="display: none;">
                <span class="draft-indicator"> Draft saved</span>
                <button type="button" id="clear-draft-btn" class="btn small-btn">Clear Draft</button>
            </div>

            <div class="form-actions">
			<button type="button" id="save-draft-btn" class="btn secondary-btn">Save Draft</button>
                <button type="submit" class="btn primary-btn">Save post</button>
                <a href="blog.php" class="btn secondary-btn">Cancel</a>
            </div>
        </form>
    </section>
</main>

<?php include 'footer.php'; ?>
</body>
</html>