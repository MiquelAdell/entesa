// Defining base pathes
var basePaths = {
	bower: './bower_components/',
	node: './node_modules/',
	dev: './src/'
};

// browser-sync watched files
// automatically reloads the page when files changed
var browserSyncWatchFiles = [
	'./css/*.min.css',
	'./js/*.min.js',
	'./*.php'
];
// browser-sync options
// see: https://www.browsersync.io/docs/options/
var browserSyncOptions = {
	proxy: "http://entesa.dev/",
	notify: false
};

// Defining requirements
var gulp = require('gulp');
var plumber = require('gulp-plumber');
var sass = require('gulp-sass');
var watch = require('gulp-watch');
var cssnano = require('gulp-cssnano');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var merge2 = require('merge2');
var imagemin = require('gulp-imagemin');
var ignore = require('gulp-ignore');
var rimraf = require('gulp-rimraf');
var clone = require('gulp-clone');
var merge = require('gulp-merge');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();
var del = require('del');
var cleanCSS = require('gulp-clean-css');
var autoprefixer = require('gulp-autoprefixer');


function swallowError(self, error) {
	console.log(error.toString())

	self.emit('end')
}

// Run:
// gulp sass + cssnano + rename
// Prepare the min.css for production (with 2 pipes to be sure that "child-theme.css" == "child-theme.min.css")
gulp.task('scss-for-prod', function() {
	var source =  gulp.src('./sass/*.scss')
		//.pipe(autoprefixer({browsers: ['last 2 versions'],cascade: false}))
		.pipe(plumber({ errorHandler: function (error) { swallowError(this, error); } }))
		.pipe(sourcemaps.init({loadMaps: true}))
		.pipe(sass());

	var pipe1 = source.pipe(clone())
		.pipe(sourcemaps.write(undefined, { sourceRoot: null }))
		.pipe(gulp.dest('./css'))
		.pipe(rename('custom-editor-style.css'))
		.pipe(gulp.dest('./css'));

	var pipe2 = source.pipe(clone())
		.pipe(plumber({ errorHandler: function (error) { swallowError(this, error); } }))
		.pipe(cssnano())
		.pipe(rename({suffix: '.min'}))
		.pipe(gulp.dest('./css'));

	return merge(pipe1, pipe2);
});


// Run:
// gulp sourcemaps + sass + reload(browserSync)
// Prepare the child-theme.css for the development environment
gulp.task('scss-for-dev', function() {
	gulp.src('./sass/*.scss')

		.pipe(plumber({ errorHandler: function (error) { swallowError(this, error); } }))
		.pipe(sourcemaps.init({loadMaps: true}))
		.pipe(sass())
		.pipe(sourcemaps.write(undefined, { sourceRoot: null }))
		.pipe(autoprefixer({browsers: ['last 2 versions'],cascade: false}))
		.pipe(gulp.dest('./css'))
});

gulp.task('watch-scss', ['browser-sync'], function () {
	gulp.watch('./sass/**/*.scss', ['scss-for-dev']);
});

// Run:
// gulp sass
// Compiles SCSS files in CSS
gulp.task('sass',['minify-css'], function () {
	var stream = gulp.src('./sass/*.scss')
		//.pipe(autoprefixer({browsers: ['last 2 versions'],cascade: false}))
		.pipe(plumber({ errorHandler: function (error) { swallowError(this, error); } }))
		.pipe(sass())
		.pipe(gulp.dest('./css'))
		.pipe(rename('custom-editor-style.css'))
		.pipe(gulp.dest('./css'));
	return stream;
});

// Run:
// gulp watch
// Starts watcher. Watcher runs gulp sass task on changes
gulp.task('watch', function () {
	gulp.watch('./sass/**/*.scss', ['sass']);
	gulp.watch('./css/child-theme.css', ['minify-css']);
	gulp.watch([basePaths.dev + 'js/**/*.js','js/**/*.js','!js/child-theme.js','!js/child-theme.min.js'], ['scripts']);
});

// Run:
// gulp imagemin
// Running image optimizing task
gulp.task('imagemin', function(){
	gulp.src('img/**')
	.pipe(imagemin())
	.pipe(gulp.dest('img'))
});

// Run:
// gulp nanocss
// Minifies CSS files
gulp.task('cssnano', ['cleancss'], function(){
  return gulp.src('./css/*.css')
	.pipe(sourcemaps.init({loadMaps: true}))
	.pipe(plumber({ errorHandler: function (error) { swallowError(self, error); } }))
	.pipe(rename({suffix: '.min'}))
	.pipe(cssnano({discardComments: {removeAll: true}}))
	.pipe(sourcemaps.write('./'))
	.pipe(gulp.dest('./css/'));
});

gulp.task('minify-css', function() {
  return gulp.src('./css/child-theme.css')
	.pipe(cleanCSS({compatibility: 'ie8'}))
	.pipe(plumber())
	.pipe(rename({suffix: '.min'}))
	.pipe(gulp.dest('./css/'));
});

