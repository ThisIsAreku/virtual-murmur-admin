function toHHMMSS(sec_num) {
    var totalSec = sec_num;
    var hours = parseInt( totalSec / 3600 ) % 24;
    var minutes = parseInt( totalSec / 60 ) % 60;
    var seconds = Math.round(totalSec % 60);

    return (hours < 10 ? "0" + hours : hours) + "h " + (minutes < 10 ? "0" + minutes : minutes) + "min " + (seconds  < 10 ? "0" + seconds : seconds) + 's';
}

$(function() {

    $('span[data-uptime]').each(function (){
        var $this = $(this);
        var initialTime = parseInt(new Date().getTime() / 1000);
        var upTime = parseInt($this.data('uptime'));
        setInterval(function () {
            var diffTime = upTime + (parseInt(new Date().getTime() / 1000) - initialTime);
            $this.text(toHHMMSS(diffTime));
        }, 1000);
    })
});