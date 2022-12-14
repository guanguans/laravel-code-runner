import axios from 'axios';
import '@ungap/custom-elements';
import 'highlighted-code';
import { Toast } from 'bootstrap';

window.runCode = function (type) {
  const code = type === 'selected' ? window.getSelection().toString() : document.getElementById('code').value;
  if (!code) {
    const inputCode = document.getElementsByTagName('lang-input-code').item(0).innerText;
    const selectedCode = document.getElementsByTagName('lang-selected-code').item(0).innerText;

    return alert(type === 'selected' ? selectedCode : inputCode);
  }

  const url = document.getElementsByTagName('url').item(0).innerText;
  const token = document.head.querySelector('meta[name="csrf-token"]').content;

  axios({
    url,
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': token
    },
    data: {
      code
    }
  })
    .then(function (response) {
      document.getElementById('result').innerHTML = response.data.result;
    })
    .catch(function (error) {
      const message = error.response.data.hasOwnProperty.call('message')
        ? error.response.data.message ?? error.code
        : error.message;

      alert(message);
    })
    .then(function () {});
};

window.clearCode = function () {
  document.getElementById('code').value = '';

  const result = document.getElementsByTagName('lang-result').item(0).innerText;
  document.getElementById('result').innerHTML = `<span class="text-muted">${result}</span>`;
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
