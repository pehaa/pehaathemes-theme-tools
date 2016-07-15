module.exports = function(grunt) {
 
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        pluginfiles : [
            '**.php',
            '!secret.php',
            'admin/css/**',
            'admin/js/**',
            'admin/**.php',
            'admin/**/*.php',
            'includes/**',
            'public/**',
            '!public/scss/**',
            'languages/**',
            'images/**',
            '**.txt',
            '**.md',
            'fonts/**',
            'plugin-update-checker/**'
        ],
        wp_readme_to_markdown: {
            dist: {
                files: {
                  'readme.md': 'readme.txt'
                },
            },
        },
        makepot: {
            target: {
                options: {
                    include: [],
                    type: 'wp-plugin',
                    potHeaders: { 
                        'report-msgid-bugs-to': 'info@pehaa.com' 
                    }
                }
            }
        },
        jshint: {
            files: [
                'admin/js/assets/**.js', 'public/js/assets/phtpb.js',
            ],
            options: {
                expr: true,
                globals: {
                    jQuery: true,
                    console: true,
                    module: true,
                    document: true
                }
            }
        },
        uglify: {
            dist: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= pkg.version %> phtpb-admin.min.js */\n',
                },
                files: {
                    'admin/js/pehaathemes-theme-tools-upload-media.min.js' : [
                        'admin/js/assets/pehaathemes-theme-tools-upload-media.js',
                    ]
                }
            },
        },
        compress: {
            main: {
                options: {
                  archive: '<%= pkg.name %>.zip',
                },
                files: [
                  {src: '<%= pluginfiles %>', dest: '' }
                ]
            }
        },
        zip: {
            src: [
                '**.php',
                'admin/**',
                'admin/**/*.php',
                'includes/**',
                'public/**',
                'languages/**',
                '**.txt',
                '**.md',
                'plugin-update-checker/**'
            ],
            dest : 'pehaathemes-theme-tools.zip',
            compression: 'DEFLATE'
        },
        watch: {
            jsjshint: {
                files: [ 'admin/js/assets/**.js' ],
                tasks: ['jshint']
            },
            js: {
                files: [ 'admin/js/assets/**.js' ],
                tasks: ['uglify:dist']
            }
        },
        "json-replace": {
            "options": {
                "space" : "\t",
                "replace" : {
                    "name" : '<%= pkg.plugin_name %>',
                    "slug" : '<%= pkg.name %>',
                    "version" : '<%= pkg.version %>',
                    "download_url" : '<%= pkg.download_url %>',
                    "sections" : {
                        "description" : '<%= pkg.description %>',
                        "changelog" : '<%= pkg.changelog %>',
                    },
                    "homepage" : '<%= pkg.repository.url %>',
                    "tested" : '<%= pkg.tested %>',
                    "author" : '<%= pkg.author %>',
                    "author_homepage" : '<%= pkg.author_url %>',
                }
            },
            "metadata": {
                "files" : [{
                    "src" : "metadata.json",
                    "dest" : "metadata.json"
                }]
            },
        },
    });
 

    //grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    //grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-curl');
    grunt.loadNpmTasks('grunt-phpdocumentor');
    grunt.loadNpmTasks('grunt-wp-i18n');
    grunt.loadNpmTasks( 'grunt-zip' );
    grunt.loadNpmTasks( 'grunt-contrib-watch' );
    grunt.loadNpmTasks('grunt-wp-readme-to-markdown');
    grunt.loadNpmTasks('grunt-json-replace');
    grunt.loadNpmTasks('grunt-contrib-compress');
 
    grunt.registerTask('default', [
        //'makepot',
        'wp_readme_to_markdown',
        'jshint',
        'uglify:dist',
    ]);

    // Serve presentation locally
    grunt.registerTask( 'serve', ['watch'] );
 
};