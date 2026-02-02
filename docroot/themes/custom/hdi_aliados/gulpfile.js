const gulp = require('gulp');
const { series, parallel } = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const del = require('delete');
const terser = require('gulp-terser');
const cleanCSS = require('gulp-clean-css');

const clean = (cb) => {
  del(['assets'], cb);
};

const compileScss = () => {
  return gulp
    .src('scss/*.scss', { sourcemaps: true })
    .pipe(sass({ sourceMap: true }).on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(gulp.dest('assets/css', { sourcemaps: '.' }));
};

const javascript = () => {
  return gulp
    .src('js/*.js', { sourcemaps: true })
    .pipe(terser())
    .pipe(gulp.dest('assets/js', { sourcemaps: '.' }));
};

function watchSassJs() {
  gulp.watch(['scss/**/*.scss', 'js/**/*.js'], parallel(compileScss, javascript));
}

exports.build = series(clean, parallel(compileScss, javascript));
exports.clean = clean;

exports.watch = series(clean, parallel(compileScss, javascript), watchSassJs);