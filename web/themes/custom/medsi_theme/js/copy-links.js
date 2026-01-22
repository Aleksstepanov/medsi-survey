(function () {
  const onClick = async (e) => {
    const btn = e.target.closest("[data-copy]");
    if (!btn) return;

    const text = btn.getAttribute("data-copy");
    if (!text) return;

    try {
      await navigator.clipboard.writeText(text);
      const prev = btn.textContent;
      btn.textContent = "Скопировано ✓";
      setTimeout(() => (btn.textContent = prev), 1200);
    } catch {
      // Fallback (старые браузеры / запрет clipboard)
      const ta = document.createElement("textarea");
      ta.value = text;
      ta.style.position = "fixed";
      ta.style.left = "-9999px";
      document.body.appendChild(ta);
      ta.select();
      document.execCommand("copy");
      document.body.removeChild(ta);

      const prev = btn.textContent;
      btn.textContent = "Скопировано ✓";
      setTimeout(() => (btn.textContent = prev), 1200);
    }
  };

  document.addEventListener("click", onClick);
})();
