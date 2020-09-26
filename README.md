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
        // folder base dimana file upload disimpan
        'base' => 'media',

        // url prefix yang ditambahkan sebelum nama file
        // untuk mendapatkan public url ke file tersebut.
        'url' => 'http://othersite.com/media/',

        // konfigurasi koneksi
        'connection' => [
            // ftp, sftp, ftps
            'type' => 'ftp',
            'server' => [
                'host' => 'ftp.host.ext',
                'port' => 21, // 22 for sftp
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