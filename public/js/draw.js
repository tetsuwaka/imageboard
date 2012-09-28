var IB = {
    color: '0,0,0,1',
    lineWidth: 1,
    width: 480,
    height: 320,
    end: false,
    pagenum: document.getElementById('pagenum').innerHTML,
    dragFlag: false,
    oldX: 0,
    oldY: 0,
    hozon: {oldX: 0, oldY: 0}
};

var socket = io.connect('http://tetsuone.rackbox.net:8080');

IB.setStatus = function() {
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
    can.addEventListener('mousemove', IB.draw, true);
    can.addEventListener('mousedown', function(e) {
        IB.drawFlag = true;
        IB.oldX = e.clientX - can.getBoundingClientRect().left;
        IB.oldY = e.clientY - can.getBoundingClientRect().top;
        socket.emit('draw', {
            act: 'start',
            x: IB.oldX,
            y: IB.oldY,
            pagenum: IB.pagenum
        });
    }, false);
    can.addEventListener('mouseup', function() {
        IB.drawFlag = false;
    }, false)
}, true);

IB.draw = function(e) {
    if (!IB.drawFlag) {
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
    context.moveTo(IB.oldX, IB.oldY);
    context.lineTo(x, y);
    context.stroke();
    context.closePath();
    IB.oldX = x;
    IB.oldY = y;

    socket.emit('draw', {
        act: 'draw',
        x: x,
        y: y,
        color: IB.color,
        lineWidth: IB.lineWidth
    });
}

socket.on('draw', function(data) {
    switch (data.act) {
        case "draw":
            var can = document.getElementById('myCanvas');
            var context = can.getContext('2d');
            context.strokeStyle = 'rgba(' + data.color + ')';
            context.lineWidth = data.lineWidth;
            context.lineCap = "round";
            context.beginPath();
            context.moveTo(IB.hozon.oldX, IB.hozon.oldY);
            context.lineTo(data.x, data.y);
            context.stroke();
            context.closePath();
            IB.hozon.oldX = data.x;
            IB.hozon.oldY = data.y;
            break;

        case "start":
            IB.hozon.oldX = data.x;
            IB.hozon.oldY = data.y;
            break;

        case "eraze":
            IB.erase(1);
            break;

        case "move":
            IB.moveTop();
            break;
    }
});

socket.on('chat', function(data) {
    IB.inputComment(data.comment, data.name);
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

IB.save = function() {
    var can = document.getElementById('myCanvas');
    var d = can.toDataURL('image/png');
    var ele = document.getElementsByName('image');
    ele[0].value = d;
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

    var inner = document.getElementById('chatinner')
    inner.appendChild(div);
    document.getElementById('chatcontainer').scrollTop = inner.scrollHeight;
}

IB.sendChat = function() {
    var name = document.getElementById('hname').value;
    var comment = document.getElementById('comment').value;
    if (comment === '') {
        return;
    }

    IB.inputComment(comment, name);

    socket.emit('chat', {
        name: name,
        comment: comment
    });
    document.getElementById('comment').value = '';
}

IB.blink = function() {
    if (document.all('message').style.visibility == 'visible') {
        document.all.message.style.visibility = 'hidden';
    } else {
        document.all.message.style.visibility = 'visible';
    }
    if (IB.end) {
        document.all.message.style.visibility = 'visible';
        document.all.complete.style.color = 'blue';
        return;
    } else {
        setTimeout("IB.blink()", 800);
    }
}

IB.hidden = function() {
    document.all.message.style.visibility = 'hidden';
    document.all.complete.style.visibility = 'hidden';
}

IB.submit = function() {
    IB.move();
    IB.save();
    document.getElementById('submit').submit();
}

socket.on('complete', function(data) {
    document.getElementById('message').innerHTML = '接続完了';
    IB.end = true;
    setTimeout("IB.hidden()", 2000);
});

socket.on('image', function(data) {
    var can = document.getElementById('myCanvas');
    var ctx = can.getContext('2d');
    var img = new Image();
    img.src = data.image;
    img.onload = function() {
        ctx.drawImage(img, 0, 0, 480, 320, 0, 0, 480, 320);
    }
});

IB.setColorStatus();
IB.setStatus();
IB.blink();