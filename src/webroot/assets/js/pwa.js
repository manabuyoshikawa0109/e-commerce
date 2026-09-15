document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* =========================
       SERVICE WORKER REGISTER
    ========================== */
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker
                .register('service-worker.js')
                .catch(function (err) {
                    console.error('Service Worker registration failed:', err);
                });
        });
    }

    /* =========================
       PWA INSTALL HANDLER
    ========================== */

    let deferredPrompt = null;
    const installButton = document.getElementById('installSuha');

    if (!installButton) return;

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredPrompt = e;
        updateInstallButton();
    });

    function isAppInstalled() {
        return (
            window.matchMedia('(display-mode: standalone)').matches ||
            window.navigator.standalone === true
        );
    }

    function updateInstallButton() {
        installButton.textContent = isAppInstalled() ?
            'Installed' :
            'Install Now';
    }

    installButton.addEventListener('click', async function () {
        if (isAppInstalled()) return;

        if (!deferredPrompt) return;

        deferredPrompt.prompt();

        const choice = await deferredPrompt.userChoice;

        if (choice.outcome === 'accepted') {
            installButton.textContent = 'Installed';
        } else {
            installButton.textContent = 'Install Now';
        }

        deferredPrompt = null;
    });

    updateInstallButton();

    window
        .matchMedia('(display-mode: standalone)')
        .addEventListener('change', updateInstallButton);
});