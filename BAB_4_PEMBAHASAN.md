# BAB 4: PEMBAHASAN DAN IMPLEMENTASI

## 4.1 Pendahuluan

Bab ini membahas implementasi dan pengembangan fitur-fitur dalam Sistem Pendukung Keputusan (SPK) menggunakan metode WASPAS untuk penentuan kandidat jabatan. Pembahasan mencakup pengembangan user interface, validasi data, dan dokumentasi sistem yang telah dikerjakan.

---

## 4.2 Pengembangan User Interface dan User Experience

### 4.2.1 Delete Confirmation Modal dengan Blur Background

**Tujuan:** Meningkatkan user experience dengan memberikan konfirmasi visual yang jelas sebelum melakukan penghapusan data.

**Implementasi:**
- Menambahkan modal delete confirmation dengan blur/overlay background pada semua halaman CRUD (Kandidat, JabatanTarget, Kriteria)
- Menggunakan Alpine.js untuk menangani state modal
- Styling dengan Tailwind CSS untuk tampilan modern dan responsif

**Fitur Utama:**
```blade
- Modal dengan overlay blur background
- Tombol Cancel dan Delete dengan styling berbeda
- Menampilkan informasi item yang akan dihapus
- Konfirmasi sebelum action penghapusan
```

**Benefit:**
- Mencegah penghapusan data yang tidak disengaja
- Meningkatkan kepercayaan pengguna terhadap aplikasi
- User experience yang lebih intuitif dan user-friendly

### 4.2.2 Styling Action Buttons pada Halaman Kandidat

**Tujuan:** Konsistensi visual dengan halaman lain dan peningkatan readability.

**Implementasi:**
- Mengubah action buttons pada halaman Kandidat untuk menggunakan SVG icons dan text labels
- Mencocokkan styling dengan halaman JabatanTarget
- Layout buttons: "Edit" dan "Hapus" dengan icon yang jelas

**Perubahan Visual:**
```
Sebelum: Text-based buttons
Sesudah: Icon + Text buttons dengan styling yang konsisten
- Edit button dengan icon pensil (primary color)
- Delete button dengan icon trash (danger color)
```

**Hasil:**
- Interface lebih konsisten di seluruh aplikasi
- User dapat dengan mudah mengidentifikasi action yang tersedia
- Tampilan lebih profesional dan modern

---

## 4.3 Fitur Master Data: Kriteria Nilai

### 4.3.1 Latar Belakang

Kriteria Nilai adalah master data yang mendefinisikan mapping antara nilai numerik (1-5) dan deskripsi kualitatif untuk setiap kriteria yang menggunakan dropdown selection (K4-K7).

### 4.3.2 Implementasi CRUD Page

**Lokasi:** `/kriteria-nilai` (under Master Data menu)

**Model dan Database:**
- Tabel: `kriteria_nilais`
- Fields:
  - `id` - Primary Key
  - `kriteria_id` - Foreign Key ke tabel kriteria
  - `nilai` - Nilai numerik (1-5)
  - `deskripsi` - Deskripsi kualitatif
  - `timestamps`

**Livewire Component:** `app/Http/Livewire/KriteriaNilai.php`
- CRUD operations (Create, Read, Update, Delete)
- Form validation
- Modal untuk create/edit
- Delete confirmation

**Blade View:** `resources/views/livewire/kriteria-nilai.blade.php`
- Tabel dengan daftar kriteria nilai
- Action buttons: Edit, Delete
- Form modal untuk input/edit data
- Delete confirmation modal

**Fitur:**
```php
- Menampilkan semua kriteria nilai dalam tabel
- Edit existing kriteria nilai via modal
- Delete kriteria nilai dengan konfirmasi
- Create kriteria nilai baru
- Validation untuk memastikan data yang diinput valid
```

### 4.3.3 Integrasi dengan Sistem

