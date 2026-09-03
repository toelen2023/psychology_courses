document.addEventListener('DOMContentLoaded', function () {

 const buttons = document.querySelectorAll('.pc-copy-shortcode');

 buttons.forEach(function (button) {

  button.addEventListener('click', function () {

   const input = this.previousElementSibling;

   if (!input)     return;

   navigator.clipboard.writeText(input.value);
   const originalText = this.textContent;
   this.textContent = 'Скопировано';
   
   setTimeout(function () {
    button.textContent = originalText;
   }, 1500);

  });

 });

});