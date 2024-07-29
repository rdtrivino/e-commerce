import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import vue from '@vitejs/plugin-vue'

export default defineConfig({
	plugins: [
		laravel({
			input: [
				'resources/sass/app.scss',
				'resources/css/index_publi.css',
				'resources/css/admin.css',
				'resources/css/carrito.css',
				'resources/js/app.js',
				'resources/js/buscador.js',
				'resources/js/carrito.js'
			],
			refresh: true
		}),
		vue({
			template: {
				transformAssetUrls: {
					base: null,
					includeAbsolute: false
				}
			}
		})
	],
	resolve: {
		alias: {
			vue: 'vue/dist/vue.esm-bundler.js'
		}
	},
	server: {
		host: 'localhost',
		port: 3000
	}
})