- Kriteria Nilai digunakan oleh Penilaian component untuk dropdown options
- Membantu user memahami meaning di balik setiap nilai numeric
- Meningkatkan consistency dalam penilaian kandidat

---

## 4.4 Perbaikan Database dan Seeding

### 4.4.1 Menu Duplication Issue

**Masalah:**
- MenuSeeder dijalankan multiple times tanpa truncate
- Menghasilkan 3x duplicate menus di database

**Solusi:**
```php
// DatabaseSeeder.php
DB::statement('SET FOREIGN_KEY_CHECKS=0;');
Menu::truncate();
DB::statement('SET FOREIGN_KEY_CHECKS=1;');
```

**Penjelasan:**
- Disable foreign key checks sebelum truncate untuk menghindari constraint violation
- Truncate table menus untuk clear data lama
- Re-enable foreign key checks setelah truncate
- Re-seed dengan data yang benar

### 4.4.2 KandidatSeeder Syntax Error

**Masalah:**
- Terdapat text "actio" sebelum `<?php` di KandidatSeeder
- Menyebabkan namespace error saat migrate

**Solusi:**
- Remove invalid text
- File syntax menjadi valid

### 4.4.3 Fresh Migration dan Seeding

**Command:**
```bash
php artisan migrate:fresh --seed
```

**Proses:**
1. Drop semua tables
2. Re-run semua migrations
3. Jalankan seeders sesuai urutan di DatabaseSeeder.php
4. Populate database dengan data initial

**Hasil:**
- Database bersih tanpa data duplikat
- Semua seeder berjalan dengan benar
- Data master terisi lengkap

---

## 4.5 Validasi Form Penilaian (Enhanced)

### 4.5.1 Identifikasi Masalah

**Masalah yang ditemukan:**
- Field dropdown pada halaman Penilaian menampilkan "Pilih Nilai" as default
- User dapat menyimpan form meskipun ada field kosong
- Nilai invalid masuk ke database

### 4.5.2 Implementasi Validasi Ketat

**Lokasi:** `app/Http/Livewire/Penilaian.php`

**Validasi Rules:**

#### Dropdown Kriteria (K4-K7):
```php
// Nilai harus 1-5, tidak boleh:
- Kosong ('')
- Null
- 0 atau '0'
- < 1 atau > 5
```

Kriteria yang termasuk:
- K4: Diklat
- K5: SKP
- K6: Penghargaan
- K7: Integritas (Hukdis)

#### Percentage Kriteria (K9-K10):
```php
// Nilai harus 0-100, tidak boleh:
- Kosong ('')
- Null
- < 0 atau > 100

// Catatan: Nilai 0 VALID (contoh: 0% = tidak ada)
```

Kriteria yang termasuk:
- K9: Potensi
- K10: Kompetensi

### 4.5.3 Implementasi dalam Code

```php
public function validateAllFilled(): bool
{
    $this->validationErrors = [];
    $manualKriterias = array_merge($this->dropdownKriterias, $this->persentaseKriterias);

    foreach ($this->kandidats as $kandidat) {
        foreach ($manualKriterias as $kriteriaId) {
            $value = $this->nilais[$kandidat->id][$kriteriaId] ?? null;

            // Validasi Dropdown
            if (in_array($kriteriaId, $this->dropdownKriterias)) {
                if ($value === '' || $value === null || $value === 0 ||
                    $value === '0' || $value < 1 || $value > 5) {
                    $this->validationErrors[$kandidat->id][$kriteriaId] = true;
                }
            }
            // Validasi Percentage
            elseif (in_array($kriteriaId, $this->persentaseKriterias)) {
                if ($value === '' || $value === null || $value < 0 || $value > 100) {
                    $this->validationErrors[$kandidat->id][$kriteriaId] = true;
                }
            }
        }
    }

    return empty($this->validationErrors);
}
```

### 4.5.4 User Feedback

