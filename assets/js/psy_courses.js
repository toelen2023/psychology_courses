const swiper = new Swiper('.pc-teacher-slider-swiper', {
  // Optional parameters
  //direction: 'vertical',
  speed: 400,
  loop: true,
  slidesPerView: 1.1,
  spaceBetween: 20,

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

  // Navigation arrows
  navigation: {
    nextEl: '.pc-teacher-slider-next',
    prevEl: '.pc-teacher-slider-prev',
  },

  // And if we need scrollbar
  scrollbar: {
    el: '.swiper-scrollbar',
  },
  // Responsive breakpoints
  breakpoints: {
    // when window width is >= 320px
    360: {
      slidesPerView: 1.1,
    },
    // when window width is >= 480px
    576: {
      slidesPerView: 2.3,
    },
    // when window width is >= 640px
    768: {
      slidesPerView: 3.3,
    }
  }
});