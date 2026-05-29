# Onboarding Summary: Akha Interior

## 1. Project ini tentang apa

`Akha Interior` adalah aplikasi web katalog dan admin panel untuk brand furniture interior berbasis kayu.

Secara implementasi saat ini, project ini berfungsi sebagai:

- storefront publik untuk menampilkan katalog produk, kategori, detail produk, halaman statis, keranjang, dan form kontak
- admin panel untuk mengelola produk, kategori, banner, halaman, user, order, payment, review, inquiry, dan setting
- fondasi e-commerce sederhana yang sudah memiliki model cart, order, payment, review, wishlist, dan checkout service

Secara bisnis, flow yang sudah paling jelas dan aktif sekarang adalah:

- pengunjung melihat katalog
- pengunjung menambahkan produk ke keranjang berbasis session
- pengunjung mengirim inquiry lewat halaman kontak
- admin mengelola data lewat panel Filament di `/back`

Catatan penting:

- flow checkout penuh sudah mulai disiapkan lewat `CartService` dan `CheckoutService`, tetapi storefront yang aktif masih memakai cart berbasis session di `CartController`
- repo ini bukan sekadar company profile; dia sudah bergerak ke arah mini e-commerce / katalog penjualan furniture

---

## 2. Tech yang digunakan

### Backend

- `PHP 8.1+`
- `Laravel 10`
- `Eloquent ORM`
- `Laravel Sanctum`
- `Guzzle`

### Admin panel

- `Filament 3`

### Frontend

- `Blade`
- `Tailwind CSS` via CDN
- `Alpine.js` via CDN
- `Vite` sudah disiapkan, tetapi pemakaian frontend saat ini masih sangat minimal

### Database dan tooling

- Laravel migration + seeder
- PHPUnit untuk test dasar
- Laravel Pint untuk formatting PHP

---

## 3. Gambaran arsitektur singkat

Secara sederhana arsitekturnya seperti ini:

1. Request masuk ke `routes/web.php`
2. Route diarahkan ke controller frontend atau admin
3. Controller mengambil data dari model Eloquent
4. Model membaca/menulis ke database
5. Data dikirim ke Blade view untuk dirender
6. Untuk admin panel, Filament resource langsung menangani form, tabel, filter, dan CRUD

Pola yang dipakai dominan:

- `MVC Laravel`
- `Service layer` untuk cart dan checkout
- `View Composer` untuk data global navigasi frontend
- `Filament Resource` untuk backoffice CRUD

---

## 4. Struktur project

```text
Akha-Interior/
|-- app/
|   |-- Filament/Back/
|   |-- Http/
|   |-- Models/
|   |-- Providers/
|   |-- Services/
|   |-- Support/
|   `-- View/
|-- bootstrap/
|-- config/
|-- database/
|   |-- factories/
|   |-- migrations/
|   `-- seeders/
|-- public/
|-- resources/
|   |-- css/
|   |-- js/
|   `-- views/
|-- routes/
|-- storage/
|-- tests/
|-- artisan
|-- composer.json
|-- package.json
|-- vite.config.js
`-- ONBOARDING_SUMMARY.md
```

---

## 5. Penjelasan setiap folder dan file inti

Catatan scope:
Dokumen ini fokus ke file aplikasi inti. File bawaan framework, cache, log, `vendor/`, dan asset generated Filament di `public/js/filament` / `public/css/filament` saya kelompokkan, karena fungsinya mostly framework-generated dan bukan business logic utama project.

### Root files

| File | Fungsi |
|---|---|
| `artisan` | Entry point command line Laravel. Dipakai untuk migrate, seed, serve, tinker, dsb. |
| `composer.json` | Dependency backend PHP. Menunjukkan stack utama: Laravel 10, Filament 3, Sanctum, Guzzle. |
| `package.json` | Dependency frontend/build tool. Saat ini hanya Vite, Axios, dan plugin Laravel Vite. |
| `vite.config.js` | Konfigurasi Vite untuk bundling asset. |
| `.env` | Konfigurasi environment lokal seperti app URL, DB, session, mail, dsb. |
| `.env.example` | Template environment untuk setup awal. |
| `phpunit.xml` | Konfigurasi test PHPUnit. |
| `README.md` | Masih dominan README bawaan Laravel, belum menjadi dokumentasi project yang lengkap. |

### `app/`

Folder utama business logic Laravel.

#### `app/Console/`

| File | Fungsi |
|---|---|
| `Kernel.php` | Registrasi command scheduler/console Laravel. |