- Display error message jika ada field yang invalid
- Highlight field dengan error
- Prevent form submission sampai semua field valid
- Success message setelah berhasil simpan

---

## 4.6 Arsitektur Penyimpanan Nilai K9 dan K10

### 4.6.1 Perubahan Konsep

**Sebelumnya:**
- K9 dan K10 disimpan dalam range 1-5 di database
- Conversion logic ada di Penilaian component

**Sekarang:**
- K9 dan K10 disimpan sebagai nilai original 0-100 di database
- Conversion ke 1-5 hanya dilakukan saat perhitungan WASPAS
- Database menyimpan data original untuk audit trail dan historisitas

### 4.6.2 Alur Penyimpanan

```
Input User (0-100)
        ↓
Penilaian Component
        ↓
Validation (0-100)
        ↓
Database Nilai
[Disimpan 0-100 original]
```

### 4.6.3 Alur Perhitungan WASPAS

```
Database Nilai (0-100)
        ↓
WaspasProses Component
        ↓
Konversi ke 1-5 menggunakan PenilaianAutoFillService
        ↓
Matrix Building (1-5)
        ↓
Normalisasi, WSM, WPM Calculation
        ↓
Final Score (Qi)
```

### 4.6.4 Implementasi dalam WaspasProses

```php
// Konversi K9 dan K10 dari 0-100 ke 1-5 untuk perhitungan
foreach ($nilais as $nilai) {
    $nilaiValue = $nilai->nilai;

    if (in_array($nilai->kriteria_id, [9, 10])) {
        $nilaiValue = $this->autoFillService->konversiPersentaseKeNilai(
            $nilai->nilai,
            $nilai->kriteria_id
        );
    }

    $this->matrix[$nilai->kandidats_id][$nilai->kriteria_id] = $nilaiValue;
}
```

### 4.6.5 Benefit dari Pendekatan Ini

1. **Data Integrity**: Nilai original tersimpan di database
2. **Audit Trail**: Dapat melacak perubahan nilai asli
3. **Flexibility**: Conversion logic dapat di-update tanpa migrate data
4. **Reporting**: Laporan dapat menampilkan both original dan converted values
5. **Consistency**: Semua proses perhitungan menggunakan logic conversion yang sama

---

## 4.7 Laporan dan Dokumentasi Sistem (Report Page)

### 4.7.1 Tujuan Report Page

- Menjelaskan teori dan dasar metode WASPAS secara detail
- Menampilkan proses perhitungan dengan data real
- Memberikan contoh perhitungan manual step-by-step
- Dokumentasi lengkap untuk kebutuhan laporan dan audit

### 4.7.2 Implementasi

**Route:** `/report` (auth required, no sidebar menu)

**Livewire Component:** `app/Http/Livewire/Report.php`
- Fetch data: Kandidat, Kriteria, Nilai
- Calculate WASPAS dengan selected jabatan target
- Build matrix, normalization, WSM, WPM, Qi

**Blade View:** `resources/views/livewire/report.blade.php`
- 9 comprehensive sections
- Interactive jabatan target selector
- Dynamic calculation display

### 4.7.3 Struktur 9 Section Report

#### 1. Pendahuluan
```
- Definisi SPK (Decision Support System)
- Tujuan sistem dalam konteks penentuan kandidat jabatan
- Keuntungan penggunaan SPK
- Objektivity vs Subjektivitas
```

#### 2. Metode WASPAS
```
- Definisi WASPAS (Weighted Aggregated Sum Product Assessment)
- Kelebihan metode:
  * Akurasi Tinggi
  * Fleksibel (Benefit/Cost)
  * Sederhana
  * Transparan
- Rumus Matematika:
  * Normalisasi: R_ij = X_ij / max(X_ij) atau min(X_ij) / X_ij
  * WSM: Q1 = Σ(r_ij × w_j)
  * WPM: Q2 = Π(r_ij)^w_j
  * Final: Qi = λ×Q1 + (1-λ)×Q2 (λ=0.5)
```

