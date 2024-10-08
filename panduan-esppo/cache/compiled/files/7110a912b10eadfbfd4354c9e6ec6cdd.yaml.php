<?php
return [
    '@class' => 'Grav\\Common\\File\\CompiledYamlFile',
    'filename' => 'C:/httpd/htdocs/esppo-smabat/panduan-esppo/user/plugins/page-toc/blueprints.yaml',
    'modified' => 1715801932,
    'size' => 4821,
    'data' => [
        'name' => 'Page Toc',
        'type' => 'plugin',
        'slug' => 'page-toc',
        'version' => '3.2.4',
        'description' => 'Generate a table of contents and anchors from a page',
        'icon' => 'list',
        'author' => [
            'name' => 'Trilby Media, LLC',
            'email' => 'hello@trilby.media',
            'url' => 'http://trilby.media'
        ],
        'homepage' => 'http://trilby.media',
        'keywords' => 'grav, plugin, toc, anchors',
        'bugs' => 'https://github.com/trilbymedia/grav-plugin-page-toc/issues',
        'docs' => 'https://github.com/trilbymedia/grav-plugin-page-toc/blob/develop/README.md',
        'license' => 'MIT',
        'dependencies' => [
            0 => [
                'name' => 'grav',
                'version' => '>=1.7.26'
            ]
        ],
        'form' => [
            'validation' => 'strict',
            'fields' => [
                'enabled' => [
                    'type' => 'toggle',
                    'label' => 'PLUGIN_ADMIN.PLUGIN_STATUS',
                    'highlight' => 1,
                    'default' => 1,
                    'options' => [
                        1 => 'PLUGIN_ADMIN.ENABLED',
                        0 => 'PLUGIN_ADMIN.DISABLED'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ],
                'include_css' => [
                    'type' => 'toggle',
                    'label' => 'PLUGIN_PAGE_TOC.INCLUDE_CSS',
                    'highlight' => 1,
                    'default' => 1,
                    'options' => [
                        1 => 'PLUGIN_ADMIN.ENABLED',
                        0 => 'PLUGIN_ADMIN.DISABLED'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ],
                'active' => [
                    'type' => 'toggle',
                    'label' => 'PLUGIN_PAGE_TOC.ACTIVE_BY_DEFAULT',
                    'highlight' => 1,
                    'default' => 1,
                    'options' => [
                        1 => 'PLUGIN_ADMIN.ENABLED',
                        0 => 'PLUGIN_ADMIN.DISABLED'
                    ],
                    'validate' => [
                        'type' => 'bool'
                    ]
                ],
                'templates' => [
                    'type' => 'selectize',
                    'label' => 'PLUGIN_PAGE_TOC.ACTIVE_FOR_TEMPLATES',
                    'help' => 'PLUGIN_PAGE_TOC.ACTIVE_FOR_TEMPLATES_HELP',
                    'validate' => [
                        'type' => 'commalist'
                    ]
                ],
                'toc_section' => [
                    'type' => 'section',
                    'title' => 'PLUGIN_PAGE_TOC.TOC_SECTION',
                    'underline' => true,
                    'fields' => [
                        'start' => [
                            'type' => 'select',
                            'label' => 'PLUGIN_PAGE_TOC.START_TOC_HEADERS',
                            'help' => 'PLUGIN_PAGE_TOC.START_TOC_HEADERS_HELP',
                            'size' => 'x-small',
                            'classes' => 'fancy',
                            'options' => [
                                1 => 'H1',
                                2 => 'H2',
                                3 => 'H3',
                                4 => 'H4',
                                5 => 'H5',
                                6 => 'H6'
                            ],
                            'validate' => [
                                'type' => 'number'
                            ]
                        ],
                        'depth' => [
                            'type' => 'range',
                            'label' => 'PLUGIN_PAGE_TOC.DEPTH_TOC_HEADERS',
                            'help' => 'PLUGIN_PAGE_TOC.DEPTH_TOC_HEADERS_HELP',
                            'classes' => 'fancy',
                            'validate' => [
                                'min' => 1,
                                'max' => 6
                            ]
                        ],
                        'hclass' => [
                            'type' => 'text',
                            'label' => 'PLUGIN_PAGE_TOC.HEADER_CSS_CLASSES',
                            'help' => 'PLUGIN_PAGE_TOC.HEADER_CSS_CLASSES_HELP'
                        ],
                        'tags' => [
                            'type' => 'selectize',
                            'label' => 'PLUGIN_PAGE_TOC.ALLOWED_HTML_TAGS',
                            'help' => 'PLUGIN_PAGE_TOC.ALLOWED_HTML_TAGS_HELP',
                            'validate' => [
                                'type' => 'commalist'
                            ]
                        ]
                    ]
                ],
                'anchors_section' => [
                    'type' => 'section',
                    'title' => 'PLUGIN_PAGE_TOC.ANCHORS_SECTION',
                    'underline' => true,
                    'fields' => [
                        'anchors.start' => [
                            'type' => 'select',
                            'label' => 'PLUGIN_PAGE_TOC.START_ANCHOR_HEADERS',
                            'size' => 'x-small',
                            'classes' => 'fancy',
                            'options' => [
                                1 => 'H1',
                                2 => 'H2',
                                3 => 'H3',
                                4 => 'H4',
                                5 => 'H5',
                                6 => 'H6'
                            ],
                            'validate' => [
                                'type' => 'number'
                            ]
                        ],
                        'anchors.depth' => [
                            'type' => 'range',
                            'label' => 'PLUGIN_PAGE_TOC.DEPTH_ANCHOR_HEADERS',
                            'help' => 'PLUGIN_PAGE_TOC.DEPTH_ANCHOR_HEADERS_HELP',
                            'classes' => 'fancy',
                            'validate' => [
                                'min' => 1,
                                'max' => 6
                            ]
                        ],
                        'anchors.link' => [
                            'type' => 'toggle',
                            'label' => 'PLUGIN_PAGE_TOC.LINK_ANCHOR_HEADERS',
                            'highlight' => 1,
                            'default' => 1,
                            'options' => [
                                1 => 'Enabled',
                                0 => 'Disabled'
                            ],
                            'validate' => [
                                'type' => 'bool'
                            ]
                        ],
                        'anchors.aria' => [
                            'type' => 'text',
                            'label' => 'PLUGIN_PAGE_TOC.ARIA_LABEL',
                            'default' => 'Anchor'
                        ],
                        'anchors.class' => [
                            'type' => 'text',
                            'label' => 'PLUGIN_PAGE_TOC.ANCHORS_CLASS',
                            'help' => 'PLUGIN_PAGE_TOC.ANCHORS_CLASS_HELP'
                        ],
                        'anchors.icon' => [
                            'type' => 'text',
                            'label' => 'PLUGIN_PAGE_TOC.ANCHORS_ICON',
                            'help' => 'PLUGIN_PAGE_TOC.ANCHORS_ICON_HELP',
                            'default' => '#',
                            'size' => 'x-small'
                        ],
                        'anchors.position' => [
                            'type' => 'select',
                            'label' => 'PLUGIN_PAGE_TOC.ANCHORS_POSITION',
                            'help' => 'PLUGIN_PAGE_TOC.ANCHORS_POSITION_HELP',
                            'size' => 'small',
                            'default' => 'after',
                            'options' => [
                                'before' => 'PLUGIN_PAGE_TOC.BEFORE_TEXT',
                                'after' => 'PLUGIN_PAGE_TOC.AFTER_TEXT'
                            ]
                        ],
                        'anchors.copy_to_clipboard' => [
                            'type' => 'toggle',
                            'label' => 'PLUGIN_PAGE_TOC.COPY_TO_CLIPBOARD',
                            'help' => 'PLUGIN_PAGE_TOC.COPY_TO_CLIPBOARD_HELP',
                            'highlight' => 1,
                            'default' => 1,
                            'options' => [
                                1 => 'Enabled',
                                0 => 'Disabled'
                            ],
                            'validate' => [
                                'type' => 'bool'
                            ]
                        ],
                        'anchors.slug_maxlen' => [
                            'type' => 'number',
                            'label' => 'PLUGIN_PAGE_TOC.SLUG_MAXLEN',
                            'help' => 'PLUGIN_PAGE_TOC.SLUG_MAXLEN_HELP',
                            'size' => 'x-small',
                            'default' => 25,
                            'append' => 'chars'
                        ],
                        'anchors.slug_prefix' => [
                            'type' => 'text',
                            'label' => 'PLUGIN_PAGE_TOC.SLUG_PREFIX',
                            'help' => 'PLUGIN_PAGE_TOC.SLUG_PREFIX_HELP'
                        ]
                    ]
                ]
            ]
        ]
    ]
];
