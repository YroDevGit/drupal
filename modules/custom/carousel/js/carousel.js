(function() {
  const trackContainer = document.getElementById('cCarouselTrackContainer');
  const scrollLeftBtn = document.getElementById('cCarouselScrollLeft');
  const scrollRightBtn = document.getElementById('cCarouselScrollRight');

  if (trackContainer && scrollLeftBtn && scrollRightBtn) {
    // Scroll left by 300px
    scrollLeftBtn.addEventListener('click', () => {
      trackContainer.scrollBy({
        left: -300,
        behavior: 'smooth'
      });
    });

    // Scroll right by 300px
    scrollRightBtn.addEventListener('click', () => {
      trackContainer.scrollBy({
        left: 300,
        behavior: 'smooth'
      });
    });
  }
})();
