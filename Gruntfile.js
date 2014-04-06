module.exports = function(grunt) {
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        less: {
            development: {
                options: {
                    paths: ["src/Hyperreal/AcaciaBundle/Resources/public/css"]
                },
                files: {
                    "src/Hyperreal/AcaciaBundle/Resources/public/css/main.css": "src/Hyperreal/AcaciaBundle/Resources/public/less/main.less"
                }
            },
            production: {
                options: {
                    paths: ["src/Hyperreal/AcaciaBundle/Resources/public/css"],
                    cleancss: true
                },
                files: {
                    "src/Hyperreal/AcaciaBundle/Resources/public/css/main.min.css": "src/Hyperreal/AcaciaBundle/Resources/public/less/main.less"
                }
            }
        },
        watch: {
            scripts: {
                files: ['src/Hyperreal/AcaciaBundle/Resources/public/less/*.less'],
                tasks: ['less'],
                options: {
                    nospawn: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.registerTask('default', ['less', 'watch']);
};