#### `app/Exceptions/`

| File | Fungsi |
|---|---|
| `Handler.php` | Global exception handler Laravel. |

#### `app/Http/Controllers/Front/`

Controller untuk storefront publik.

| File | Fungsi |
|---|---|
| `HomeController.php` | Menyusun data homepage: banner aktif, kategori aktif, produk unggulan, produk terbaru, dan testimonial review. Juga melayani halaman about dan page dinamis berbasis slug. |
| `ShopController.php` | Menangani katalog produk: list produk dengan filter kategori, search, sorting, pagination, dan detail produk. |
| `CategoryController.php` | Menampilkan produk berdasarkan kategori tertentu. |
| `CartController.php` | Mengelola keranjang berbasis session: lihat cart, tambah item, update qty, hapus item, kosongkan cart. |
| `InquiryController.php` | Menampilkan form kontak dan menyimpan inquiry ke database. |

#### `app/Http/Controllers/Admin/`

Controller admin berbasis JSON/resource route.

| File | Fungsi |
|---|---|
| `CategoryController.php` | CRUD kategori via response JSON. |
| `ProductController.php` | CRUD produk via response JSON, termasuk validasi dan slug default. |
| `OrderController.php` | CRUD order via response JSON. Cocok sebagai API/admin endpoint sederhana. |

Catatan:
Area admin utama project sebenarnya lebih banyak dijalankan oleh Filament, jadi controller admin ini terasa seperti layer tambahan / alternatif API internal.

#### `app/Http/Middleware/`

| File | Fungsi |
|---|---|
| `AdminMiddleware.php` | Membatasi akses hanya untuk user admin aktif. |
| `Authenticate.php` | Middleware auth bawaan Laravel. |
| `EncryptCookies.php`, `VerifyCsrfToken.php`, `TrimStrings.php`, dll | Middleware standar request lifecycle Laravel. |
| `Kernel.php` | Registrasi global middleware dan route middleware termasuk alias `admin`. |

#### `app/Models/`

Berisi representasi tabel database dan relasi antar entitas.

| File | Fungsi |
|---|---|
| `User.php` | Model user. Punya role (`admin` / `customer`), status aktif, relasi ke address, cart, order, review, wishlist, serta izin akses panel Filament. |
| `Category.php` | Model kategori produk. Relasi `hasMany` ke product. |
| `Product.php` | Model inti katalog produk. Relasi ke category, images, variants, reviews, dan wishlist users. Menggunakan soft delete. |
| `ProductImage.php` | Gambar tambahan per produk. |
| `ProductVariant.php` | Varian produk seperti ukuran/warna, termasuk tambahan harga dan stok. |
| `Review.php` | Ulasan user ke produk, dengan flag approval. |
| `Banner.php` | Banner hero/storefront. |
| `Page.php` | Halaman statis dinamis berbasis slug. |
| `Setting.php` | Key-value settings sederhana. |
| `Inquiry.php` | Pesan masuk dari form kontak. |
| `Address.php` | Alamat user untuk pengiriman/order. |
| `Cart.php` | Keranjang database-level untuk user/session. |
| `CartItem.php` | Item dalam keranjang database (`carts_items`). |
| `Order.php` | Order utama, menyimpan total, status pembayaran, status order, invoice, notes, dan timestamp order. |
| `OrderItem.php` | Snapshot item order (`orders_items`) pada saat checkout. |
| `Payment.php` | Data pembayaran order. |
| `Wishlist.php` | Pivot-like model untuk produk favorit user. |

#### `app/Services/`

| File | Fungsi |
|---|---|
| `CartService.php` | Service untuk cart berbasis database: create/find cart, merge guest cart ke user, add/update/remove item, clear cart, hitung total. |
| `CheckoutService.php` | Service checkout yang mengubah cart menjadi order + order item + payment, lalu mengurangi stok dan mengosongkan cart. |

Catatan:
Ini menandakan arsitektur checkout yang lebih matang sudah disiapkan, walau belum sepenuhnya dipakai storefront aktif.

#### `app/Support/`

| File | Fungsi |
|---|---|
| `Money.php` | Helper format angka menjadi Rupiah. Banyak dipakai di Blade. |

#### `app/View/Composers/`

| File | Fungsi |
|---|---|
| `FrontComposer.php` | Menyuntikkan `navCategories` ke layout/navbar/footer frontend agar kategori selalu tersedia di navigasi. |

#### `app/Providers/`

