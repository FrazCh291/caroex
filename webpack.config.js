const path = require('path');

module.exports = {
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
        },
    },
    stats: {
        children: true,
    },

    // output: {
    //     chunkFilename: 'js/[name].js?id=[chunkhash]',
    // },
};
