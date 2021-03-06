<?php

	global $wp_customize;

	$zerif_total_posts = get_option('posts_per_page'); /* number of latest posts to show */

	if( !empty($zerif_total_posts) && ($zerif_total_posts > 0) ):

		echo '<section class="latest-news" id="latestnews">';

			echo '<div class="container">';

				echo '<div class="row">';

					echo '<div class="latest-news-widget col-lg-6 col-md-6 column">';


					if (is_active_sidebar('latest-news-right')):
						dynamic_sidebar('latest-news-right');
					endif;

					echo '</div>';


				/* SECTION HEADER */

				



				echo '<div id="carousel-homepage-latestnews" class="carousel slide col-lg-6 col-md-6 column" data-ride="carousel">';

				echo '<div class="section-header">';

					$zerif_latestnews_title = get_theme_mod('zerif_latestnews_title');

					// title
					if( !empty($zerif_latestnews_title) ):

						echo '<h2 class="black-text">' . wp_kses_post( $zerif_latestnews_title ) . '</h2>';

					else:

						echo '<h2 class="black-text">' . __('blabla','zerif-lite') . '</h2>';

					endif;

					/* subtitle */
					$zerif_latestnews_subtitle = get_theme_mod('zerif_latestnews_subtitle');

					if( !empty($zerif_latestnews_subtitle) ):

						echo '<div class="dark-text section-legend">'.wp_kses_post( $zerif_latestnews_subtitle ).'</div>';

					elseif ( isset( $wp_customize ) ):

						echo '<div class="dark-text section-legend zerif_hidden_if_not_customizer"></div>';

					endif;

				echo '</div><!-- END .section-header -->';

					

					

					echo '<div class="carousel-inner" role="listbox">';


						$zerif_latest_loop = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => $zerif_total_posts, 'order' => 'DESC','ignore_sticky_posts' => true, 'category_name' => 'Fremhevet' ) );

						$newSlideActive = '<div class="item active">';
						$newSlide 		= '<div class="item">';
						$newSlideClose 	= '<div class="clear"></div></div>';
						$i_latest_posts= 0;

						if ( $zerif_latest_loop->have_posts() ) :

							while ( $zerif_latest_loop->have_posts() ) : $zerif_latest_loop->the_post();

								$i_latest_posts++;

								if ( !wp_is_mobile() ){

										if($i_latest_posts == 1){
											echo $newSlideActive;
										}
										else if($i_latest_posts % 4 == 1){

											echo $newSlide;
										}

										echo '<div class="col-sm-3 latestnews-box">';

											echo '<div class="latestnews-img">';

												echo '<a class="latestnews-img-a" href="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'">';

													if ( has_post_thumbnail() ) :
														the_post_thumbnail();
													else:
														echo '<img src="'.esc_url( get_template_directory_uri() ).'/images/blank-latestposts.png" alt="'.esc_attr( get_the_title() ).'" />';
													endif;

												echo '</a>';

											echo '</div>';

											echo '<div class="latesnews-content">';

												$title = get_the_title();

												echo '<h3 class="latestnews-title"><a href="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'" style="color: black">'.wp_kses_post( $title ).'</a></h3>';

												echo '<div class="latestnews-description">';
													$ismore = @strpos( $post->post_content, '<!--more-->');

													if($ismore) {
														the_content( sprintf( esc_html__('[...]','zerif-lite'), '<span class="screen-reader-text">'.esc_html__('about ', 'zerif-lite').get_the_title().'</span>' ) );
													} else {
														echo excerpt(25);
													}
												echo '</div>';
											echo '</div>';

										echo '</div><!-- .latestnews-box"> -->';

										/* after every four posts it must closing the '.item' */
										if($i_latest_posts % 4 == 0){
											echo $newSlideClose;
										}

								} else {

									if($i_latest_posts) $active = 'active'; else $active = '';

									echo '<div class="item '.$active.'">';
										echo '<div class="col-md-3 latestnews-box">';
											echo '<div class="latestnews-img">';
												echo '<a class="latestnews-img-a" href="'.get_permalink().'" title="'.get_the_title().'">';
													if ( has_post_thumbnail() ) :
														the_post_thumbnail();
													else:
														echo '<img src="'.esc_url( get_template_directory_uri() ).'/images/blank-latestposts.png" alt="'.esc_attr( get_the_title() ).'" />';
													endif;
												echo '</a>';

											echo '</div>';
											echo '<div class="latesnews-content">';
												echo '<h3 class="latestnews-title"><a href="'.esc_url( get_permalink() ).'" title="'.esc_attr( get_the_title() ).'" style="color: black">'.wp_kses_post( get_the_title() ).'</a></h3>';

												$ismore = @strpos( $post->post_content, '<!--more-->');

												if($ismore) {
													the_content( sprintf( esc_html__('[...]','zerif-lite'), '<span class="screen-reader-text">'.esc_html__('about ', 'zerif-lite').get_the_title().'</span>' ) );
												} else {
													the_excerpt();
												}
											echo '</div>';
										echo '</div>';
									echo '</div>';
								}

							endwhile;

						endif;

						if ( !wp_is_mobile() ) {

							// if there are less than 10 posts
							if($i_latest_posts % 4!=0){
								echo $newSlideClose;
							}

						}

						wp_reset_postdata();

					echo '</div><!-- .carousel-inner -->';

				echo '</div><!-- #carousel-homepage-latestnews -->';

				echo '</div><!-- .row -->';


			echo '</div><!-- .container -->';
		echo '</section>';

endif; ?>
