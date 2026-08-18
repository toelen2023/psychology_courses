<?php
/**
 * Single Course template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
 the_post();

 $prices = pc_get_course_prices( get_the_ID() );

 $duration = get_post_meta(
  get_the_ID(),
  pc_get_duration_meta_key(),
  true
 );
?>

<main class="pc-course">

 <header class="pc-course__header">

  <h1 class="entry-title"><?php the_title(); ?></h1>

 </header>

 <section class="pc-course__meta">

  <p>

   <strong><?php esc_html_e( 'Duration:', 'psychology-courses' ); ?></strong>

   <?php
   printf(
    esc_html(
     _n(
      '%d month',
      '%d months',
      (int) $duration,
      'psychology-courses'
     )
    ),
    (int) $duration
   );
   ?>

  </p>

 </section>

 <section class="pc-course__content">

  <?php the_content(); ?>

 </section>

 <section class="pc-course__prices">

  <h2>

   <?php esc_html_e(
    'Course price',
    'psychology-courses'
   ); ?>

  </h2>

  <table>

   <tbody>

   <?php foreach ( pc_get_currencies() as $code => $label ) : ?>

    <?php

    $full  = $prices[ $code ]['full'] ?? '';
    $month = $prices[ $code ]['month'] ?? '';

    ?>

    <tr>

     <th>

      <?php echo esc_html( $label ); ?>

     </th>

     <td>

      <?php echo esc_html( $full ); ?>

     </td>

     <td>

      <?php echo esc_html( $month ); ?>

     </td>

    </tr>

   <?php endforeach; ?>

   </tbody>

  </table>

 </section>

</main>

<?php

endwhile;

get_footer();