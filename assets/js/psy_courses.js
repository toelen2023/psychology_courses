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

 if (!filters.length || !grid) {
  return;
 }

 const cards = Array.from(
  grid.querySelectorAll('.pc-course-card')
 );

 filters.forEach(function (filter) {

  filter.addEventListener('click', function () {

   const selectedFilter = this.dataset.filter;

   // Не запускаем анимацию, если эта категория уже выбрана.
   
   if (this.classList.contains('is-active'))  return;

   /*
    * Возвращаем все карточки в layout.
    * Это необходимо при переходе с одного
    * фильтра на другой.
    */
   cards.forEach( (card) =>  card.classList.remove('is-removed'));

   // 1. Запоминаем начальные координаты.
 
   const firstPositions = new Map();

   cards.forEach(function (card) {

    const rect = card.getBoundingClientRect();

    firstPositions.set(card, {
     left: rect.left,
     top: rect.top,
    });

   });

   /*
    * 2. Определяем, какие карточки показывать.
    * selectedFilter берётся из data-filter кнопки и содержит slug категории.
    */
   cards.forEach(function (card) {

    const badges = card.querySelectorAll('.pc-course-card__badge' );

    const shouldShow =  selectedFilter === 'all' ||
     Array.from(badges).some((badge) => badge.classList.contains(selectedFilter) );

    card.classList.toggle( 'is-hidden', ! shouldShow );

   });

   //3. Заставляем браузер пересчитать Grid.

   grid.offsetHeight;

   // 4. Получаем новые координаты  и запускаем FLIP-анимацию.
   
   cards.forEach(function (card) {

    const first = firstPositions.get(card);
    if (! first) return;

    const last = card.getBoundingClientRect();

    const deltaX = first.left - last.left;
    const deltaY = first.top - last.top;

    // Карточка должна исчезнуть.
   
    if (card.classList.contains('is-hidden')) {

     card.animate(
      [
       {
        opacity: 1,
        transform: 'translate(0, 0) scale(1)',
       },
       {
        opacity: 0,
        transform:'translate(0, 0) scale(0.95)',
       },
      ],
      { duration: 300,
       easing: 'ease',
       fill: 'forwards', });

     return;
    }

    // Карточка осталась, но её положение изменилось.
     
    if ( Math.abs(deltaX) > 1 ||  Math.abs(deltaY) > 1 ) {

     card.animate(
      [ 
        { transform: `translate(${deltaX}px,${deltaY}px)`,  },
        { transform: 'translate(0, 0)', },
      ],
      {
       duration: 400,
       easing: 'ease',
      } );

    }

   });

   //5. После исчезновения карточек убираем их из Grid.
    
   setTimeout(function () {

    cards.forEach(function (card) {

     if (card.classList.contains('is-hidden'))   card.classList.add('is-removed');

    });

   }, 300);

   //6. Переключаем активную кнопку.
 
   filters.forEach( (button) =>  button.classList.remove('is-active') );
   this.classList.add('is-active');

  });

 });

};
courseFilter();