/* globals __dirname, module */
const webpack = require('webpack')
const path = require('path')
const TerserPlugin = require('terser-webpack-plugin')

module.exports = (env, argv) => {
  const inProduction = argv.mode === 'production'
  const inDevelopment = argv.mode === 'development'
  const settings = {
    entry: {
      form: './javascript/src/index.js',
      email: './javascript/src/Email.js'
    },
    output: {
      path: path.resolve(__dirname, 'javascript/dev'),
      filename: '[name].js'
    },
    resolve: {
      extensions: ['.js', '.jsx']
    },
    externals: {
      $: 'jQuery',
      jquery: 'jQuery'
    },
    optimization: {
      minimizer: [new TerserPlugin()],
      splitChunks: {
        minChunks: 3,
        cacheGroups: {
          vendors: {
            test: /[\\/]node_modules[\\/]/,
            minChunks: 3,
            name: 'vendor',
            enforce: true,
            chunks: 'all'
          }
        }
      }
    },
    plugins: [],
    module: {
      rules: [
        {
          test: /\.jsx?/,
          include: path.resolve(__dirname, 'javascript/src'),
          loader: 'babel-loader',
          query: {
            presets: ['@babel/preset-env', '@babel/preset-react']
          }
        }, {
          test: /\.(png|woff|woff2|eot|ttf|svg)$/,
          loader: 'url-loader?limit=100000'
        }, {
          test: /\.css$/,
          use: ['style-loader', 'css-loader']
        }
      ]
    }
  }

  if (inDevelopment) {
    const BrowserSyncPlugin = require('browser-sync-webpack-plugin')
    settings.plugins.push(
      new BrowserSyncPlugin({host: 'localhost', notify: false, port: 3000, files: ['./javascript/dev/*.js'], proxy: 'localhost/canopy'})
    )
    settings.devtool = 'inline-source-map'
  }

  if (inProduction) {
    // const BundleAnalyzerPlugin =
    // require('webpack-bundle-analyzer').BundleAnalyzerPlugin
    // settings.plugins.push(new BundleAnalyzerPlugin())

    new webpack.DefinePlugin(
      {'process.env.NODE_ENV': JSON.stringify('production')}
    )

    settings.output = {
      path: path.resolve(__dirname, 'javascript/build'),
      filename: '[name].js'
    }
  }

  return settings
}
