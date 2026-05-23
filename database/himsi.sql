CREATE DATABASE IF NOT EXISTS himsi_website CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE himsi_website;

DROP TABLE IF EXISTS press_releases;
DROP TABLE IF EXISTS open_recruitments;
DROP TABLE IF EXISTS programs;
DROP TABLE IF EXISTS divisions;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE press_releases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    slug VARCHAR(220) NOT NULL UNIQUE,
    category VARCHAR(100) DEFAULT 'Berita',
    excerpt TEXT,
    content LONGTEXT NOT NULL,
    image VARCHAR(255),
    author VARCHAR(100) DEFAULT 'Admin HIMSI',
    status ENUM('draft', 'published') DEFAULT 'published',
    published_at DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE open_recruitments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT,
    schedule VARCHAR(255),
    requirements TEXT,
    selection_steps TEXT,
    divisions TEXT,
    poster VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE programs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    event_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE divisions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins (name, username, password) VALUES
('Administrator HIMSI', 'admin', '$2y$12$ZBskPetW/GUeCax89eqqzeOACpg65lqD5Z.n8lo688gTHmZC52flO');

INSERT INTO programs (title, description, image, event_date) VALUES
('HIMSI Gathering', 'Kegiatan tahunan untuk mempererat silaturahmi seluruh keluarga besar Sistem Informasi UBSI melalui talkshow dan hiburan.', 'program-gathering.svg', '2026-06-20'),
('Workshop IT', 'Pelatihan intensif bersama praktisi industri untuk menguasai teknologi terbaru.', 'program-workshop.svg', '2026-07-12'),
('Informatics Cup', 'Kompetisi tahunan bidang coding dan e-sports bagi seluruh mahasiswa.', 'program-cup.svg', '2026-08-10'),
('Pengabdian Masyarakat', 'Implementasi ilmu IT untuk membantu masyarakat dan UMKM go-digital.', 'program-service.svg', '2026-09-05');

INSERT INTO press_releases (title, slug, category, excerpt, content, image, author, status, published_at) VALUES
('AI Chatbot Development with Python', 'ai-chatbot-development-with-python', 'Workshop', 'Pelajari cara membangun chatbot cerdas menggunakan Python dan integrasi API.', 'HIMSI UBSI menyelenggarakan workshop AI Chatbot Development with Python sebagai bentuk pengembangan kompetensi mahasiswa dalam bidang kecerdasan buatan. Kegiatan ini membahas pengenalan chatbot, pemrosesan input pengguna, serta integrasi API untuk membangun layanan percakapan yang lebih interaktif. Peserta juga mendapatkan sesi praktik langsung agar mampu memahami alur kerja pengembangan chatbot dari tahap perancangan sampai pengujian.', 'press-ai.svg', 'Admin HIMSI', 'published', '2026-06-29'),
('Ethical Hacking Fundamental', 'ethical-hacking-fundamental', 'Cybersecurity', 'Memahami dasar-dasar keamanan siber dan cara melindungi infrastruktur jaringan.', 'Kegiatan Ethical Hacking Fundamental dirancang untuk memperkenalkan konsep dasar keamanan siber kepada mahasiswa Sistem Informasi. Materi yang dibahas mencakup pengenalan ancaman digital, prinsip ethical hacking, keamanan jaringan, dan praktik dasar pengujian keamanan yang dilakukan secara etis. Melalui kegiatan ini, peserta diharapkan memiliki pemahaman awal mengenai pentingnya keamanan informasi di era digital.', 'press-cyber.svg', 'Admin HIMSI', 'published', '2026-07-12'),
('Mastering Figma for Web Design', 'mastering-figma-for-web-design', 'UI/UX Design', 'Tingkatkan skill desain dari basic hingga pembuatan prototype interaktif di Figma.', 'Workshop Mastering Figma for Web Design membahas proses perancangan antarmuka website mulai dari riset sederhana, pembuatan wireframe, desain visual, hingga prototype. Kegiatan ini bertujuan membantu mahasiswa memahami alur kerja UI/UX dan menghasilkan desain yang rapi, konsisten, dan mudah digunakan.', 'press-figma.svg', 'Admin HIMSI', 'published', '2026-08-05');

INSERT INTO open_recruitments (title, description, schedule, requirements, selection_steps, divisions, poster, status) VALUES
('Open Recruitment Pengurus HIMSI UBSI 2026', 'HIMSI UBSI membuka kesempatan bagi mahasiswa Sistem Informasi yang ingin berkembang dalam organisasi, kepemimpinan, dan kolaborasi teknologi.', '1 Juni 2026 - 20 Juni 2026', 'Mahasiswa aktif Sistem Informasi UBSI\nMemiliki komitmen mengikuti kegiatan organisasi\nBersedia mengikuti seluruh tahapan seleksi\nMemiliki minat pada bidang teknologi, organisasi, atau publikasi', '1. Pengumpulan berkas\n2. Wawancara calon pengurus\n3. Seleksi divisi\n4. Pengumuman hasil seleksi', 'Divisi Pendidikan dan Pengembangan\nDivisi Kominfo\nDivisi Kewirausahaan\nDivisi Hubungan Masyarakat\nDivisi Minat dan Bakat', 'poster-oprec.svg', 'active');

INSERT INTO divisions (name, description) VALUES
('Pendidikan dan Pengembangan', 'Mengelola kegiatan edukatif seperti workshop, pelatihan, dan pengembangan kemampuan akademik mahasiswa.'),
('Kominfo', 'Mengelola publikasi, dokumentasi, konten media sosial, dan informasi resmi organisasi.'),
('Hubungan Masyarakat', 'Menjalin komunikasi dan kolaborasi dengan internal kampus maupun pihak eksternal.'),
('Kewirausahaan', 'Mengembangkan program kewirausahaan dan kegiatan produktif organisasi.'),
('Minat dan Bakat', 'Memfasilitasi kegiatan non-akademik, kreativitas, kompetisi, dan kebersamaan anggota.');