#### 3. Kriteria Penilaian
```
- Tabel semua kriteria dengan:
  * Kode (K1-K10)
  * Nama kriteria
  * Bobot (dalam %)
  * Jenis (Benefit/Cost)
  * Keterangan (auto-fill, dropdown, persentase)
- Total bobot harus 100%
- Penjelasan Benefit vs Cost normalization
```

#### 4. Data Kandidat
```
- Tabel kandidat:
  * No, NIP, Nama
  * Jabatan saat ini
  * Golongan
  * Pendidikan
- Total kandidat yang dievaluasi
```

#### 4.5 Proses Perhitungan
```
Jabatan Target Selector
        ↓
Step 5.1: Matriks Keputusan (X)
- Tabel dengan nilai setiap kandidat per kriteria
- Nilai sudah dalam skala 1-5
        ↓
Step 5.2: Nilai Min/Max per Kriteria
- Minimum dan maksimum setiap kriteria
- Digunakan untuk normalisasi
        ↓
Step 5.3: Matriks Ternormalisasi (R)
- Hasil normalisasi untuk setiap kandidat-kriteria
- Nilai berkisar 0-1
        ↓
Step 5.4: Perhitungan Q1 dan Q2
- Q1 (WSM): Penjumlahan terbobot
- Q2 (WPM): Perkalian terbobot
- Qi = 0.5×Q1 + 0.5×Q2
```

#### 6. Contoh Perhitungan Manual (NEW!)
```
Langkah 1: Data Nilai Awal (Matriks X)
- Tabel dengan nilai original setiap kandidat
- Bobot dalam % dan desimal
- Jenis kriteria (Benefit/Cost)

Langkah 2: Proses Normalisasi
- Formula normalisasi per kriteria
- Perhitungan detail untuk setiap K1-K10
- Hasil normalisasi dengan 4 decimal

Langkah 3: Perhitungan Q1 (WSM)
- Formula: Q1 = Σ (r_ij × w_j)
- Tabel breakdown: setiap kriteria × bobot
- Total Q1 dengan highlighting

Langkah 4: Perhitungan Q2 (WPM)
- Formula: Q2 = Π (r_ij + ε)^w_j
- Penjelasan epsilon (0.0001)
- Tabel breakdown dengan hasil setiap kriteria
- Total Q2

Langkah 5: Perhitungan Qi Final
- Formula: Qi = 0.5×Q1 + 0.5×Q2
- Breakdown dengan nilai asli Q1 dan Q2
- Intermediate: 0.5×Q1 dan 0.5×Q2
- Final Qi Result (highlighted)

Info: Proses sama untuk setiap kandidat, di-sort descending by Qi
```

#### 7. Hasil Perangkingan
```
- Tabel hasil ranking:
  * Ranking (with trophy icon for #1)
  * Nama kandidat
  * NIP
  * Q1, Q2, Qi values
- Rekomendasi sistem untuk kandidat terbaik
```

#### 8. Implementasi Sistem
```
8.1 Teknologi yang Digunakan
- Laravel 10 (PHP Framework)
- Livewire 3 (Reactive UI)
- Tailwind CSS (Styling)
- MySQL (Database)

8.2 Fitur Utama Sistem
- Manajemen Kandidat
- Manajemen Kriteria
- Auto-Fill Nilai
- Input Penilaian
- Perhitungan WASPAS
- Hasil & Perangkingan
- Laporan

8.3 Alur Kerja Sistem
Input Data Kandidat → Atur Kriteria & Bobot → Input Penilaian
→ Proses WASPAS → Hasil Ranking
```

