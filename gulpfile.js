const gulp = require('gulp');

gulp.task("dist", function() {
	return gulp.src(
			[
				"./inc/**",
				"./languages/**",
				"./vendor/**",
				"./**/*.php",
				"./**/*.txt",
			],
			{
				base: "./"
			}
		)
		.pipe(gulp.dest("dist/lightning-g3-three-column-unit"));
});