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

