# lib-upload-ftp

Adalah module yang memungkinkan aplikasi menyimpan file upload ke ftp server.
Untuk dukungan koneksi dengan ssh ( sftp ), pastikan meng-install module
`lib-ftp-ssh`.

## Instalasi

Jalankan perintah di bawah di folder aplikasi:

```
mim app install lib-upload-ftp
```

## Konfigurasi

Tambahkan konfigurasi seperti di bawah pada konfigurasi aplikasi:

```php
return [
    'libUploadFtp' => [
        // file base dimana file upload disimpan
        'base' => 'media',

        // url prefix yang ditambahkan sebelum nama file
        // untuk mendapatkan public url ke file tersebut.
        'url' => 'http://othersite.com/',

        // konfigurasi koneksi
        'connection' => [
            // ftp, sftp, ftps
            'type' => 'ftp',
            'server' => [
                'host' => 'ftp.host.ext',
                'port' => 21,
                'timeout' => 90
            ],
            'user' => [
                'name' => 'user',
                'password' => '/secret/'
            ]
        ]
    ]
];
```

Konfigurasi seperti di atas akan meng-upload file user ke folder `media` di target server,
dan ketika front-end membutuhkan public url, maka hostname dari properti `url` akan digunakan.

Jika module ini terinstall, semua file upload akan selalu terupload ke ftp. Untuk mematikan fungsi
ini, tambahkan konfigurasi seperti di bawah:

```php
return [
    'libUpload' => [
        'keeper' => [
            'handlers' => [
                'ftp' => [
                    'use' => false
                ]
            ]
        ]
    ]
];
```

Konfigurasi seperti ini akan membuat lib-upload melewati module ini ketika user meng-upload file.

Untuk menggunakan library ini sebagai handler utama di front-end, tambahkan juga konfigurasi seperti
di bawah:

```php
    'libMedia' => [
        'handler' => 'LibUploadFtp\\Handler\\Ftp'
    ]
```

Dengan konfigurasi seperti ini, maka setiap kali file akan digunakan di front-end, maka file dari ftp
akan digunakan.

## Server

Module ini tidak menghandle resize dan compresi file, server ftp harus menyediakan file-file yang
dibutuhkan pada saat request terjadi dengan spesifikasi sebagai berikut:

1. `dir/dir/dir/filename.ext` Mengembalikan original file.
1. `dir/dir/dir/filename.ext.webp` Mengembalikan file gambar dengan format webp.
1. `dir/dir/dir/filename_{width}x{height}.ext` Mengembalikan file gambar dengan format original
dengan ukuran gambar lebar `{width}` dan tinggi `{height}`.
1. `dir/dir/dir/filename_{width}x{height}.ext.webp` Mengembalikan file gambar dengan format webp
dengan ukuran gambar lebar `{width}` dan tinggi `{height}`.

Untuk response dengan original format, sangat disarankan mengembalikan dengan compresi `brotli` jika
memungkinkan dan `gzip` sebagai alternative.