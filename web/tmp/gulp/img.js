
import gulp from 'gulp'
import plumber from 'gulp-plumber'
import webp from 'gulp-webp'
import del from 'del'


gulp.task('webp', (done) => {
	del(global.config.path.img + '/webp/*', {force: true})

	gulp.src(global.config.path.img + '/**/*.+(jpg|jpeg|png)')
	.pipe(plumber())
	.pipe(webp({
		quality: 75
	}))
	.pipe(gulp.dest(global.config.path.img + '/webp'))
	done()
});