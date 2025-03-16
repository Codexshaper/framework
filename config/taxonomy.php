<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

return [
    'namespace' => 'CodexShaper\\Framework\\Taxonomies',
    'base_path' => trailingslashit(untrailingslashit(plugin_dir_path( dirname(__DIR__, 3) ))) . 'src/Taxonomies',
    'stub_name' => 'taxonomy',
];