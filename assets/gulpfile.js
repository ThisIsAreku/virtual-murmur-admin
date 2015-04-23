var fs          = require('fs');
var gulp        = require('gulp');
var less        = require('gulp-less');
var prefix      = require('gulp-autoprefixer');
var plumber     = require('gulp-plumber');
var concat      = require('gulp-concat');
var watch       = require('gulp-watch');

var base_path = '../';

var web_path = base_path+'web/';

var stylesheets_path = web_path+'stylesheets/';
var javascripts_path = web_path+'javascripts/';
var images_path = web_path+'images/';

function createDirOrFail(path, callback) {
    fs.mkdir(path, function (err) {
        if (err != null && err.code != 'EEXIST') {
            throw err;
        }

        if (typeof callback !== 'undefined') {
            callback(path);
        }
    })
}

gulp.task('default', ['stylesheets', 'js']);
gulp.task('first-deploy', ['create-tmp']);


gulp.task('create-tmp', function () {
    createDirOrFail(stylesheets_path);
    createDirOrFail(images_path);
});


gulp.task('stylesheets', function () {
    gulp.src('stylesheets/*.less')
        .pipe(plumber())
        .pipe(less())
        .pipe(prefix())
        .pipe(gulp.dest(stylesheets_path))
})

gulp.task('images', function () {
    gulp.src(['images/*.jpg', 'images/front/*.jpg', 'images/*.png', 'images/front/*.png'])
        .pipe(plumber())
        .pipe(gulp.dest(images_path))
})

gulp.task('js', function () {
     gulp.src(['javascripts/web.js'])
         .pipe(concat('web.js', {newLine: ';'}))
         .pipe(gulp.dest(javascripts_path))
})

gulp.task('watch', ['default'], function (){
    watch('javascripts/web.js')
        .pipe(concat('web.js', {newLine: ';'}))
        .pipe(gulp.dest(javascripts_path));

    watch('stylesheets/*.less')
        .pipe(plumber())
        .pipe(less())
        .pipe(prefix())
        .pipe(gulp.dest(stylesheets_path))
});


