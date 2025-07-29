# SIMAK
## Introduction
Assalamu'alikum.
Project pembuatan sistem management akademik
## Features
- Authentication menggunakan Laravel UI Bootstrap :
    
    * Login
    * CAPTCHA Login.

## Requered :
- PHP ^8.0
- Composer version 2.3.7
- Postgresql ^18.0

## Package PHP :
- "barryvdh/laravel-debugbar": "^3.7"
    > Note: Untuk DebugBar Info.
- "intervention/image": "^2.7",
    > Note: Untuk Manajemen Image (Upload).
- "maatwebsite/excel": "^3.1",
    > Note: Untuk Membuat Report dalam bentuk Excel.
- "mews/captcha": "3.2.7",
    > Note: Untuk captcha ketika login.
- "pragmarx/google2fa-laravel": "^2.0",
    > Note: Untuk Google 2FA.  
- "simplesoftwareio/simple-qrcode": "^4.2",
    > Note: Untuk menampilkan QRCode Google 2FA.  
- "spatie/laravel-permission": "^6.9",
    > Note: Untuk Manajemen Authorization User.
- "yajra/laravel-datatables": "^11.0",
    > Note: Untuk Manajemen Table Display.
- "yaza/laravel-repository-service": "^5.0.1"
    > Note: Untuk Manajemen Repository design pattern.

## Setup :
- Clone Project dari Github :
```shell
https://github.com/devanlustig/simaks.git
- Buat .env dari file .env.example
- Jalankan perintah :
```shell
composer install
```
- Jalankan perintah :
```shell
php artisan key:generate
```
- Buat Database dengan nama simak
- Lalu eksport database yang berada di folder database dengan nama simak.backup
- Konfigurasi Database.

- Jalankan perintah :
```shell
php artisan serve
```
## Note :
login admin bisa menggunakan user : admin password : P@ssword123
login mahasiswa bisa menggunakan user : dede password : P@ssword123