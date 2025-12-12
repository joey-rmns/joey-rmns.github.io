<?php
function isCurrentPage($page) {
   
    return '';
}
?>

<nav id="main-nav">
    <ul>
    <li><a href="index.php">Home</a></li>
    <li class="dropdown">
    <a href="#" class="dropbtn">Discover me!</a>
    <div class="dropdown-content">
    <a href="my_artistic_self.php"> Fashion </a>
    <a href="nave.php">Nave Agency</a>
    </div>
    </li>
    <li><a href="marketplace.php">Marketplace</a></li>
    <li><a href="my_form.php">Quizz!</a></li>
    <li><a href="blog.php">Fashion Week Blog</a></li> 
    <li><a href="login.php">Task list</a></li>
    </ul>

    <div class="hamburger" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
    </div>
</nav>

<style>

 /* Flexbox navigation layout */

#main-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #324a5f;
	border-bottom: 1px solid #eee;
    padding: 0.8% 0.8%;
    position: fixed;  
    top: 0;
    z-index: 1000;
	width:100%;
	

}


#main-nav ul {
    display: flex;
    align-items: center;
    gap: 11.5rem;         
    list-style: none;
    margin: 0;
    padding: 0;
}

#main-nav li {
    position: relative;
}


#main-nav a {
    text-decoration: none;
    color: #FDF0D5;
    padding: 0.4rem 0.6rem;
    border-radius: 999px;
    font-size: 0.95rem;
}

#main-nav a:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.current_page {
    font-weight: bold;
    color: #007bff;
    text-decoration: underline !important;
}

.dropdown {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.dropdown-content {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    background-color: #324a5f;
    min-width: 180px;
    z-index: 2000;
    padding: 0.4rem 0;
}

.dropdown-content a {
    color: black;
    padding: 0.5rem 0.9rem;
    text-decoration: none;
    display: block;
    border-radius: 0;
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

@media screen and (max-width: 768px) {
    #main-nav {
        flex-wrap: wrap;     
    }

    #main-nav ul {
        display: none;     
        flex-direction: column;
        width: 100%;
        margin-top: 0.5rem;
        background-color: #ffffff;
        padding: 0.5rem 0;
        border-top: 1px solid #eee;
    }

    #main-nav.responsive ul {
        display: flex;
    }

    .hamburger {
        display: flex;     
        margin-left: auto;
    }

    .dropdown-content {
        position: static;  
        box-shadow: none;
        min-width: 100%;
    }
}

</style>