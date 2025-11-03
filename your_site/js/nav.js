function splitAtRoot(path) {
  const url = new URL(path, location.origin);
  return url.pathname;
}

function normalize(path) {
  path = splitAtRoot(path);
  path = path.replace(/\/index\.html$/, '/');
  if (path.length > 1 && path.endsWith('/')) path = path.slice(0, -1);
  return path;
}

function setNav(current_path) {
  fetch('nav.html', { cache: 'no-cache' })
    .then(r => r.text())
    .then(html => {
      const host = document.getElementById('main-nav');
      host.innerHTML = html;

      const current = normalize(current_path);
      host.querySelectorAll('a[href]').forEach(a => {
        const hrefNorm = normalize(a.href || a.getAttribute('href') || '');
        if (hrefNorm === current) {
          a.classList.add('current_page');
        } else {
          a.classList.remove('current_page');
        }
      });
    })
    .catch(err => console.error('Failed to load nav:', err));
}