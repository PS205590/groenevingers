@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="mt-5">Checkout</h1>
        <form method="POST" action="{{ route('checkout.store') }}" class="mt-4">
            @csrf

            <div class="mb-3">
                <label for="customer_name" class="form-label">Naam:</label>
                <input type="text" class="form-control" id="customer_name" name="customer_name">
            </div>

            <div class="mb-3">
                <label for="postcode" class="form-label">Postcode:</label>
                <input type="text" class="form-control" id="postcode" name="postcode">
            </div>

            <div class="mb-3">
                <label for="house_number" class="form-label">Huisnummer:</label>
                <input type="text" class="form-control" id="house_number" name="house_number">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Adres:</label>
                <input type="text" class="form-control" id="address" name="address" readonly>
            </div>

            <button type="button" id="lookupAddress" class="btn btn-primary">Vind adres</button>

            <div class="mb-3">
                <label for="product" class="form-label">Selecteer product:</label>
                <select name="product" id="product" class="form-select">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} - €{{ $product->price }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" id="addProduct" class="btn btn-success">Voeg product toe</button>
            <ul id="selectedProducts" class="list-group mt-3 mb-3"></ul>
            <input type="hidden" name="selectedProducts" id="selectedProductsInput">
            <button type="submit" class="btn btn-primary">Plaats bestelling</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script>
        const productMap = {};



        document.addEventListener('DOMContentLoaded', function() {
            const addProductBtn = document.getElementById('addProduct');
            const selectedProductsList = document.getElementById('selectedProducts');
            const selectedProductsInput = document.getElementById('selectedProductsInput');
            // Map to track product quantities


            addProductBtn.addEventListener('click', function() {
                const productId = document.getElementById('product').value;
                const productName = document.getElementById('product').options[document.getElementById(
                    'product').selectedIndex].text;

                if (productMap[productId]) {
                    // If the product already exists, increase its quantity
                    productMap[productId]++;

                    updateProductListItem(productId, productMap[productId]);

                    alert(JSON.stringify(productMap))

                } else {
                    // If the product is added for the first time, initialize its quantity to 1
                    productMap[productId] = 1;
                    createProductListItem(productId, productName, productMap[productId]);

                    alert(JSON.stringify(productMap))
                }

                updateSelectedProductsInput();

            });

            function createProductListItem(productId, productName, quantity) {
                const listItem = document.createElement('li');
                listItem.textContent = productName;
                listItem.className = 'list-group-item';

                const quantitySpan = document.createElement('span');
                quantitySpan.textContent = ' ' + quantity + '';
                listItem.appendChild(quantitySpan);

                const deleteButton = document.createElement('button');
                deleteButton.textContent = 'Delete';
                deleteButton.className = 'btn btn-danger btn-sm ms-2';
                deleteButton.onclick = function() {
                    listItem.remove();
                    productMap[productId]--;
                    if (productMap[productId] === 0) {
                        delete productMap[productId];
                    }
                    updateSelectedProductsInput();
                };
                listItem.appendChild(deleteButton);

                selectedProductsList.appendChild(listItem);

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'products[]';
                input.value = productId;
                listItem.appendChild(input);
            }

            function updateProductListItem(productId, quantity) {
                const listItem = Array.from(selectedProductsList.children).find(item => item.querySelector('input')
                    .value === productId);
                if (listItem) {
                    const quantitySpan = listItem.querySelector('span');
                    if (quantitySpan) {
                        quantitySpan.textContent = ' ' + quantity + '';
                    }
                }
            }

            function updateSelectedProductsInput() {
                const selectedProductInputs = selectedProductsList.querySelectorAll('input');
                const selectedProductData = Array.from(selectedProductInputs).map(input => {
                    const productId = input.value;
                    const quantity = productMap[productId] || 1; // Default quantity to 1 if not found
                    return {
                        id: productId,
                        quantity: quantity
                    };
                });
                selectedProductsInput.value = JSON.stringify(selectedProductData);
            }




            document.getElementById('lookupAddress').addEventListener('click', function() {
                const postcode = document.getElementById('postcode').value;
                const houseNumber = document.getElementById('house_number').value;

                getAddressFromPostcodeAndHouse(postcode, houseNumber);
            });

            function getAddressFromPostcodeAndHouse(postcode, houseNumber) {
                const apiKey = 'ArGkRG9i9A8WjC2G2_BZybftt-RZu6YpQnQbEPX50vg6amY5I1uRsZoMlkEyZX5P';
                const url =
                    `https://dev.virtualearth.net/REST/v1/Locations?postalCode=${postcode}&addressLine=${houseNumber}&key=${apiKey}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        const address = data.resourceSets[0].resources[0].address;
                        const fullAddress =
                            `${address.addressLine}, ${address.locality}, ${address.adminDistrict}, ${address.countryRegion}`;
                        console.log('Full Address:', fullAddress);
                        document.getElementById('address').value = fullAddress;
                    })
                    .catch(error => {
                        console.error('Error fetching address:', error);
                    });
            }
        });
    </script>
@endsection
