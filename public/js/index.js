var canvas = document.getElementById('myCanvas');
var ctx = canvas.getContext('2d');
var img = new Image();
img.src = "img/livewait.png";
img.onload = function() {
    ctx.drawImage(img, 0, 0, 320, 240, 0, 0, 320, 240);
}
            
function pushSubmit() {
    document.getElementsByTagName('form')[0].submit();
}
var socket = io.connect('http://tetsuone.rackbox.net:8080');
socket.on('draw', function (data) {
    if (data.pagenum == <?php echo $threadnum; ?>) {
        var element = document.getElementById('livewrite');
        element.innerHTML = '<img src="img/livewrite.png">';
        element.addEventListener('click', pushSubmit, false);
    }
    if (data.act === 'move') {
        ctx.clearRect(0, 0, 320, 240);
        var img = new Image();
        img.src = data.image;
        img.onload = function() {
            ctx.drawImage(img, 0, 0, 480, 320, 0, 0, 320, 240);
        }
        var element = document.getElementById('livewrite');
        element.innerHTML = '<img src="img/wait.png">';
    }
});