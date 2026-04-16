<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Inventory Audit Facilitation System
A web-based Inventory Audit Facilitation System built with Laravel (backend) and Vue.js (frontend). This system streamlines inventory tracking, auditing, and data entry through multiple input methods including manual entry, barcode scanning, and Excel import.

## 🚀 Features
### 📦 Inventory Management
- Add and manage inventory items efficiently
- Store detailed information for each item
- View and track inventory records in real-time
### 📝 Data Entry Methods
#### Manual Entry
- Backend form to insert individual inventory items
- User-friendly interface for entering item details
#### Barcode Scanning
- Scan item barcodes using device camera
- Automatically fetch and store item details
- Works on both desktop (with scanner) and mobile browsers
#### Excel Import
- Upload Excel files to bulk insert inventory data
- Supports structured templates for seamless import
- Reduces manual data entry effort
## 👥 User Roles & Access Control
### Super Admin
- Full system access
- Manage users and roles
- View and control all inventory records
### User
- Limited access based on permissions
- Add, scan, and view inventory items
- Perform audit-related tasks

## 📱 Mobile Accessibility
- Fully accessible via mobile browsers
- Optimized for on-the-go barcode scanning
- No need for a separate mobile application

## 🛠️ Tech Stack
- Backend: Laravel
- Frontend: Vue.js
- Database: MySQL (or compatible)
- Other Tools:
  * Barcode scanning libraries (e.g., QuaggaJS / similar)
  * Excel import handling (e.g., Laravel Excel)

## 📂 Core Functionalities
- Inventory item creation and management
- Barcode-based quick entry system
- Bulk upload via Excel files
- Role-based authentication and authorization
- Mobile-responsive interface

## Usage
### Login as Super Admin or User
- Add inventory items using:
  * Manual form
  * Barcode scanner
  * Excel upload
- View and manage inventory records
- Perform audit operations efficiently

## 🔐 Authentication
- Role-based login system
- Secure access control for different user types

## 📌 Future Enhancements
- Advanced reporting and analytics
- Export inventory reports (PDF/Excel)
- Integration with external inventory systems
- Offline scanning support
