var app = require('express').createServer()
, io = require('socket.io').listen(app);

app.listen(8080);
drawList = [];

io.sockets.on('connection', function (socket) {
    
    if (drawList.length > 0) {
        for (var i in drawList) {
            socket.emit('draw', drawList[i]);
        }
    }
    
    socket.on('draw', function(data){
        if (data.act === 'eraze') {
            drawList = [];
        }
        drawList.push(data);
        socket.broadcast.emit('draw', data);
        console.log(data);
    });
});

