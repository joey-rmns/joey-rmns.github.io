<?php

require_once __DIR__ . '/includes/config.php';
start_custom_session();

if (empty($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'] ?? ($_COOKIE['todo-username'] ?? '');

$displayName = $username !== '' ? htmlspecialchars($username) : 'User';

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="my_style.css">
   <script src="js/nav.js" defer></script>
   
  <title><?php echo $displayName; ?>'s To-Do List</title>
  
  <style>
  /* Logout button styling */
  .logout-form {
      position: relative;
  }
  .logout-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #e74c3c;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 14px;
      z-index: 1000;
  }
  .logout-btn:hover {
      background: #c0392b;
  }
  </style>
</head>
<body>
<?php require_once 'nav.php'; ?>

<form action="login.php" method="post" class="logout-form">
    <button type="submit" name="action" value="logout" class="logout-btn">
        Log out
    </button>
</form>

	<script>
	  document.addEventListener('DOMContentLoaded', () => {
	  const current_path = location.pathname;
	setNav(current_path);
	});
	</script>
	
  <main class="todo-card">
    <h2><?php echo $displayName; ?>'s to‑do list</h2>

    <form id="todo-form" class="todo-form" onsubmit="return false;">
    <label for="todo-input" class="visually-hidden">Add a to‑do item</label>
    <input id="todo-input" type="text" placeholder="finish the lab" />
    <button id="add-btn" type="button">Add item</button>
    </form>

    <div class="todo-list-wrap">
    <h3>My to‑do list this week!</h3>
    <ul id="todo-list" class="todo-list"></ul>
    <p class="muted">Items are saved in your browser (localStorage).</p>
    </div>
  </main>

<script>
  const STORAGE_KEY = 'todo_items_v1';

  let items = [];

  const $input = document.getElementById('todo-input');
  const $addBtn = document.getElementById('add-btn');
  const $list = document.getElementById('todo-list');
  
  function load() {
    try {
    const raw = localStorage.getItem(STORAGE_KEY);
    items = raw ? JSON.parse(raw) : [];
    if (!Array.isArray(items)) items = [];
    } catch (e) {
    console.warn('Failed to parse items from storage', e);
    items = [];
    }
  }

  function save() {
    localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
  }

  function renderItem(item_text, id) {
    const li = document.createElement('li');
    li.className = 'todo-item';
    li.dataset.id = id;

    const span = document.createElement('span');
    span.className = 'todo-text';
    span.textContent = item_text;

    const actions = document.createElement('span');
    actions.className = 'todo-actions';

    const delBtn = document.createElement('button');
    delBtn.className = 'icon-btn';
    delBtn.title = 'Delete';
    delBtn.textContent = '🗑️';
    delBtn.addEventListener('click', () => removeItem(id));

    actions.appendChild(delBtn);
    li.appendChild(span);
    li.appendChild(actions);
    $list.appendChild(li);
  }
  
  function renderAll() {
    $list.innerHTML = '';
    items.forEach(({ text, id }) => renderItem(text, id));
  }

  function addItem() {
    const text = $input.value.trim();
    if (!text) {
    alert('Please write something to add.');
    return;
    }
    const id = (crypto.randomUUID && typeof crypto.randomUUID === 'function')
    ? crypto.randomUUID()
    : Date.now().toString();

    const item = { id, text };
    items.push(item);
    save();    
    renderItem(item.text, item.id);
    $input.value = '';
    $input.focus();
  }

 
  function removeItem(id) {
    items = items.filter(i => i.id !== id);
    save();
    renderAll();
  }

  document.addEventListener('DOMContentLoaded', () => {
    if (typeof setNav === 'function') setNav(location.pathname);

    load();    
    renderAll();  

    $addBtn.addEventListener('click', addItem);

    $input.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') addItem();
    });
  });
</script>

<?php require_once 'footer.php'; ?>

</body>
</html>