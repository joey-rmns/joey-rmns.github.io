<?php
function isCurrentPage($page) {
    $current = basename($_SERVER['PHP_SELF']);
    return ($current === $page) ? 'current_page' : '';
}
?>

<nav id="main-nav">
    <ul>
        <li><a href="index.php" class="<?php echo isCurrentPage('index.php'); ?>">Home</a></li>
        <li class="dropdown">
            <a href="#" class="dropbtn">Discover me!</a>
            <div class="dropdown-content">
                <a href="my_artistic_self.php" class="<?php echo isCurrentPage('my_artistic_self.php'); ?>"> Fashion </a>
                <a href="nave.php" class="<?php echo isCurrentPage('nave.php'); ?>">Nave Agency</a>
            </div>
        </li>
        <li><a href="marketplace.php" class="<?php echo isCurrentPage('marketplace.php'); ?>">Marketplace</a></li>
        <li><a href="my_form.php" class="<?php echo isCurrentPage('my_form.php'); ?>">Quizz!</a></li>
		<li><a href="login.php" class="<?php echo isCurrentPage('login.php'); ?>">Task list</a></li>    </ul>
    
    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
</nav>

<script>
function toggleMenu() {
    const nav = document.getElementById('main-nav');
    nav.classList.toggle('responsive');
}
</script>

<style>
/* Dropdown menu styles */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* Hamburger menu styles */
.hamburger {
    display: none;
    flex-direction: column;
    cursor: pointer;
}

.hamburger span {
    width: 25px;
    height: 3px;
    background-color: #333;
    margin: 4px 0;
    transition: 0.4s;
}

/* Mobile responsive */
@media screen and (max-width: 768px) {
    #main-nav ul {
        display: none;
        flex-direction: column;
    }
    
    #main-nav.responsive ul {
        display: flex;
    }
    
    .hamburger {
        display: flex;
    }
    
    .dropdown-content {
        position: static;
    }
}

    .current_page {
    font-weight: bold;
    color: #007bff;
    text-decoration: underline !important;
}

</style>