<?php

/*
Plugin Name: AppCommunity InstagramEmbed
Plugin URI: http://apppresser.com
Description: Embeds only the image from an Instrgram embed
Version: 0.0.1
Author: AppPresser Team
Author URI: http://apppresser.com
License: GPLv2
*/

class AppCommunity_InstagramEmbed {

	public function __construct() { }

	public function hooks() {
		add_filter('appcommunity_activity_content', array( $this, 'get_embed' ), 10, 2 );
	}

	public function get_embed( $content, $activity_id ) {

		$instagram_id = $this->get_instagram_id( $content );

		if( $instagram_id ) {
			$img_url = 'https://instagram.com/p/'.$instagram_id.'/media/?size=l';
			// $url     = 'https://www.instagram.com/p/'.$instagram_id.'/';

			return '<div class="instagram-img"><img src="' . $img_url . '" /></div>';
		}

		return $content;
	}

	public function get_instagram_id( $content ) {

		$re = '/data-instgrm-permalink=\\"https:\/\/www.instagram.com\/p\/(.*)\//mU';
		preg_match($re, $content, $matches, PREG_OFFSET_CAPTURE, 0);

		// Print the entire match result
		if($matches && isset($matches[1], $matches[1][0])) {
			return $matches[1][0];
		} else {
			$re = '/https:\/\/www.instagram.com\/p\/(.*)\//mU';
			preg_match($re, $content, $matches, PREG_OFFSET_CAPTURE, 0);

			// Print the entire match result
			if($matches && isset($matches[1], $matches[1][0])) {
				return $matches[1][0];
			}
		}

		return false;
	}
}

$appCommunity_InstagramEmbed = new appCommunity_InstagramEmbed();
$appCommunity_InstagramEmbed->hooks();