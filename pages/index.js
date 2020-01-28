for (const link of document.querySelectorAll('main > article > :not(nav) a')) {
  link.setAttribute('target', '_blank');
  link.setAttribute('rel', 'noopener');
}
