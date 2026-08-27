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

// ============================================
// ページ内アンカーメニューの現在地ハイライト
// ============================================
(function () {
  const nav = document.querySelector('.anchor-nav');
  if (!nav) return;

  const links = [...nav.querySelectorAll('a[href^="#"]')];
  const sections = links
    .map((a) => ({ link: a, el: document.getElementById(a.getAttribute('href').slice(1)) }))
    .filter((s) => s.el);
  if (!sections.length) return;

  const list = nav.querySelector('ul');
  let currentLink = null;

  function setCurrent(target) {
    if (target === currentLink) return;
    currentLink = target;
    sections.forEach(({ link }) => link.classList.toggle('is-current', link === target));

    // スマホの横並びメニューでは現在地が見えるよう横スクロールさせる
    if (list && list.scrollWidth > list.clientWidth + 1) {
      const left = target.offsetLeft - (list.clientWidth - target.offsetWidth) / 2;
      list.scrollTo({ left: Math.max(0, left), behavior: 'smooth' });
    }
  }

  // 画面上部（追従メニューの下）に最も近いセクションを現在地とする
  function update() {
    // スマホは横並びバーの直下、PCは固定ヘッダー分を基準線にする
    const isBar = list && getComputedStyle(list).display === 'flex';
    const offset = isBar ? nav.getBoundingClientRect().bottom + 20 : 140;
    let current = sections[0];
    for (const s of sections) {
      if (s.el.getBoundingClientRect().top <= offset) current = s;
    }
    // 最下部までスクロールしたら最後の項目を選択
    if (window.innerHeight + window.scrollY >= document.body.scrollHeight - 4) {
      current = sections[sections.length - 1];
    }
    setCurrent(current.link);
  }

  let ticking = false;
  window.addEventListener('scroll', () => {
    if (ticking) return;
    ticking = true;
    requestAnimationFrame(() => { update(); ticking = false; });
  }, { passive: true });

  window.addEventListener('resize', update);
  update();
})();
