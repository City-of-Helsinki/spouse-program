/**
 * Created by Lisette on 28/07/16.
 * Updated by Markus on 24/01/18.
 */

// ---------------
// General plugins
// ---------------
var browserSync = require('browser-sync').create();
var chalk = require('chalk');
var colors = require('ansi-colors');
var gulp = require('gulp');
var gulpIf = require('gulp-if');
var log = require('fancy-log');
var noop = require('gulp-noop');
var rename = require('gulp-rename');
var clean = require('gulp-rimraf');

// ------------
// Sass plugins
// ------------
var sass = require('gulp-sass');
var sassGlob = require('gulp-sass-glob');
var sourcemaps = require('gulp-sourcemaps');
var autoprefix = require('gulp-autoprefixer');
var cleanCss = require('gulp-clean-css');

// ----------------------------
// Javascript plugins
// ----------------------------
var uglify = require('gulp-uglify');

// ------
// Config
// ------
var basePath = {
  src: './src/',
  assets: './assets/',
  templates: './templates/',
};

var path = {
  styles: {
    src: basePath.src + 'scss/',
    assets: './',
  },
  scripts: {
    src: basePath.src + 'js/',
    assets: basePath.assets + 'js/',
  },
  images: {
    src: basePath.src + 'image/',
    assets: basePath.assets + 'image/',
  },
  fonts: {
    src: basePath.src + 'font/',
    assets: basePath.assets + 'font/',
  },
  templates: {
    assets: basePath.templates,
  },
  node_modules: 'node_modules/',
  breakpoint_sass: 'breakpoint-sass/stylesheets/',
  fontAwesome: 'font-awesome/scss/',
};

var changeEvent = function(evt) {
  log(
    'File',
    colors.cyan(
      evt.path.replace(new RegExp('/.*(?=/' + basePath.src + ')/'), ''),
    ),
    'was',
    colors.magenta(evt.type),
  );
};

// ------------
// BrowserSync.
// ------------
function browserSyncInit() {
  browserSync.init({
    files: [path.styles.assets + '**/*.css', path.scripts.assets + '**/*.js'],
    // proxy: 'http://druid.fi.docker.amazee.io/',
    browser: 'firefox',
  });
}

// -------------
// Compile SASS.
// -------------
function compileSASS() {
  return gulp
    .src(path.styles.src + '**/*.scss')
    .pipe(gulpIf(path.env === 'development', sourcemaps.init()))
    .pipe(sassGlob())
    .pipe(
      path.env === 'development'
        ? sass({
          includePaths: [
            path.node_modules + path.breakpoint_sass,
            path.node_modules + path.fontAwesome,
            './',
          ],
          outputStyle: 'expanded',
        }).on('error', function(err) {
          log.error(
            chalk.black.bgRed(
              ' SASS ERROR',
              chalk.white.bgBlack(' ' + err.message.split('  ')[2] + ' '),
            ),
          );
          log.error(
            chalk.black.bgRed(
              ' FILE:',
              chalk.white.bgBlack(' ' + err.message.split('\n')[0] + ' '),
            ),
          );
          log.error(
            chalk.black.bgRed(
              ' LINE:',
              chalk.white.bgBlack(' ' + err.line + ' '),
            ),
          );
          log.error(
            chalk.black.bgRed(
              ' COLUMN:',
              chalk.white.bgBlack(' ' + err.column + ' '),
            ),
          );
          log.error(
            chalk.black.bgRed(
              ' ERROR:',
              chalk.white.bgBlack(' ' + err.formatted.split('\n')[0] + ' '),
            ),
          );
          return this.emit('end');
        })
        : sass({
          includePaths: [
            path.node_modules + path.breakpoint_sass,
            path.node_modules + path.fontAwesome,
            './',
          ],
          outputStyle: 'expanded',
        }),
    )
    .pipe(
      autoprefix({
        browsers: ['last 2 versions'],
      }),
    )
    .pipe(path.env === 'production' ? cleanCss() : noop())
    .pipe(gulpIf(path.env === 'development', sourcemaps.write()))
    .pipe(gulp.dest(path.styles.assets));
}

// -----------
// Watch task.
// -----------
gulp.task('watch', gulp.series(runWatch));

// ---------------------------------------------------
// Copy js from src to assets and uglify if necessary.
// ---------------------------------------------------
function copyScripts() {
  return gulp
    .src(path.scripts.src + '**/*.js')
    .pipe(path.env === 'production' ? uglify() : noop())
    .pipe(
      rename({
        suffix: '.min',
      }),
    )
    .pipe(gulp.dest(path.scripts.assets));
}

// ---------------------------------------------------
// Copy images from src to assets if necessary.
// ---------------------------------------------------
function copyImages() {
  return gulp.src(path.images.src + '**/*').pipe(gulp.dest(path.images.assets));
}

// ---------------------------------------------------
// Copy fonts from src to assets if necessary.
// ---------------------------------------------------
function copyFonts() {
  return gulp.src(path.fonts.src + '**/*').pipe(gulp.dest(path.fonts.assets));
}

// ----------------------
// Function to run watch.
// ----------------------
function runWatch() {
  gulp.watch(path.styles.src + '**/*.scss', compileSASS);
  gulp.watch(path.scripts.src + '**/*.js', copyScripts);
}

function cleanAssets() {
  allowEmpty = true;
  console.log('Clean all files in assets folder');

  return gulp.src('./assets/', { read: false, allowEmpty: true }).pipe(clean());
}

// --------------------------------------
// Set environment variable via dev task.
// --------------------------------------
gulp.task('dev', function(done) {
  environment('development');
  done();
});

// ---------------------------------------
// Set environment variable via prod task.
// ---------------------------------------
gulp.task('prod', function(done) {
  environment('production');
  done();
});

// -------------------------------------
// Build development css & scripts task.
// -------------------------------------
gulp.task(
  'development',
  gulp.series(
    'dev',
    cleanAssets,
    compileSASS,
    copyScripts,
    copyImages,
    copyFonts,
  ),
  function(done) {
    done();
  },
);

// -------------
// Default task.
// -------------
gulp.task(
  'default',
  gulp.series('dev', gulp.parallel('watch', browserSyncInit)),
  function(done) {
    done();
  },
);

// ----------------
// Production task.
// ----------------
gulp.task(
  'production',
  gulp.series(
    'prod',
    cleanAssets,
    compileSASS,
    gulp.parallel(copyScripts, copyImages, copyFonts),
  ),
  function(done) {
    done();
  },
);

// ------------------------------------------
// Helper function for selecting environment.
// ------------------------------------------
function environment(env) {
  console.log('Running tasks in ' + env + ' mode.');
  return (path.env = env);
}
