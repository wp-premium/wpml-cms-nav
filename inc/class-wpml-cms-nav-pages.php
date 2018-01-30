<?php

class WPML_CMS_Nav_Pages {

	/** @var wpdb */
	private $wpdb;

	/** @var WPML_Display_As_Translated_Posts_Query */
	private $display_as_translated_query;

	public function __construct( wpdb $wpdb, WPML_Display_As_Translated_Posts_Query $display_as_translated_query ) {
		$this->wpdb                        = $wpdb;
		$this->display_as_translated_query = $display_as_translated_query;
	}

	/**
	 * @param string $current_language
	 * @param string $default_language
	 * @param bool $show_cat_menu
	 * @param int $page_for_posts
	 * @param bool $existing_content_language_verified
	 * @param string $order
	 * @param bool $pages_are_display_as_translated
	 *
	 * @return array
	 */
	public function get_pages(
		$current_language,
		$default_language,
		$show_cat_menu,
		$page_for_posts,
		$existing_content_language_verified,
		$order,
		$pages_are_display_as_translated
	) {

		// exclude some pages
		$excluded_pages_prepared = $this->wpdb->prepare( "
                SELECT post_id
                FROM {$this->wpdb->postmeta} pm LEFT JOIN {$this->wpdb->prefix}icl_translations tr ON pm.post_id = tr.element_id AND element_type='post_page'
                WHERE meta_key='_top_nav_excluded' AND meta_value <> '' AND tr.language_code = %s
                ", $current_language );

		$excluded_pages = $this->wpdb->get_col( $excluded_pages_prepared );

		$excluded_pages[] = 0; //add this so we don't have an empty array
		if ( ! $show_cat_menu && $page_for_posts ) {
			$excluded_pages[] = $page_for_posts;
		}
		$excluded_pages = wpml_prepare_in( $excluded_pages, '%d' );

		if ( current_user_can( 'read_private_pages' ) ) {
			$private = " OR post_status='private'";
		} else {
			$private = "";
		}

		if ( $existing_content_language_verified && 'all' != $current_language ) {

			if ( $pages_are_display_as_translated ) {
				$display_as_translated_types = array( 'page' );
			} else {
				$display_as_translated_types = array();
			}
			$display_as_translated_snippet = $this->display_as_translated_query->get_language_snippet( $current_language, $default_language, $display_as_translated_types );

			$pages_prepared = $this->wpdb->prepare( "
                    SELECT p.ID FROM {$this->wpdb->posts} p
                        JOIN {$this->wpdb->prefix}icl_translations t ON p.ID = t.element_id AND element_type='post_page'
                    WHERE post_type='page' AND (post_status='publish' {$private})
                        AND post_parent=0 AND p.ID NOT IN ({$excluded_pages})  AND ( t.language_code = %s || {$display_as_translated_snippet} )
                    ORDER BY " . $order, $current_language );

			$pages = $this->wpdb->get_col( $pages_prepared );

		} else {

			$pages_prepared = "
                    SELECT p.ID FROM {$this->wpdb->posts} p
                    WHERE post_type='page' AND (post_status='publish' {$private}) AND post_parent=0 AND p.ID NOT IN ({$excluded_pages})
                    ORDER BY " . $order;

			$pages = $this->wpdb->get_col( $pages_prepared );

		}

		return array( $pages, $excluded_pages );
	}
}