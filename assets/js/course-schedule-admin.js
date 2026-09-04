document.addEventListener('DOMContentLoaded', function () {

 const container = document.getElementById('pc-schedule-rows');
 const addButton = document.getElementById('pc-schedule-add-row');
 const template = document.getElementById('pc-schedule-row-template');

 if (!container ||  !addButton ||  !template)  return;


 let index = container.querySelectorAll('.pc-schedule-row').length;

 addButton.addEventListener('click', function () {

  const fragment = template.content.cloneNode(true);

  fragment.querySelectorAll('[name]').forEach(function (field) {

   field.name = field.name.replace( /\[INDEX\]/g, '[' + index + ']' );

  });

  container.appendChild(fragment);

  index++;
 });

 container.addEventListener('click', function (event) {

  const button = event.target.closest( '.pc-schedule-remove-row');
  if (!button)  return;
  
  const row = button.closest('.pc-schedule-course');
  if (row && confirm("Уверены, что надо удалить?")) row.remove();
  
 });

});

jQuery(document).ready(function ($) {

    let mediaFrame;

    $('.pc-schedule-icon-upload').on('click', function (e) {
        e.preventDefault();
        let btn =  $(this);

        if (mediaFrame) {
            mediaFrame.open();
            return;
        }

        mediaFrame = wp.media({
            title: 'Выберите иконку',
            button: {
                text: 'Использовать изображение'
            },
            multiple: false
        });

        mediaFrame.on('select', function () {

            const attachment = mediaFrame
                .state()
                .get('selection')
                .first()
                .toJSON();

            btn.parent().find('.pc_schedule_icon').val(attachment.id);
            console.log("icon", btn.parent().find('.pc_schedule_icon'));

            btn.prev('.pc-schedule-icon-preview').html(
                '<img src="' + attachment.url + '" ' +
                'style="max-width:60px;height:auto;">'
            );

            btn.next('.pc-schedule-icon-remove').show();
            console.log("prev", btn.prev(),
                        "next", btn.next());
        });

        mediaFrame.open();
    });


    $('.pc-schedule-icon-remove').on('click', function (e) {
        e.preventDefault();
        let btn =  $(this);
        btn.parent().find('.pc_schedule_icon').val('');
        btn.parent().find('.pc-schedule-icon-preview').empty();
        btn.hide();
    });

});