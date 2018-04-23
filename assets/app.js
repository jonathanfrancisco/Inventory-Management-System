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

