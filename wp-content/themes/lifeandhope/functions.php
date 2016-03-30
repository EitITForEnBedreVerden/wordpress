<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles',99);
function child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	 wp_enqueue_style( 'child-style',get_stylesheet_directory_uri() . '/custom.css', array( $parent_style ));
}
if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
         update_option( 'theme_mods_' . get_template(), $value );
         return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}

/* Redusere antall ord i latest news postene */
function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).' ...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

function content($limit) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).' ...';
    } else {
        $content = implode(" ",$content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

/* Trimme strl på tittelen på post i frontsiden */
function trim_title() {
    $title = get_the_title();
    $limit = 20;
    $pad=" ...";

    if(strlen($title) <= $limit) {
        echo $title;
    } else {
        $title = substr($title, 0, $limit) . $pad;
        echo $title;
    }
}

/* Legger til søkeboks i menyen som er satt som primary */
add_filter( 'wp_nav_menu_items','add_search_box', 10, 2 );
function add_search_box( $items, $args ) {
    if ($args->theme_location == 'primary') {
        $items .= '<li class="widget widget_search">' . get_search_form(false) . '</li>';
        $items .= '<li class="widget widget_translate">' . do_shortcode('[google-translator]') . '</li>';

    }
    return $items;
}




/**
 * Nytt widgetområde til høyre i "lastest news"/fremhevede innlegg-seksjonen
 *
 */
function featured_posts_widget_right() {

    register_sidebar( array(
        'name'          => 'Fremhevede innlegg(høyre)',
        'id'            => 'latest-news-right',
        'before_widget' => '
                            <div class="stripe-content">    
                            ',
        'after_widget'  => '</div>',
        'before_title'  => '
                            <div class="section-header">
                            <h2 class="black-text">
                            
        ',
        'after_title'   => '</h2></div>',
    ) );

}
add_action( 'widgets_init', 'featured_posts_widget_right' );

?>