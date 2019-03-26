var path = require('path');

module.exports = function(grunt) {
    require('jit-grunt')(grunt);
    require('time-grunt')(grunt);

    grunt.loadNpmTasks('grunt-scss-lint');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-spritesmith');
    grunt.loadNpmTasks('grunt-assets-versioning');
    grunt.loadNpmTasks('grunt-contrib-symlink');
    grunt.loadNpmTasks('grunt-mkdir');
    grunt.loadNpmTasks('grunt-vue');
    grunt.loadNpmTasks('grunt-contrib-uglify-es');

    require('load-grunt-config')(grunt, {
        configPath: path.join(process.cwd(), 'app/grunt'),
        jitGrunt: true
    });
};
