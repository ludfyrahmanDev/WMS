# Summary: Menu Transaksi Lain-Lain Khusus Angkutan

## Deskripsi
Telah berhasil membuat menu dan fitur **Transaksi Lain-Lain Khusus Angkutan** (Transport Spending) sebagai sistem terpisah dari Transaksi Lain-Lain reguler.

## Komponen yang Dibuat

### 1. Model
- **File:** `/app/Models/TransportSpending.php`
- **Atribut:**
  - `id` (Primary Key)
  - `date` (Tanggal transaksi)
  - `description` (Deskripsi transaksi - optional)
  - `spending_category_id` (Foreign Key ke spending_category)
  - `cv_id` (Foreign Key ke cv - perusahaan)
  - `mutation` (Enum: 'Uang Masuk' atau 'Uang Keluar')
  - `payment_method` (Metode pembayaran)
  - `nominal` (Jumlah nominal - bigInteger)
  - `who_create` (Pembuat data)
  - `who_update` (Pembarui data)
  - `timestamps` dan `soft_deletes`
- **Relasi:**
  - `belongsTo(SpendingCategory)`
  - `belongsTo(CV)`

### 2. Database Migration
- **File:** `/database/migrations/2026_01_22_000000_create_transport_spending_table.php`
- **Tabel:** `transport_spending`
- **Status:** ✅ Sudah dijalankan dengan sukses

### 3. Controller
- **File:** `/app/Http/Controllers/TransportSpendingController.php`
- **Method:**
  - `index()` - Menampilkan list transaksi dengan filter, search, dan statistik
  - `create()` - Form tambah transaksi baru
  - `store()` - Simpan transaksi baru
  - `edit()` - Form edit transaksi
  - `update()` - Update transaksi
  - `destroy()` - Hapus transaksi
- **Fitur:**
  - Filter berdasarkan tanggal dan company
  - Search by description
  - Pagination
  - Perhitungan total income dan outcome

### 4. Request Validation
- **File:** `/app/Http/Requests/Transaksi/TransportSpendingStoreRequest.php`
- **Validasi:**
  - `spending_category` (required)
  - `nominal` (required)
  - `tanggal` (required)
  - `mutasi` (required)

### 5. Views
- **Index:** `/resources/views/pages/backoffice/transport_spending/index.blade.php`
  - Header dengan icon truck
  - Statistics cards (Total Pengeluaran, Pemasukan, Transaksi)
  - Filter & search functionality
  - Tabel dengan kolom: No, Tanggal, Keterangan, Kategori, Masuk, Keluar, Metode Pembayaran, Aksi
  - Pagination
  - Edit & Delete buttons
  - Delete confirmation modal

- **Form:** `/resources/views/pages/backoffice/transport_spending/_form.blade.php`
  - Input: Tanggal, Mutasi, Kategori Transaksi, Deskripsi, Metode Pembayaran, Nominal
  - Support untuk multi-company (cv_id)
  - Validasi error display
  - Cancel & Save buttons

### 6. Routes
- **File:** `/routes/web.php`
- **Routes:**
  - `Route::resource('transportSpending', TransportSpendingController::class)` 
  - Middleware: `permission:spending.view,spending.create,spending.edit,spending.delete`
- **Methods Auto-Generated:** 
  - `GET  /transportSpending` → index
  - `GET  /transportSpending/create` → create
  - `POST /transportSpending` → store
  - `GET  /transportSpending/{id}/edit` → edit
  - `PUT  /transportSpending/{id}` → update
  - `DELETE /transportSpending/{id}` → destroy

### 7. Navigation Menu
- **File:** `/app/Main/SideMenu.php`
- **Penempatan:**
  - **Transaksi Menu:**
    - Lain Lain (spending.create) - existing
    - **Lain Lain - Angkutan (transportSpending.create)** ← NEW
  
  - **Laporan Menu:**
    - Laporan Transaksi (spending.index) - existing
    - **Laporan Transaksi Angkutan (transportSpending.index)** ← NEW

