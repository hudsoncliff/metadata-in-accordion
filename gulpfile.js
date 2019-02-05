var gulp = require('gulp'),
browserSync = require('browser-sync').create(),
sass = require('gulp-sass'),
postcss = require('gulp-postcss'),
cssnext = require('postcss-cssnext'),
paths = {
  'source': '',
  'sass': 'sass/',
  'css': 'css'
};

// gulp.task('serve', function() {
//
//     browserSync.init({
//         server: "./src"
//     });
//
//     gulp.watch("src/**", function() {
//       browserSync.reload();
//     });
// });

gulp.task('sass', function(){
  var processors = [
    cssnext({browsers: ['last 2 version']})
  ];
  return gulp.src(paths.sass + '*.scss')
  .pipe(sass().on('error', sass.logError))
  .pipe(postcss(processors))
  .pipe(gulp.dest(paths.css));
});

//watch if each children files in sass folder has changed
gulp.task('sass:watch', function(){
  gulp.watch(paths.sass + '**/*.scss', ['sass']);
})

gulp.task('default', ['serve','sass:watch']);