| File | Fungsi |
|---|---|
| `AppServiceProvider.php` | Mendaftarkan `FrontComposer` untuk view frontend. |
| `RouteServiceProvider.php` | Routing bootstrap Laravel. |
| `AuthServiceProvider.php`, `BroadcastServiceProvider.php`, `EventServiceProvider.php` | Provider standar Laravel. |

#### `app/Providers/Filament/`

| File | Fungsi |
|---|---|
| `BackPanelProvider.php` | Konfigurasi panel admin Filament di path `/back`, termasuk auth, theme, resources, pages, dan widgets. |

#### `app/Filament/Back/Pages/`

| File | Fungsi |
|---|---|
| `Dashboard.php` | Halaman dashboard admin custom dengan widget statistik, chart, order terbaru, inquiry terbaru, dan stok menipis. |

#### `app/Filament/Back/Widgets/`

| File | Fungsi |
|---|---|
| `AdminStatsOverview.php` | Widget angka total produk, kategori, order, user, inquiry baru. |
| `AdminSalesOverview.php` | Widget omzet paid, payment pending, banner aktif, page aktif. |
| `SalesChart.php` | Grafik penjualan 6 bulan terakhir berdasarkan order berstatus paid. |
| `RecentOrders.php` | Tabel order terbaru di dashboard. |
| `RecentInquiries.php` | Tabel inquiry terbaru di dashboard. |
| `LowStockProducts.php` | Tabel produk dengan stok menipis. |

#### `app/Filament/Back/Resources/`

Ini adalah pusat CRUD admin panel.

| File | Fungsi |
|---|---|
| `CategoryResource.php` | Form dan tabel CRUD kategori. |
| `ProductResource.php` | CRUD produk lengkap, termasuk gallery dan variant via repeater. |
| `OrderResource.php` | Lihat/edit order dan statusnya. Create dinonaktifkan dari panel. |
| `PaymentResource.php` | Kelola data pembayaran order. |
| `InquiryResource.php` | Review inquiry customer dan update statusnya. Create dinonaktifkan dari panel. |
| `BannerResource.php` | CRUD banner homepage. |
| `PageResource.php` | CRUD halaman statis dinamis. |
| `SettingResource.php` | CRUD key-value settings. |
| `ReviewResource.php` | Moderasi review produk. Create dinonaktifkan dari panel. |
| `UserResource.php` | CRUD user admin/customer. |

#### `app/Filament/Back/Resources/*/Pages/`

| File pattern | Fungsi |
|---|---|
| `ManageCategories.php`, `ManageProducts.php`, dst | Halaman manage bawaan Filament untuk masing-masing resource. Biasanya hanya menjadi route/page wrapper untuk resource terkait. |

---

### `bootstrap/`

| File | Fungsi |
|---|---|
| `app.php` | Bootstrap aplikasi Laravel. |
| `cache/.gitignore` | Menjaga folder cache tetap ada di git tanpa menyimpan file cache runtime. |

### `config/`

Berisi konfigurasi framework Laravel.

| File | Fungsi |
|---|---|
| `app.php` | Konfigurasi aplikasi umum: nama app, locale, providers, timezone, dsb. |
| `auth.php` | Konfigurasi autentikasi. |
| `broadcasting.php` | Konfigurasi broadcast/event realtime. |
| `cache.php` | Konfigurasi cache. |
| `cors.php` | Konfigurasi CORS. |
| `database.php` | Konfigurasi koneksi database. |
| `filesystems.php` | Konfigurasi storage disk dan upload. |
| `hashing.php` | Konfigurasi hashing password. |
| `logging.php` | Konfigurasi log channel. |
| `mail.php` | Konfigurasi mail. |
| `queue.php` | Konfigurasi queue worker. |
| `sanctum.php` | Konfigurasi token auth Sanctum. |
| `services.php` | Konfigurasi service pihak ketiga. |
| `session.php` | Konfigurasi session. Penting karena cart frontend saat ini berbasis session. |
| `view.php` | Konfigurasi engine view Laravel. |

### `database/factories/`

| File | Fungsi |
|---|---|
| `UserFactory.php` | Factory user untuk test/seeding dummy. |

### `database/migrations/`

Definisi struktur database.

