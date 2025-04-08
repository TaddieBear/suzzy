import { NFC } from 'nfc-pcsc';
import express from 'express';
import cors from 'cors';

const app = express();
const port = 3000;
const nfc = new NFC();

let latestUid = '';
let readers = {}; // Store active readers
let clients = []; // To track connected EventSource clients

app.use(cors());
app.use(express.json());

app.get('/nfc-status', (req, res) => {
    res.setHeader('Content-Type', 'text/event-stream');
    res.setHeader('Cache-Control', 'no-cache');
    res.setHeader('Connection', 'keep-alive');

    clients.push(res);
    sendScannerStatus(res);

    req.on('close', () => {
        clients = clients.filter(client => client !== res);
    });
});

function sendScannerStatus(client) {
    const statusMessage = JSON.stringify({ scannerStatus: Object.keys(readers).length > 0, uid: latestUid });
    client.write(`data: ${statusMessage}\n\n`);
}

function sendUid() {
    const message = JSON.stringify({ uid: latestUid });
    clients.forEach(client => {
        client.write(`data: ${message}\n\n`);
    });
}

nfc.on('reader', reader => {
    console.log(`✅ NFC Reader Connected: ${reader.reader.name}`);
    readers[reader.reader.name] = reader;
    sendScannerStatusToAll();

    reader.on('card', card => {
        console.log(`🎫 Card detected: UID = ${card.uid}`);
        latestUid = card.uid;
        sendUid();
    });

    reader.on('error', err => {
        console.error(`❌ Reader Error (${reader.reader.name}): ${err}`);
    });

    reader.on('end', () => {
        console.log(`⚠️ NFC Reader Disconnected: ${reader.reader.name}`);
        delete readers[reader.reader.name];
        latestUid = ''; // Clear UID only when scanner is disconnected
        sendScannerStatusToAll();
    });
});

function sendScannerStatusToAll() {
    const statusMessage = JSON.stringify({ scannerStatus: Object.keys(readers).length > 0, uid: latestUid });
    clients.forEach(client => {
        client.write(`data: ${statusMessage}\n\n`);
    });
}

nfc.on('error', err => {
    console.error(`❌ NFC error: ${err}`);
    console.log('🔄 Restarting NFC Service...');
});

app.listen(port, () => {
    console.log(`🚀 NFC Server running at http://localhost:${port}`);
});
