var app = require('express').createServer()
, io = require('socket.io').listen(app);

app.listen(8080);
drawList = [];

io.sockets.on('connection', function (socket) {
    
    if (drawList.length > 0) {
        for (var i in drawList) {
            socket.send(drawList[i]);
        }
    }
    
    socket.on('start', function(data){
        drawList.push(data);
        socket.broadcast.emit('start', data);
    });
    socket.on('draw', function(data){
        drawList.push(data);
        socket.broadcast.emit('draw', data);
    });
    socket.on('eraze', function(data){
        drawList = [];
        socket.broadcast.emit('draw', data);
    });
});

