# cancer-detection
-----------------------------------------------------------
## Bagian Robot
### Desain dan Perakitan Robot:
- Mendesain struktur robot untuk mendukung servo dan kamera.
- Merakit komponen mekanik, seperti penyangga, tekukan, dan pergelangan.
- Memastikan stabilitas dan fleksibilitas gerakan robot.

### Kontrol Servo:
- Menulis kode kontrol untuk mengatur gerakan servo sesuai perintah.
- Mengintegrasikan feedback loop untuk meningkatkan presisi gerakan.
- Menyediakan fitur kalibrasi awal untuk posisi netral.
-----------------------------------------------------------

## Bagian Software
### Machine Learning untuk Deteksi:
- Mengembangkan model deteksi kanker kulit menggunakan dataset gambar yang relevan.
- Melatih model dengan algoritma CNN YOLO v11 untuk deteksi kanker kulit.
- Mengintegrasikan model dengan kamera robot untuk mendeteksi secara real-time.

### Pengambilan dan Penyimpanan Gambar:
- Menulis kode untuk mengambil gambar dari kamera.
- Menyimpan gambar hasil deteksi beserta metadata (misalnya, timestamp, posisi robot).

### UI/UX untuk Operator:
- Mendesain antarmuka untuk memudahkan pengguna dalam mengontrol robot dan melihat hasil deteksi.
- Memberikan fitur pemantauan secara real-time.
-----------------------------------------------------------

## Laporan
- Membuat laporan hasil scan, termasuk peta area tubuh yang telah diperiksa.
- Menyediakan fitur analisis lanjutan (misalnya, heatmap aktivitas deteksi).