gulp.task('cleancss', function() {
  return gulp.src('./css/*.min.css', { read: false }) // much faster
	.pipe(ignore('theme.css'))
	.pipe(rimraf());
});

// Run:
// gulp browser-sync
// Starts browser-sync task for starting the server.
gulp.task('browser-sync', function() {
	browserSync.init(browserSyncWatchFiles, browserSyncOptions);
});

// Run:
// gulp watch-bs
// Starts watcher with browser-sync. Browser-sync reloads page automatically on your browser
gulp.task('watch-bs', ['browser-sync', 'watch', 'minify-css'], function () { });

// Run:
// gulp scripts.
// Uglifies and concat all JS files into one
gulp.task('scripts', function() {
	var scripts = [
		basePaths.dev + 'js/tether.js', // Must be loaded before BS4
		// Start - All BS4 stuff
		basePaths.dev + 'js/bootstrap4/bootstrap.js',
		// End - All BS4 stuff
		basePaths.dev + 'js/skip-link-focus-fix.js',
		basePaths.dev + 'js/masonry.pkgd.min.js',
		basePaths.dev + 'js/entesa.js'
	];
  gulp.src(scripts)
	.pipe(concat('child-theme.min.js'))
	.pipe(uglify())
	.pipe(gulp.dest('./js/'));

  gulp.src(scripts)
	.pipe(concat('child-theme.js'))
	.pipe(gulp.dest('./js/'));
});

// Deleting any file inside the /src folder
gulp.task('clean-source', function () {
  return del(['src/**/*',]);
});

// Run:
// gulp copy-assets.
// Copy all needed dependency assets files from bower_component assets to themes /js, /scss and /fonts folder. Run this task after bower install or bower update


// Copy all Bootstrap JS files
gulp.task('copy-assets', function() {

////////////////// All Bootstrap 4 Assets /////////////////////////
// Copy all Bootstrap JS files
	gulp.src(basePaths.node + 'bootstrap/dist/js/**/*.js')
	   .pipe(gulp.dest(basePaths.dev + '/js/bootstrap4'));

// Copy all Bootstrap SCSS files
	gulp.src(basePaths.node + 'bootstrap/scss/**/*.scss')
	   .pipe(gulp.dest(basePaths.dev + '/sass/bootstrap4'));
////////////////// End Bootstrap 4 Assets /////////////////////////

// Copy all UnderStrap SCSS files
	gulp.src(basePaths.node + 'understrap/sass/**/*.scss')
	   .pipe(gulp.dest(basePaths.dev + '/sass/understrap'));

// Copy all Font Awesome Fonts
	gulp.src(basePaths.node + 'font-awesome/fonts/**/*.{ttf,woff,woff2,eof,svg}')
		.pipe(gulp.dest('./fonts'));

// Copy all Font Awesome SCSS files
	gulp.src(basePaths.node + 'font-awesome/scss/*.scss')
		.pipe(gulp.dest(basePaths.dev + '/sass/fontawesome'));

// Copy jQuery
	gulp.src(basePaths.node + 'jquery/dist/*.js')
		.pipe(gulp.dest(basePaths.dev + '/js'));

// _s SCSS files
	gulp.src(basePaths.node + 'undescores-for-npm/sass/**/*.scss')
		.pipe(gulp.dest(basePaths.dev + '/sass/underscores'));

// _s JS files
	gulp.src(basePaths.node + 'undescores-for-npm/js/*.js')
		.pipe(gulp.dest(basePaths.dev + '/js'));


// Copy Tether JS files
	gulp.src(basePaths.node + 'tether/dist/js/*.js')
		.pipe(gulp.dest(basePaths.dev + '/js'));

// Copy Tether CSS files
	gulp.src(basePaths.node + 'tether/dist/css/*.css')
		.pipe(gulp.dest(basePaths.dev + '/css'));


// Copy Tether CSS files
	gulp.src(basePaths.node + 'masonry-layout/dist/*.js')
		.pipe(gulp.dest(basePaths.dev + '/js'));
});

// Run
// gulp dist
// Copies the files to the /dist folder for distributon
gulp.task('dist', ['clean-dist'], function() {
	gulp.src(['**/*','!bower_components','!bower_components/**','!node_modules','!node_modules/**','!src','!src/**','!dist','!dist/**','!sass','!sass/**','!readme.txt','!readme.md','!package.json','!gulpfile.js','!CHANGELOG.md','!.travis.yml','!jshintignore', '!codesniffer.ruleset.xml', '*'])
	.pipe(gulp.dest('dist/'))
});

// Deleting any file inside the /src folder
gulp.task('clean-dist', function () {
  return del(['dist/**/*',]);
});

// Run
// gulp dist-product
// Copies the files to the /dist folder for distributon
gulp.task('dist-product', ['clean-dist-product'], function() {
	gulp.src(['**/*','!bower_components','!bower_components/**','!node_modules','!node_modules/**','!dist','!dist/**', '*'])
	.pipe(gulp.dest('dist-product/'))
});

// Deleting any file inside the /src folder
gulp.task('clean-dist-product', function () {
  return del(['dist-product/**/*',]);
});
