var MAX_STACK = 50; // 最大保存ストロークスタック数

// canvasを作成
var Canvas = require('canvas')
  , canvas = new Canvas(480, 320)
  , ctx = canvas.getContext('2d');

// socket.ioを用いてwebscoketサーバ作成
var app = require('express').createServer()
, io = require('socket.io').listen(app);

app.listen(8080);

var strokeStack = [];            // ストロークスタック
var imageStack = [];             // イメージスタック
var strokeAllStack = [];         // 全てのストロークスタック
var hozon = {oldX: 0, oldY: 0};  // ストローク開始位置の保存


function draw(data) {
    ctx.strokeStyle = 'rgba(' + data.color + ')';
    ctx.lineWidth = data.lineWidth;
    ctx.lineCap = "round";
    ctx.beginPath();
    ctx.moveTo(hozon.oldX, hozon.oldY);
    ctx.lineTo(data.x, data.y);
    ctx.stroke();
    ctx.closePath();
    hozon.oldX = data.x;
    hozon.oldY = data.y;
}

function drawStart(data) {
    hozon.oldX = data.x;
    hozon.oldY = data.y;
}


io.sockets.on('connection', function (socket) {

    // 接続完了を知らせる
    socket.emit('complete', 'complete');

    // 接続時に、ストロークスタックを送る
    if (strokeStack.length > 0 || imageStack.length > 0) {
        if (imageStack.length > 0) {
            socket.emit('image', {image: imageStack[imageStack.length - 1]});
        }
        for (var i in strokeStack) {
            socket.emit('draw', strokeStack[i]);
        }
    }

    // データが送られてきたときの処理
    socket.on('draw', function(data){
        strokeStack.push(data);
        strokeAllStack.push(data);
        socket.broadcast.emit('draw', data);

        if (data.act === 'eraze' || data.act === 'move') {
            strokeStack = [];
            imageStack = [];
        } else if (data.act === 'draw') {
            draw(data);
        } else if (data.act === 'start') {
            drawStart(data);
        }

        if (strokeStack.length === MAX_STACK) {
            imageStack.push(canvas.toDataURL());
            strokeStack = [];
        }
    });
});