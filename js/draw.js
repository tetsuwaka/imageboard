var drawFlag = false;
var oldX = 0;
var oldY = 0;
window.addEventListener('load', function() {
    var can = document.getElementById('myCanvas');
    can.addEventListener('mousemove', draw, true);
    can.addEventListener('mousedown', function(e) {
        drawFlag = true;
        oldX = e.clientX;
        oldY = e.clientY;
    }, false);
    can.addEventListener('mouseup', function() {
        drawFlag = false;
    }, false)
}, true);

function draw(e) {
    if (!drawFlag) {
        return;
    }
    var x = e.clientX;
    var y = e.clientY;
    var can = document.getElementById('myCanvas');
    var context = can.getContext('2d');
    context.strokeStyle = 'rgba(255,0,0,1)';
    context.lineWidth = 1;
    context.beginPath();
    context.moveTo(oldX, oldY);
    context.lineTo(x, y);
    context.stroke();
    context.closePath();
    oldX = x;
    oldY = y;
}

// 保存処理
function saveData(){
    var can = document.getElementById('myCanvas');
    var d = can.toDataURL('image/png');
    d = d.replace('image/png', 'image/octet-stream');
    window.open(d, 'save');
}