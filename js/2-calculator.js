function compute_days() {
  const dob = get_dob();

  const birth = dob instanceof Date ? dob : new Date(dob);
  if (isNaN(birth.getTime())) {
    write_answer_days("Please enter a valid date of birth.");
    return;
  }

  const now = new Date();
  const start = new Date(birth.getFullYear(), birth.getMonth(), birth.getDate());
  const end = new Date(now.getFullYear(), now.getMonth(), now.getDate());

  const msPerDay = 24 * 60 * 60 * 1000;
  const diffDays = Math.floor((end - start) / msPerDay);

  write_answer_days('You are approximately ${diffDays.toLocaleString()} days old.');
}

function compute_circle() {
  const screen = get_screen_dims();

  const minSide = Math.min(screen.width, screen.height);
  const radius = minSide / 2;
  const area = Math.PI * radius * radius;

  write_answer_circle(
    'Screen: ${screen.width} × ${screen.height} px <br>' +
      'Max circle radius: ${radius.toFixed(2)} px <br>' +
      'Area: ${area.toFixed(2)} px²'
  );
}

function check_palindrome() {
  let text_input = get_palindrome();
  if (typeof text_input !== "string") {
    write_answer_palindrome("Please enter text to check.");
    return;
  }

  const normalized = text_input.replace(/[^a-z0-9]/gi, "").toLowerCase();

  let isPal = true;
  for (let i = 0, j = normalized.length - 1; i < j; i++, j--) {
    if (normalized[i] !== normalized[j]) {
      isPal = false;
      break;
    }
  }

  write_answer_palindrome(
    'Input: "${text_input}<br>'+
      Normalized: '${normalized}<br>'+
      (normalized.length === 0
        ? "No alphanumeric characters to check."
        : isPal
        ? "Result: It is a palindrome"
        : "Result: It is not a palindrome")"
  );
}

function create_fibo() {
  
  const n = Number(get_number("fibo_length")); 

  if (!Number.isFinite(n) || n < 0 || !Number.isInteger(n)) {
    write_answer_fibo("Please enter a non-negative whole number for the length.");
    return;
  }

  const fib = [];
  if (n >= 1) fib.push(0);
  if (n >= 2) fib.push(1);

  for (let i = 2; i < n; i++) {
    fib.push(fib[i - 1] + fib[i - 2]);
  }

  
  write_answer_fibo(
    'Requested length: ${n}'
      (n === 0 ? "Sequence: []" : 'Sequence: [${fib.join(", ")}]')
  );
}