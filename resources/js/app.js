import axios from 'axios';
import $ from 'jquery';
import 'bootstrap';
import '@ungap/custom-elements';
import 'highlighted-code';

const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

window.runCode = function (type) {
    var code = type === 'selected' ? window.getSelection().toString() : $('#code').val();
    if (!code) {
        return alert('selected' ? 'Please select code.' : 'Please input code.');
    }

    const url = $('url').text();
    var setting = {
        url: url,
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            code: code
        }
    };

    $.ajax(setting)
        .done(function (response, status, xhr) {
            $('#result').html(response.result);
        })
        .fail(function (xhr, status, err) {
            var message = xhr.responseJSON.hasOwnProperty('message')
                ? xhr.responseJSON.message ?? err
                : err;

            alert(message);
        })
        .always(function (responseOrXhr, status, xhrOrErr) {});
};

window.clearCode = function () {
    $('#code').val('');

    $('#result').html('<span class="text-muted">Result</span>');
};

window.alert = function (message) {
    $('.toast-body').text(message);

    var toastElement = document.getElementById('toast');
    var toast = new bootstrap.Toast(toastElement);
    toast.show();
};

(async ({ chrome, netscape }) => {
    // add Safari polyfill if needed
    if (!chrome && !netscape) {
        await import('@ungap/custom-elements');
    }

    const { default: HighlightedCode } = await import('highlighted-code');
    const theme = $('theme').text();
    HighlightedCode.useTheme(theme);
})(self);
