<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Code Runner</title>
    <link rel="alternate icon" class="js-site-favicon" type="image/png"
          href="{{ asset(mix('favicon/favicon@32.png', 'vendor/code-runner')) }}">
    <link rel="icon" class="js-site-favicon" type="image/svg+xml"
          href="{{ asset(mix('favicon/favicon@32.svg', 'vendor/code-runner')) }}">
    <link href='{{ asset(mix('app.css', 'vendor/code-runner')) }}' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="container-fluid">
    <div class="position-fixed top-0 end-0 p-3">
        <div id="toast" class="toast align-items-center text-white bg-danger border-0" role="alert"
             aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ __('Please input code.') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="{{ __('close') }}"></button>
            </div>
        </div>
    </div>
    <div class="row g-0">
        <div class="col-6">
            <label class="form-label" for="code"></label>
            <textarea id="code" class="form-control code-show" placeholder="{{ __('code') }}" is="highlighted-code"
                      language="php"
                      tab-size="4"></textarea>
        </div>
        <div class="col-6">
            <label class="form-label" for="result"></label>
            <div class="form-control overflow-auto code-show">
                <pre id="result"><span class="text-muted">{{ __('result') }}</span></pre>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-4">
            <button type="submit" class="form-control btn btn-success" onclick="runCode('all')">{{ __('run') }}</button>
        </div>
        <div class="col-4">
            <button type="submit" class="form-control btn btn-success"
                    onclick="runCode('selected')">{{ __('run selected') }}</button>
        </div>
        <div class="col-4">
            <button type="submit" class="form-control btn btn-success" onclick="clearCode()">{{ __('clear') }}</button>
        </div>
    </div>
</div>
<lang-result class="d-none">{{ __('result') }}</lang-result>
<lang-input-code class="d-none">{{ __('Please input code.') }}</lang-input-code>
<lang-selected-code class="d-none">{{ __('Please select code.') }}</lang-selected-code>
<url class="d-none">{{ $url }}</url>
<theme class="d-none">{{ $theme }}</theme>
<script type="text/javascript" src="{{ asset(mix('app.js', 'vendor/code-runner')) }}"></script>
</body>
</html>