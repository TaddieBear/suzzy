document.addEventListener('DOMContentLoaded', function () {
    const rfidInput = document.getElementById('rfid_uid');
    const facultyForm = document.getElementById('faculty-registration-form');
    const scannerStatus = document.getElementById('scanner-status') || createScannerStatusElement();

    rfidInput.value = ''; // Clear on page load

    const eventSource = new EventSource('http://localhost:3000/nfc-status');

    eventSource.onopen = function () {
        console.log('✅ Connected to NFC server');
    };

    eventSource.onmessage = function (event) {
        const data = JSON.parse(event.data);
        console.log('✅ Received scanner status:', data.scannerStatus);
        console.log('✅ UID data:', data.uid);

        if (data.uid) {
            console.log(`✅ UID received: ${data.uid}`);
            rfidInput.value = data.uid;
            scannerStatus.classList.add('d-none');
        } else {
            rfidInput.value = '';
        }

        updateScannerStatus(data.scannerStatus);
    };

    eventSource.onerror = function () {
        console.error('❌ Error connecting to NFC server.');
        updateScannerStatus(false);
    };

    function createScannerStatusElement() {
        const status = document.createElement('div');
        status.id = 'scanner-status';
        rfidInput.parentNode.appendChild(status);
        return status;
    }

    function updateScannerStatus(isConnected) {
        if (isConnected) {
            scannerStatus.className = 'alert alert-success mt-2';
            scannerStatus.innerText = '✅ NFC scanner detected!';
            scannerStatus.style.display = 'block';
            scannerStatus.style.opacity = '1';

            // Fade out after 2 seconds
            setTimeout(() => {
                scannerStatus.style.opacity = '0';
                setTimeout(() => scannerStatus.style.display = 'none', 500);
            }, 2000);
        } else if (!rfidInput.value) {
            scannerStatus.className = 'alert alert-warning mt-2';
            scannerStatus.innerText = '⚠️ Warning: NFC scanner not detected. Please plug it in.';
            scannerStatus.style.display = 'block';
            scannerStatus.style.opacity = '1';
        }
    }

    facultyForm?.addEventListener('submit', function () {
        setTimeout(() => {
            rfidInput.value = ''; // Clear ONLY after form submission
        }, 500);
    });
});
