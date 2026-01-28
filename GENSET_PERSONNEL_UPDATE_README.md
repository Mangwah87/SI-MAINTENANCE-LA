# Update Struktur Pelaksana Form Genset

## Perubahan yang Dilakukan

### 1. Migrasi Database
**File:** `database/migrations/2026_01_28_000000_update_genset_personnel_structure.php`

Perubahan struktur database dari:
- `technician_1_name`, `technician_1_department`
- `technician_2_name`, `technician_2_department`
- `technician_3_name`, `technician_3_department`
- `approver_name`, `approver_department`, `approver_nik`

Menjadi:
- **4 Executor:** `executor_1`, `mitra_internal_1`, `executor_2`, `mitra_internal_2`, `executor_3`, `mitra_internal_3`, `executor_4`, `mitra_internal_4`
- **Verifikator:** `verifikator`, `verifikator_nik`
- **Head of Sub Department:** `head_of_sub_department`, `head_of_sub_department_nik`

### 2. Form Create & Edit
**Files:** 
- `resources/views/genset/create.blade.php`
- `resources/views/genset/edit.blade.php`

Perubahan:
- Menambah 4 executor (sebelumnya 3 technician)
- Menambah field Mitra/Internal untuk setiap executor
- Menambah section Verifikator dengan NIK
- Menambah section Head of Sub Department dengan NIK

### 3. Controller
**File:** `app/Http/Controllers/GensetController.php`

Update validation rules untuk menerima field baru:
- `executor_1` hingga `executor_4`
- `mitra_internal_1` hingga `mitra_internal_4`
- `verifikator` dan `verifikator_nik`
- `head_of_sub_department` dan `head_of_sub_department_nik`

### 4. View Show
**File:** `resources/views/genset/show.blade.php`

Menampilkan:
- 4 executor dengan badge Mitra/Internal
- Verifikator dengan NIK
- Head of Sub Department dengan NIK

### 5. PDF Template
**File:** `resources/views/genset/pdf_template.blade.php`

Update struktur tabel signature mengikuti format form AC:
- Tabel dengan 4 baris executor
- Kolom: No, Nama, Mitra/Internal, Signature
- Kolom Verifikator dengan NIK
- Kolom Head of Sub Department dengan NIK

## Cara Menjalankan

### Langkah 1: Backup Database
```bash
# Backup database terlebih dahulu
php artisan db:backup
# atau manual export dari database
```

### Langkah 2: Jalankan Migrasi
```bash
php artisan migrate
```

**PENTING:** Migrasi ini akan menghapus data lama (technician & approver). Pastikan data sudah di-backup!

### Langkah 3: Rollback (Jika Diperlukan)
Jika ingin mengembalikan ke struktur lama:
```bash
php artisan migrate:rollback
```

## Testing Checklist

- [ ] Form create genset dapat menambah data baru
- [ ] Form edit genset dapat update data existing
- [ ] Data lama (jika ada) sudah dimigrasikan atau di-backup
- [ ] PDF generate dengan benar menampilkan executor dan verifikator
- [ ] View show menampilkan data dengan benar
- [ ] Field Mitra/Internal tersimpan dengan benar
- [ ] NIK Verifikator dan Head of Sub Department tersimpan dengan benar

## Catatan Penting

1. **Data Lama:** Migrasi akan menghapus kolom lama. Pastikan tidak ada data penting yang belum di-backup.

2. **Data Migration (Optional):** Jika ingin memigrasikan data lama ke struktur baru, tambahkan script migration sebelum drop columns:
   ```php
   // Before dropping old columns
   DB::table('genset_maintenances')->get()->each(function($record) {
       DB::table('genset_maintenances')
           ->where('id', $record->id)
           ->update([
               'executor_1' => $record->technician_1_name,
               'mitra_internal_1' => 'Internal', // default value
               'executor_2' => $record->technician_2_name,
               'executor_3' => $record->technician_3_name,
               'head_of_sub_department' => $record->approver_name,
               'head_of_sub_department_nik' => $record->approver_nik,
           ]);
   });
   ```

3. **Model Update:** Model `GensetMaintenance` tidak perlu diupdate karena menggunakan mass assignment.

## Struktur Form Baru vs Lama

### Lama:
```
Pelaksana:
- Pelaksana 1: Nama, Department
- Pelaksana 2: Nama, Department
- Pelaksana 3: Nama, Department

Mengetahui:
- Approver: Nama, NIK, Department
```

### Baru (Sesuai Form AC):
```
Executor:
- Executor 1: Nama, Mitra/Internal
- Executor 2: Nama, Mitra/Internal
- Executor 3: Nama, Mitra/Internal
- Executor 4: Nama, Mitra/Internal

Mengetahui:
- Verifikator: Nama, NIK
- Head of Sub Department: Nama, NIK
```

## Support
Jika ada masalah, cek:
1. Log Laravel: `storage/logs/laravel.log`
2. Database migration status: `php artisan migrate:status`
3. Rollback jika ada error: `php artisan migrate:rollback`
