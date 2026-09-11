jQuery( function ( $ ) {

 const wpInlineEdit = inlineEditPost.edit;

 inlineEditPost.edit = function ( id ) {

  wpInlineEdit.apply( this, arguments );

  let postId = 0;

  if ( typeof id === 'object' ) postId = parseInt( this.getId( id ), 10 );
  else   postId = parseInt( id, 10 ); 

  if ( ! postId )  return;


  const row = $( '#post-' + postId );

  $( '.pc-quick-edit-short-title' ).val(
   row.find( '.pc-course-short-title' ).data( 'value' ) || '');

  $( '.pc-quick-edit-duration' ).val(
   row.find( '.pc-course-duration' ).data( 'value' ) || '');

  $( '.pc-quick-edit-lessons' ).val(
   row.find( '.pc-course-lessons' ).data( 'value' ) || '');
 };

} );

jQuery(document).ready(function ($) {

    $('.pc-course-icon-upload').on('click', function (e) {
        e.preventDefault();

        const btn = $(this);

        const mediaFrame = wp.media({
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

            const field = btn
                .closest('.pc-course-icon-field')
                .find('.pc-course-icon-id');

            const preview = btn
                .closest('.pc-course-icon-field')
                .find('.pc-course-icon-preview');

            const removeButton = btn
                .closest('.pc-course-icon-field')
                .find('.pc-course-icon-remove');

            field.val(attachment.id);

            preview.html(
                '<img src="' + attachment.url + '" ' +
                'style="max-width:60px;height:auto;">'
            );

            removeButton.show();
        });

        mediaFrame.open();
    });


    $('.pc-course-icon-remove').on('click', function (e) {
        e.preventDefault();

        const btn = $(this);

        const field = btn.closest('.pc-course-icon-field');

        field
            .find('.pc-course-icon-id')
            .val('');

        field
            .find('.pc-course-icon-preview')
            .empty();

        btn.hide();
    });

});