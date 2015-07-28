module.exports = function(grunt) {

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // 2.A Convert LESS to CSS
        less: {
            options: {
                paths: ["css"]
            },
            dist: {
                files: {
                    "assets/css/generate/custom-admin-bootstrap.css": "assets/less/custom-admin-bootstrap.less",
                    "assets/css/generate/custom-bootstrap.css": "assets/less/custom-bootstrap.less",
                    "assets/css/generate/font-awesome.css": "bower_components/font-awesome/less/font-awesome.less",
                    "assets/css/generate/custom-styles.css": "assets/less/custom-styles.less",
                    "assets/css/generate/custom-admin-styles.css": "assets/less/custom-admin-styles.less"
                }
            }
        },

        // 2.B Configuration for concatinating files
        concat: {
            bootstrap: {
                src: [
                  'bower_components/bootstrap/js/transition.js',
                  'bower_components/bootstrap/js/alert.js',
                  'bower_components/bootstrap/js/button.js',
                  'bower_components/bootstrap/js/carousel.js',
                  'bower_components/bootstrap/js/collapse.js',
                  'bower_components/bootstrap/js/dropdown.js',
                  'bower_components/bootstrap/js/modal.js',
                  'bower_components/bootstrap/js/tooltip.js',
                  'bower_components/bootstrap/js/popover.js',
                  'bower_components/bootstrap/js/scrollspy.js',
                  'bower_components/bootstrap/js/tab.js',
                  'bower_components/bootstrap/js/affix.js'
                ],
                dest: 'assets/js/generate/bootstrap.js'
              },

            styles: {
                src: [
                  'assets/css/generate/custom-bootstrap.css',
                  'assets/css/generate/font-awesome.css',
                  'assets/css/generate/custom-styles.css',
                ],
                dest: 'public/css/all.css'
              },

            adminstyles: {
                src: [
                  'assets/css/generate/custom-admin-bootstrap.css',
                  'assets/css/generate/font-awesome.css',
                  'assets/css/generate/custom-admin-styles.css',
                ],
                dest: 'public/css/all.admin.css'
              },

            scripts: {
                src: [
                  'bower_components/jquery/dist/jquery.js',
                  'assets/js/generate/bootstrap.js', // We merged bootstrap manually.
                  'assets/js/scripts.js',
                ],
                dest: 'public/js/all.js'
              },

            adminscripts: {
                src: [
                  'bower_components/jquery/dist/jquery.js',
                  'assets/js/generate/bootstrap.js', // We merged bootstrap manually.
                  'assets/js/admin/*.js',
                ],
                dest: 'public/js/all-admin.js'
              },

            nonmodern: {
                src: [
                  'bower_components/modernizr/modernizr.js',
                  'bower_components/respond/dest/respond.src.js'
                ],
                dest: 'public/js/modernizr-respond.js'
              }
        },

        // minify the css files
        cssmin: {
            dist: {
                options: {
                    banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
                },
                files: {
                    'public/css/all.min.css': ['public/css/all.css'],
                    'public/css/all.admin.min.css': ['public/css/all.admin.css'],
                }
            }
        },

        // uglify the concat javascript files
        uglify: {
            options: {
                compress : {
                    drop_console: true // DROP console.log
                },
                banner: '/*! <%= pkg.name %> <%= grunt.template.today("dd-mm-yyyy") %> */\n'
            },
            dist: {
                files: {
                    'public/js/all.min.js': [
                        'public/js/all.js',
                        'public/js/modernizr-respond.js'
                        ],
                    'public/js/all-admin.min.js': [
                        'public/js/all-admin.js',
                        ],
                }
            }
        },

        // 2.C Copy assets
        copy: {
            images: {
                expand: true,
                cwd: 'assets/img/',
                src: '**',
                dest: 'public/img/',
                flatten: false,
            },

            fonts: {
                expand: true,
                cwd: 'bower_components/font-awesome/fonts/',
                src: '**',
                dest: 'public/fonts/',
                flatten: true,
                filter: 'isFile',
            },

            customfonts: {
                expand: true,
                src: 'assets/fonts/**',
                dest: 'public/fonts/',
                flatten: true,
                filter: 'isFile',
            }
        },

        // WATCH
        watch: {
            scripts: {
                files: ['assets/less/*.{css,less}', 'assets/js/admin/*.js', 'assets/js/scripts.js'],
                tasks: ['dev'],
            },
        },

    });

    // 3. Where we tell Grunt we plan to use this plug-in.
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('default', ['less', 'concat','cssmin','uglify','copy']);

    // Development tasks - $ grunt dev
    grunt.registerTask('dev', ['less', 'concat', 'copy']);

};