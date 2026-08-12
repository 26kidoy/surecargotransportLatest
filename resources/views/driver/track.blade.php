<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SureCargo Driver GPS</title>
    <link rel="icon" type="image/jpeg" href="/assets/white.jpg">
    <style nonce="{{ $csp_nonce }}">
        body { font-family: Arial; text-align: center; padding: 20px; background: #111; color: white; }
        .card { background: #1e2a3a; border-radius: 32px; padding: 24px; margin-top: 20px; }
        .coord { font-family: monospace; background: #0f1724; padding: 8px; border-radius: 16px; margin: 10px 0; }
        button { background: #3b82f6; border: none; color: white; padding: 12px 24px; border-radius: 40px; margin-top: 20px; width: 80%; font-size: 1rem; }
        .error { background: #dc2626; padding: 12px; border-radius: 24px; margin-top: 20px; }
        .success { background: #10b981; padding: 12px; border-radius: 24px; }
        .warning { background: #f59e0b; padding: 12px; border-radius: 24px; }
        #statusText { font-weight: bold; margin-top: 10px; }
        .instruction { font-size: 14px; background: #2d3748; padding: 12px; border-radius: 16px; margin-top: 20px; text-align: left; }
    </style>
</head>
<body>
    <h2>🚛 SureCargo Driver</h2>
    <div class="card">
        <div id="trackingStatus" class="success">📍 Waiting for location permission...</div>
        <div class="coord">
            Latitude: <span id="lat">—</span><br>
            Longitude: <span id="lng">—</span>
        </div>
        <div>Accuracy: <span id="accuracy">—</span> m</div>
        <div>Last sent: <span id="lastSent">—</span></div>
        <div>Server response: <span id="serverResponse">—</span></div>
        <button id="requestBtn">🔘 Allow Location Access</button>
        <button id="toggleBtn" style="display:none;">⏸️ Pause Tracking</button>
        <div id="statusText"></div>
        <div id="instructionBox" class="instruction" style="display:none;"></div>
    </div>

   <script nonce="{{ $csp_nonce }}">
        let watchId = null;
        let isTracking = false;
        let lastSend = 0;
        const INTERVAL = 3000;

        async function sendLocation(lat, lng) {
            try {
                const response = await fetch('/tracking/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ lat, lng })
                });
                const result = await response.json();
                if (response.ok) {
                    document.getElementById('lastSent').innerText = new Date().toLocaleTimeString();
                    document.getElementById('serverResponse').innerHTML = '✅ ' + JSON.stringify(result);
                } else {
                    document.getElementById('serverResponse').innerHTML = '❌ HTTP ' + response.status;
                }
            } catch (err) {
                console.error('Send error', err);
                document.getElementById('serverResponse').innerHTML = '❌ Network error: ' + err.message;
            }
        }

        function onLocationSuccess(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            const acc = position.coords.accuracy;
            document.getElementById('lat').innerText = lat.toFixed(6);
            document.getElementById('lng').innerText = lng.toFixed(6);
            document.getElementById('accuracy').innerText = Math.round(acc);
            document.getElementById('statusText').innerHTML = '✅ GPS active – sending updates';
            document.getElementById('instructionBox').style.display = 'none';

            const now = Date.now();
            if (isTracking && (now - lastSend) >= INTERVAL) {
                sendLocation(lat, lng);
                lastSend = now;
            }
        }

        function onLocationError(error) {
            let msg = '';
            let instructions = '';
            switch(error.code) {
                case 1:
                    msg = 'Permission denied.';
                    instructions = '🔧 Tap the lock icon in address bar → Permissions → Location → Allow.';
                    break;
                case 2:
                    msg = 'Position unavailable. Check GPS signal.';
                    instructions = 'Make sure you are outdoors or near a window.';
                    break;
                case 3:
                    msg = 'GPS timeout. Try moving to an open area.';
                    instructions = 'Restart the browser and try again.';
                    break;
                default:
                    msg = error.message;
            }
            document.getElementById('trackingStatus').innerHTML = '❌ ' + msg;
            document.getElementById('trackingStatus').className = 'error';
            document.getElementById('statusText').innerHTML = msg;
            document.getElementById('instructionBox').innerHTML = instructions.replace(/\n/g, '<br>');
            document.getElementById('instructionBox').style.display = 'block';

            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }
            isTracking = false;
            document.getElementById('toggleBtn').style.display = 'none';
            document.getElementById('requestBtn').style.display = 'block';
        }

        function startTracking() {
            if (watchId) return;
            if (!navigator.geolocation) {
                alert('Geolocation not supported');
                return;
            }
            watchId = navigator.geolocation.watchPosition(onLocationSuccess, onLocationError, {
                enableHighAccuracy: true,
                maximumAge: 0,
                timeout: 15000
            });
            isTracking = true;
            document.getElementById('trackingStatus').innerHTML = '📍 Tracking ON';
            document.getElementById('trackingStatus').className = 'success';
            document.getElementById('toggleBtn').style.display = 'block';
            document.getElementById('requestBtn').style.display = 'none';
            document.getElementById('toggleBtn').innerHTML = '⏸️ Pause Tracking';
        }

        function stopTracking() {
            if (watchId) {
                navigator.geolocation.clearWatch(watchId);
                watchId = null;
            }
            isTracking = false;
            document.getElementById('trackingStatus').innerHTML = '⏸️ Tracking PAUSED';
            document.getElementById('trackingStatus').className = 'success';
            document.getElementById('toggleBtn').innerHTML = '▶️ Resume Tracking';
        }

        document.getElementById('requestBtn').addEventListener('click', startTracking);
        document.getElementById('toggleBtn').addEventListener('click', () => {
            if (isTracking) stopTracking();
            else startTracking();
        });

        if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
            document.getElementById('instructionBox').innerHTML = '⚠️ This page is served over HTTP. Location may be blocked. Use Firefox or manually allow location in Chrome site settings.';
            document.getElementById('instructionBox').style.display = 'block';
        }
    </script>
</body>
</html>
