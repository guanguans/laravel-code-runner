import axios from 'axios';
import '@ungap/custom-elements';
import 'highlighted-code';
import { Toast } from 'bootstrap';

window.runCode = function (type) {
    var code =
        type === 'selected'
            ? window.getSelection().toString()
            : document.getElementById('code').value;
    if (!code) {
        return alert('selected' ? 'Please select code.' : 'Please input code.');
    }

    const url = document.getElementsByTagName('url').item(0).innerText;
    const token = document.head.querySelector(
        'meta[name="csrf-token"]'
    ).content;

    axios({
        url: url,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': token
        },
        data: {
            code: code
        }
    })
        .then(function (response) {
            document.getElementById('result').innerHTML = response.data.result;
        })
        .catch(function (error) {
            const message = error.response.data.hasOwnProperty('message')
                ? error.response.data.message ?? error.code
                : error.message;

            alert(message);
        })
        .then(function () {});
};

window.clearCode = function () {
    document.getElementById('code').value = '';
    document.getElementById('result').innerHTML =
        '<span class="text-muted">Result</span>';
};

window.alert = function (message) {
    document.getElementsByClassName('toast-body').item(0).innerHTML = message;

    const toastElement = document.getElementById('toast');
    const toast = new Toast(toastElement);
    toast.show();
};

(async ({ chrome, netscape }) => {
    // add Safari polyfill if needed
    if (!chrome && !netscape) {
        await import('@ungap/custom-elements');
    }

    const { default: HighlightedCode } = await import('highlighted-code');
    const theme = document.getElementsByTagName('theme').item(0).innerText;

    HighlightedCode.useTheme(theme);
})(self);
