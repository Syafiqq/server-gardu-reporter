/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 20 June 2017, 10:58 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

var gulp = require('gulp');
var watch = require('gulp-watch');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var htmlmin = require('gulp-htmlmin');
var pump = require('pump');
var imagemin = require('gulp-imagemin');

gulp.task('move-application-assets', function ()
{
    return gulp.src('./raw/application/**', {base: './raw/application/'})
        .pipe(gulp.dest('./application/'));
});

gulp.task('watch-move-application-assets', function ()
{
// Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch('./raw/application/**', function ()
    {
        return gulp.src('./raw/application/**', {base: './raw/application/'})
            .pipe(gulp.dest('./application/'));
    });
});
