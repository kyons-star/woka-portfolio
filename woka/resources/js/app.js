/* woka – UI behaviour (previews, carousel, logout confirm, editor rows) */
(function () {
  'use strict';

  var $ = function (id) { return document.getElementById(id); };

  /* ---------- scale the 900px-wide portfolio previews to fit their card ---------- */
  function fit() {
    [].forEach.call(document.querySelectorAll('.pv'), function (p) {
      var w = p.clientWidth;
      var inner = p.firstElementChild;
      if (!w || !inner) return;
      inner.style.transform = 'scale(' + (w / 900) + ')';
      p.style.height = Math.round(w * (parseFloat(p.getAttribute('data-r')) || 0.9)) + 'px';
    });
  }
  window.addEventListener('resize', fit);
  window.addEventListener('load', fit);
  fit();

  /* ---------- home page: template carousel ---------- */
  var sl = $('slider');
  if (sl) {
    var tabs = [].slice.call(sl.querySelectorAll('.tab'));
    var N = tabs.length, i = 0, timer, paused = false, x0 = null;

    var go = function (n) {
      i = (n + N) % N;
      tabs.forEach(function (t, j) {
        t.classList.toggle('on', j === i);
        t.setAttribute('aria-selected', j === i);
      });
    };
    var restart = function () {
      clearInterval(timer);
      if (window.matchMedia('(prefers-reduced-motion:reduce)').matches) return;
      timer = setInterval(function () {
        if (!paused && !document.hidden) go(i + 1);
      }, 4500);
    };

    tabs.forEach(function (t, j) {
      t.addEventListener('click', function () { go(j); restart(); });
    });
    sl.addEventListener('mouseenter', function () { paused = true; });
    sl.addEventListener('mouseleave', function () { paused = false; });
    sl.addEventListener('focusin', function () { paused = true; });
    sl.addEventListener('focusout', function () { paused = false; });
    sl.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') { go(i - 1); restart(); }
      if (e.key === 'ArrowRight') { go(i + 1); restart(); }
    });
    sl.addEventListener('pointerdown', function (e) { x0 = e.clientX; });
    sl.addEventListener('pointerup', function (e) {
      if (x0 === null) return;
      var d = e.clientX - x0; x0 = null;
      if (Math.abs(d) > 50) { go(d < 0 ? i + 1 : i - 1); restart(); }
    });
    restart();
  }

  /* ---------- "Are you sure you want to log out?" ---------- */
  var modal = $('outModal'), navbtn = $('navbtn');
  if (modal && navbtn) {
    var closeOut = function () { modal.classList.remove('show'); navbtn.focus(); };
    navbtn.addEventListener('click', function () {
      modal.classList.add('show');
      $('outYes').focus();
    });
    $('outNo').addEventListener('click', closeOut);
    modal.addEventListener('click', function (e) { if (e.target === modal) closeOut(); });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.classList.contains('show')) closeOut();
    });
  }

  /* ---------- confirm before deleting a template ---------- */
  [].forEach.call(document.querySelectorAll('form[data-confirm]'), function (f) {
    f.addEventListener('submit', function (e) {
      if (!window.confirm(f.getAttribute('data-confirm'))) e.preventDefault();
    });
  });

  /* ---------- editor: add / remove rows, live avatar preview ---------- */
  [].forEach.call(document.querySelectorAll('[data-list]'), function (box) {
    var rows = box.querySelector('.rows');
    var tpl = box.querySelector('template');
    var next = parseInt(box.getAttribute('data-next'), 10) || 0;

    box.querySelector('[data-add]').addEventListener('click', function () {
      var html = tpl.innerHTML.replace(/__INDEX__/g, String(next++));
      rows.insertAdjacentHTML('beforeend', html);
    });
    box.addEventListener('click', function (e) {
      if (e.target.classList.contains('rm')) e.target.parentNode.remove();
    });
  });

  var file = $('efile'), epic = $('epic');
  if (file && epic) {
    file.addEventListener('change', function () {
      var f = file.files && file.files[0];
      if (!f) return;
      epic.style.backgroundImage = 'url("' + URL.createObjectURL(f) + '")';
    });
  }
})();