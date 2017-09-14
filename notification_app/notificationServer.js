/**
 * Created by arash on 8/29/16.
 */

var fs = require("fs");

var privateKey = fs.readFileSync('/usr/local/apache/conf/ssl.key/hinza-automation.key').toString();
var certificate = fs.readFileSync('/usr/local/apache/conf/ssl.crt/hinza-automation.crt').toString();

var app = require('express')();
var server = require('https').createServer({
	key : privateKey ,
	cert : certificate
},app);

var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);

var clientSockets = {};

io.on('connection', function (socket) {

    var redisClient = redis.createClient();
    redisClient.subscribe('notification');

    redisClient.on("message", function (channel, message) {
        console.log(message);
        message = JSON.parse(message);
        message.user_id = ""+message.user_id;
        if(Object.keys(clientSockets).indexOf(message.user_id) != -1){
            Object.keys(clientSockets[message.user_id]).forEach(function (token) {
                (clientSockets[message.user_id][token]).emit(channel, message);
            });
        }
    });

    socket.on('identify', function (data) {
        if (!clientSockets[data.id]) {
            clientSockets[data.id] = [];
        }
        clientSockets[data.id][data.token] = socket;
    });

    socket.on('disconnect', function () {
        redisClient.quit();
    });

    socket.on('logout', function (data) {
        if (clientSockets[data.id][data.token])
            delete clientSockets[data.id][data.token];
    })
});
