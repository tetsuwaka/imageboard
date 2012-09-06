var app = require('express').createServer()
, io = require('socket.io').listen(app);

app.listen(8080);
drawList = [];

io.sockets.on('connection', function (socket) {

    socket.emit('complete', 'complete');

    if (drawList.length > 0) {
        for (var i in drawList) {
            socket.emit('draw', drawList[i]);
        }
    }

    socket.on('draw', function(data){
        drawList.push(data);
        socket.broadcast.emit('draw', data);
        if (data.act === 'eraze' || data.act === 'move') {
            drawList = [];
        }
    });
});

