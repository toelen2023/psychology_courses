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