document.addEventListener('DOMContentLoaded', () => {
  'use strict';

  const root = document.documentElement;

  /* =========================
     DARK MODE
  ========================== */
  const darkSwitch = document.getElementById('darkSwitch');
  const savedTheme = localStorage.getItem('theme');

  if (savedTheme) {
    root.setAttribute('theme-color', savedTheme);
    if (darkSwitch) darkSwitch.checked = savedTheme === 'dark';
  }

  darkSwitch?.addEventListener('change', e => {
    const theme = e.target.checked ? 'dark' : 'light';
    root.setAttribute('theme-color', theme);
    localStorage.setItem('theme', theme);
  });

  /* =========================
     RTL / LTR MODE
  ========================== */
  const rtlSwitch = document.getElementById('rtlSwitch');
  const savedDir = localStorage.getItem('dir');

  if (savedDir) {
    root.setAttribute('dir', savedDir);
    if (rtlSwitch) rtlSwitch.checked = savedDir === 'rtl';
  }

  rtlSwitch?.addEventListener('change', e => {
    const dir = e.target.checked ? 'rtl' : 'ltr';
    root.setAttribute('dir', dir);
    localStorage.setItem('dir', dir);
  });
});