/*!
 * ZF2 Boilplate Gruntfile
 */
module.exports = function(grunt) {

    var conf = {
        bspath : './bower_components/bootstrap',
        jqpath : './bower_components/jquery',
        fapath : './bower_components/font-awesome'
    };

    // 1. All configuration goes here
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        concat: {
            options: {
                stripBanners: false
            },

            bootstrap: {
                src: [
                    conf.bspath+'/dist/js/bootstrap.js'
                ],
                dest: 'assets/js/generate/latest-bs4.js'
            },

            wwwjs: {
                src: [
                    conf.jqpath + '/dist/jquery.js',
                    'assets/js/generate/latest-bs4.js',
                    'assets/js/plugins.js',
                    'assets/js/scripts.js'
                ],
                dest: 'assets/js/generate/<%= pkg.name %>.js'
            },

            adminjs: {
                src: [
                    conf.jqpath + '/dist/jquery.js',
                    'assets/js/generate/latest-bs4.js',
                    'assets/js/admin/admin-scripts.js',
                ],
                dest: 'assets/js/generate/<%= pkg.name %>-admin.js'
            },

            wwwcss: {
                src: [
                    'assets/css/generate/<%= pkg.name %>.css',
                    conf.fapath + '/css/font-awesome.css'
                ],
                dest: 'assets/css/generate/<%= pkg.name %>.css'
            },

            admincss: {
                src: [
                    conf.jqpath + '/dist/jquery.js',
                    'assets/js/generate/latest-bs4.js',
                    'assets/js/plugins.js',
                    'assets/js/scripts.js'
                ],
                dest: 'assets/js/generate/<%= pkg.name %>.js'
            },
        },

        sass: {
          options: {
            includePaths: [conf.bspath + '/scss'],
            precision: 6,
            sourceComments: false,
            sourceMap: true,
            outputStyle: 'expanded'
          },
          core: {
            files: {
              'assets/css/generate/<%= pkg.name %>.css': 'assets/scss/app.scss'
            }
          }
        },

        // Watch
        watch: {
            sass: {
                files: 'assets/scss/**/*.scss',
                tasks: ['dev']
            },
        },

        autoprefixer: {
          options: {
            browsers: [
              'Android 2.3',
              'Android >= 4',
              'Chrome >= 35',
              'Firefox >= 31',
              'Explorer >= 9',
              'iOS >= 7',
              'Opera >= 12',
              'Safari >= 7.1'
            ]
          },
          core: {
            options: {
              map: false
            },
            src: 'assets/css/generate/*.css'
          }
        },

        usebanner: {
          options: {
            position: 'top',
            banner: '<%= banner %>'
          },
          files: {
            src: 'assets/css/generate/*.css'
          }
        },

        csscomb: {
          dist: {
            options: {
              config: conf.bspath+'scss/.csscomb.json'
            },
            expand: true,
            cwd: 'assets/css/generate/css/',
            src: ['*.css', '!*.min.css'],
            dest: 'assets/css/generate/css/'
          }
        },

        cssmin: {
          options: {
            compatibility: 'ie8',
            keepSpecialComments: '*',
            sourceMap: false,
            noAdvanced: true
          },
          core: {
            files: [
              {
                expand: true,
                cwd: 'assets/css/generate',
                src: ['*.css', '!*.min.css'],
                dest: 'assets/css/generate',
                ext: '.min.css'
              }
            ]
          }
        },

        uglify: {
          options: {
            compress: {
              warnings: false,
              drop_console: true
            },
            mangle: true,
            preserveComments: 'some',
             banner: '/*! <%= pkg.name %> - ' + '<%= grunt.template.today("yyyy-mm-dd") %> */\n'
          },
          www: {
            src: 'assets/js/generate/<%= pkg.name %>.js',
            dest: 'assets/js/generate/<%= pkg.name %>.min.js'
          },
          admin: {
            src: 'assets/js/generate/<%= pkg.name %>-admin.js',
            dest: 'assets/js/generate/<%= pkg.name %>-admin.min.js'
          }
        },

        copy: {
          images: {
            expand: true,
            cwd:'assets/img/',
            src: '**',
            dest: 'public/img/',
            flatten: false
          },
          styles: {
            expand: true,
            cwd:'assets/css/generate/',
            src: '*.css',
            dest: 'public/css/',
            flatten: false
          },
          scripts: {
            expand: true,
            cwd:'assets/js/generate/',
            src: '<%= pkg.name %>*',
            dest: 'public/js/',
            flatten: false
          },
          fonts: {
            expand: true,
            cwd:conf.fapath + '/fonts/',
            src: '**',
            dest: 'public/fonts/',
            flatten: false,
            filter: 'isFile'
          }
        },

    });

  // These plugins provide necessary tasks.
  require('load-grunt-tasks')(grunt, { scope: 'devDependencies',
    // Exclude Sass compilers. We choose the one to load later on.
    pattern: ['grunt-*'] });
  require('time-grunt')(grunt);

  grunt.loadNpmTasks('grunt-sass');

  grunt.registerTask('bootstrap', ['sass:core', 'autoprefixer:core', 'usebanner', 'csscomb:dist', 'concat:bootstrap']);

  // Development build
  grunt.registerTask('dev', ['bootstrap', 'concat:wwwjs', 'concat:adminjs', 'concat:wwwcss', 'copy:images', 'copy:scripts', 'copy:styles', 'copy:fonts']);

  // Production build
  grunt.registerTask('default', ['dev', 'cssmin:core', 'uglify'])
};