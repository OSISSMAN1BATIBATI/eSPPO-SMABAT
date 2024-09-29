<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => 'C:/httpd/htdocs/esppo-smabat/panduan-esppo/user/config/system.yaml',
    'modified' => 1726551473,
    'size' => 733,
    'data' => [
        'absolute_urls' => false,
        'home' => [
            'alias' => '/rumah'
        ],
        'pages' => [
            'theme' => 'learn2',
            'markdown' => [
                'extra' => false
            ],
            'process' => [
                'markdown' => true,
                'twig' => false
            ]
        ],
        'cache' => [
            'enabled' => true,
            'check' => [
                'method' => 'file'
            ],
            'driver' => 'auto',
            'prefix' => 'g'
        ],
        'twig' => [
            'cache' => true,
            'debug' => true,
            'auto_reload' => true,
            'autoescape' => true
        ],
        'assets' => [
            'css_pipeline' => false,
            'css_minify' => true,
            'css_rewrite' => true,
            'js_pipeline' => false,
            'js_module_pipeline' => false,
            'js_minify' => true
        ],
        'errors' => [
            'display' => true,
            'log' => true
        ],
        'debugger' => [
            'enabled' => false,
            'twig' => true,
            'shutdown' => [
                'close_connection' => true
            ]
        ],
        'gpm' => [
            'verify_peer' => true
        ],
        'languages' => [
            'supported' => [
                0 => 'id'
            ],
            'default_lang' => 'id',
            'include_default_lang' => false,
            'include_default_lang_file_extension' => true,
            'http_accept_language' => true
        ]
    ]
];