| File | Fungsi |
|---|---|
| `2014_10_12_000000_create_users_table.php` | Tabel user. |
| `2014_10_12_100000_create_password_reset_tokens_table.php` | Tabel reset password. |
| `2019_08_19_000000_create_failed_jobs_table.php` | Tabel failed queue jobs. |
| `2019_12_14_000001_create_personal_access_tokens_table.php` | Tabel token Sanctum. |
| `2026_04_23_163403_create_categories_table.php` | Tabel kategori. |
| `2026_04_23_163425_create_product_table.php` | Tabel produk utama. |
| `2026_04_23_163443_create_product_images_table.php` | Tabel galeri produk. |
| `2026_04_23_163459_create_product_variants_table.php` | Tabel varian produk. |
| `2026_04_23_163517_create_addresses_table.php` | Tabel alamat user. |
| `2026_04_23_163536_create_carts_table.php` | Tabel cart berbasis DB. |
| `2026_04_23_163550_create_carts_items_table.php` | Tabel item cart berbasis DB. |
| `2026_04_23_163606_create_orders_table.php` | Tabel order header. |
| `2026_04_23_163616_create_orders_items_table.php` | Tabel item order. |
| `2026_04_23_163931_create_payments_table.php` | Tabel pembayaran. |
| `2026_04_23_163954_create_wishlists_table.php` | Tabel wishlist. |
| `2026_04_23_164009_create_reviews_table.php` | Tabel review produk. |
| `2026_04_23_164026_create_banners_table.php` | Tabel banner storefront. |
| `2026_04_23_164038_create_pages_table.php` | Tabel halaman statis. |
| `2026_04_23_164108_create_settings_table.php` | Tabel setting key-value. |
| `2026_04_23_164129_create_inquiries_table.php` | Tabel pesan kontak customer. |

### `database/seeders/`

| File | Fungsi |
|---|---|
| `DatabaseSeeder.php` | Entry seeder utama, memanggil admin, kategori, dan produk. |
| `AdminSeeder.php` | Membuat/memperbarui admin default `admin@akha.inc`. |
| `CategorySeeder.php` | Seed 3 kategori awal. |
| `ProductSeeder.php` | Seed 3 produk sample yang ditautkan ke kategori. |

### `resources/views/`

Berisi Blade template untuk storefront.

#### `resources/views/front/layouts/`

| File | Fungsi |
|---|---|
| `app.blade.php` | Layout utama frontend: head, meta, font, Tailwind CDN, warna theme, navbar, footer, flash status. |

#### `resources/views/front/partials/`

| File | Fungsi |
|---|---|
| `navbar.blade.php` | Navbar desktop/mobile, kategori dropdown, indikator jumlah cart dari session. |
| `footer.blade.php` | Footer site dengan link navigasi dan kategori. |
| `product-card.blade.php` | Komponen card produk reusable untuk list/grid. |

#### `resources/views/front/`

| File | Fungsi |
|---|---|
| `home.blade.php` | Homepage storefront. |
| `about.blade.php` | Halaman tentang brand Akha. |
| `page.blade.php` | Halaman statis dinamis dari tabel `pages`. |
| `contact.blade.php` | Form kontak/inquiry. |

#### `resources/views/front/shop/`

| File | Fungsi |
|---|---|
| `index.blade.php` | Katalog produk dengan search, filter, sort, dan pagination. |
| `show.blade.php` | Detail produk, galeri, harga, stok, review, related products, dan add-to-cart. |

#### `resources/views/front/categories/`

| File | Fungsi |
|---|---|
| `show.blade.php` | Daftar produk per kategori. |

#### `resources/views/front/cart/`

| File | Fungsi |
|---|---|
| `index.blade.php` | Tampilan keranjang belanja dan ringkasan subtotal. |

#### file view lain

| File | Fungsi |
|---|---|
| `welcome.blade.php` | View default Laravel, tampaknya tidak dipakai oleh flow project utama. |

### `resources/js/`

| File | Fungsi |
|---|---|
| `app.js` | Entry JS Vite, hanya import bootstrap. |
| `bootstrap.js` | Setup Axios dan placeholder Laravel Echo. |

Catatan:
Frontend saat ini lebih banyak memakai CDN `Tailwind` dan `Alpine`, jadi folder JS masih sangat tipis.

### `resources/css/`

| File | Fungsi |
|---|---|
| `app.css` | File CSS Vite. Saat ini nyaris belum dipakai. |

### `routes/`

| File | Fungsi |
|---|---|
| `web.php` | Route utama storefront publik dan route admin JSON yang dilindungi auth+admin. Ini file routing paling penting di project ini. |
| `api.php` | Route API default Laravel. Saat ini hanya endpoint `auth:sanctum /user`. |
| `console.php` | Command closure console default Laravel. |
| `channels.php` | Definisi channel broadcast default user channel. |

