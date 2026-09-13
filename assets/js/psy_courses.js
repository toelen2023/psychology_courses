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
    },
    1100: {
      slidesPerView: 4.3,
    }
  }
});


//filter for courses
 function courseFilter() {

 const filters = document.querySelectorAll('.pc-course-filter');
 const grid = document.querySelector('.pc-courses-grid');

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
   toggleCards(true);
   updateCards(true, selectedFilter);
  });
 });
};

courseFilter();

let getVisibleLimit = () => window.innerWidth < 600 ? 4 : 6;

let cardsExpanded = false;

const toggle = document.querySelector('.pc-course-cards__toggle');


function updateToggleButton() {

    if (!toggle) return;

    toggle.textContent = cardsExpanded
        ? toggle.dataset.hideText
        : toggle.dataset.showText;

    toggle.classList.toggle('is-open', cardsExpanded);
}


function updateCards() {

    const cards = Array.from(
        document.querySelectorAll('.pc-course-card')
    );

    const visibleLimit = getVisibleLimit();
    let visibleCount = 0;

    cards.forEach(function (card) {

        /*
         * Cards excluded by the selected filter
         * remain hidden.
         */
        if (card.classList.contains('is-hidden')) {
            card.classList.add('is-removed');
            return;
        }

        /*
         * Filter is selected:
         * show all matching cards.
         */
        if (cardsExpanded) {
            card.classList.remove('is-removed');
            return;
        }

        /*
         * Normal state:
         * show only the first 4/6 matching cards.
         */
        if (visibleCount < visibleLimit) {
            card.classList.remove('is-removed');
            visibleCount++;
        } else {
            card.classList.add('is-removed');
        }
    });

    updateToggleButton();
}


if (toggle) {

    toggle.addEventListener('click', function () {

        cardsExpanded = !cardsExpanded;

        updateCards();
    });
}


updateCards();

