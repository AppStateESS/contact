/* globals __dirname, module */
import webpack from 'webpack'
import path from 'path'
import BrowserSyncPlugin from 'browser-sync-webpack-plugin'

module.exports = (_env, argv) => {
  const inProduction = argv.mode === 'production'
  const inDevelopment = argv.mode === 'development'
  const settings = {
    entry: {
      form: './javascript/src/index.js',
      email: './javascript/src/Email.js',
    },
    output: {
      path: path.resolve(__dirname, 'javascript/dev'),
      filename: '[name].js',
    },
    resolve: {
      extensions: ['.js', '.jsx'],
    },
    externals: {
      $: 'jQuery',
      jquery: 'jQuery',
    },
    optimization: {
      splitChunks: {
        minChunks: 3,
        cacheGroups: {
          vendors: {
            test: /[\\/]node_modules[\\/]/,
            minChunks: 3,
            name: 'vendor',
            enforce: true,
            chunks: 'all',
          },
        },
      },
    },
    plugins: [],
    module: {
      rules: [
        {
          test: /\.jsx?/,
          include: path.resolve(__dirname, 'javascript/src'),
          use: {
            loader: 'babel-loader',
            options: {
              presets: ['@babel/preset-env', '@babel/preset-react'],
            },
          },
        },
        {
          test: /\.(png|woff|woff2|eot|ttf|svg)$/,
          use: {
            loader: 'url-loader?limit=100000',
          },
        },
        {
          test: /\.css$/,
          use: ['style-loader', 'css-loader'],
        },
      ],
    },
  }

  if (inDevelopment) {
    settings.plugins.push(
      new BrowserSyncPlugin({
        host: 'localhost',
        notify: false,
        port: 3000,
        files: ['./javascript/dev/*.js'],
        proxy: 'localhost/canopy',
      })
    )

    settings.devtool = 'inline-source-map'
  }

  if (inProduction) {
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify('production'),
    })

    settings.output = {
      path: path.resolve(__dirname, 'javascript/build'),
      filename: '[name].js',
    }
  }

  return settings
}
