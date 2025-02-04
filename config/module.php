<?php

return [
    'widget' => [
        'elementor' => [
            'module_prefix' => 'cxf--',
            'widget_prefix' => 'cxf--',
            'module_stub_name' => 'el-module',
            'module_config_stub_name' => 'el-module-config',
            'widget_stub_name' => 'el-widget',
            'view_stub_name' => 'el-view',
            'view_filename' => 'content',
            'view_extension' => 'view.php',
            'widget_category' => 'cxf--widget',
            'base_path' => cxf_plugin_base_path() . 'widgets/elementor/',
            'namespace' => "CodexShaper\\Framework\\Widgets\\Elementor\\Modules",
        ],
        'wordpress' => [
            'module_prefix' => 'cxf--',
            'widget_prefix' => 'cxf--',
            'module_stub_name' => 'wp-module',
            'widget_stub_name' => 'wp-widget',
            'view_stub_name' => 'wp-view',
            'view_filename' => 'content',
            'view_extension' => 'view.php',
            'widget_category' => 'cxf--widget',
            'base_path' => cxf_plugin_base_path() . 'widgets/wordpress/',
            'namespace' => "CodexShaper\\Framework\\Widgets\\Wordpress\\Modules",
        ],
    ],
];