#### 9. Kesimpulan
```
- Ringkasan implementasi SPK WASPAS
- Kelebihan sistem:
  * Penilaian objektif dan terukur
  * Perhitungan otomatis dan akurat
  * Hasil dapat dilacak dan diverifikasi
  * Dokumentasi lengkap
- Rekomendasi:
  * Hasil sebagai bahan pertimbangan
  * Keputusan akhir pada pengambil keputusan
  * Validasi dengan assessment lain
  * Review berkala bobot kriteria
- Catatan penting: Hasil bersifat rekomendasi
```

### 4.7.4 Fitur Interaktif

**Jabatan Target Selector:**
```blade
<select wire:model.live="selectedJabatanId">
    -- Pilih Jabatan Target --
</select>
```

- User dapat memilih jabatan target
- Calculations di-regenerate secara real-time
- Menampilkan contoh perhitungan dengan data selected jabatan

### 4.7.5 Dynamic Calculation Example

Contoh perhitungan manual menggunakan data kandidat pertama dari hasil perhitungan:

```php
// Di component
$contoh = $results[0]; // Kandidat pertama sebagai contoh
// Build tables dan calculations berdasarkan $contoh['matrix'],
// $contoh['normalized'], $contoh['q1'], $contoh['q2'], $contoh['qi']
```

**Benefit:**
- Menunjukkan perhitungan dengan data real, bukan dummy data
- User dapat understand step-by-step dari raw data ke final score
- Semua formula dan intermediate calculations terlihat jelas

### 4.7.6 Styling dan Design

- **Modern Design**: Gradient headers, colored sections
- **Responsive**: Mobile-friendly layout
- **Dark Mode Support**: Full dark mode compatibility
- **Icons**: Bootstrap icons untuk visual enhancement
- **Tables**: Clear, readable tables dengan proper spacing
- **Highlighting**: Important values dengan warna berbeda (blue untuk Q1, purple untuk Q2, orange untuk Qi)

---

## 4.8 Ringkasan Implementasi

### 4.8.1 Komponen-Komponen yang Dikembangkan

| Komponen | Status | Fungsi |
|----------|--------|--------|
| Delete Confirmation Modal | ✅ Complete | Konfirmasi sebelum hapus data |
| Kandidat Action Buttons | ✅ Complete | Edit dan Delete dengan icons |
| Kriteria Nilai CRUD | ✅ Complete | Master data untuk nilai kriteria |
| Penilaian Validation | ✅ Enhanced | Validasi ketat untuk input data |
| K9/K10 Architecture | ✅ Refactored | Storage 0-100, convert saat calculation |
| Report Page | ✅ Complete | Dokumentasi WASPAS dengan 9 sections |

### 4.8.2 Database Changes

```
Migrations:
- 2025_12_24_100000_create_masa_jabatan_ranges_table
- 2025_12_24_100001_create_persentase_conversions_table

Seeders:
- MenuSeeder (with truncate fix)
- MasaJabatanRangeSeeder
- PersentaseConversionSeeder
```

### 4.8.3 Routes Ditambahkan

```php
// Protected routes (menu.access)
GET /kriteria-nilai          → KriteriaNilai (CRUD)

// Auth-only routes (no menu)
GET /report                  → Report (Documentation)
```

### 4.8.4 Livewire Components

| Component | Fungsi |
|-----------|--------|
| Penilaian | Input scoring dengan enhanced validation |
| WaspasProses | Perhitungan WASPAS dengan K9/K10 conversion |
| Report | Dokumentasi dan manual calculation examples |
| KriteriaNilai | Master data CRUD untuk nilai kriteria |

---

## 4.9 Testing dan Quality Assurance

### 4.9.1 Validation Testing

**Penilaian Form:**
- ✅ Dropdown K4-K7 tidak accept nilai 0 atau kosong
- ✅ Persentase K9-K10 accept 0-100, reject kosong
- ✅ Error message menampilkan jumlah field yang error
- ✅ Prevent save jika ada field error

### 4.9.2 Database Integrity

- ✅ Fresh migration berjalan tanpa error
- ✅ Seeding selesai dengan data lengkap
- ✅ No duplicate menus di database
- ✅ Foreign key constraints intact

