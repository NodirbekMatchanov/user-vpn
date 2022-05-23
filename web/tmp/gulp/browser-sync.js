
import gulp from 'gulp'
import plumber from 'gulp-plumber'
import browserSync from 'browser-sync'


gulp.task('browser-sync', () => {
	return browserSync({
		server: {
			baseDir: 'public'
		},
		// proxy: 'msb',
		notify: false,
		open: false,
		ghostMode: false
	})
})
