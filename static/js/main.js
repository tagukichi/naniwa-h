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
// 日付欄の下限を今日にする（引越予定日）
// ============================================
(function () {
  const fields = document.querySelectorAll('input[type="date"][data-min-today]');
  if (!fields.length) return;

  const d = new Date();
  const today = d.getFullYear() + '-' +
    String(d.getMonth() + 1).padStart(2, '0') + '-' +
    String(d.getDate()).padStart(2, '0');

  fields.forEach((f) => f.setAttribute('min', today));
})();

// ============================================
// 見積フォームの必須チェック
// ブラウザ標準の吹き出しは環境差が大きいので、
// 項目の下と先頭にこちらでメッセージを出す。
// ============================================
(function () {
  const forms = document.querySelectorAll('form.form-card');
  if (!forms.length) return;

  // 「必須」ラベルから、メッセージに使う項目名を取り出す
  function labelOf(row, control) {
    const label = row && row.querySelector('.label');
    let text = label ? label.textContent : '';
    text = text.replace(/必須|任意/g, '').trim();

    // 1行に複数の入力欄がある場合は、読み上げ用ラベルで区別する
    if (control && control.id) {
      const own = row.querySelector('label[for="' + control.id + '"].visually-hidden');
      if (own) text += '（' + own.textContent.trim() + '）';
    }
    return text || 'この項目';
  }

  function isChoice(control) {
    return control.tagName === 'SELECT' || control.type === 'radio' || control.type === 'checkbox';
  }

  function clearErrors(form) {
    form.querySelectorAll('.form-row.is-error').forEach((r) => r.classList.remove('is-error'));
    form.querySelectorAll('.field-error, .form-alert').forEach((e) => e.remove());
  }

  function showFieldError(row, control, message) {
    row.classList.add('is-error');
    const holder = control.closest('.form-row > div') || row;
    if (holder.querySelector('.field-error')) return;
    const p = document.createElement('p');
    p.className = 'field-error';
    p.textContent = message;
    holder.appendChild(p);
  }

  function showSummary(form) {
    // 1行に2つ入力欄がある項目（階数など）は1か所として数える
    const count = form.querySelectorAll('.form-row.is-error').length;
    const inner = form.querySelector('.form-inner') || form;
    const box = document.createElement('div');
    box.className = 'form-alert';
    box.setAttribute('role', 'alert');
    box.textContent = '未入力の必須項目が ' + count + ' か所あります。ご確認ください。';
    inner.insertBefore(box, inner.firstChild);
    return box;
  }

  forms.forEach((form) => {
    // 入力し直したらその項目のエラー表示を消す
    form.addEventListener('input', onFix);
    form.addEventListener('change', onFix);

    function onFix(e) {
      const row = e.target.closest && e.target.closest('.form-row.is-error');
      if (!row) return;
      row.classList.remove('is-error');
      row.querySelectorAll('.field-error').forEach((p) => p.remove());
    }

    // 未入力の項目を集める
    function collect() {
      const seen = {};
      const invalid = [];

      form.querySelectorAll('[required]').forEach((control) => {
        // ラジオは同じ name でひとつの項目として扱う
        if (control.type === 'radio') {
          if (seen[control.name]) return;
          seen[control.name] = true;
          if (form.querySelector('input[name="' + control.name + '"]:checked')) return;
        } else if (control.value.trim() !== '') {
          // メールアドレスだけ形式も見る
          if (control.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(control.value.trim())) {
            invalid.push({ control: control, reason: 'format' });
          }
          return;
        }
        invalid.push({ control: control, reason: 'empty' });
      });

      return invalid;
    }

    // エラーを表示して、先頭の項目まで移動する
    function report(invalid) {
      invalid.forEach(({ control, reason }) => {
        const row = control.closest('.form-row');
        if (!row) return;
        const message =
          reason === 'format'
            ? 'メールアドレスの形式が正しくありません。'
            : labelOf(row, control) + 'を' + (isChoice(control) ? '選択' : '入力') + 'してください。';
        showFieldError(row, control, message);
      });

      const box = showSummary(form);
      box.scrollIntoView({ behavior: 'smooth', block: 'center' });

      const first = invalid[0].control;
      if (first.type === 'radio') {
        const row = first.closest('.form-row');
        if (row) row.setAttribute('tabindex', '-1');
      }
      setTimeout(() => {
        try {
          first.focus({ preventScroll: true });
        } catch (err) {
          first.focus();
        }
      }, 400);
    }

    function check() {
      clearErrors(form);
      const invalid = collect();
      if (!invalid.length) return true;
      report(invalid);
      return false;
    }

    // WordPress 側は submit ボタン
    form.addEventListener('submit', (e) => {
      // 「戻る」「修正する」は入力途中でも押せるようにする
      const submitter = e.submitter || document.activeElement;
      if (submitter && submitter.hasAttribute && submitter.hasAttribute('formnovalidate')) return;
      if (!check()) e.preventDefault();
    });

    // 静的プレビューは「次へ」がリンクなので、そちらも同じように止める
    form.addEventListener('click', (e) => {
      const next = e.target.closest('.form-actions a.btn-primary');
      if (!next || !form.contains(next)) return;
      if (!check()) e.preventDefault();
    });
  });
})();

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
