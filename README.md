# 🛒 CaggyShop - Toko Kebutuhan Game Online

![CaggyShop Preview](https://via.placeholder.com/1200x600/667eea/ffffff?text=CaggyShop+-+Toko+Kebutuhan+Game)

[![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)](https://mysql.com)
[![Midtrans](https://img.shields.io/badge/Payment-Midtrans_Snap-green)](https://midtrans.com)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

**CaggyShop** adalah platform e-commerce khusus untuk memenuhi kebutuhan para gamer, seperti pembelian Robux dan item Roblox. Website ini dibangun dengan PHP Native, MySQL, dan terintegrasi dengan **Midtrans Snap** sebagai payment gateway.

> ⚡ **Dibuat dengan fokus pada kemudahan penggunaan, keamanan, dan tampilan modern.**

---

## ✨ Fitur Unggulan

### 🛒 **Untuk Pembeli**
| Fitur | Deskripsi |
|-------|-----------|
| **Halaman Produk** | Tampilan produk dalam bentuk card dengan gambar, nama, harga, dan tombol beli |
| **Form Pembelian** | Input data pembeli: Nickname, ID Game, dan Nomor WhatsApp |
| **Pembayaran Mudah** | Terintegrasi **Midtrans Snap** (Transfer Bank, Kartu Kredit, E-Wallet, Indomaret, Alfamart, dll) |
| **Notifikasi Otomatis** | Redirect ke WhatsApp Admin dengan format pesan otomatis setelah pembayaran sukses |
| **Tampilan Responsif** | Desain modern dengan gradasi biru-ungu, mobile friendly |

### 🔐 **Untuk Admin**
| Fitur | Deskripsi |
|-------|-----------|
| **Login Aman** | Sistem autentikasi dengan session dan password ter-hash |
| **Dashboard Admin** | Antarmuka khusus untuk mengelola toko |
| **Manajemen Produk** | Tambah, edit, hapus produk dengan upload gambar |
| **Manajemen Transaksi** | Lihat semua transaksi, update status pembayaran (pending/paid/failed) |
| **Nomor Otomatis** | Generate nomor pesanan otomatis format: `INV-XXXX` |

---

## 🚀 Teknologi yang Digunakan

| Bagian | Teknologi |
|--------|-----------|
| **Frontend** | HTML5, CSS3, JavaScript (Vanilla), Google Fonts (Poppins) |
| **Backend** | PHP 7.4+ (Native) |
| **Database** | MySQL 5.7+ |
| **Payment Gateway** | Midtrans Snap (Production & Sandbox) |
| **Web Server** | Apache / Nginx |

---

## 📋 Persyaratan Sistem

- ✅ PHP 7.4 atau lebih tinggi
- ✅ MySQL 5.7 atau lebih tinggi
- ✅ Web Server (Apache / Nginx)
- ✅ Akun Midtrans ([Daftar di sini](https://midtrans.com))

---

## 🔧 Panduan Installasi Lengkap

### 📥 1. Clone Repository
```bash
git clone https://github.com/caggyid/caggyshop.git
cd caggyshop
