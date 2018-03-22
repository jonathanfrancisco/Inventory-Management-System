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