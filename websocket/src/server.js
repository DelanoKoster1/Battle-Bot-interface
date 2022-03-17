const { createServer } = require("http");
const express = require("express");
const WebSocket = require("ws");
const { isIPv4, Socket } = require("net");


const app = express();

app.use(express.json({ extended: false }));

app.use("/client/chat", require("./routes/client/chat"));
app.use("/robot/robot", require("./routes/robot/robot"));

const port = 3001;
const server = createServer(app);
server.listen(port, () => console.info(`Server running on port: ${port}`));
