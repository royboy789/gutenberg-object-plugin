module.exports = {
  entry: './assets/js/main.js', // Webpack
  output: {
    path: __dirname + '/build/js/',
    filename: 'gutenberg-db.build.js'
  },
  module: {
    loaders: [
      {
        test: /.js$/,
        loader: 'babel-loader',
        exclude: /node_modules/,
      },
    ],
  },
};
