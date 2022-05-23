
import gulp from 'gulp'
import browserSync from 'browser-sync'
import plumber from 'gulp-plumber'

import webpack from 'webpack-stream'
// import uglify from 'gulp-uglify'
import named from 'vinyl-named'
// import gulpif from 'gulp-if'

import uglify from 'uglifyjs-webpack-plugin'


gulp.task('scripts', () => {
	return gulp.src([
		global.config.path.js[0] + '/*.js'
		])
	.pipe(plumber())
	.pipe(named())
	.pipe(webpack({
		mode: global.config.mode == 'dev' ? 'development' : 'production',
		watch: false,
		stats: {
			colors: true,
			hash: false,
			version: false,
			timings: false,
			assets: false,
			chunks: false,
			modules: false,
			reasons: false,
			children: false,
			source: false,
			errors: true,
			errorDetails: true,
			warnings: false,
			publicPath: false,
			builtAt: false,
		},
		optimization: {
			minimizer: [
			new uglify({
				sourceMap: true,
				uglifyOptions: {
					compress: false,
					mangle: false,
					drop_console: false
				}
			})
			],
			runtimeChunk: false,
		},
		module: {
			rules: [
			{
				test: /\.css$/,
				use: [
				'vue-style-loader',
				'css-loader'
				],
			},
			{
				test: /\.scss$/,
				use: [
				'vue-style-loader',
				'css-loader',
				'sass-loader'
				],
			},
			{
				test: /\.sass$/,
				use: [
				'vue-style-loader',
				'css-loader',
				'sass-loader?indentedSyntax'
				],
			},
			{
				test: /\.vue$/,
				loader: 'vue-loader',
				options: {
					loaders: {
						'scss': [
						'vue-style-loader',
						'css-loader',
						'sass-loader'
						],
						'sass': [
						'vue-style-loader',
						'css-loader',
						'sass-loader?indentedSyntax'
						]
					}
				}
			},
			{
				test: /\.js$/,
				loader: 'babel-loader',
				exclude: /node_modules|libs/,
			},
			{
				test: /\.(png|jpg|gif|svg)$/,
				loader: 'file-loader',
				options: {
					name: '[name].[ext]?[hash]'
				}
			}
			]
		},
		externals: {
			jquery: 'jQuery'
		},
		resolve: {
			alias: {
				// 'vue$': 'vue/dist/vue.esm.js',
			},
			extensions: ['*', '.js', '.vue', '.json']
		},
		performance: {
			hints: false
		},
	}))

	.pipe(gulp.dest(global.config.path.js[1]))
	.pipe(browserSync.reload({ stream: true }))
})