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

//filter for courses
 function courseFilter() {

 const filters = document.querySelectorAll('.pc-course-filter');
 const grid = document.querySelector('.pc-courses-grid');
 const toggle = container.querySelector('.pc-course-cards__toggle');
 let expanded = false;

 function getVisibleLimit() {
   return window.innerWidth < 600?  4: 6;
 }

 if (!filters.length || !grid) return;
   

 const cards = Array.from(grid.querySelectorAll('.pc-course-card'));

 filters.forEach(function (filter) {

  filter.addEventListener('click', function () {

   const selectedFilter = this.dataset.filter;
   
   if (this.classList.contains('is-active'))  return;
   cards.forEach( (card) =>  card.classList.remove('is-removed'));

   // Определяем, какие карточки показывать.
   cards.forEach(function (card) {
    const badges = card.querySelectorAll('.pc-course-card__badge' );
    const shouldShow =  selectedFilter === 'all' ||
     Array.from(badges).some((badge) => badge.classList.contains(selectedFilter) );
    card.classList.toggle( 'is-hidden', ! shouldShow );
   });

   setTimeout(function () {
     cards.forEach((card) =>  {
        if(card.classList.contains('is-hidden')) card.classList.add('is-removed')
     });
   }, 300);
 
   filters.forEach( (button) =>  button.classList.remove('is-active') );
   this.classList.add('is-active');

  });

 });

};
courseFilter();