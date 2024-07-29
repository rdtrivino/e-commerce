// Función para actualizar la cantidad de productos en el carrito
function updateCartQuantity(productId, change) {
	fetch(`/cart/update/${productId}`, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': document
				.querySelector('meta[name="csrf-token"]')
				.getAttribute('content')
		},
		body: JSON.stringify({
			quantity_change: change
		})
	})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				updateCartCount()
				updateCartItems()
			} else {
				alert('Error al actualizar la cantidad.')
			}
		})
		.catch(error => console.error('Error updating cart quantity:', error))
}

// Función para eliminar un producto del carrito
function removeCartItem(productId) {
	fetch(`/cart/remove/${productId}`, {
		method: 'DELETE',
		headers: {
			'Content-Type': 'application/json',
			'X-CSRF-TOKEN': document
				.querySelector('meta[name="csrf-token"]')
				.getAttribute('content')
		}
	})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				updateCartCount()
				updateCartItems()
			} else {
				alert('Error al eliminar el producto.')
			}
		})
		.catch(error => console.error('Error removing cart item:', error))
}

// Función para actualizar el número de productos en el carrito
function updateCartCount() {
	fetch('/cart/count')
		.then(response => response.json())
		.then(data => {
			document.getElementById('cart-count').innerText = data.count
		})
		.catch(error => console.error('Error updating cart count:', error))
}

// Función para actualizar los elementos del carrito en el modal
function updateCartItems() {
	fetch('/cart/items')
		.then(response => response.json())
		.then(data => {
			const cartItems = document.getElementById('cart-items')
			const cartModalTotal = document.getElementById('cart-modal-total')

			cartItems.innerHTML = ''
			let total = 0

			if (data.items.length) {
				data.items.forEach(item => {
					const itemElement = document.createElement('li')
					itemElement.className =
						'list-group-item d-flex justify-content-between align-items-center'
					itemElement.innerHTML = `
                    <img src="${item.image}" class="cart-item-image" alt="${item.name}">
                    <div>
                        <h6>${item.name}</h6>
                        <p>$${item.price}</p>
                    </div>
                    <div class="quantity-controls d-flex align-items-center">
                        <button class="btn btn-sm btn-outline-secondary decrease-quantity" data-id="${item.id}">-</button>
                        <span class="mx-2">${item.quantity}</span>
                        <button class="btn btn-sm btn-outline-secondary increase-quantity" data-id="${item.id}">+</button>
                        <button class="btn btn-sm btn-danger ml-2 remove-item" data-id="${item.id}">Eliminar</button>
                    </div>
                `
					cartItems.appendChild(itemElement)
					total += item.price * item.quantity
				})
			} else {
				cartItems.innerHTML =
					'<li class="list-group-item text-center">No hay productos en el carrito.</li>'
			}

			cartModalTotal.innerText = total.toFixed(2)
		})
		.catch(error => console.error('Error updating cart items:', error))
}

// Función para mostrar un modal de éxito al agregar un producto al carrito
function showSuccessModal() {
	$('#successModal').modal('show')
	setTimeout(() => {
		$('#successModal').modal('hide')
	}, 2000)
}

// Event listeners para aumentar, disminuir y eliminar productos del carrito
document.addEventListener('click', event => {
	if (event.target.classList.contains('increase-quantity')) {
		const productId = event.target.getAttribute('data-id')
		updateCartQuantity(productId, 'increase')
	} else if (event.target.classList.contains('decrease-quantity')) {
		const productId = event.target.getAttribute('data-id')
		updateCartQuantity(productId, 'decrease')
	} else if (event.target.classList.contains('remove-item')) {
		const productId = event.target.getAttribute('data-id')
		removeCartItem(productId)
	}
})

// Inicializa el carrito cuando se carga la página
document.addEventListener('DOMContentLoaded', () => {
	updateCartCount()
	updateCartItems()
})

// Agrega un evento de clic a los botones de "Agregar al carrito"
document.querySelectorAll('.add-to-cart').forEach(button => {
	button.addEventListener('click', event => {
		event.preventDefault()
		const productId = event.target.getAttribute('data-id')

		fetch('/cart/add', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-CSRF-TOKEN': document
					.querySelector('meta[name="csrf-token"]')
					.getAttribute('content')
			},
			body: JSON.stringify({
				product_id: productId
			})
		})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					updateCartCount()
					showSuccessModal()
					updateCartItems()
				} else {
					alert('Error al agregar el producto al carrito.')
				}
			})
			.catch(error => console.error('Error adding to cart:', error))
	})
})
