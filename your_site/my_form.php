<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Which Fashion House Are You?</title>
  <link rel="stylesheet" href="my_style.css" />
  <script src="js/nav.js" defer></script>
</head>
<body>
  <header>
    <?php require_once 'nav.php'; ?>
  </header>

  <main class="container">
    <h1>Which fashion house are you?</h1>
    <p>Answer the questions below. If your total score is more than 20, we’ll reveal your haute-couture match.</p>

    <form id="fashion-quiz" action="quiz_verification.php" method="get" novalidate>
      <fieldset>
        <legend>Your info</legend>

        <div class="form-row">
          <label for="name">Your name</label>
          <input type="text" id="name" name="name" placeholder="e.g., Joey" required />
        </div><br>

        <div class="form-row">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="you@example.com" required />
        </div>
      </fieldset><br>

      <fieldset>
        <legend>Fashion reveal</legend>

   
        <div class="form-row">
          <span class="q-label">Q1. Your everyday style is closest to:</span>
          <div class="options">
            <label><input type="radio" name="q1" value="1" required /> Minimal, clean lines, neutral palette</label><br>
            <label><input type="radio" name="q1" value="3" /> Tailored classics with a twist</label><br>
            <label><input type="radio" name="q1" value="5" /> Bold, experimental, statement pieces</label><br> <br>
          </div>
        </div>

  
        <div class="form-row">
          <span class="q-label">Q2. Pick the details you gravitate toward</span>
          <div class="options">
            <label><input type="checkbox" name="q2" value="2" /> Monograms and logos</label><br>
            <label><input type="checkbox" name="q2" value="3" /> Architectural silhouettes</label><br>
            <label><input type="checkbox" name="q2" value="1" /> Understated luxury fabrics</label><br>
            <label><input type="checkbox" name="q2" value="2" /> Vintage-inspired touches</label><br><br>
          </div>
        </div>

      
        <div class="form-row">
          <label for="q3" class="q-label">Q3. Your dream fashion city</label>
          <select id="q3" name="q3" required>
            <option value="" disabled selected>Choose one</option><br>
            <option value="1">Milan</option><br>
            <option value="3">Paris</option><br>
            <option value="5">Tokyo</option><br><br>
          </select>
        </div>

        <div class="form-row">
          <label for="q4" class="q-label">Q4. How many statement items do you own?</label>
          <input type="number" id="q4" name="q4" min="0" max="20" step="1" value="2" />
        </div>

        <div class="form-row">
          <span class="q-label">Q5. Your approach to trends</span>
          <div class="options">
            <label><input type="radio" name="q5" value="5" required /> I set them</label><br>
            <label><input type="radio" name="q5" value="3" /> I adapt what suits me</label><br>
            <label><input type="radio" name="q5" value="1" /> I prefer timeless staples</label><br>
          </div>
        </div>
      </fieldset>

      <div class="form-actions">
        <button type="submit" class="btn primary">Reveal my house</button>
      </div>

      <output id="result" class="result" aria-live="polite"></output>
    </form>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const current_path = location.pathname;
      setNav(current_path);

      const form = document.getElementById('fashion-quiz');
      const out = document.getElementById('result');


        let total = 0;

        const q1 = form.querySelector('input[name="q1"]:checked');
        if (q1) total += Number(q1.value);

        form.querySelectorAll('input[name="q2"]:checked').forEach(cb => {
          total += Number(cb.value);
        });

		const q3 = Number(form.q3.value || 0);
        total += q3;

        const q4 = Number(form.q4.value || 0);
        total += Math.min(5, Math.round(q4 / 4)); 
		
        const q5 = form.querySelector('input[name="q5"]:checked');
        if (q5) total += Number(q5.value);

        let house = '';
        let blurb = '';

        if (total > 20) {
          house = 'Avant‑Garde House';
          blurb = 'Concept first. You love unconventional shapes, daring textures, and runway-level statements.';
        } else if (total >= 14) {
          house = 'Heritage House';
          blurb = 'Craft and legacy matter. You balance refinement with iconic codes and time-honored silhouettes.';
        } else {
          house = 'Minimalist House';
          blurb = 'Quiet luxury. You prefer clean tailoring, perfect fabrics, and pieces that whisper rather than shout.';
        }

        out.textContent = `Total score: ${total}. Your match: ${house}. ${blurb}`;
        out.classList.add('show');
        out.scrollIntoView({ behavior: 'smooth', block: 'center' });
      });
    });
  </script>
<?php include 'footer.php'; ?>
</body>
</html>