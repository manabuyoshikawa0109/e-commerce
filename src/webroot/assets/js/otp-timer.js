document.addEventListener('DOMContentLoaded', function () {
    (function () {
        'use strict';

        var resendEl = document.getElementById("resendOTP");
        if (!resendEl) return;

        var count = 60;
        var counter = setInterval(timer, 1000);

        function timer() {
            count--;

            if (count <= 0) {
                clearInterval(counter);
                resendEl.innerHTML =
                    '<a class="resendOTP" href="javascript:void(0)">Resend OTP</a>';
            } else {
                resendEl.textContent = 'Wait ' + count + ' secs';
            }
        }

        document.querySelectorAll('.single-otp-input').forEach((input, index, inputs) => {
            input.addEventListener('keyup', () => {
                if (input.value.length === input.maxLength) {
                    inputs[index + 1] ? inputs[index + 1].focus() : input.blur();
                }
            });
        });

    })();
});