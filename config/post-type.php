<?php

return [
    'namespace' => 'CodexShaper\\Framework\\PostTypes',
    'base_path' => trailingslashit(untrailingslashit(plugin_dir_path( dirname(__DIR__, 3) ))) . 'src/PostTypes',
    'stub_name' => 'post-type',
];