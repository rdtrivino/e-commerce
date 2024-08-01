import { createApp } from 'vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import axios from 'axios'

document.addEventListener('DOMContentLoaded', function () {
	axios
		.get('/cart/count')
		.then(response => {
			document.getElementById('cart-count').textContent = response.data.count
		})
		.catch(error => {
			console.error('Error fetching cart count:', error)
		})
})

const app = createApp({})

import ExampleComponent from './components/ExampleComponent.vue'
app.component('example-component', ExampleComponent)

app.mount('#app')