### `public/`

| File/folder | Fungsi |
|---|---|
| `index.php` | Front controller web Laravel. |
| `favicon.ico`, `robots.txt` | Asset publik standar. |
| `js/filament/*`, `css/filament/*` | Asset generated/bundled untuk admin panel Filament. |

### `storage/`

| Folder | Fungsi |
|---|---|
| `app/` | Penyimpanan file aplikasi, termasuk potensi upload yang diserve via storage link. |
| `framework/` | Cache, session, compiled view, testing temp. |
| `logs/` | Log runtime Laravel. |

### `tests/`

| File | Fungsi |
|---|---|
| `TestCase.php` | Base test case Laravel. |
| `CreatesApplication.php` | Bootstrap app untuk test. |
| `Feature/ExampleTest.php` | Test feature bawaan yang hanya cek `/` return 200. |
| `Unit/ExampleTest.php` | Test unit placeholder default. |

### `vendor/`

Folder dependency Composer. Isinya package Laravel, Filament, dan library pihak ketiga. Tidak perlu disentuh kecuali debugging dependency.

---

## 6. Domain model / entitas utama

Entitas yang paling penting untuk dipahami:

- `Category` -> kelompok produk
- `Product` -> item furniture utama
- `ProductImage` -> galeri produk
- `ProductVariant` -> opsi varian produk
- `Review` -> testimoni/ulasan customer
- `Banner` -> konten hero homepage
- `Page` -> halaman statis dinamis
- `Inquiry` -> pesan dari calon customer
- `Cart` + `CartItem` -> keranjang berbasis DB
- `Order` + `OrderItem` -> transaksi pemesanan
- `Payment` -> data pembayaran order
- `Wishlist` -> favorit user
- `Address` -> alamat pengiriman
- `User` -> admin/customer

Relasi yang paling penting:

- `Category` punya banyak `Product`
- `Product` punya banyak `ProductImage`, `ProductVariant`, `Review`
- `User` punya banyak `Address`, `Order`, `Review`, `Wishlist`
- `Cart` punya banyak `CartItem`
- `Order` punya banyak `OrderItem` dan satu `Payment`

---

## 7. Dari mana dan ke mana aliran datanya

### A. Aliran data storefront katalog

Flow:

1. User membuka route seperti `/`, `/shop`, `/shop/{slug}`, `/categories/{slug}`
2. `routes/web.php` mengarahkan request ke controller frontend
3. Controller query ke model Eloquent
4. Model mengambil data dari tabel database
5. Data dikirim ke Blade view di `resources/views/front/*`
6. Blade merender HTML untuk browser

Contoh:

- `/` -> `HomeController@index`
- ambil `Banner`, `Category`, `Product`, `Review`
- render `front.home`

### B. Aliran data kategori global di navbar/footer

Flow:

1. Layout frontend dirender
2. `AppServiceProvider` memasang `FrontComposer`
3. `FrontComposer` mengambil kategori aktif dari DB
4. Data `navCategories` otomatis tersedia di navbar/footer

Ini membuat kategori navigasi tidak perlu diisi manual di setiap controller.

### C. Aliran data cart yang aktif saat ini

Flow aktif:

1. User klik "Tambah ke Keranjang" pada detail produk
2. Request `POST /cart/{product}` masuk ke `CartController@add`
3. Controller menyimpan item ke `session('cart.items')`
4. Saat halaman cart dibuka, `CartController@index` membaca session
5. Controller fetch detail produk dari DB berdasarkan ID yang ada di session
6. Controller hitung subtotal per item + subtotal total
7. Data dirender ke `front.cart.index`

Poin penting:

- cart aktif saat ini belum memakai tabel `carts` dan `carts_items`
- session adalah source of truth cart frontend saat ini

### D. Aliran data inquiry / contact form

Flow:

1. User buka `/contact`
2. `InquiryController@form` merender form
3. User submit form `POST /contact`
4. `InquiryController@store` memvalidasi input
5. Data disimpan ke tabel `inquiries` dengan status default `new`
6. User diarahkan balik ke halaman kontak dengan flash message
7. Admin bisa melihat dan mengelola data ini di Filament `InquiryResource`

### E. Aliran data admin panel Filament

Flow:

1. Admin login ke `/back`
2. `BackPanelProvider` mem-bootstrap panel Filament
3. `User::canAccessPanel()` memastikan hanya admin aktif yang bisa masuk
4. Filament resource mengambil data model masing-masing
5. Form/table Filament melakukan CRUD langsung ke database melalui Eloquent

