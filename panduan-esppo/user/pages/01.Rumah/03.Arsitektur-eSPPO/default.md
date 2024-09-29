---
title: Desain, Arsitektur Infrastruktur eSPPO
menu: Desain dan Arsitektur
---

## Desain eSPPO
**eSPPO (Sistem Penyelenggaraan Pemilihan OSIS Elektronik)** merupakan aplikasi berbasis web yang dirancang untuk menyelenggarakan pemilihan OSIS secara elektronik. Sebagai aplikasi berbasis web, eSPPO dapat diakses dari berbagai perangkat yang terhubung ke internet maupun jaringan lokal (LAN), sehingga fleksibel dalam penggunaannya, baik di lingkungan sekolah ataupun dalam skala yang lebih luas.

### Teknologi dan Arsitektur Sistem
- **Pemrograman Back-End**: eSPPO diprogram menggunakan bahasa PHP murni tanpa framework tambahan seperti CodeIgniter atau Laravel. Hal ini memungkinkan aplikasi memiliki tingkat fleksibilitas dan kustomisasi yang tinggi, serta memberikan kebebasan pengembangan lebih lanjut. Meski demikian, arsitektur eSPPO juga dapat dikembangkan agar kompatibel dengan framework PHP modern, jika dibutuhkan di masa depan.

- **Framework UI Front-End**: Pada bagian antarmuka pengguna (UI), eSPPO menggunakan kombinasi **Bootstrap 5** dan **AdminLTE 3.2** untuk memberikan tampilan yang modern, responsif, dan mudah digunakan. **Bootstrap 5** menawarkan fitur-fitur desain berbasis grid dan komponen yang memudahkan pengembangan front-end, sementara **AdminLTE 3.2** menyediakan template dashboard yang mendukung pengelolaan data dengan antarmuka yang ramah pengguna.

- **Jaringan dan Koneksi**: Salah satu keunggulan eSPPO adalah fleksibilitasnya dalam pengaturan koneksi. Aplikasi ini dapat beroperasi di jaringan lokal (LAN) atau di internet, tergantung pada infrastruktur yang tersedia. eSPPO mendukung beberapa tipe koneksi, termasuk **HTTP klasik**, **HTTPS** untuk koneksi terenkripsi, dan **HTTP/2**, yang menawarkan kinerja lebih cepat dan efisien dalam pengiriman data selama server web mendukung protokol tersebut.

- **Server Basis Data MySQL/MariaDB**: Untuk mengelola dan menyimpan data pemilihan, eSPPO memerlukan akses ke server basis data **MySQL** atau yang kompatibel, seperti **MariaDB**. Server basis data ini menyimpan semua informasi penting terkait pemilih, kandidat, hasil suara, dan aktivitas pemilihan lainnya secara aman dan efisien.

- **Operasi Jarak Jauh dan Lokasi**: Karena berbasis web, eSPPO dapat diakses dari jarak jauh menggunakan perangkat apa pun yang memiliki browser web dan koneksi ke jaringan. Hal ini memudahkan pemilih dan panitia untuk mengakses aplikasi tanpa batasan geografis, selama memiliki akses ke server hosting aplikasi, baik melalui jaringan lokal maupun internet.

### Kebutuhan Infrastruktur
Untuk menjalankan **eSPPO**, infrastruktur berikut diperlukan:
- **Web Server**: Aplikasi ini di-host pada web server seperti **Apache HTTP Server**, yang mampu menjalankan PHP dan mendukung protokol koneksi HTTP/HTTPS. Jika diperlukan, **HTTP/2** juga bisa diaktifkan untuk meningkatkan performa.
- **Server Basis Data**: Database tipe **MySQL** atau **MariaDB** harus tersedia untuk menyimpan semua data yang terkait dengan pemilihan. Koneksi antara web server dan database harus terjamin aman dan cepat untuk menghindari gangguan selama pemilihan berlangsung.

## Arsitektur Infrastruktur eSPPO
Infrastruktur **eSPPO** terdiri dari beberapa komponen utama yang saling terhubung melalui jaringan, baik melalui internet maupun LAN, untuk memastikan sistem berfungsi dengan baik. Berikut adalah diagram teknis arsitektur infrastruktur **eSPPO**:

![Diagram](../../images/Presentasi_Pengenalan_eSPPO_SMABAT-Diagram_Teknis_Infrastruktur.png)

1. **PASSE (Perangkat Akses Surat Suara Elektronik)**: Perangkat yang digunakan oleh pemilih untuk mengakses surat suara secara elektronik melalui browser internet. PASSE dapat berupa laptop, tablet, atau perangkat lainnya yang terhubung ke jaringan.

2. **Klien Web Panitia/Pengawas**: Digunakan oleh panitia dan pengawas untuk mengelola data pemilih, memantau jalannya pemilihan, dan melihat hasil perolehan suara. Panitia dan pengawas dapat mengakses Pusminlihdu melalui jaringan internet atau LAN.

3. **Web Server**: Menjalankan aplikasi eSPPO, di mana SSE dan Pusminlihdu di-hosting. Server ini membutuhkan layanan HTTP/HTTPS untuk mengamankan dan mengatur aliran data antara klien dan server. Teknologi yang digunakan meliputi **Apache** sebagai server HTTP dan **PHP** untuk pemrosesan logika aplikasi.

4. **Database Server**: Menyimpan semua data pemilihan, termasuk daftar pemilih, data kandidat, dan hasil perolehan suara. **MariaDB** digunakan sebagai basis data yang terhubung dengan web server. Koneksi antara web server dan database dilakukan melalui koneksi yang aman.

### Tipe Koneksi:
- **Merah (HTTP)**: Digunakan untuk koneksi yang tidak terenkripsi, di mana keamanan tidak menjadi prioritas utama (misalnya pada jaringan lokal yang aman).
- **Hitam (HTTPS)**: Koneksi terenkripsi untuk menjamin keamanan data yang dikirimkan antara klien dan server, terutama pada jaringan internet.
- **Hijau**: Koneksi internal antara web server dan database untuk mengakses dan menyimpan data secara real-time.

## Cara Kerja Sistem eSPPO
1. **Pemilih** mengakses PASSE melalui perangkatnya, mengautentikasi diri, dan memilih pasangan calon yang diinginkan.
2. Data suara dikirimkan melalui jaringan (internet/LAN) ke **Web Server**, di mana SSE akan mengolah suara yang masuk.
3. **Web Server** memproses dan menyimpan hasil pemungutan suara ke **Database Server** secara real-time.
4. Panitia dan pengawas dapat mengakses **Pusminlihdu** melalui klien web untuk memantau proses pemungutan suara, melihat laporan, dan hasil akhir pemilihan yang dihasilkan oleh sistem.
