// SOS button behavior: get geolocation and POST to /sos
(function () {
    const btn = document.getElementById('sos-button');
    if (!btn) return;

    function showToast(msg) {
        try {
            alert(msg);
        } catch (e) {
            console.log(msg);
        }
    }

    btn.addEventListener('click', function () {
        btn.disabled = true;
        btn.classList.add('opacity-70');

        if (!navigator.geolocation) {
            showToast('Geolocation is not supported by your browser');
            btn.disabled = false;
            btn.classList.remove('opacity-70');
            return;
        }

        navigator.geolocation.getCurrentPosition(async function (pos) {
            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const res = await fetch('/sos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ latitude: lat, longitude: lon, message: '' })
                });

                if (res.ok) {
                    const data = await res.json();
                    showToast('SOS sent — help is on the way');
                } else {
                    const err = await res.json().catch(() => ({}));
                    showToast('Failed to send SOS: ' + (err.message || res.statusText));
                }
            } catch (e) {
                console.error(e);
                showToast('Network error while sending SOS');
            }

            btn.disabled = false;
            btn.classList.remove('opacity-70');
        }, function (err) {
            showToast('Unable to retrieve your location');
            btn.disabled = false;
            btn.classList.remove('opacity-70');
        }, { enableHighAccuracy: true, timeout: 15000 });
    });
})();
/**
 * SOS Button Handler
 * Handles geolocation and sends SOS alert to server
 */

document.addEventListener('DOMContentLoaded', function() {
    const sosBtn = document.getElementById('sos-btn');
    const loadingSpinner = document.getElementById('loading-spinner');
    const statusText = document.getElementById('status-text');
    const toast = document.getElementById('toast');
    const toastIcon = document.getElementById('toast-icon');
    const toastTitle = document.getElementById('toast-title');
    const toastMessage = document.getElementById('toast-message');

    let isProcessing = false;

    sosBtn.addEventListener('click', function() {
        if (isProcessing) return;

        isProcessing = true;
        sosBtn.disabled = true;
        loadingSpinner.classList.remove('hidden');
        statusText.textContent = 'Getting location...';
        statusText.classList.add('text-yellow-600', 'dark:text-yellow-400');

        // Get user's geolocation
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    const accuracy = position.coords.accuracy;

                    // Send SOS alert to server
                    sendSosAlert(latitude, longitude);
                },
                function(error) {
                    handleGeolocationError(error);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            showToast('error', 'Geolocation Not Supported', 'Your browser does not support geolocation. Please use a modern browser.');
            resetButton();
        }
    });

    function sendSosAlert(latitude, longitude) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/sos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                latitude: latitude,
                longitude: longitude,
                message: 'Emergency assistance required'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                statusText.textContent = 'Alert Sent ✓';
                statusText.classList.remove('text-yellow-600', 'dark:text-yellow-400');
                statusText.classList.add('text-green-600', 'dark:text-green-400');

                showToast('success', 'SOS Alert Sent!', 'Emergency services have been notified of your location.');

                // Play success sound if available
                playSuccessSound();

                // Add ripple effect
                createRipple(event);

                // Reset after 3 seconds
                setTimeout(resetButton, 3000);
            } else {
                showToast('error', 'Failed to Send Alert', data.message || 'Please try again.');
                resetButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', 'Network Error', 'Failed to send SOS alert. Check your internet connection.');
            resetButton();
        })
        .finally(() => {
            loadingSpinner.classList.add('hidden');
        });
    }

    function handleGeolocationError(error) {
        let errorMessage = '';

        switch(error.code) {
            case error.PERMISSION_DENIED:
                errorMessage = 'Location permission denied. Please enable location services and try again.';
                break;
            case error.POSITION_UNAVAILABLE:
                errorMessage = 'Location information is unavailable.';
                break;
            case error.TIMEOUT:
                errorMessage = 'Location request timed out. Please try again.';
                break;
            default:
                errorMessage = 'An unknown error occurred while getting your location.';
        }

        showToast('error', 'Location Error', errorMessage);
        resetButton();
    }

    function resetButton() {
        isProcessing = false;
        sosBtn.disabled = false;
        statusText.textContent = 'Ready';
        statusText.classList.remove('text-yellow-600', 'dark:text-yellow-400', 'text-green-600', 'dark:text-green-400');
        statusText.classList.add('text-green-600', 'dark:text-green-400');
    }

    function showToast(type, title, message) {
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };

        const colors = {
            success: 'text-green-600 dark:text-green-400',
            error: 'text-red-600 dark:text-red-400',
            warning: 'text-yellow-600 dark:text-yellow-400',
            info: 'text-blue-600 dark:text-blue-400'
        };

        toastIcon.textContent = icons[type];
        toastIcon.className = `text-2xl mr-3 ${colors[type]}`;
        toastTitle.textContent = title;
        toastMessage.textContent = message;

        toast.classList.remove('hidden');
        toast.classList.add('animate-pulse');

        // Auto-hide after 5 seconds
        setTimeout(() => {
            toast.classList.add('hidden');
            toast.classList.remove('animate-pulse');
        }, 5000);
    }

    function createRipple(event) {
        const container = document.getElementById('ripple-container');
        if (!container) return;

        const ripple = document.createElement('div');
        ripple.className = 'ripple';

        const size = 10;
        ripple.style.width = ripple.style.height = size + 'px';
        ripple.style.left = (event?.pageX - container.getBoundingClientRect().left - size / 2) + 'px';
        ripple.style.top = (event?.pageY - container.getBoundingClientRect().top - size / 2) + 'px';

        container.appendChild(ripple);

        setTimeout(() => ripple.remove(), 600);
    }

    function playSuccessSound() {
        // Create a simple beep using Web Audio API
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const now = audioContext.currentTime;
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.value = 800;
            oscillator.type = 'sine';

            gainNode.gain.setValueAtTime(0.3, now);
            gainNode.gain.exponentialRampToValueAtTime(0.01, now + 0.5);

            oscillator.start(now);
            oscillator.stop(now + 0.5);
        } catch (e) {
            console.log('Audio context not available');
        }
    }
});