Contoh:

- admin edit produk -> `ProductResource`
- data masuk ke model `Product`
- jika ada galeri/varian, relasi `images` dan `variants` ikut di-handle dari repeater Filament
- hasilnya langsung tersimpan ke tabel `product`, `product_images`, `product_variants`

### F. Aliran data checkout yang sudah disiapkan

Flow yang sudah tersedia di service layer:

1. `CartService` resolve cart user/guest dari DB
2. item cart disimpan di `carts` + `carts_items`
3. `CheckoutService` membaca cart
4. service membuat `Order`
5. service membuat `OrderItem` dari tiap item cart
6. service membuat `Payment`
7. service mengurangi stok produk/varian
8. service mengosongkan cart

Poin penting:

- flow ini sudah siap di level service dan model
- tetapi route/controller storefront yang memanggil flow checkout ini belum terlihat aktif di repo sekarang

---

## 8. Endpoint dan halaman penting

### Frontend

| URL | Fungsi |
|---|---|
| `/` | Homepage |
| `/about` | Tentang brand |
| `/page/{slug}` | Halaman statis dinamis |
| `/shop` | Katalog produk |
| `/shop/{slug}` | Detail produk |
| `/categories/{slug}` | Produk per kategori |
| `/cart` | Keranjang |
| `/contact` | Form kontak |

### Admin / backoffice

| URL | Fungsi |
|---|---|
| `/back` | Panel admin Filament |
| `/admin/categories` | Resource route JSON kategori |
| `/admin/products` | Resource route JSON produk |
| `/admin/orders` | Resource route JSON order |

---

## 9. Hal-hal yang perlu cepat dipahami saat onboarding

### 1. Ada dua layer admin

- `Filament` adalah admin panel utama yang paling siap dipakai
- `app/Http/Controllers/Admin/*` adalah endpoint CRUD JSON tambahan

### 2. Ada dua pendekatan cart

- cart aktif di storefront: `session-based`
- cart yang lebih matang di domain model/service: `database-based`

Kalau nanti kamu diminta mengerjakan checkout, sinkronisasi dulu apakah tim mau lanjut dari cart session yang ada, atau migrasi penuh ke `CartService`.

### 3. Data homepage sepenuhnya dinamis dari DB

Homepage bukan hardcoded penuh. Ia menarik:

- `banners`
- `categories`
- `featured products`
- `new products`
- `approved reviews`

### 4. Filament memegang banyak business CRUD

Kalau ada perubahan form admin, kemungkinan besar file yang harus dibuka adalah:

- `app/Filament/Back/Resources/*`

### 5. Frontend belum terlalu bergantung pada build pipeline

- view banyak memakai CDN Tailwind + Alpine
- `resources/js` dan `resources/css` masih minimal

---

## 10. Risiko / catatan teknis yang kelihatan dari codebase

- `README.md` belum mendokumentasikan project ini secara spesifik.
- `RecentInquiries` widget memakai mapping status `in_progress` dan `closed`, padahal migration/model inquiry memakai `new`, `read`, `replied`. Jadi ada mismatch kecil di layer dashboard widget.
- checkout service sudah ada, tetapi route/controller checkout storefront belum tersambung penuh.
- file asset `resources/js` dan `resources/css` belum banyak dipakai oleh UI utama karena frontend masih mengandalkan CDN.
- route admin JSON dan admin panel Filament berpotensi overlap secara fungsi; perlu dipahami mana yang memang dipakai tim.

---

## 11. Kesimpulan singkat

Project ini adalah aplikasi Laravel untuk brand furniture `Akha Interior` yang menggabungkan:

- storefront katalog publik
- admin panel Filament untuk operasional
- fondasi domain e-commerce seperti cart, order, payment, review, inquiry, dan wishlist

Kalau kamu baru onboarding, urutan file yang paling worth dibaca dulu adalah:

1. `routes/web.php`
2. `app/Http/Controllers/Front/*`
3. `app/Models/*`
4. `app/Filament/Back/Resources/*`
5. `database/migrations/*`
6. `resources/views/front/*`
7. `app/Services/CartService.php` dan `app/Services/CheckoutService.php`

Kalau diringkas satu kalimat:

> ini adalah katalog furniture Laravel + admin Filament, dengan storefront yang sudah berjalan dan fondasi checkout e-commerce yang sudah mulai dibangun tetapi belum seluruhnya terhubung ke flow frontend aktif
