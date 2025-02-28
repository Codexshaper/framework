<?php

if ( ! function_exists( 'cmf_inflector' ) ) {

	/**
	 * Get inflector instance
	 *
	 * @return \CodexShaper\Framework\Supports\Inflector The single instance of the class.
	 */
	function cmf_inflector() {
		if ( ! class_exists( '\CodexShaper\Framework\Support\Inflector' ) ) {
			return;
		}
		return CodexShaper\Framework\Support\Inflector::instance();
	}
}

if ( ! function_exists( 'cmf_tableize' ) ) {

	/**
	 * Get tableize name from given string name.
	 * E.g: ModelName converts to model_name
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The tableized name.
	 */
	function cmf_tableize( $word ) {
		return cmf_inflector()->tableize( $word );
	}
}

if ( ! function_exists( 'cmf_classify' ) ) {

	/**
	 * Get classify name from given string name.
	 * E.g. model_name converts to ModelName
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The classified name.
	 */
	function cmf_classify( $word ) {
		return cmf_inflector()->classify( $word );
	}
}

if ( ! function_exists( 'cmf_camelize' ) ) {

	/**
	 * Get camelize name from given string name.
	 * First converts to classiname e.g. model_name to ModelName
	 * Later convert first latter to small letter E.g: ModelName to modelName
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The camelized name.
	 */
	function cmf_camelize( $word ) {
		return cmf_inflector()->camelize( $word );
	}
}

if ( ! function_exists( 'cmf_capitalize' ) ) {

	/**
	 * Get capitalize name from given string name.
	 * E.g. top-o-the-morning to all_of_you! converts to Top-O-The-Morning To All_of_you!
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The capitalized name.
	 */
	function cmf_capitalize( $word ) {
		return cmf_inflector()->capitalize( $word );
	}
}

if ( ! function_exists( 'cmf_pluralize' ) ) {

	/**
	 * Get pluralize name from given string name.
	 * E.g: category converts to categories
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The pluralized name.
	 */
	function cmf_pluralize( $word ) {
		return cmf_inflector()->pluralize( $word );
	}
}

if ( ! function_exists( 'cmf_singularize' ) ) {

	/**
	 * Get singularize name from given string name.
	 * E.g. categories converts to category
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string Singularized name.
	 */
	function cmf_singularize( $word ) {
		return cmf_inflector()->singularize( $word );
	}
}

if ( ! function_exists( 'cmf_slug' ) ) {

	/**
	 * Get slug name from given string name.
	 * E.g: 'My first blog post' converts to 'my-first-blog-post'
	 *
	 * @param string $word The convertable word.
	 *
	 * @return string The slug.
	 */
	function cmf_slug( $word ) {
		return cmf_inflector()->slug( $word );
	}
}

if ( ! function_exists( 'cmf_title' ) ) {

	/**
	 * Get title name from given text.
	 * E.g: 'My first blog post' converts to 'my-first-blog-post'
	 *
	 * @param string $text The convertable text.
	 *
	 * @return string The title.
	 */
	function cmf_title( $text ) {
		$string = preg_replace( '/([a-z])([A-Z])/', '\\1 \\2', $text );
		$string = preg_replace( '/[-_]/', ' ', $string );
		return ucwords( $string );
	}
}
