<?php

if ( ! function_exists( 'csmf_inflector' ) ) {

	/**
	 * Get inflector instance
	 *
	 * @return \CodexShaper\Framework\Supports\Inflector The single instance of the class.
	 */
	function csmf_inflector() {
		if ( ! class_exists( '\CodexShaper\Framework\Support\Inflector' ) ) {
			return;
		}
		return CodexShaper\Framework\Support\Inflector::instance();
	}
}

if ( ! function_exists( 'csmf_tableize' ) ) {

	/**
	 * Get tableize name from given string name.
	 * E.g: ModelName converts to model_name
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The tableized name.
	 */
	function csmf_tableize( $word ) {
		return csmf_inflector()->tableize( $word );
	}
}

if ( ! function_exists( 'csmf_classify' ) ) {

	/**
	 * Get classify name from given string name.
	 * E.g. model_name converts to ModelName
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The classified name.
	 */
	function csmf_classify( $word ) {
		return csmf_inflector()->classify( $word );
	}
}

if ( ! function_exists( 'csmf_camelize' ) ) {

	/**
	 * Get camelize name from given string name.
	 * First converts to classiname e.g. model_name to ModelName
	 * Later convert first latter to small letter E.g: ModelName to modelName
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The camelized name.
	 */
	function csmf_camelize( $word ) {
		return csmf_inflector()->camelize( $word );
	}
}

if ( ! function_exists( 'csmf_capitalize' ) ) {

	/**
	 * Get capitalize name from given string name.
	 * E.g. top-o-the-morning to all_of_you! converts to Top-O-The-Morning To All_of_you!
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The capitalized name.
	 */
	function csmf_capitalize( $word ) {
		return csmf_inflector()->capitalize( $word );
	}
}

if ( ! function_exists( 'csmf_pluralize' ) ) {

	/**
	 * Get pluralize name from given string name.
	 * E.g: category converts to categories
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The pluralized name.
	 */
	function csmf_pluralize( $word ) {
		return csmf_inflector()->pluralize( $word );
	}
}

if ( ! function_exists( 'csmf_singularize' ) ) {

	/**
	 * Get singularize name from given string name.
	 * E.g. categories converts to category
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string Singularized name.
	 */
	function csmf_singularize( $word ) {
		return csmf_inflector()->singularize( $word );
	}
}

if ( ! function_exists( 'csmf_slug' ) ) {

	/**
	 * Get slug name from given string name.
	 * E.g: 'My first blog post' converts to 'my-first-blog-post'
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The slug.
	 */
	function csmf_slug( $word ) {
		return csmf_inflector()->slug( $word );
	}
}

if ( ! function_exists( 'csmf_title' ) ) {

	/**
	 * Get title name from given text.
	 * E.g: 'My first blog post' converts to 'my-first-blog-post'
	 *
	 * @param string $text The convertable text.
	 *
	 * @return string The title.
	 */
	function csmf_title( $text ) {
		$string = preg_replace( '/([a-z])([A-Z])/', '\\1 \\2', $text );
		$string = preg_replace( '/[-_]/', ' ', $string );
		return ucwords( $string );
	}
}
