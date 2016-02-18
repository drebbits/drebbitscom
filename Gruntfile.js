/*global require */
module.exports = function( grunt ) {
	'use strict';

	// Load all grunt tasks
	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	// Project configuration
	grunt.initConfig( {
		pkg:    grunt.file.readJSON( 'package.json' ),

		// Concat
		concat: {
			options: {
				stripBanners: true,
				banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
				' * <%= pkg.homepage %>\n' +
				' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
				' * Licensed GPLv2+' +
				' */\n'
			},
			theme: {
				src: [
					'assets/js/vendor/*.js',
					'assets/js/src/theme/*.js'
				],
				dest: 'assets/js/drebbits.js'
			},
			admin: {
				src: [
					'assets/js/src/admin/*.js'
				],
				dest: 'assets/js/drebbits_admin.js'
			}
		},

		// JSHint
		jshint: {
			all: [
				'Gruntfile.js',
				'assets/js/src/**/*.js',
				'assets/js/test/**/*.js'
			],
			options: {
				jshintrc: '.jshintrc'
			}
		},

		// Uglify
		uglify: {
			all: {
				files: {
					'assets/js/drebbits.min.js': ['assets/js/drebbits.js'],
					'assets/js/drebbits_admin.min.js': ['assets/js/drebbits_admin.js'],
				},
				options: {
					banner: '/*! <%= pkg.title %> - v<%= pkg.version %>\n' +
					' * <%= pkg.homepage %>\n' +
					' * Copyright (c) <%= grunt.template.today("yyyy") %>;' +
					' * Licensed GPLv2+' +
					' */\n',
					mangle: {
						except: ['jQuery']
					}
				}
			},
		},

		// Test
		test:   {
			files: ['assets/js/test/**/*.js']
		},

		// SASS
		sass:   {
			theme: {
				options: {
					outputStyle: 'expanded',
					sourceMap: true,
					precision: 2
				},
				files: [{
					expand: true,
					cwd: 'assets/css/sass/',
					src: ['style.scss'],
					dest: 'assets/css/',
					ext: '.css'
				}]
			},
			admin: {
				options: {
					outputStyle: 'expanded',
					sourceMap: true,
					precision: 2
				},
				files: {
					//'assets/css/admin.css': 'assets/css/admin_sass/admin.scss',
					//'assets/css/editor.css': 'assets/css/editor_sass/editor.scss'
				}
			}
		},

		// PostCSS
		postcss: {
			options: {
				processors: [
					require('autoprefixer')({browsers: ['last 3 versions', 'Firefox > 4'] })
				]
			},
			theme: {
				src: ['assets/css/drebbits.css']
			},
			admin: {
				src: ['assets/css/drebbits_admin.css', 'assets/css/drebbits_editor.css']
			}
		},

		// Wacth
		watch:  {
			styles: {
				files: ['assets/css/**/**/*.scss'],
				tasks: ['sass:theme', 'sass:admin', 'postcss:theme', 'postcss:admin'],
				options: {
					debounceDelay: 500,
					livereload: true
				}
			},
			scripts: {
				files: ['assets/js/src/**/*.js', 'assets/js/vendor/**/*.js'],
				tasks: ['jshint'],
				options: {
					debounceDelay: 500,
					livereload: true
				}
			},
			livereload: {
				options: { livereload: true },
				files: ['assets/css/*']
			}

		},

		// SassDoc
		sassdoc: {
			default: {
				src: 'assets/css/sass',
				options: {
					groups: {
						'undefined': 'General',
						'helpers': 'Helpers',
						'drebbits': 'drebbits paper theme',
						'sass-mq': 'sass-mq'
					},
					force: true
				}
			}
		}
	} );

	// Default task.
	grunt.registerTask( 'default', ['jshint', 'sass:theme', 'postcss:theme', 'sass:admin', 'postcss:admin'] );
	grunt.registerTask( 'js', ['jshint', 'concat', 'uglify'] );
	grunt.registerTask( 'css', ['sass:theme', 'postcss:theme'] );
	grunt.registerTask( 'admin', ['sass:admin', 'postcss:admin'] );
	grunt.registerTask( 'release', ['concat', 'uglify', 'sassdoc']);

	grunt.util.linefeed = '\n';
};