const path = require('path');
const {VueLoaderPlugin} = require("vue-loader");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const postcssPresetEnv = require('postcss-preset-env');

const DEFAULT_GLOBALS = {
    vue: 'RobotCore.vue',
    axios: 'RobotCore.axios',
    'element-plus': 'RobotCore.ElPlus',
    VueTheMask: 'RobotCore.VueTheMask',
}

module.exports = (env, argv) => {
    const mode = argv.mode ?? "production";
    const isDev = mode === "development";

    let babelOptions = {};
    if (!isDev) {
        babelOptions = {
            test: /\.(?:js|mjs|cjs)$/i,
            exclude: /node_modules/,
            use: {
                loader: 'babel-loader',
                options: {
                    presets: [
                        ['@babel/preset-env', {targets: "defaults"}]
                    ],
                }
            }
        };
    }

    return {
        mode: mode,
        devtool: isDev && "source-map",
        watchOptions: {
            aggregateTimeout: 600
        },
        entry: path.resolve(__dirname, "./src/main.js"),
        output: {
            path: path.resolve(__dirname, './dist/'),
            filename: 'script.bundle.js',
            clean: true,
            library: {
                name: 'RobotTestCard',
                type: 'umd',
                export: 'default',
            }
        },
        externals: DEFAULT_GLOBALS,
        plugins: [
            new VueLoaderPlugin(),
            new MiniCssExtractPlugin({ filename: 'styles.bundle.css' }),
        ],
        resolve: {
            extensions: ['.js', '.vue', '.css', '.scss']
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'vue-loader',
                    }
                },
                {
                    test: /\.(c|sa|sc)ss$/i,
                    include: [/node_modules/, path.resolve(__dirname, './src')],
                    use: [
                        MiniCssExtractPlugin.loader,
                        "css-loader",
                        {
                            loader: "postcss-loader",
                            options: {
                                postcssOptions: {
                                    plugins: [postcssPresetEnv]
                                }
                            }
                        },
                        "sass-loader"
                    ],
                },
                babelOptions
            ]
        },
    }
};