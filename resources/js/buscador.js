var swiper = new Swiper('.swiper-container', {
	slidesPerView: 3,
	spaceBetween: 10,
	pagination: {
		el: '.swiper-pagination',
		clickable: true
	},
	navigation: {
		nextEl: '.swiper-button-next',
		prevEl: '.swiper-button-prev'
	}
})
document.addEventListener('DOMContentLoaded', function () {
	const categoryItems = document.querySelectorAll('.category-item')
	const searchInput = document.getElementById('search-input')
	const searchForm = document.getElementById('search-form')
	const productContainer = document.getElementById('product-list')
	const categoryName = document.getElementById('category-name')

	categoryItems.forEach(item => {
		item.addEventListener('click', function (event) {
			event.preventDefault()
			const categoryId = this.getAttribute('data-id')
			fetch(`/categories/${categoryId}/products`)
				.then(response => response.json())
				.then(data => {
					categoryName.textContent = data.category.name
					productContainer.innerHTML = ''
					data.products.forEach(product => {
						const productCard = `
                            <div class="col-md-4 mb-4 product-item">
                                <div class="card">
                                    <img src="${
																			product.image_url
																		}" class="card-img-top" alt="${
							product.name
						}">
                                    <div class="card-body">
                                        <h5 class="card-title">${
																					product.name
																				}</h5>
                                        <p class="card-text">${product.description.substring(
																					0,
																					100
																				)}</p>
                                        <p class="card-text">$${
																					product.price
																				}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('products.showPublic', '') }}/${
																					product.id
																				}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-success">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `
						productContainer.insertAdjacentHTML('beforeend', productCard)
					})
				})
		})
	})

	const performSearch = query => {
		if (query.length > 2) {
			fetch(`/search/live?query=${query}`)
				.then(response => response.json())
				.then(data => {
					productContainer.innerHTML = ''
					data.products.forEach(product => {
						const productCard = `
                            <div class="col-md-4 mb-4 product-item">
                                <div class="card">
                                    <img src="${
																			product.image_url
																		}" class="card-img-top" alt="${
							product.name
						}">
                                    <div class="card-body">
                                        <h5 class="card-title">${
																					product.name
																				}</h5>
                                        <p class="card-text">${product.description.substring(
																					0,
																					100
																				)}</p>
                                        <p class="card-text">$${
																					product.price
																				}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('products.showPublic', '') }}/${
																					product.id
																				}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-success">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        `
						productContainer.insertAdjacentHTML('beforeend', productCard)
					})
				})
		} else {
			productContainer.innerHTML = ''
		}
	}

	searchInput.addEventListener('input', function (event) {
		const query = event.target.value
		performSearch(query)
	})

	searchForm.addEventListener('submit', function (event) {
		event.preventDefault()
		const query = searchInput.value
		performSearch(query)
	})
})

// carrito 

document.addEventListener('DOMContentLoaded', function() {
    const categoryItems = document.querySelectorAll('.category-item');
    const searchInput = document.getElementById('search-input');
    const searchForm = document.getElementById('search-form');
    const productContainer = document.getElementById('product-list');
    const categoryName = document.getElementById('category-name');
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    const cartCount = document.getElementById('cart-count');
    const cartItems = document.getElementById('cart-items');

    let cart = [];

    const updateCart = () => {
        cartCount.textContent = cart.length;
        cartItems.innerHTML = '';
        if (cart.length > 0) {
            cart.forEach(item => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = item.name;
                cartItems.appendChild(listItem);
            });
        } else {
            const emptyItem = document.createElement('li');
            emptyItem.className = 'list-group-item';
            emptyItem.textContent = 'No hay productos en el carrito.';
            cartItems.appendChild(emptyItem);
        }
    };

    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            fetch(`/products/${productId}`)
                .then(response => response.json())
                .then(data => {
                    cart.push(data.product);
                    updateCart();
                });
        });
    });

    categoryItems.forEach(item => {
        item.addEventListener('click', function(event) {
            event.preventDefault();
            const categoryId = this.getAttribute('data-id');
            fetch(`/categories/${categoryId}/products`)
                .then(response => response.json())
                .then(data => {
                    categoryName.textContent = data.category.name;
                    productContainer.innerHTML = '';
                    data.products.forEach(product => {
                        const productCard = `
                        <div class="col-md-4 mb-4 product-item">
                            <div class="card">
                                <img src="${product.image_url}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">${product.description.substring(0, 100)}</p>
                                    <p class="card-text">$${product.price}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="/products/${product.id}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-success add-to-cart" data-id="${product.id}">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                        productContainer.insertAdjacentHTML('beforeend',
                            productCard);
                    });
                });
        });
    });

    searchForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const query = searchInput.value;
        fetch(`/search/live?query=${query}`)
            .then(response => response.json())
            .then(data => {
                productContainer.innerHTML = '';
                if (data.products.length > 0) {
                    data.products.forEach(product => {
                        const productCard = `
                        <div class="col-md-4 mb-4 product-item">
                            <div class="card">
                                <img src="${product.image_url}" class="card-img-top" alt="${product.name}">
                                <div class="card-body">
                                    <h5 class="card-title">${product.name}</h5>
                                    <p class="card-text">${product.description.substring(0, 100)}</p>
                                    <p class="card-text">$${product.price}</p>
                                </div>
                                <div class="card-footer">
                                    <a href="/products/${product.id}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button class="btn btn-success add-to-cart" data-id="${product.id}">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                        productContainer.insertAdjacentHTML('beforeend', productCard);
                    });
                } else {
                    productContainer.innerHTML = '<p>No se encontraron productos.</p>';
                }
            });
    });
});
