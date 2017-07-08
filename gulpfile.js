/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 08 July 2017, 9:56 AM.
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
        .pipe(imagemin([
            imagemin.gifsicle({interlaced: true}),
            imagemin.jpegtran({progressive: true}),
            imagemin.optipng({optimizationLevel: 5}),
            imagemin.svgo({plugins: [{removeViewBox: true}]})
        ]))
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
            uglify(),
            gulp.dest('./public/assets/')
        ],
        cb
    );
});

gulp.task('minify-css', function ()
{
    return gulp.src(['./raw/assets/**/*.css', '!./raw/assets/**/*.min.css'], {base: './raw/assets/'})
        .pipe(cleanCSS({compatibility: 'ie8', rebase: false}))
        .pipe(rename({
            suffix: ".min",
            extname: ".css"
        }))
        .pipe(gulp.dest('./public/assets/'));
});

gulp.task('minify-html', function ()
{
    return gulp.src('./raw/application/views/**/{*.php,*.html}', {base: './raw/application/views/'})
        .pipe(htmlmin({
            collapseWhitespace: true,
            removeAttributeQuotes: true,
            removeComments: true,
            minifyJS: true,
            minifyCSS: true
        }))
        .pipe(gulp.dest('./application/views/'));
});

gulp.task('minify-json', function ()
{
    return gulp.src(['./raw/assets/**/*.json', '!./raw/assets/**/*.min.json'], {base: './raw/assets/'})
        .pipe(jsonMinify())
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
            .pipe(imagemin([
                imagemin.gifsicle({interlaced: true}),
                imagemin.jpegtran({progressive: true}),
                imagemin.optipng({optimizationLevel: 5}),
                imagemin.svgo({plugins: [{removeViewBox: true}]})
            ]))
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('watch-minify-js', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch(['./raw/assets/**/*.js', '!./raw/assets/**/*.min.js'], function (cb)
    {
        pump([
                gulp.src(['./raw/assets/**/*.js', '!./raw/assets/**/*.min.js'], {base: './raw/assets/'}).pipe(rename({
                    suffix: ".min",
                    extname: ".js"
                })),
                uglify(),
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
            .pipe(cleanCSS({compatibility: 'ie8'}))
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
    return watch('./raw/application/views/**/{*.php,*.html}', function ()
    {
        return gulp.src('./raw/application/views/**/{*.php,*.html}', {base: './raw/application/views/'})
            .pipe(htmlmin({
                collapseWhitespace: true,
                removeAttributeQuotes: true,
                removeComments: true,
                minifyJS: true,
                minifyCSS: true
            }))
            .pipe(gulp.dest('./application/views/'));
    });
});

gulp.task('watch-minify-json', function ()
{
    // Callback mode, useful if any plugin in the pipeline depends on the `end`/`flush` event
    return watch(['./raw/assets/**/*.json', '!./raw/assets/**/*.min.json'], function ()
    {
        return gulp.src(['./raw/assets/**/*.json', '!./raw/assets/**/*.min.json'], {base: './raw/assets/'})
            .pipe(jsonMinify())
            .pipe(rename({
                suffix: ".min",
                extname: ".json"
            }))
            .pipe(gulp.dest('./public/assets/'));
    });
});

gulp.task('cleaning-generated-file', function ()
{
    return gulp.src('cleaning.sh', {read: false})
        .pipe(shell([
            'sh <%= file.path %>'
        ]))
});

gulp.task('move-application-sql-migration', function ()
{
    return gulp.src('./raw/application/sql/*ion_auth*.sql', {base: './raw/application/sql/'})
        .pipe(gulp.dest('./assets/db/ddl/ion_auth/'));
});