### 8. Menu Service
- **File:** `/app/Services/MenuService.php`
- **Update:** Added route permission mappings untuk `transportSpending.create` dan `transportSpending.index`

## Kolom dan Input (Sama dengan Transaksi Lain-Lain)

| Kolom | Tipe | Required | Deskripsi |
|-------|------|----------|-----------|
| Tanggal | Date | Yes | Tanggal transaksi |
| Mutasi | Select | Yes | Uang Masuk atau Uang Keluar |
| Kategori Transaksi | Select | Yes | Kategori dari spending_category |
| Deskripsi | Textarea | No | Keterangan tambahan |
| Metode Pembayaran | Select | Yes | Cash, Transfer, Cheque, dll |
| Nominal | Number | Yes | Jumlah uang dalam format currency |

## Fitur Utama

✅ **CRUD Operations** - Create, Read, Update, Delete
✅ **Data Filtering** - Berdasarkan tanggal range dan search
✅ **Statistics Cards** - Menampilkan total pengeluaran, pemasukan, dan jumlah transaksi
✅ **Pagination** - Default 10 per halaman
✅ **Soft Delete** - Data yang dihapus tidak hilang, hanya ditandai deleted
✅ **Multi-Company Support** - Setiap CV dapat mengelola data terpisah
✅ **Audit Trail** - Mencatat siapa yang membuat dan mengupdate data
✅ **Permission-Based Access** - Akses kontrol berbasis role
✅ **Form Validation** - Validasi server-side dengan pesan error yang jelas
✅ **Responsive Design** - Mobile-friendly interface dengan Tailwind CSS

## Cara Menggunakan

1. **Akses Menu:**
   - Via Sidebar: Transaksi → Lain Lain - Angkutan
   - Atau Laporan → Laporan Transaksi Angkutan

2. **Tambah Transaksi Baru:**
   - Klik tombol "Tambah Data Pengeluaran Angkutan"
   - Isi form dengan data yang diperlukan
   - Klik "Save"

3. **Lihat Laporan:**
   - Akses Laporan → Laporan Transaksi Angkutan
   - Gunakan filter tanggal dan search untuk mencari data

4. **Edit/Hapus Transaksi:**
   - Klik icon Edit (pencil) atau Delete (trash) di kolom Aksi
   - Untuk delete, konfirmasi di modal

## Perbedaan dari Spending (Transaksi Lain-Lain) Reguler

- **Tabel Terpisah:** Menggunakan tabel `transport_spending` bukan `spending`
- **Model Terpisah:** TransportSpending model dengan relasi sendiri
- **View Terpisah:** Template khusus untuk angkutan
- **Menu Terpisah:** Menu terpisah di sidebar untuk akses mudah
- **Fokus:** Khusus untuk transaksi yang terkait dengan angkutan/transportasi

## Database Structure

```sql
CREATE TABLE transport_spending (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    date DATE,
    description VARCHAR(255) NULLABLE,
    spending_category_id BIGINT,
    cv_id BIGINT NULLABLE,
    mutation ENUM('Uang Masuk', 'Uang Keluar'),
    payment_method VARCHAR(255),
    nominal BIGINT,
    who_create VARCHAR(255),
    who_update VARCHAR(255),
    deleted_at TIMESTAMP NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (spending_category_id) REFERENCES spending_category(id),
    FOREIGN KEY (cv_id) REFERENCES cv(id)
);
```

## Testing
Untuk testing, Anda dapat:
1. Login sebagai user dengan permission `spending.view` atau lebih
2. Navigasi ke Transaksi → Lain Lain - Angkutan
3. Tambah data baru
4. Test filter, search, edit, dan delete
5. Lihat laporan di Laporan → Laporan Transaksi Angkutan

## Selesai! ✅
Sistem **Transaksi Lain-Lain Khusus Angkutan** sudah siap digunakan dengan struktur yang sama dengan transaksi lain-lain reguler namun dalam tabel dan menu yang terpisah.
