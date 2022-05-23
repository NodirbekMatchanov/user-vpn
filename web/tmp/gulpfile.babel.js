
import gulp from 'gulp';

import './gulp/_config.js'
import './gulp/styles'
import './gulp/scripts'
import './gulp/img'
import './gulp/browser-sync'
import './gulp/watch'

gulp.task('default', gulp.parallel('browser-sync', 'watch'));