var IB = {
    color: '0,0,0',
    lineWidth: 1,
    width: 480,
    height: 320
};

var pagenum = document.getElementById('pagenum').innerHTML;
var drawFlag = false;
var oldX = 0;
var oldY = 0;
var socket = io.connect('http://tetsuone.rackbox.net:8080');
var hozon = {
    oldX: 0,
    oldY: 0
};

window.addEventListener('load', function() {
    var can = document.getElementById('myCanvas');
    can.addEventListener('mousemove', draw, true);
    can.addEventListener('mousedown', function(e) {
        drawFlag = true;
        oldX = e.clientX - can.getBoundingClientRect().left;
        oldY = e.clientY - can.getBoundingClientRect().top;
        socket.emit('draw', {
            act: 'start',
            x: oldX,
            y: oldY,
            pagenum: pagenum
        });
    }, false);
    can.addEventListener('mouseup', function() {
        drawFlag = false;
    }, false)
}, true);

function draw(e) {
    if (!drawFlag) {
        return;
    }
    var can = document.getElementById('myCanvas');
    var x = e.clientX - can.getBoundingClientRect().left;
    var y = e.clientY - can.getBoundingClientRect().top;
    var context = can.getContext('2d');
    context.strokeStyle = 'rgba(' + IB.color + ',1)';
    context.lineWidth = IB.lineWidth;
    context.lineCap = "round";
    context.beginPath();
    context.moveTo(oldX, oldY);
    context.lineTo(x, y);
    context.stroke();
    context.closePath();
    oldX = x;
    oldY = y;

    socket.emit('draw', {
        act: 'draw',
        x: x,
        y: y,
        color: IB.color,
        lineWidth: IB.lineWidth
    });
}

socket.on('draw', function(data){
    switch (data.act) {
        case 'draw':
            var can = document.getElementById('myCanvas');
            var context = can.getContext('2d');
            context.strokeStyle = 'rgba(' + data.color + ',1)';
            context.lineWidth = data.lineWidth;
            context.lineCap = "round";
            context.beginPath();
            context.moveTo(hozon.oldX, hozon.oldY);
            context.lineTo(data.x, data.y);
            context.stroke();
            context.closePath();
            hozon.oldX = data.x;
            hozon.oldY = data.y;
            
        case 'start':
            hozon.oldX = data.x;
            hozon.oldY = data.y;
            
        case 'eraze':
            IB.erase();
    }
});

IB.changeColor = function(color) {
    IB.color = color;
}

IB.changeLineWidth = function() {
    var dom = document.getElementsByName('lineWidth');
    IB.lineWidth = dom[0].value;
}

IB.erase = function() {
    var can = document.getElementById('myCanvas');
    var context = can.getContext('2d');
    context.clearRect(0, 0, IB.width, IB.height);
    socket.emit('draw', {
       act: 'eraze'
    });
}

// 保存処理
IB.saveData = function() {
    var can = document.getElementById('myCanvas');
    var d = can.toDataURL('image/png');
    d = d.replace('image/png', 'image/octet-stream');
    window.open(d, 'save');
}
