/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 20 June 2017, 10:58 AM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */

var gulp = require('gulp');
var watch = require('gulp-watch');
var util = require('gulp-util');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var htmlmin = require('gulp-htmlmin');
var pump = require('pump');
var imagemin = require('gulp-imagemin');
var jsonMinify = require('gulp-json-minify');
var shell = require('gulp-shell')

gulp.task('move-application-assets', function ()
{
    return gulp.src('./raw/application/**', {base: './raw/application/'})
        .pipe(gulp.dest('./application/'));
});

gulp.task('move-assets', function ()
{
    return gulp.src('./raw/assets/**', {base: './raw/assets/'})
        .pipe(gulp.dest('./public/assets/'));
});

gulp.task('minify-img', function ()
{
    return gulp.src('./raw/assets/**/{*.png,*.jpg,*.jpeg}', {base: './raw/assets/'})
        .pipe(gulp.dest('./public/assets/'));
});

gulp.task('minify-js', function (cb)
{
    pump([
            gulp.src(['./raw/assets/**/*.js', '!./raw/assets/**/*.min.js'], {base: './raw/assets/'})
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
    return gulp.src(['./raw/assets/**/*.css', '!./raw/assets/**/*.min.css'], {base: './raw/assets/'})
        .pipe(rename({
            suffix: ".min",
            extname: ".css"
        }))
        .pipe(gulp.dest('./public/assets/'));
});

gulp.task('minify-html', function ()
{
    return gulp.src('./raw/application/**/{*.php,*.html}', {base: './raw/application/'})
        .pipe(gulp.dest('./application/'));
});

gulp.task('minify-json', function ()
{
    return gulp.src(['./raw/assets/**/*.json', '!./raw/assets/**/*.min.json'], {base: './raw/assets/'})
        .pipe(rename({
            suffix: ".min",
            extname: ".json"
        }))
        .pipe(gulp.dest('./public/assets/'));
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
    return watch('./raw/assets/**', function ()
    {
        return gulp.src('./raw/assets/**', {base: './raw/assets/'})
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('watch-minify-img', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch('./raw/assets/**/{*.png,*.jpg,*.jpeg}', function ()
    {
        return gulp.src('./raw/assets/**/{*.png,*.jpg,*.jpeg}', {base: './raw/assets/'})
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('watch-minify-js', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch(['./raw/assets/**/*.js', '!./raw/assets/**/*.min.js'], function (cb)
    {
        pump([
                gulp.src(['./raw/assets/**/*.js', '!./raw/assets/**/*.min.js'], {base: './raw/assets/'})
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
    return watch(['./raw/assets/**/*.css', '!./raw/assets/**/*.min.css'], function ()
    {
        return gulp.src(['./raw/assets/**/*.css', '!./raw/assets/**/*.min.css'], {base: './raw/assets/'})
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
    return watch('./raw/application/**/{*.php,*.html}', function ()
    {
        return gulp.src('./raw/application/**/{*.php,*.html}', {base: './raw/application/'})
            .pipe(gulp.dest('./application/'));
    });
});

gulp.task('watch-minify-json', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch(['./raw/assets/**/*.json', '!./raw/assets/**/*.min.json'], function ()
    {
        return gulp.src(['./raw/assets/**/*.json', '!./raw/assets/**/*.min.json'], {base: './raw/assets/'})
            .pipe(rename({
                suffix: ".min",
                extname: ".json"
            }))
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('cleaning-generated-file', shell.task([
    'cleaning.sh'
]));

gulp.task('cleaning-generated-file', function ()
{
    return gulp.src('cleaning.sh', {read: false})
        .pipe(shell([
            'sh <%= file.path %>'
        ]))
});
