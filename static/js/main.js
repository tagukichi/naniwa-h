// ============================================
// ドロワーメニュー
// ============================================
(function () {
  const toggle = document.querySelector('.nav-toggle');
  const drawer = document.querySelector('.drawer');
  const overlay = document.querySelector('.drawer-overlay');
  const closeBtn = document.querySelector('.drawer-close');
  if (!toggle || !drawer || !overlay) return;

  let lastFocused = null;

  function open() {
    lastFocused = document.activeElement;
    drawer.hidden = false;
    overlay.hidden = false;
    // hidden 解除直後だとトランジションが効かないため次フレームで付与
    requestAnimationFrame(() => {
      drawer.classList.add('show');
      overlay.classList.add('show');
    });
    toggle.setAttribute('aria-expanded', 'true');
    toggle.setAttribute('aria-label', 'メニューを閉じる');
    document.body.classList.add('drawer-open');
    if (closeBtn) closeBtn.focus();
  }

  function close() {
    drawer.classList.remove('show');
    overlay.classList.remove('show');
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'メニューを開く');
    document.body.classList.remove('drawer-open');

    const done = () => {
      drawer.hidden = true;
      overlay.hidden = true;
    };
    drawer.addEventListener('transitionend', done, { once: true });
    // トランジションが発火しない環境向けのフォールバック
    setTimeout(done, 400);

    if (lastFocused) lastFocused.focus();
  }

  toggle.addEventListener('click', () => {
    toggle.getAttribute('aria-expanded') === 'true' ? close() : open();
  });
  overlay.addEventListener('click', close);
  if (closeBtn) closeBtn.addEventListener('click', close);

  drawer.addEventListener('click', (e) => {
    if (e.target.closest('a')) close();
  });

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') close();
  });

  // ドロワー内でフォーカスを閉じ込める
  drawer.addEventListener('keydown', (e) => {
    if (e.key !== 'Tab') return;
    const items = drawer.querySelectorAll('a[href], button:not([disabled])');
    if (!items.length) return;
    const first = items[0];
    const last = items[items.length - 1];
    if (e.shiftKey && document.activeElement === first) {
      e.preventDefault();
      last.focus();
    } else if (!e.shiftKey && document.activeElement === last) {
      e.preventDefault();
      first.focus();
    }
  });
})();

// ============================================
// 荷物カウンター（見積フォーム）
// ============================================
(function () {
  document.querySelectorAll('.counter').forEach((counter) => {
    const input = counter.querySelector('input');
    if (!input) return;
    counter.querySelectorAll('button').forEach((btn) => {
      btn.addEventListener('click', () => {
        const step = btn.dataset.step === 'down' ? -1 : 1;
        const next = Math.max(0, (parseInt(input.value, 10) || 0) + step);
        input.value = next;
      });
    });
  });
})();

// ============================================
// FAQ カテゴリ内アンカーのスムーススクロール補正は CSS の
// scroll-padding-top で対応済み
// ============================================
