<?php

require_once 'nav.php';

$name = $_GET['name'] ?? '';
$email = $_GET['email'] ?? '';
$q1 = $_GET['q1'] ?? '';
$q3 = $_GET['q3'] ?? '';
$q4 = $_GET['q4'] ?? '';
$q5 = $_GET['q5'] ?? '';
$q2 = $_GET['q2'] ?? []; 

if (!is_array($q2)) {
    $q2 = [$q2];
}

$missing = ($name === '' || $email === '' || $q1 === '' || $q3 === '' || $q5 === '');

if ($missing) {
    echo "<h1>Oops! Missing data</h1>";
    echo "<p>Please go back and fill out all required fields.</p>";
    echo '<p><a href="my_form.php">&#8592; Return to Quiz</a></p>';
    include 'footer.php';
    exit();
}

$total = 0;
$total += (int)$q1;
$total += array_sum(array_map('intval', $q2));
$total += (int)$q3;
$total += min(5, round(($q4 ?? 0) / 4));
$total += (int)$q5;


if ($total > 20) {
    $result = "Avant‑Garde House";
    $description = "Concept first. You love unconventional shapes, daring textures, and runway-level statements.";
    $color = "#C0392B";
} elseif ($total >= 14) {
    $result = "Heritage House";
    $description = "Craft and legacy matter. You balance refinement with iconic codes and time-honored silhouettes.";
    $color = "#3498DB";
} else {
    $result = "Minimalist House";
    $description = "Quiet luxury. You prefer clean tailoring, perfect fabrics, and pieces that whisper rather than shout.";
    $color = "#27AE60";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Fashion House Result</title>
    <link rel="stylesheet" href="my_style.css">
    <style>
        body {
            background-color: #f6f6f6;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .result-container {
            max-width: 900px;
            margin: 60px auto;
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            font-size: 2em;
        }
        .result-box {
            padding: 20px;
            margin-top: 20px;
            background-color: #fafafa;
        }
        .categories {
            margin-top: 40px;
        }
        .category {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 15px;
        }
        footer {
            margin-top: 60px;
        }
        .btn-back {
            display: inline-block;
            margin-top: 20px;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-back:hover {
            background: #000 !important;
        }
    </style>
</head>
<body>

<div class="result-container">
    <h1>✨ Your Fashion House Result</h1>
    <div class="result-box" style="border-left: 8px solid <?php echo $color; ?>;">
        <h2 style="color: <?php echo $color; ?>;">You are: <?php echo $result; ?></h2>
        <p><?php echo $description; ?></p>
    </div>

    <div class="categories">
        <h3>All possible results:</h3>
        <div class="category" style="background-color: <?php echo $color; ?>20; padding: 10px; border-radius: 5px;"><strong>Avant‑Garde House:</strong> Daring, bold, experimental.</div>
        <div class="category" style="background-color: <?php echo $color; ?>20; padding: 10px; border-radius: 5px;"><strong>Heritage House:</strong> Classic, refined, timeless.</div>
        <div class="category" style="background-color: <?php echo $color; ?>20; padding: 10px; border-radius: 5px;"><strong>Minimalist House:</strong> Clean, modern, understated.</div>
    </div>

    <a href="my_form.php" class="btn-back" style="background: <?php echo $color; ?>;">← Take the quiz again</a>
</div>

<?php include 'footer.php'; ?>

</body>
</html>