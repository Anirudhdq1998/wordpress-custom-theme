document.addEventListener('DOMContentLoaded', function () {
	const toggleButtons = document.querySelectorAll('.toggleButton');
	const menu = document.querySelector('.mob-nav-menu');

	// Add a click event listener to each toggle button
	toggleButtons.forEach(button => {
		button.addEventListener('click', function() {
			// Toggle the menu's display style between 'none' and 'block'
			if (menu.style.display === 'none' || menu.style.display === '') {
				menu.style.display = 'block';
				// Add the 'active' class to each toggle button span
				button.classList.add('active');
			} else {
				menu.style.display = 'none';

				button.classList.remove('active');
			}
		});
	});

}); 
(function () {
  const btn = document.querySelector('.backtotop');
  if (!btn) return;

  window.addEventListener('scroll', function () {
    // scrolled to bottom = scrollY + window height >= full document height
    const scrolledToBottom =
      window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 50;

    if (scrolledToBottom) {
      btn.classList.add('is-visible');
    } else {
      btn.classList.remove('is-visible');
    }
  });

  btn.addEventListener('click', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
})();
