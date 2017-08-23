<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Wistiti
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" role="main">

			<?php
			while ( have_posts() ) : the_post();

				if (locate_template('components/page/content-' . $post->post_name . '.php')!='')
					get_template_part( 'components/page/content', $post->post_name );
				else
					get_template_part( 'components/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main>
	</div>
<?php
get_sidebar();
get_footer();
