var app = require('express').createServer()
, io = require('socket.io').listen(app);

app.listen(8080);

io.sockets.on('connection', function (socket) {
    socket.on('start', function(data){
        socket.broadcast.emit('start', data);
    });
    socket.on('draw', function(data){
        socket.broadcast.emit('draw', data);
    });
});

