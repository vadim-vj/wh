document.addEventListener('DOMContentLoaded', () => {
  for (const link of document.querySelectorAll('#content > ul:not(#nav-main) a')) {
    link.setAttribute('target', '_blank');
  }
});
