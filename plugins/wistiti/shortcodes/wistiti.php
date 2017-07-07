<?php

/* A generic  shortcode for all wistiti elements

Attibutes :
type = post type
id = post id (meta)
meta_key = meta key
meta_value = meta value
tax_key = taxonomy key
tax_value = taxonomy value
layout = list or grid
col : number of cols for grid layout
display : media, card or collapsible
background : a background url
firstheadinghierarchy : Hx starting level
*/

function wistiti_shortcode($atts = [], $content = null, $tag = '') {

    //Type
    if (!isset($atts['type']) || empty($atts['type'])) return false;

    //Default values according to type
    $default_layout = 'list';
    $default_display = 'media';
    $default_col = 3;
    $default_firstheadinghierarchy = 3;
    $default_background = '';

    switch ($atts['type']) {

      case 'jumbotron':
      $default_layout = 'jumbotron';
      $default_display = 'classic';
      $default_firstheadinghierarchy = 1;
      break;

      case 'card':
      $default_layout = 'card';
      $default_display = 'classic';
      break;

      case 'block':
      $default_layout = 'block';
      $default_display = 'card';
      break;

      case 'teammember':
      case 'service':
      case 'link':
        $default_layout = 'grid';
        $default_display = 'card';
      break;

      case 'faq':
        $default_display = 'collapsible';
      break;

      default:
      break;
    }

    //Taxonomie
		$atts = shortcode_atts(
		array(
			'type' => '',
      'id' => '',
      'meta_key' => '',
      'meta_value' => '',
      'tax_key' => '',
			'tax_value' => '',
			'layout' => $default_layout,
			'col' => $default_col,
			'display' => $default_display,
      'background' => $default_background,
 			'firstheadinghierarchy' => $default_firstheadinghierarchy
		), $atts);
		$atts = array_change_key_case((array)$atts, CASE_LOWER);

		//Query
    //Post ID

    //Post meta
    $meta_key = '';
    $meta_value = '';
    if (isset($atts['meta_key']) && !empty($atts['meta_key'])) {
      $meta_key = '_'.$atts['type'].'_'.$atts['meta_key'];
      $meta_value = $atts['meta_value'];
    }

    //Taxonomy
		$tax_arg = null;
		if (isset($atts['tax_key']) && !empty($atts['tax_value']))
			$tax_arg = array(
					array(
							'taxonomy' => $atts['type'].'-'.$atts['tax_key'],
							'field' => 'slug',
							'terms' => $atts['tax_value']
			));
		$args = array(
	      'post_type' => $atts['type'],
        'p' => $atts['id'],
        'meta_key' => $meta_key,
        'meta_value' => $meta_value,
				'tax_query' => $tax_arg,
	      'orderby'=> 'menu_order',
	      'order' => 'ASC',
	      'post_status' => 'publish'
	    );

	  $atts['query'] = new WP_Query( $args );

		//Template
		ob_start();

		if (!empty($atts['query'])) wistiti_get_template($atts['layout'].'.php', $atts);

		return ob_get_clean();
}

add_shortcode( 'wistiti', 'wistiti_shortcode' );

?>
