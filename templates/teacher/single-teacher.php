<?php
/**
 * Single Teacher template.
 *
 * @package Psychology_Courses
 */

defined( 'ABSPATH' ) || exit;

get_header();

 ?>

 <main class="site-main" id="main">
   <article <?php post_class(); ?>>
    <div class="inside-article pc-teacher">
        <?php pc_get_template_part('teacher/content-teacher'); ?>
    </div>
   </article>
 </main>

 <?php

get_footer();