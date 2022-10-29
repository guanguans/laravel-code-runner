<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Code Runner</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
          integrity="sha256-IUOUHAPazai08QFs7W4MbzTlwEWFo7z/4zw8YmxEiko=" crossorigin="anonymous">
    <style>
        textarea {
            resize: none;
        }

        .code-show {
            height: 500px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="position-fixed top-0 end-0 p-3">
        <div id="toast" class="toast align-items-center text-white bg-danger border-0" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Please input code.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-6">
            <label class="form-label" for="code"></label>
            <textarea id="code" class="form-control code-show" placeholder="Code" is="highlighted-code" language="php"
                      tab-size="4"></textarea>
        </div>
        <div class="col-6">
            <label class="form-label" for="result"></label>
            <div class="form-control overflow-auto code-show">
                <pre id="result"><span class="text-muted">Result</span></pre>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-4">
            <button type="submit" class="form-control btn btn-success" onclick="runCode('all')">运行全部</button>
        </div>
        <div class="col-4">
            <button type="submit" class="form-control btn btn-success" onclick="runCode('selected')">运行选中</button>
        </div>
        <div class="col-4">
            <button type="submit" class="form-control btn btn-success" onclick="clearCode()">清除代码</button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.3/dist/axios.min.js"
        integrity="sha256-uiO//DbvswiStsyiG3bbtDcoUqQIGKvRzR6fffIbvs0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha256-xLI5SjD6DkojxrMIVBNT4ghypv12Xtj7cOa0AgKd6wA=" crossorigin="anonymous"></script>
<script>
  function runCode(type) {
    var code = type === "selected" ? window.getSelection().toString() : $("#code").val();

    if (!code) {
      var toastElement = document.getElementById('toast')
      var toast = new bootstrap.Toast(toastElement);
      type === "selected" ? $('.toast-body').text('Please select code.') : null;

      return toast.show();
    }

    var setting = {
      "url": "{{ $url }}",
      "method": "POST",
      "data": {
        "code": code
      },
    };

    $.ajax(setting).done(function (response) {
      $("#result").html(response.result)
    });
  }

  function clearCode() {
    $("#code").val("");

    $("#result").html('<span class="text-muted">Result</span>');
  }
</script>
<script type="module">
  (async ({chrome, netscape}) => {
    // add Safari polyfill if needed
    if (!chrome && !netscape) {
      await import("https://unpkg.com/@ungap/custom-elements");
    }

    const {default: HighlightedCode} = await import("https://unpkg.com/highlighted-code");

    HighlightedCode.useTheme("{{ $theme }}");
  })(self);
</script>
</body>
</html>