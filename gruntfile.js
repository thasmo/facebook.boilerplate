module.exports = function(grunt) {

	require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			templates: {
				files: ['application/template/**/*.html']
			},
			styles: {
				files: ['application/asset/**/*.css'],
				tasks: ['cssmin']
			},
			scripts: {
				files: ['application/asset/**/*.js'],
				tasks: ['uglify']
			},
			options: {
				livereload: true
			}
		},
		cssmin: {
			main: {
				files: {
					'htdocs/static/style/application.css': [
						'bower_components/normalize-css/normalize.css',
						'application/asset/style/main.css'
					]
				}
			}
		},
		uglify: {
			main: {
				files: {
					'htdocs/static/script/application.js': [
						'bower_components/jquery/jquery.js',
						'application/asset/script/bootstrap.js',
						'application/asset/script/main.js'
					]
				}
			}
		},
		copy: {
			main: {
				src: 'bower_components/html5shiv/dist/html5shiv.js',
				dest: 'htdocs/static/script/vendor/',
				expand: true,
				flatten: true
			}
		}
	});

	grunt.registerTask('default', ['cssmin', 'uglify', 'copy']);
};