### 4.9.3 UI/UX Testing

- ✅ Delete confirmation modal smooth dan intuitive
- ✅ Action buttons responsive di mobile
- ✅ Report page displays correctly dengan data dynamic
- ✅ Dark mode support working properly

---

## 4.10 Dokumentasi dan Best Practices

### 4.10.1 Code Quality

- ✅ Syntax valid (PHP lint check passed)
- ✅ Proper naming conventions
- ✅ Clear separation of concerns
- ✅ DRY principle applied

### 4.10.2 User Documentation

- ✅ Report page explains WASPAS theory
- ✅ Manual calculation examples included
- ✅ Formula dan variables clear
- ✅ Multi-language support (Indonesian)

### 4.10.3 Developer Documentation

- ✅ CLAUDE.md di codebase untuk guidelines
- ✅ Code comments untuk complex logic
- ✅ Commit messages clear dan descriptive
- ✅ Architecture documented

---

## 4.11 Kesimpulan dan Rekomendasi

### 4.11.1 Kesimpulan

Implementasi sistem telah mencakup:
1. Peningkatan UX dengan modal dan styling yang konsisten
2. Penambahan master data untuk kriteria nilai
3. Perbaikan database integrity dan seeding process
4. Enhanced validation untuk data accuracy
5. Refactoring architecture untuk K9/K10 storage
6. Comprehensive documentation melalui Report page

### 4.11.2 Rekomendasi Pengembangan Lanjutan

1. **Export Functionality**: Tambahkan export report ke PDF
2. **Historical Tracking**: Track perubahan nilai untuk audit trail
3. **Advanced Filtering**: Filter candidates berdasarkan criteria tertentu
4. **Email Integration**: Kirim hasil ranking via email
5. **Mobile App**: Develop mobile version untuk input penilaian
6. **Analytics Dashboard**: Tambahkan statistics dan trends

### 4.11.3 Best Practices untuk Maintenance

1. Always truncate before seeding ketika ada perubahan data
2. Test validation rules setiap kali ada perubahan requirement
3. Keep Report page updated dengan latest WASPAS documentation
4. Monitor database performance untuk large dataset
5. Regular backup sebelum running migrations

---

## 4.12 Lampiran

### 4.12.1 Commit History

```
964fd2b feat: Add Report page with WASPAS theory and manual calculation examples
81f1797 refactor: Store original values for K9 and K10, convert only during WASPAS calculation
eea0e4f fix: Improve validation for penilaian form
d2761a1 fix: Remove invalid text from KandidatSeeder file
```

### 4.12.2 Files Created/Modified

**Created:**
- app/Http/Livewire/Report.php
- resources/views/livewire/report.blade.php
- app/Http/Livewire/KriteriaNilai.php
- resources/views/livewire/kriteria-nilai.blade.php
- database/migrations/2025_12_24_100000_create_masa_jabatan_ranges_table.php
- database/migrations/2025_12_24_100001_create_persentase_conversions_table.php
- database/seeders/MasaJabatanRangeSeeder.php
- database/seeders/PersentaseConversionSeeder.php

**Modified:**
- routes/web.php
- app/Http/Livewire/Penilaian.php
- app/Http/Livewire/WaspasProses.php
- database/seeders/DatabaseSeeder.php
- database/seeders/MenuSeeder.php
- database/seeders/KandidatSeeder.php

### 4.12.3 Teknologi dan Tools

- **Framework**: Laravel 10
- **UI**: Livewire 3, Tailwind CSS 4
- **Database**: MySQL
- **Version Control**: Git
- **Development**: PHP 8.1+

---

**Dokumen ini dibuat sebagai dokumentasi resmi implementasi BAB 4: Pembahasan dan Implementasi Sistem Pendukung Keputusan WASPAS.**

*Last Updated: 2025-12-24*
