<?php

return [
    
    'plugin_text_domain' => "codexshaper-framework",
    'plugin_namespaces' => "CodexShaper\\Framework\\",
    'plugin_base_path' => trailingslashit(untrailingslashit(plugin_dir_path( dirname(__DIR__, 4) ))),
    'plugin_base_url' => trailingslashit(untrailingslashit(plugins_url( '/', dirname(__DIR__, 3)))),
    'builder' => [
        'base_paths' => [],
        'field_namespaces' => [
            "CodexShaper\\Framework\\Builder\\OptionBuilder\\Fields\\",
            // Write your custom field namespace here
        ],
    ]
    
];