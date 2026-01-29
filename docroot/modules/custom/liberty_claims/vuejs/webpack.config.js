let path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
  entry: './src/main.js',
  output: {
    path: path.resolve(__dirname, './dist'),
    publicPath: '/dist/',
    filename: 'build.js',
    clean: true
  },
  module: {
    rules: [
      { test: /\.css$/, use: ['vue-style-loader', 'css-loader'] },
      { test: /\.scss$/, use: ['vue-style-loader', 'css-loader', 'sass-loader'] },
      {
        test: /\.sass$/,
        use: [
          'vue-style-loader',
          'css-loader',
          {
            loader: 'sass-loader',
            options: { sassOptions: { indentedSyntax: true } }
          }
        ]
      },
      { test: /\.vue$/, loader: 'vue-loader' },
      { test: /\.m?js$/, loader: 'babel-loader', exclude: /node_modules/ },
      {
        test: /\.(png|jpe?g|gif|svg)$/i,
        type: 'asset/resource',
        generator: { filename: 'assets/[name].[hash:8][ext]' }
      }
    ]
  },
  resolve: {
    alias: { vue$: 'vue/dist/vue.esm.js' },
    extensions: ['*', '.js', '.vue', '.json']
  },
  plugins: [
    new VueLoaderPlugin(),
  ],
  devServer: {
    historyApiFallback: true,
    hot: true,
    static: false,
    client: { overlay: true }
  },
  performance: { hints: false },
  devtool: 'eval-source-map'
};

if (process.env.NODE_ENV === 'production') {
  module.exports.devtool = 'source-map';
  module.exports.mode = 'production';
}