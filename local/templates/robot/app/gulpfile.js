import gulp from 'gulp';
const { src, dest, watch, series } = gulp;

import { deleteAsync } from 'del';
import syncServer from 'browser-sync';
const sync = syncServer.create();
import flatten from 'gulp-flatten';

import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);
import autoprefixer from 'gulp-autoprefixer';
import minify from 'gulp-clean-css';
import sourcemaps from 'gulp-sourcemaps';
import concat from 'gulp-concat';

import babel from 'gulp-babel';
import terser from 'gulp-terser';

import imagemin from 'gulp-imagemin';
import svgSprite from 'gulp-svg-sprite';
import svgmin from 'gulp-svgmin';

const scss = () => {
	return src('src/styles/index.scss')
		.pipe(sourcemaps.init())
		.pipe(autoprefixer())
		.pipe(sass().on('error', sass.logError))
		.pipe(concat('style.min.css'))
		.pipe(minify())
		.pipe(sourcemaps.write('.'))
		.pipe(dest('dist/css'));
}

const js = () => {
	return src('src/scripts/**/*.js')
		.pipe(sourcemaps.init())
		.pipe(babel())
		.pipe(concat('main.min.js'))
		.pipe(terser())
		.pipe(sourcemaps.write('.'))
		.pipe(dest('dist/js'));
}

const clear = () => {
	return deleteAsync('dist');
}

const images = () => {
	return src('src/assets/img/*')
		.pipe(imagemin())
		.pipe(flatten())
		.pipe(dest('dist/assets/images/'));
}

const icons = () => {
	return gulp.src('src/assets/icons/**/*.svg')
		.pipe(svgmin({
			js2svg: {
				pretty: true
			}
		}))
		.pipe(svgSprite({
				mode: {
					stack: {
						sprite: "../sprite.svg"
					}
				},
			}
		))
		.pipe(dest('dist/assets/icons'));
};


const serve = () => {
	watch(['src/styles/**/**.scss'], scss);
	watch(['src/scripts/**/*.js'], js);
	watch(['src/assets/img/*'], images);
	watch(['src/assets/icons/*'], icons);
}

const build = series([clear, scss, js, images, icons]);
const dev = series([clear, scss, js, images, icons, serve]);

export { build, dev };