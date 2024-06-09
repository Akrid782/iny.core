module.exports = {
    input: 'src/app.js',
    output: 'dist/app.bundle.js',
    namespace: 'BX.Iny',
    browserslist: true,
    minification: false,
    plugins: {
        resolve: true,
    },
};
