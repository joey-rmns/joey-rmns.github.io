	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	  
	  <link rel="stylesheet" href="my_style.css">
		<script src= "js/1-marketplace.js"></script>
		 <script src="js/nav.js" defer></script>

	  
	  <title>marketplace</title>
	  <script src="js/1-marketplace.js" defer></script>
	</head>
	<body>

		<?php require_once 'nav.php'; ?>
		

		<h1> Hello! This is a marketplace </h1>
		
		<ol>
			<h2><li> Creating the cart</h2>
				<p> You have 0 item, for a total amount 0$, in your cart!</li>
			<h2><li> Adding 15 pants at 10.05$ each to the cart!</h2>
				<p> You have 1 item(s) in your cart, for a total amount 150.75$. With taxes, this is 173.36$. </li>
			<h2><li> Adding 1 coat at 99.99$ to the cart!</h2>
				<p> You have 2 item(s) in your cart, for a total amount 250.74$. With taxes, this is 288.35$. </li>

	<?php include 'footer.php'; ?>
	<body/>
	</html>