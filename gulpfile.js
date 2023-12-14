const gulp = require('gulp');

gulp.task("dist", function() {
	return gulp.src(
			[
				"./inc/**",
				"./modules/**",
				"./languages/**",
				"./vendor/**",
				"./**/*.php",
				"./**/*.txt",
				"!./tests/**",
				"!./dist/**",
				"!./node_modules/**"
			],
			{
				base: "./"
			}
		)
		.pipe(gulp.dest("dist/lightning-g3-three-column-unit"));
});