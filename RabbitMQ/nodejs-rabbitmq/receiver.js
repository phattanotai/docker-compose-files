const amqp = require("amqplib/callback_api");

const host = "localhost:5672";
const credential = "nestjsUser:nestjsPassword";
const server = `amqp://${credential}@${host}`;
console.log(server);
amqp.connect(server, (err, conn) => {
  if (err) {
    console.log(err);
  } else {
    conn.createChannel((err, ch) => {
      const queue = "nestjs_queue";
      ch.assertQueue(queue, { durable: false });
      console.log(
        " [*] Waiting for messages in %s. To exit press CTRL+C",
        queue
      );
      ch.consume(
        queue,
        function (msg) {
          console.log(" [x] Received %s", msg.content.toString());
        },
        { noAck: true }
      );
    });
  }
});
