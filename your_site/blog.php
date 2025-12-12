	<?php
	

	require_once __DIR__ . '/includes/config.php';
	start_custom_session();

	$is_logged_in = !empty($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
	$username     = $_SESSION['username'] ?? '';

	
	$postsFile = __DIR__ . '/blog_posts.json';

	$posts = [];

	if (file_exists($postsFile) && is_readable($postsFile)) {
	$json = file_get_contents($postsFile);
	$data = json_decode($json, true);
	if (is_array($data) && isset($data['posts']) && is_array($data['posts'])) {
		$posts = $data['posts'];
	}
	}
	?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Fashion Week Blog</title>

	<link rel="stylesheet" href="my_style.css">
	<script src="js/nav.js" defer></script>
	<script src="js/blog.js" defer></script>
	</head>
	<body>
	<header class="blog-header">
	<?php require_once 'nav.php'; ?>

	<div class="blog-auth-area">
	<button id="theme-toggle-btn" class="btn theme-btn" title="Toggle light/dark theme">
		🌙
	</button>
		<?php if (!$is_logged_in): ?>
			<a href="login.php" class="btn blog-login-btn">Log in</a>
		<?php else: ?>
			<form action="login.php" method="post" class="blog-logout-form">
				<button type="submit" name="action" value="logout" class="btn blog-logout-btn">
					Log out (<?php echo htmlspecialchars($username); ?>)
				</button>
			</form>
		<?php endif; ?>
	</div>
	</header>

	<main class="blog-page">
	<section class="blog-hero">
		<div class="blog-hero-content">
			<h1>Fashion Week Diary</h1>
			<p>
				Welcome to my Fashion Week blog, where I break down what actually happens
				on and off the runway. From Paris to Milan, from runway looks to street
				style, this page follows real outfits, bold styling choices, and the
				trends that are worth watching after the lights go down.
			</p>
			<p>
				Every post captures a different moment of Fashion Week: opening nights,
				backstage energy, and the creative chaos happening outside the official shows.
				If you love fashion that mixes storytelling, design, and real people,
				you&apos;re in the right place.
			</p>

			<?php if ($is_logged_in): ?>
				
				<div class="blog-hero-actions">
					<a href="add_post.php" class="btn primary-btn">Add new post</a>
				</div>
			<?php endif; ?>
		
		
		<div class="blog-hero-image-look">
		<img src="images/fw.png" alt = "Fashion week runway" class = "blog-hero-image">
		</div>
		</div>
	</section>

	<section class="blog-layout">
	<section class="blog-main" id="blog-main">
	<div class="pagination-controls">
		<div class="pagination-selector">
			<label for="posts-per-page">Posts per page:</label>
			<select id="posts-per-page" class="posts-per-page-select">
				<option value="3">3</option>
				<option value="5" selected>5</option>
				<option value="10">10</option>
				<option value="all">All</option>
			</select>
		</div>
		
		<div class="pagination-buttons">
			<button type="button" id="prev-page" class="btn small-btn pagination-btn" disabled>
				← Previous
			</button>
			<span id="page-info" class="page-info">Page 1</span>
			<button type="button" id="next-page" class="btn small-btn pagination-btn">
				Next →
			</button>
		</div>
	</div>
		
			<?php if (empty($posts)): ?>
				<p class="muted">No posts yet. Log in and add the first Fashion Week entry!</p>
			<?php else: ?>
				<?php foreach ($posts as $index => $post): ?>
					<?php
						// Defensive defaults
						$postId   = $post['id']    ?? ('post' . $index);
						$title    = $post['title'] ?? 'Untitled post';
						$date     = $post['date']  ?? '';
						$category = $post['category'] ?? '';
						$paras    = $post['paragraphs'] ?? [];
					?>
					<article
						id="post-<?php echo htmlspecialchars($postId); ?>"
						class="blog-post"
						data-post-id="<?php echo htmlspecialchars($postId); ?>"
					>
						<header class="blog-post-header">
							<h2 class="blog-post-title">
								<?php echo htmlspecialchars($title); ?>
							</h2>

							<div class="blog-post-meta">
								<?php if ($date): ?>
									<span class="blog-post-date">
										<?php echo htmlspecialchars($date); ?>
									</span>
								<?php endif; ?>
								<?php if ($category): ?>
									<span class="blog-post-category">
										<?php echo htmlspecialchars($category); ?>
									</span>
								<?php endif; ?>
							</div>

							<?php if ($is_logged_in): ?>
								<button
									type="button"
									class="btn small-btn delete-post-btn"
									data-delete-post="<?php echo htmlspecialchars($postId); ?>"
								>
									Delete
								</button>
							<?php endif; ?>
						</header>

						<div class="blog-post-body">
							<?php if (!empty($paras) && is_array($paras)): ?>
								<?php foreach ($paras as $para): ?>
									<p><?php echo $para; ?></p>
								<?php endforeach; ?>
							<?php else: ?>
								<p class="muted">This post has no content yet.</p>
							<?php endif; ?>
						</div>
						<div class="comment-section" data-post-id="<?php echo htmlspecialchars($postId); ?>">
							<h3 class="comment-heading">Comments</h3>
							
							<div class="comments-list" id="comments-<?php echo htmlspecialchars($postId); ?>">
								<p class="loading-comments">Loading comments...</p>
							</div>

							 // Add Comment Form 

							<form class="comment-form" data-post-id="<?php echo htmlspecialchars($postId); ?>">
								<h4>Leave a Comment</h4>
								<div class="form-group">
									<label for="comment-author-<?php echo htmlspecialchars($postId); ?>">
										Name (optional - leave blank for Anonymous):
									</label>
									<input
										type="text"
										id="comment-author-<?php echo htmlspecialchars($postId); ?>"
										name="author"
										placeholder="Your name or leave blank"
										maxlength="100"
									>
								</div>
								<div class="form-group">
									<label for="comment-text-<?php echo htmlspecialchars($postId); ?>">
										Comment: <span class="required">*</span>
									</label>
									<textarea
										id="comment-text-<?php echo htmlspecialchars($postId); ?>"
										name="text"
										placeholder="Share your thoughts..."
										required
										rows="4"
										maxlength="1000"
									></textarea>
								</div>
								<button type="submit" class="btn primary-btn">Post Comment</button>
							</form>
							</div>
					</article>
				<?php endforeach; ?>
			<?php endif; ?>
			
			//Pagination controls (bottom)

	<div class="pagination-controls pagination-bottom">
		<div class="pagination-buttons">
			<button type="button" id="prev-page-bottom" class="btn small-btn pagination-btn" disabled>
				← Previous
			</button>
			<span id="page-info-bottom" class="page-info">Page 1</span>
			<button type="button" id="next-page-bottom" class="btn small-btn pagination-btn">
				Next →
			</button>
		</div>
	</div>
		</section>


		
		<aside class="blog-aside">
			<h2>Posts</h2>
			
			//Search bar

	<div class="blog-search">
		<input
			type="text"
			id="post-search"
			class="search-input"
			placeholder="Search posts..."
			aria-label="Search posts"
		>
		<button type="button" id="clear-search" class="btn small-btn" style="display: none;">
			Clear
		</button>
	</div>

	<div id="search-results-info" class="search-info" style="display: none;"></div>

			<?php if (empty($posts)): ?>
				<p class="muted">No posts to list yet.</p>
			<?php else: ?>
				<ul class="blog-post-list" id="aside-post-list">
					<?php foreach ($posts as $index => $post): ?>
						<?php
							$postId = $post['id'] ?? ('post' . $index);
							$title  = $post['title'] ?? 'Untitled post';
						?>
						<li
							class="blog-post-list-item"
							data-aside-post-id="<?php echo htmlspecialchars($postId); ?>"
						>
							<a href="#post-<?php echo htmlspecialchars($postId); ?>">
								<?php echo htmlspecialchars($title); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</aside>
	</section>
	</main>

	<?php include 'footer.php'; ?>
	</body>
	</html>