<footer>
    <div class="footer-content">
        <p>&copy; <?php echo date('Y'); ?> My Website. All rights reserved.</p>
    </div>
</footer>

<style>
footer {
    position: relative; 
    background-color: #333;
    color: white;
    text-align: center;
    padding: 20px;
    margin-top: auto !important;
    width: 100%;
}

main, .body_wraper, .container {
    flex: 1;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.footer-content {
    max-width: 1200px;
    margin: 0 auto;
}

footer a {
    color: #4CAF50;
    text-decoration: none;
}

footer a:hover {
    text-decoration: underline;
}

</style>