const amqp = require("amqplib/callback_api");

const host = "localhost:5672";
const credential = "nestjsUser:nestjsPassword";
const server = `amqp://${credential}@${host}`;

amqp.connect(server, (err, conn) => {
  conn.createChannel((err, ch) => {
    const queue = "nestjs_queue";
    ch.assertQueue(queue, { durable: false });
    const data = JSON.stringify({
      pattern: "hello",
      data: "hello rabbitMq Nodejs",
    });
    ch.sendToQueue(queue, new Buffer(data));
    console.log(` [x] Sent '${data}'`);
    setTimeout(() => {
      conn.close();
      process.exit(0);
    }, 500);
  });
});
