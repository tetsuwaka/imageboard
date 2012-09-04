var IB = {
    color: '0,0,0,1',
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

IB.setStatus = function () {
    var can = document.getElementById('setting');
    var ctx = can.getContext('2d');
    ctx.clearRect(0, 0, 100, 100);
    ctx.strokeStyle = 'rgba(' + IB.color + ')';
    ctx.fillStyle = 'rgba(' + IB.color + ')';
    ctx.beginPath();
    ctx.arc(50, 50, IB.lineWidth / 2, 0, Math.PI*2, false);
    ctx.stroke();
    ctx.fill();
}

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
    context.strokeStyle = 'rgba(' + IB.color + ')';
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
        case "draw":
            var can = document.getElementById('myCanvas');
            var context = can.getContext('2d');
            context.strokeStyle = 'rgba(' + data.color + ')';
            context.lineWidth = data.lineWidth;
            context.lineCap = "round";
            context.beginPath();
            context.moveTo(hozon.oldX, hozon.oldY);
            context.lineTo(data.x, data.y);
            context.stroke();
            context.closePath();
            hozon.oldX = data.x;
            hozon.oldY = data.y;
            break;

        case "start":
            hozon.oldX = data.x;
            hozon.oldY = data.y;
            break;

        case "eraze":
            IB.erase(1);
            break;

        case "move":
            IB.moveTop();
            break;

        case "chat":
            IB.inputComment(data.comment, data.name);
            break;
    }
});

document.getElementById('color').addEventListener('change', function() {
    var r = document.getElementById('r').value;
    var g = document.getElementById('g').value;
    var b = document.getElementById('b').value;
    var a = document.getElementById('a').value;
    IB.changeColor(r + ',' + g + ',' + b + ',' + a);
}, true);

IB.setColorStatus = function() {
    var colors = IB.color.split(',');
    document.getElementById('r').value = colors[0];
    document.getElementById('g').value = colors[1];
    document.getElementById('b').value = colors[2];
    document.getElementById('a').value = colors[3];
};

IB.changeColor = function(color) {
    IB.color = color;
    IB.setStatus();
    IB.setColorStatus();
}

IB.changeLineWidth = function() {
    var dom = document.getElementsByName('lineWidth');
    IB.lineWidth = dom[0].value;
    IB.setStatus();
}

IB.erase = function(flag) {
    var can = document.getElementById('myCanvas');
    var context = can.getContext('2d');
    context.clearRect(0, 0, IB.width, IB.height);
    if(flag !== 1) {
        socket.emit('draw', {
            act: 'eraze'
        });
    }
}

IB.move = function() {
    var can = document.getElementById('myCanvas');
    var d = can.toDataURL('image/png');
    socket.emit('draw', {
        act: 'move',
        image: d
    });
}

// Topに移動
IB.moveTop = function() {
    location.href = 'index.php';
}

IB.inputComment = function(comment, name) {
    var div = document.createElement('div');
    div.className = 'cell';
    var spanName = document.createElement('span');
    spanName.className = 'name';
    spanName.innerHTML = name;
    var spanComment = document.createElement('span');
    spanComment.className = 'comment';
    spanComment.innerHTML = comment;

    div.appendChild(spanComment);
    div.appendChild(spanName);

    document.getElementById('chatinner').appendChild(div);
    document.getElementById('chatcontainer').scrollByLines(1);
}

IB.sendChat = function() {
    var name = document.getElementById('hname').value;
    var comment = document.getElementById('comment').value;
    if (comment === '') {
        return;
    }

    IB.inputComment(comment, name);

    socket.emit('draw', {
        act: 'chat',
        name: name,
        comment: comment
    });
    document.getElementById('comment').value = '';
}

IB.setColorStatus();
IB.setStatus();