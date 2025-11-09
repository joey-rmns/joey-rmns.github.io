	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="my_style.css">
		<title>Let's meet!</title>
		<script src="js/nav.js" defer></script>

		
	</head>
	<body>

		<?php require_once 'nav.php'; ?>
		
	<script>
	  document.addEventListener('DOMContentLoaded', () => {
	  const current_path = location.pathname;
	setNav(current_path);
	});
	</script>

		  
		<div class="body_wraper">

		<h1>Call me Joey, my name is long </h1>
		<h2>About Me</h2>

	  
		<p>Hello! My name is Joey, I'm Lebanese/Canadian, and I’m most interested in <strong>Artificial Intelligence</strong> &amp; <em>fashion</em>. 
		   Apart from studying Computer Science, I'm developing my own Automation and AI Creative Agency called <a href="nave.html">Nave</a>.</p>


		<p>I also studied in <a href="my_artistic_self.html">fashion school</a>.<br> Along with AI, I want to make fashion a big part of my life and career.</p>


	   
		<h2>My Hobbies</h2>
		<ul>
			<li>Playing Chess</li>
			<li>Attending social events</li>
			<li>Compose Music</li>
			<li>Produce AI fashion content</li>
		</ul>

	 
		<h2>My Top 3 Skills</h2>
		<ol>
			<li>Problem Solving</li>
			<li>Sales skills</li>
			<li>Teamwork</li>
		</ol>
	  
		</div>
		
<?php include 'footer.php'; ?>

	</body>
	</html>