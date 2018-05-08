var tickClock = () => {
    var time = new Date();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var seconds = time.getSeconds();
    updateTime(hours, minutes, seconds);
}

var updateTime = (hours, minutes, seconds) => {
    var currentTime = `${hours >= 12 ? hours - 12 : hours}:${minutes}:${seconds} ${hours >= 12 ? "PM" : "AM"}`;
    document.querySelector('.header__time').innerHTML = currentTime;
}

setInterval(tickClock,1000);

function toggleAddModal() {
   document.querySelector('.modal-add').classList.toggle('show-modal');
   document.querySelector('.modal-add__form').classList.toggle('show-modal__form');
   document.querySelector('body').classList.toggle('modal-body--open');  
}

function toggleEditModal() {
    document.querySelector('.modal-edit').classList.toggle('show-modal');
    document.querySelector('body').classList.toggle('modal-body--open');  
}


function toggleStockModal() {
    document.querySelector('.modal-stock').classList.toggle('show-modal');
    document.querySelector('body').classList.toggle('modal-body--open');  
}

function toggleInvoiceModal() {
    document.querySelector('.modal-invoice').classList.toggle('show-modal');
    document.querySelector('body').classList.toggle('modal-body--open');  
}




document.querySelector('.addCartRow').addEventListener('click', (event) => {
    event.preventDefault();

    // var rowDiv = document.createElement('div');
    // var productDiv = document.createElement('div');
    // var productLabel = document.createElement('label');
    // var productBr = document.createElement('br');
    // var productSelect = document.createElement('select');
    // var quantityDiv = document.createElement('div');
    // var quantityLabel = document.createElement(quantityLabel);
    // var quantityBr = document.createElemet('br');
    // var quantityInput = document.createElemet('input');
    // var totalDiv = document.createElement('div');
    // var removeRowBtn = document.createElement('button');

    var rowDiv = document.createElement('div');
    rowDiv.className = "cartRow";
    var optionsHTML = document.querySelector('.first').innerHTML;
    rowDiv.innerHTML = `    <div>
                                <label>Select product:</label>
                                <br>
                                <select required name="product[]">
                                ${optionsHTML}
                                </select>
                            </div>
                            <div>
                                <label>Price:</label>
                                <br>
                                <input class="price" type="text" readonly style="background-color: rgba(0,0,0,0.2)" value="">
                            </div>
                            <p>X</p>
                            <div>
                                <label>Quantity:</label>
                                <br>
                                <input required class="quantity" min="1" type="text" name="quantity[]">
                            </div>
                            <p>=</p>
                            <div>
                                <label>Total:</label>
                                <br>
                                <input class="total" type="number" readonly style="background-color: rgba(0,0,0,0.2)" value="">
                            </div>
                            <button class="removeCartRow">X</button>`;
    
    
    document.querySelector('.productsCart').appendChild(rowDiv);

});

// DELETE ROW PRODUCT
document.querySelector('.productsCart').addEventListener('click', function(event) {


    if(event.target.tagName === "BUTTON") {
      
        var divToRemoved = event.target.parentNode;
        this.removeChild(divToRemoved);

    }

})

document.querySelector('.productsCart').addEventListener('input', function(event) {
    
    var row = event.target.parentNode.parentNode;

    if(event.target.tagName === "SELECT") {
        var index = event.target.selectedIndex;
        var selectedProduct = event.target.options[index];
        var price = selectedProduct.getAttribute('data-price');
        var quantity = row.querySelector('.quantity').value || 1;
        alert(quantity);
        row.querySelector('.price').value = price;
    }

    else if(event.target.tagName === "INPUT") {
        var index = row.querySelector('select').selectedIndex;
        var selectedProduct = row.querySelector('select').options[index];
        var price = selectedProduct.getAttribute('data-price');
        var quantity = row.querySelector('.quantity').value;
    }

    row.querySelector('.total').value = price * quantity;

    var totalArray = Array.from(document.querySelectorAll('.total'));
    var totalAmount = 0;

    for(var i = 0;i<totalArray.length;i++) {
        totalAmount += parseInt(totalArray[i].value);
    }

    document.getElementById("totalAmount").value = totalAmount;

    document.querySelector('.paidAmount').setAttribute("min",totalAmount);

});

document.querySelector('.paidAmount').addEventListener('input', function(event) {
   
    var changeAmount =  this.value - document.getElementById("totalAmount").value;
    document.querySelector('.changeAmount').value = changeAmount;

});
