# website company profile himsi ubsi

website company profile himpunan mahasiswa sistem informasi universitas bina sarana informatika. website ini dibuat menggunakan html, css vanilla, php vanilla, mysql, dan javascript opsional tanpa framework.

project ini memiliki halaman publik untuk menampilkan informasi organisasi dan panel admin untuk mengelola konten seperti press release, open recruitment, divisi, dan program kerja.

---

## teknologi yang digunakan

- html
- css vanilla
- php vanilla
- mysql
- javascript vanilla
- xampp / laragon
- phpmyadmin

---

## fitur utama

### halaman publik

- beranda website himsi
- profil organisasi
- sejarah organisasi
- visi dan misi
- struktur organisasi
- halaman divisi
- halaman program kerja
- halaman open recruitment
- halaman press release
- detail artikel press release
- kontak dan media sosial
- responsive untuk desktop dan mobile

### panel admin

- login admin
- dashboard admin
- kelola press release
- tambah artikel
- edit artikel
- hapus artikel
- upload gambar artikel
- publish / draft artikel
- kelola open recruitment
- upload poster open recruitment
- kelola divisi
- kelola program kerja

---

## ketentuan project

- tidak menggunakan framework php
- tidak menggunakan framework css seperti bootstrap atau tailwind
- website dijalankan di localhost menggunakan xampp atau laragon
- database menggunakan mysql
- warna utama website menggunakan `#0c1250`
- open recruitment hanya menampilkan informasi
- tidak menyediakan fitur pendaftaran online
- pengunjung dapat membaca press release tanpa login
- halaman admin wajib login terlebih dahulu

---

## struktur folder

```txt
himsi-website/
│
├── admin/
│   ├── includes/
│   │   ├── head.php
│   │   └── sidebar.php
│   │
│   ├── open-recruitment/
│   │   ├── index.php
│   │   ├── edit.php
│   │   └── update.php
│   │
│   ├── press-release/
│   │   ├── index.php
│   │   ├── create.php
│   │   ├── store.php
│   │   ├── edit.php
│   │   ├── update.php
│   │   └── delete.php
│   │
│   ├── dashboard.php
│   ├── login.php
│   └── logout.php
│
├── assets/
│   ├── css/
│   │   ├── style.css
│   │   └── admin.css
│   │
│   ├── images/
│   │   ├── uploads/
│   │   └── default/
│   │
│   └── js/
│       └── main.js
│
├── config/
│   ├── database.php
│   └── auth.php
│
├── database/
│   └── himsi.sql
│
├── includes/
│   ├── footer.php
│   ├── functions.php
│   ├── header.php
│   └── navbar.php
│
├── detail-press-release.php
├── divisi.php
├── index.php
├── kontak.php
├── open-recruitment.php
├── press-release.php
├── profil.php
└── program.php