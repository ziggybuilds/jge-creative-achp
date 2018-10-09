const gulp = require('gulp'),
	concat = require('gulp-concat'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify'),
	gutil = require('gulp-util'),
	connect = require('gulp-connect'),
	browserSync = require('browser-sync').create(),
	rename = require('gulp-rename'),
	sourcemaps = require('gulp-sourcemaps'),
	pump = require('pump'),
	autoprefixer = require('gulp-autoprefixer'),
	babel = require('gulp-babel'),
	eslint = require('gulp-eslint');

// flag errors

gulp.task('log', function() {
	gutil.log('== My Log Task ==')
});

// Process sass files

// autoprefixer autoprefixerOptions
const autoprefixerOptions = {
  browsers: ['last 2 versions', '> 5%', 'Firefox ESR']
};

gulp.task('sass', function() {
	gulp.src('src/sass/**/*.scss')
		.pipe(sourcemaps.init())
		.pipe(sass({
			outputStyle: 'compressed'
		}))
			.on('error', gutil.log)
		// .pipe(sourcemaps.write())
		.pipe(autoprefixer(autoprefixerOptions))
		.pipe(gulp.dest('./'))
		.pipe(rename('style.min.css'))
		.pipe(gulp.dest('./'))
});

gulp.task('js', function() {
	gulp.src(['src/js/**/*.js'])
		.pipe(eslint())
		.pipe(concat('script.js'))
		.pipe(eslint.format())
		.pipe(babel())
		.pipe(gulp.dest('./js'))
});

gulp.task('compress', function(cb) {
		pump([
			gulp.src('js/script.js'),
			uglify(),
			rename('script.min.js'),
			gulp.dest('js')
		],
		cb
	);
});

gulp.task('watch', function() {
  gulp.watch('src/js/*.js', ['js']);
  gulp.watch('js/*.js', ['compress']);
  gulp.watch('src/sass/**/*.scss', ['sass']);
});


// Setup browser sync 

// browser-sync watched files
// automatically reloads the page when files changed
var browserSyncFiles = [
    './style.css',
    './js/script.min.js',
    './*.php'
];
// browser-sync options
// see: https://www.browsersync.io/docs/options/
var browserSyncOptions = {
    proxy: "http://localhost/america-works-usa-2018/wordpress/",
    notify: false,
    injectChanges: false
};

// Browser sync
gulp.task('sync', function() {
    browserSync.init(browserSyncFiles, browserSyncOptions);
});

gulp.task('run', ['sync', 'watch']);