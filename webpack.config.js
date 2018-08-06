/* globals __dirname, module */
const webpack = require('webpack')
const path = require('path')

module.exports = (env, argv) => {
  const inProduction = argv.mode === 'production'
  const inDevelopment = argv.mode === 'development'
  const settings = {
    entry: './javascript/src/index.js',
    output: {
      path: path.resolve(__dirname, 'javascript/dev'),
      filename: 'index.js'
    },
    resolve: {
      extensions: ['.js', '.jsx',]
    },
    plugins: [],
    module: {
      rules: [
        {
          test: /\.jsx?/,
          include: path.resolve(__dirname, 'javascript/src'),
          loader: 'babel-loader',
          query: {
            presets: ['env', 'react',]
          },
        }, {
          test: /\.(png|woff|woff2|eot|ttf|svg)$/,
          loader: 'url-loader?limit=100000'
        }, {
          test: /\.css$/,
          use: ['style-loader', 'css-loader',]
        },
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

    const UglifyJsPlugin = require('uglifyjs-webpack-plugin')
    settings.plugins.push(
      new webpack.DefinePlugin({'process.env.NODE_ENV': JSON.stringify('production')})
    )
    settings.plugins.push(new UglifyJsPlugin({extractComments: true}))
    settings.output = {
      path: path.resolve(__dirname, 'javascript/build'),
      filename: 'index.js'
    }
  }

  return settings
}
