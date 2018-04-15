var tickClock = () => {
    var time = new Date();
    var hours = time.getHours();
    var minutes = time.getMinutes();
    var seconds = time.getSeconds();
    updateTime(hours, minutes, seconds);
}

var updateTime = (time, hours, seconds) => {
    var currentTime = `${time}:${hours}:${seconds} ${time >= 12 ? "PM" : "AM"}`;
    document.querySelector('.header__time').innerHTML = currentTime;
}

setInterval(tickClock,1000);

function toggleAddModal() {
   document.querySelector('.modal-add').classList.toggle('show-modal');
   document.querySelector('.modal-add__form').classList.toggle('show-modal__form');
}

function toggleEditModal() {
    document.querySelector('.modal-edit').classList.toggle('show-modal');
}


function toggleStockModal() {
    document.querySelector('.modal-stock').classList.toggle('show-modal');
}