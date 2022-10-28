# laravel-code-runner

![](docs/usage.png)

[ENGLISH](README.md) | [简体中文](README-zh_CN.md)

> Run the PHP code in the browser. - 在浏览器中运行 PHP 代码。

[![tests](https://github.com/guanguans/laravel-code-runner/workflows/tests/badge.svg)](https://github.com/guanguans/laravel-code-runner/actions)
[![check & fix styling](https://github.com/guanguans/laravel-code-runner/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/laravel-code-runner/actions)
[![codecov](https://codecov.io/gh/guanguans/laravel-code-runner/branch/main/graph/badge.svg?token=URGFAWS6S4)](https://codecov.io/gh/guanguans/laravel-code-runner)
[![Latest Stable Version](https://poser.pugx.org/guanguans/laravel-code-runner/v)](//packagist.org/packages/guanguans/laravel-code-runner)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/guanguans/laravel-code-runner)
[![Total Downloads](https://poser.pugx.org/guanguans/laravel-code-runner/downloads)](//packagist.org/packages/guanguans/laravel-code-runner)
[![License](https://poser.pugx.org/guanguans/laravel-code-runner/license)](//packagist.org/packages/guanguans/laravel-code-runner)

## 环境要求

* PHP >= 7.4
* Laravel >= 7.0

## 安装

通过 Composer 安装该软件包。

```bash
$ composer require guanguans/laravel-code-runner --prefer-dist -vvv
```

运行此命令来发布资源文件。

```bash
$ php artisan code-runner:install
```

发布配置文件(可选的)。

```bash
$ php artisan vendor:publish --provider="Guanguans\LaravelCodeRunner\CodeRunnerServiceProvider" --tag="code-runner-config"
```

## 使用

默认情况下，此包仅在本地环境中运行。

访问 `/code-runner` 查看页面。

### Authorization

如果您想在另一个环境中运行它（我们不建议这样做），您必须执行两个步骤。

1. 您必须将 `code-runner` 配置文件中的 `enabled` 值设置为 `true`。

2. 您必须注册一个 `view-code-runner` 的 `ability`。最好在 Laravel 附带的 `AuthServiceProvider` 中。

```php
use Illuminate\Contracts\Auth\Authenticatable;

public function boot()
{
    $this->registerPolicies();

    Gate::define('view-code-runner', function (?Authenticatable $user = null) {
        // 如果允许访问 web tinker，则返回 true。这是一个例子：
        return $user && in_array($user->email, [
            'admin@example.com',
        ]);
    });
}
```

## 测试

```bash
$ composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

## 贡献者

* [guanguans](https://github.com/guanguans)
* [所有贡献者](../../contributors)

## 协议

MIT 许可证（MIT）。有关更多信息，请参见[协议文件](LICENSE)。
