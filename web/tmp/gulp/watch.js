
import gulp from 'gulp'
import browserSync from 'browser-sync'


function browserSyncReload(done) {
	browserSync.reload()
	done()
}

gulp.task('watch', gulp.series(
	'styles',
	'scripts',
	'webp',

	(done) => {

	gulp.watch([global.config.path.css[0] + '/**/*.+(sass|scss|css)'], gulp.series('styles'))
	gulp.watch([global.config.path.js[0] + '/**/*.js', global.config.path.app + '/libs/**/*.js', global.config.path.app + '/**/*.vue'], gulp.series('scripts'))

	gulp.watch(global.config.path.html + '/**/*.php', gulp.series(browserSyncReload))
	gulp.watch([global.config.path.img + '/**/*.+(jpg|jpeg|png)', '!' + global.config.path.img + '/webp'], gulp.series('webp'))

	done()
}))
