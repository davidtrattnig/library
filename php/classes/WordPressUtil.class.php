<?php
/* Copyright (c) 2012 David Trattnig, subsquare.at
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require_once(get_template_directory() . "/classes/StringUtil.class.php");
					
class WordPressUtil
{	

	/** retrieves the meta description provided by the Yoast SEO Plugin **/
	static public function renderYoastMetaDescription() {
		$postCustom = get_post_custom($post->ID);
		$yoastMetaDescription = $postCustom['_yoast_wpseo_metadesc'][0];
		if ($yoastMetaDescription) {
			echo '<meta itemprop="description" content="' . $yoastMetaDescription . '">' . "\n";
		}
	}
	
	/** returns an array of thumbnail URLs for the given post ID **/
	static public function getThumbnails( $postId ) {
		return wp_get_attachment_image_src( get_post_thumbnail_id($postId), "thumbnail");	
	}
	
	/** returns the first thumbnail URL for the given post ID **/
	static public function getThumbnail( $postId ) {
		$images = wp_get_attachment_image_src( get_post_thumbnail_id($postId), "thumbnail");	
		return $images[0];
	}
	
	/** returns the large version of the thumbnail image **/
	static public function getFeatureImage() {
		$img = "";
		if ( has_post_thumbnail()) {
			$img = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
		}
		return ($img[0]);
	}
	
	/** checks the given content for the existence of a short code **/
	static public function hasShortcode( $content, $codeType ) {

		$result = FALSE;
		$codes = static::getShortcodes($content);
		
		foreach ($codes as $code):
			if (StringUtil::startsWith($code, "[".$codeType)) { //TODO improve regex
				$result = TRUE;
			}
		endforeach;	
		
		return $result;
	}
	
	/** retrieves all shortcodes withing the given content, empty string when shortcode n/a **/
	static public function getShortcodes( $content ) {
		preg_match('/\[.*\]/s', $content, $tags);
		return $tags;
	}
	
	/** returns the full path to the WP include directory "wp-includes" **/
	static public function wpIncludeDir() {
	    $wp_include_dir = preg_replace('/wp-content$/', 'wp-includes', WP_CONTENT_DIR);
	    return $wp_include_dir;
	}
	
}
					
?>