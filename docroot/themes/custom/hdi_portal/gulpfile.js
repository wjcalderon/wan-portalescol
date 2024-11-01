const gulp = require('gulp')
const { series, parallel } = require('gulp')
const sass = require('gulp-sass')(require('sass'))
const del = require('delete')
const terser = require('gulp-terser')
const cleanCSS = require('gulp-clean-css')
const sourcemaps = require('gulp-sourcemaps')

const clean = (cb) => {
  del(['assets'], cb)
}

const compileScss = (cb) => {
  return gulp.src('scss/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(cleanCSS())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('assets/css'))
}

const javascript = (cb) => {
  return gulp.src('js/*.js')
    .pipe(sourcemaps.init())
    .pipe(terser())
    .pipe(sourcemaps.write())
    .pipe(gulp.dest('assets/js'))
}

function watchSassJs() {
  gulp.watch(['scss/**/*.scss', 'js/*.js'], parallel(compileScss, javascript))
}

exports.build = series(clean, parallel(compileScss, javascript))
exports.clean = clean
exports.watch = series(clean, watchSassJs)
