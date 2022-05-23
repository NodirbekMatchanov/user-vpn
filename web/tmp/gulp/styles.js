
import gulp from 'gulp'
import plumber from 'gulp-plumber'
import browserSync from 'browser-sync'

import sass from 'gulp-sass'
import glob from 'gulp-sass-glob'
import postcss from 'gulp-postcss'
import autoprefixer from 'autoprefixer'
import mqpacker from 'css-mqpacker'
import mqsort from 'sort-css-media-queries'
import cssnano from 'cssnano'
import gulpif from 'gulp-if'
import sorting from 'postcss-sorting'
// import sassJson from 'gulp-sass-import-json'
import short from 'postcss-short'


gulp.task('styles', () => {
	return gulp.src([
		global.config.path.css[0] + '/*.+(sass|scss|css)'
		])
	.pipe(plumber())
	// .pipe(sassJson({
	// 	cache: false
	// }))
	.pipe(glob())
	.pipe(sass())
	.pipe(postcss([
		short(),
		mqpacker({
			sort: mqsort
		}),
		autoprefixer({
			grid: true,
		})
		])
	)
	.pipe(gulpif(global.config.mode == 'prod',
		postcss([cssnano()])
		))
	.pipe(gulp.dest(global.config.path.css[1]))
	.pipe(browserSync.reload({ stream: true }))
})