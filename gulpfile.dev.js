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

gulp.task('move-assets', function ()
{
    return gulp.src('./resources/assets/raw/**', {base: './resources/assets/raw/'})
        .pipe(gulp.dest('./public/assets/'));
});

gulp.task('minify-img', function ()
{
    return gulp.src('./resources/assets/raw/**/{*.png,*.jpg,*.jpeg}', {base: './resources/assets/raw/'})
        .pipe(gulp.dest('./public/assets/'));
});

gulp.task('minify-js', function (cb)
{
    pump([
            gulp.src(['./resources/assets/raw/**/*.js', '!./resources/assets/raw/**/*.min.js'], {base: './resources/assets/raw/'})
                .pipe(rename({
                    suffix: ".min",
                    extname: ".js"
                })),
            gulp.dest('./public/assets/')
        ],
        cb
    );
});

gulp.task('minify-css', function ()
{
    return gulp.src(['./resources/assets/raw/**/*.css', '!./resources/assets/raw/**/*.min.css'], {base: './resources/assets/raw/'})
        .pipe(rename({
            suffix: ".min",
            extname: ".css"
        }))
        .pipe(gulp.dest('./public/assets/'));
});

gulp.task('minify-html', function ()
{
    return gulp.src('./resources/assets/views/**/{*.php,*.html}', {base: './resources/assets/views/'})
        .pipe(gulp.dest('./resources/views/'));
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

gulp.task('watch-move-assets', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch('./resources/assets/raw/**', function ()
    {
        return gulp.src('./resources/assets/raw/**', {base: './resources/assets/raw/'})
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('watch-minify-img', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch('./resources/assets/raw/**/{*.png,*.jpg,*.jpeg}', function ()
    {
        return gulp.src('./resources/assets/raw/**/{*.png,*.jpg,*.jpeg}', {base: './resources/assets/raw/'})
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('watch-minify-js', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch(['./resources/assets/raw/**/*.js', '!./resources/assets/raw/**/*.min.js'], function (cb)
    {
        pump([
                gulp.src(['./resources/assets/raw/**/*.js', '!./resources/assets/raw/**/*.min.js'], {base: './resources/assets/raw/'})
                    .pipe(rename({
                        suffix: ".min",
                        extname: ".js"
                    })),
                gulp.dest('./public/assets/')
            ],
            cb
        );
    });
});

gulp.task('watch-minify-css', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch(['./resources/assets/raw/**/*.css', '!./resources/assets/raw/**/*.min.css'], function ()
    {
        return gulp.src(['./resources/assets/raw/**/*.css', '!./resources/assets/raw/**/*.min.css'], {base: './resources/assets/raw/'})
            .pipe(rename({
                suffix: ".min",
                extname: ".css"
            }))
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('watch-minify-html', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch('./resources/assets/views/**/{*.php,*.html}', function ()
    {
        return gulp.src('./resources/assets/views/**/{*.php,*.html}', {base: './resources/assets/views/'})
            .pipe(gulp.dest('./resources/views/'));
    });
});
