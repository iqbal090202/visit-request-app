<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Visit Request App

Aplikasi untuk pengajuan kunjungan tamu.

## Requirements
Download & Install [php](https://windows.php.net/downloads/releases/php-8.3.4-nts-Win32-vs16-x64.zip)

Download & Install [node](https://nodejs.org/en/download)

Download & Install [Git](https://windows.php.net/downloads/releases/php-8.3.4-nts-Win32-vs16-x64.zip)

*optional

Download & Install [Visual Studio Code](https://code.visualstudio.com/download)

## Clone Project

Langkah pertama masuk ke directory aplikasi yang akan disimpan

Selanjutnya buka command prompt

Lalu clone project menggunakan git

```bash
git clone https://github.com/iqbal090202/visit-request-app.git
```

Selanjutnya masukkan perintah 

```bash
cd visit-request-app
```

## Usage

Didalam directory project masukkan perintah

```bash
composer install
```
Tunggu sampai selesai.

Selanjutnya masukkan perintah

```bash
npm install
```
Tunggu sampai selesai.

Selanjutnya masukkan perintah

```bash
copy .env.example .env
```

Selanjutnya masukkan perintah

```bash
php artisan key:generate
```

Dan terakhir masukkan perintah

```bash
php artisan migrate --seed
```

## Run Project

Masukkan perintah berikut

```bash
php run dev
```

Ketik Ctrl+Shift+2 pada command prompt untuk membuka tab baru, lalu masukkan perintah berikut

```bash
npm artisan serve
```

Lalu ketikkan http://127.0.0.1:8000 pada browser atau ctrl+click di tulisan http://127.0.0.1:8000 pada command prompt

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](https://choosealicense.com/licenses/mit/)
