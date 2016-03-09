<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( ! is_search() ) : ?>

		<?php if ( has_post_thumbnail()) : ?>

		<div class="post-img-wrap">

			 	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >

				<?php the_post_thumbnail("post-thumbnail"); ?>

				</a>

		</div>

		<div class="listpost-content-wrap">

		<?php else: ?>

		<div class="listpost-content-wrap-full">

		<?php endif; ?>

	<?php else:  ?>

			<div class="listpost-content-wrap-full">

	<?php endif; ?>

	<div class="list-post-top">

	<header class="entry-header">

		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>

		<div class="entry-meta">

			<?php zerif_posted_on(); ?>

		</div><!-- .entry-meta -->

		<?php endif; ?>

	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>

	<div class="entry-summary">

		<?php the_excerpt(); ?>
		
	<?php else : ?>

	<div class="entry-content">

		<?php 
			$ismore = @strpos( $post->post_content, '<!--more-->');

			if($ismore) {
				the_content( sprintf( esc_html__('[...]','zerif-lite'), '<span class="screen-reader-text">'.esc_html__('about ', 'zerif-lite').get_the_title().'</span>' ) );
			} else {
				the_excerpt();
			}
			
			wp_link_pages( array(

				'before' => '<div class="page-links">' . __( 'Pages:', 'zerif-lite' ),

				'after'  => '</div>',

			) );

		endif; ?>

	</div><!-- .entry-content --><!-- .entry-summary -->

	</div><!-- .list-post-top -->

</div><!-- .listpost-content-wrap -->

</article><!-- #post-## -->