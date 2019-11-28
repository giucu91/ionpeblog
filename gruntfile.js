'use strict';
module.exports = function (grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, { scope: 'devDependencies' });

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		dirs: {
			css: 'assets/css',
			js : 'assets/js'
		},

		makepot      : {
			target: {
				options: {
					domainPath     : '/languages/',
					potFilename    : '<%= pkg.name %>.pot',
					potHeaders     : {
						poedit                 : true,
						'x-poedit-keywordslist': true
					},
					processPot     : function (pot, options) {
						pot.headers[ 'report-msgid-bugs-to' ] = 'https://www.machothemes.com/';
						pot.headers[ 'language-team' ] = 'Macho Themes <office@machothemes.com>';
						pot.headers[ 'last-translator' ] = 'Macho Themes <office@machothemes.com>';
						pot.headers[ 'language-team' ] = 'Macho Themes <office@machothemes.com>';
						return pot;
					},
					updateTimestamp: true,
					type           : 'wp-theme'
				}
			}
		},
		addtextdomain: {
			target: {
				options: {
					updateDomains: true,
					textdomain   : '<%= pkg.name %>'
				},
				files  : {
					src: [
						'*.php',
						'!node_modules/**'
					]
				}
			}
		},

		clean: {
			init  : {
				src: [ 'build/' ]
			},
			build : {
				src: [
					'build/*',
					'!build/<%= pkg.name %>.zip'
				]
			},
			cssmin: {
				target: {
					files: [ {
						expand: true,
						cwd   : 'assets/css',
						src   : [ '*.css', '!*.min.css', '!style-overrides.css', '!custom-editor-style.css' ],
						dest  : 'assets/css',
						ext   : '.min.css'
					} ]
				}
			},
			jsmin : {
				src: [
					'assets/js/frontend/*.min.js',
					'assets/js/frontend/*.min.js.map',
				]
			}
		},

		copy: {
			readme: {
				src : 'readme.md',
				dest: 'build/readme.txt'
			},
			build : {
				expand: true,
				src   : [ '**', '!node_modules/**', '!build/**', '!readme.md', '!gruntfile.js', '!package.json', '!nbproject/**', '!package-lock.json', '!phpcs.xml.dist' ],
				dest  : 'build/'
			}
		},

		compress: {
			build: {
				options: {
					pretty : true,
					archive: 'build/<%= pkg.name %>.zip'
				},
				expand : true,
				cwd    : 'build/',
				src    : [ '**/*' ],
				dest   : '<%= pkg.name %>/'
			}
		},

		uglify: {
			jsfiles: {
				files: [ {
					expand: true,
					cwd   : 'assets/js/frontend/',
					src   : [
						'*.js',
						'!*.min.js',
						'!Gruntfile.js',
					],
					dest  : 'assets/js/frontend/',
					ext   : '.min.js'
				} ]
			},
		},

		checktextdomain: {
			standard: {
				options: {
					text_domain       : [ 'newsmag-pro' ], //Specify allowed domain(s)
					create_report_file: "true",
					keywords          : [ //List keyword specifications
						'__:1,2d',
						'_e:1,2d',
						'_x:1,2c,3d',
						'esc_html__:1,2d',
						'esc_html_e:1,2d',
						'esc_html_x:1,2c,3d',
						'esc_attr__:1,2d',
						'esc_attr_e:1,2d',
						'esc_attr_x:1,2c,3d',
						'_ex:1,2c,3d',
						'_n:1,2,4d',
						'_nx:1,2,4c,5d',
						'_n_noop:1,2,3d',
						'_nx_noop:1,2,3c,4d'
					]
				},
				files  : [ {
					src   : [
						'**/*.php',
						'!**/node_modules/**',
						'!**/framework/**'
					], //all php
					expand: true
				} ]
			}
		},

		concat: {
			dist: {
				src : [
					'assets/js/frontend/lazyload.min.js',
					'assets/js/frontend/owl.min.js',
					'assets/js/frontend/sticky-kit.min.js',
					'assets/js/frontend/front.min.js',
				],
				dest: 'assets/js/main.min.js'
			},
		},

		cssmin: {
			target: {
				files: [ {
					expand: true,
					cwd   : 'assets/css',
					src   : [ '*.css', '!*.min.css', '!style-overrides.css', '!custom-editor-style.css' ],
					dest  : 'assets/css',
					ext   : '.min.css'
				} ]
			}
		},

    sass: {
      dist: {
        options: {
          style: 'expanded',
          sourcemap: 'none',
        },
        files: [
          {
            expand: true,
            cwd: 'assets/sass/',
            src: [ '*.scss', '!fonts.scss', '!owl.carousel.scss', '!owl.theme.default.scss' ],
            dest: 'assets/css/',
            ext: '.css'
          } ]
      }
	},
	watch: {
		css: {
			files: 'assets/sass/*.scss',
			tasks: ['sass']
		}
	}
	});
  grunt.loadNpmTasks('grunt-contrib-concat');

  grunt.registerTask( 'startSass', [
    'sass'
  ] );

	grunt.registerTask('default', []);

	// Build .pot file
	grunt.registerTask('buildpot', [
		'makepot'
	]);

	// Check Missing Text Domain Strings
	grunt.registerTask('textdomain', [
		'checktextdomain'
	]);

	// Minify CSS
	grunt.registerTask('mincss', [
		'sass',
		'clean:cssmin',
		'cssmin'
	]);

	// Minify and concat JS
	grunt.registerTask('minjs', [
		'clean:jsmin',
		'uglify',
		'concat:dist'
	]);

	grunt.registerTask('build-archive', [
		'mincss',
		'minjs',
		'clean:init',
		'copy',
		'compress:build',
		'clean:build'
	]);

};