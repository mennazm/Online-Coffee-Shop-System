//! 02_user
let priceArr = [];

function getSum(total, num) {
    return total + num;
}

// Select order
document.querySelectorAll('.allProducts .products .each-order').forEach(function(element) {
    element.addEventListener('click', function() {
        let itemPrice = parseInt(this.querySelector('input').value);
        let itemName = this.querySelector('input').getAttribute('name');
        let itemId = parseInt(this.getAttribute('data-product-id')); // Get the product ID from the data attribute
        let itemImageSrc = this.querySelector('img').getAttribute('src');
        let choosenItems = document.querySelector('.choosen-items ul');
        let newItem = document.createElement('li');
        newItem.className = 'hidden';
        newItem.innerHTML = `
            <div class='item-info'> 
                <img src="${itemImageSrc}" alt="${itemName}" style="width: 70px; height: 70px;">
                <h5>${itemName}</h5> 
                <div class='item-counter' style="color: #93634C;">
                    <span>1</span>
                    <i class='add fa fa-plus-circle' style="color: #93634C;"></i>
                    <i class='sub fa fa-minus-circle' style="color: #93634C;"></i>
                </div>
                <div class="price">
                    <span>EGP <span>${itemPrice}</span></span>
                    <i class="remove fa fa-trash"></i>
                </div>
                <input type="text" name="${itemName}" value="${itemPrice}" hidden />
                <input type="hidden" name="product_id[]" value="${itemId}" />
                <input type="hidden" name="quantity[${itemId}]" value="1" class="quantity" />
                <span class="itemPrice hidden">${itemPrice}</span>
            </div>`;

        // Append the new item to the chosen items container and fade it in
        choosenItems.appendChild(newItem);
        newItem.classList.remove('hidden');

        // Update the total price
        let totalPrice = document.querySelector('.orders-panel .total-price span span');
        priceArr.push(itemPrice);
        let total = priceArr.reduce(getSum, 0);
        priceArr = [];
        priceArr.push(total);
        totalPrice.textContent = total;

        // Set the total price in an input field for potential form submission
        document.querySelector('.orders-panel .total-price input').value = total;

        // Log the priceArr array to the console for debugging
        console.log(priceArr);
    });
});

// Add one item
document.querySelector(".choosen-items").addEventListener("click", function(event) {
    if (event.target.classList.contains("add")) {
        let itemPrice = parseInt(
            event.target.closest(".item-info").querySelector(".itemPrice").innerHTML
        );
        let itemCounter = parseInt(
            event.target.closest(".item-info").querySelector(".item-counter span").innerHTML
        );
        let newPrice = parseInt(
            event.target.closest(".item-info").querySelector(".price span span").textContent
        );
        let totalPrice = document.querySelector(".orders-panel .total-price span span");
        itemCounter++;
        newPrice = newPrice + itemPrice;
        event.target.closest(".item-info").querySelector(".item-counter span").textContent = itemCounter;
        event.target.closest(".item-info").querySelector(".price span span").textContent = newPrice;
        event.target.closest(".item-info").querySelector("input").value = newPrice;

        // Increment the quantity input value
        let quantityInput = event.target.closest(".item-info").querySelector(".quantity");
        quantityInput.value = itemCounter;

        priceArr.push(itemPrice);
        let total = priceArr.reduce(getSum);
        priceArr = [];
        priceArr.push(total);
        totalPrice.textContent = total;
        document.querySelector(".orders-panel .total-price input").value = total;
        console.log(priceArr);
    }
});

// Subtract one item
document.querySelector(".choosen-items").addEventListener("click", function(event) {
    if (event.target.classList.contains("sub")) {
        let itemPrice = parseInt(
            event.target.closest(".item-info").querySelector(".itemPrice").innerHTML
        );
        let itemCounter = parseInt(
            event.target.closest(".item-info").querySelector(".item-counter span").innerHTML
        );
        let newPrice = parseInt(
            event.target.closest(".item-info").querySelector(".price span span").textContent
        );
        let totalPrice = document.querySelector(".orders-panel .total-price span span");
        if (itemCounter > 0) {
            itemCounter--;
            newPrice = newPrice - itemPrice;
            event.target.closest(".item-info").querySelector(".item-counter span").textContent = itemCounter;
            event.target.closest(".item-info").querySelector(".price span span").textContent = newPrice;
            event.target.closest(".item-info").querySelector("input").value = newPrice;

            // Decrement the quantity input value
            let quantityInput = event.target.closest(".item-info").querySelector(".quantity");
            quantityInput.value = itemCounter;

            let total = priceArr[0];
            total = total - itemPrice;
            priceArr = [];
            priceArr.push(total);
            totalPrice.textContent = total;
            document.querySelector(".orders-panel .total-price input").value = total;
            console.log(priceArr);
        }
    }
});

// Remove selected item
document.querySelector('.choosen-items').addEventListener('click', function(event) {
    if (event.target.classList.contains('remove')) {
        let itemInfo = event.target.closest('.item-info');
        let itemTotalPrice = parseInt(itemInfo.querySelector('input').value);
        let totalPriceElem = document.querySelector('.orders-panel .total-price span span');
        let totalPrice = priceArr[0];

        totalPrice = totalPrice - itemTotalPrice;
        priceArr = [];
        priceArr.push(totalPrice);

        totalPriceElem.textContent = totalPrice;
        document.querySelector('.orders-panel .total-price input').value = totalPrice;

        itemInfo.parentNode.removeChild(itemInfo);
        console.log(priceArr);
    }
});

//* ////////////////////////////////////////////////////////////////////////
