# Fix Memory Exhausted Error pada PDF Generation

## Masalah
Error: `Allowed memory size of 134217728 bytes exhausted` saat generate PDF Genset Maintenance.

## Penyebab
1. Gambar terlalu besar dikonversi ke base64
2. Banyak gambar dalam satu PDF (bisa sampai 9+ gambar)
3. Memory limit default PHP terlalu kecil (128MB)

## Solusi yang Diterapkan

### 1. Optimasi Image Processing (pdf_template.blade.php)
- **Resize gambar** otomatis maksimal 800x600px sebelum encoding
- **Compress JPEG** dengan quality 65% untuk ukuran lebih kecil
- **Skip gambar besar** lebih dari 2MB
- **Free memory** langsung setelah processing setiap gambar
- Konversi semua format ke JPEG untuk consistency

### 2. Increase Memory Limit (GensetController.php)
- Memory limit ditingkatkan dari 512M ke **768M**
- Max execution time 300 detik
- **Limit maksimal 15 gambar** per PDF
- Garbage collection setelah PDF generation
- Unset variable untuk free memory

### 3. Server Configuration (.htaccess)
```apache
php_value memory_limit 768M
php_value max_execution_time 300
php_value post_max_size 100M
php_value upload_max_filesize 100M
```

## Jika Error Masih Muncul di Hosting

### Opsi 1: Tambahkan di php.ini (Jika Ada Akses)
```ini
memory_limit = 768M
max_execution_time = 300
post_max_size = 100M
upload_max_filesize = 100M
```

### Opsi 2: Kurangi Jumlah Gambar
Edit [GensetController.php](app/Http/Controllers/GensetController.php) line ~255:
```php
// Ganti 15 dengan angka lebih kecil, misalnya 9 atau 6
if (count($maintenance->images) > 9) {
    $maintenance->images = array_slice($maintenance->images, 0, 9);
}
```

### Opsi 3: Compress Gambar Lebih Agresif
Edit [pdf_template.blade.php](resources/views/genset/pdf_template.blade.php) line ~203:
```php
// Ganti quality dari 65 ke 50 atau lebih kecil
imagejpeg($thumb, null, 50); // 50% quality
```

### Opsi 4: Resize Gambar Lebih Kecil
Edit [pdf_template.blade.php](resources/views/genset/pdf_template.blade.php) line ~182:
```php
// Ganti dari 800x600 ke ukuran lebih kecil
$maxWidth = 600;  // dari 800
$maxHeight = 450; // dari 600
```

## Testing
Setelah deploy ke hosting:
1. Test dengan data yang memiliki sedikit gambar (1-3 gambar)
2. Test dengan data yang memiliki banyak gambar (9+ gambar)
3. Monitor log error di `storage/logs/laravel.log`

## Monitoring
Jika masih error, cek:
```bash
# Cek memory usage actual
tail -f storage/logs/laravel.log | grep "Memory"

# Cek PHP info di hosting
php -i | grep memory_limit
```

## Kontak Developer
Jika masalah berlanjut, hubungi tim development dengan info:
- Jumlah gambar dalam data yang error
- Ukuran file gambar (KB/MB)
- Memory limit yang tersedia di hosting
- Full error log dari Laravel
