# 🛒 PHP E-Commerce Mini Website

| Field | Details |
|------|--------|
| Name | Kapil Chauhan |
| Enrollment Number | 250905091004 |
| Subject | Fundamentals of Web Development (FWD) |
| ALA | Mini Project ALA |

---

## 📌 Project Overview

This is a fully functional **dynamic e-commerce mini website** built using **Core PHP** and **MySQL**, developed as part of a college activity learning assignment. The project demonstrates real-world concepts including:

- **CRUD Operations** — Create, Read, Update, Delete products via an admin panel
- **Session Management** — Admin login authentication and session-based shopping cart
- **Form Handling with Validation** — Server-side validation on all forms
- **Database-Driven Display** — All product data is fetched dynamically from MySQL
- **Image Upload** — Admin can upload JPG product images (min 300×200px, max 5MB)
- **Responsive UI** — Clean, mobile-friendly interface with no external CSS framework

The project covers the complete e-commerce flow: product listing for users, a shopping cart, and a full admin panel for product management.

---

## ✨ Features Implemented

| # | Feature | Details |
|---|---------|---------|
| 1 | **User-Facing Product Listing** | All products fetched from DB and displayed in a responsive grid |
| 2 | **Admin Login / Logout** | Session-based authentication with credentials stored in MySQL |
| 3 | **Add Product (CREATE)** | Admin form to add a new product with image upload |
| 4 | **View Products (READ)** | Admin table listing all products from the database |
| 5 | **Edit Product (UPDATE)** | Inline edit form pre-filled from DB, updates on submit |
| 6 | **Delete Product (DELETE)** | Admin can remove any product with a confirmation prompt |
| 7 | **Session-Based Cart** | Users add/remove items; cart persists across pages via PHP `$_SESSION` |
| 8 | **Clear Cart** | Full cart reset in a single click |
| 9 | **Form Validation** | Required fields, price format checks, image type/size constraints |
| 10 | **Auto Database Setup** | `config/db.php` auto-creates the DB and tables on first run |
| 11 | **Reusable Includes** | Shared `header.php` and `footer.php` across all pages |
| 12 | **SQL Dump** | `database/ecommerce.sql` provided for manual import |

---

## 🗂️ Folder Structure

```
php-ecommerce-mini/
│
├── config/
│   └── db.php                  # Database connection + auto-setup
│
├── database/
│   └── ecommerce.sql           # SQL file to create tables and seed data
│
├── assets/
│   ├── css/
│   │   └── style.css           # Global stylesheet
│   ├── js/
│   │   └── script.js           # Client-side interactions
│   └── images/                 # Uploaded product images stored here
│
├── admin/
│   ├── dashboard.php           # Admin home page
│   ├── products.php            # List all products (READ)
│   ├── add_product.php         # Add a new product (CREATE)
│   ├── edit_product.php        # Edit an existing product (UPDATE)
│   └── delete_product.php      # Delete a product (DELETE)
│
├── user/
│   ├── add_to_cart.php         # Add item to session cart
│   ├── cart.php                # View and manage cart
│   ├── remove_from_cart.php    # Remove single item from cart
│   └── clear_cart.php          # Clear entire cart
│
├── includes/
│   ├── header.php              # Reusable navigation header
│   └── footer.php              # Reusable page footer
│
├── index.php                   # Homepage — dynamic product listing
├── login.php                   # Admin login page
├── logout.php                  # Session destroy + redirect
├── setup_images.php            # Utility: placeholder image setup
└── README.md                   # Project documentation
```

---

## 🗃️ Database Structure

**Database Name:** `ecommerce_mini`

### Table: `users`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Unique user ID |
| `username` | VARCHAR(50) | NOT NULL | Login username |
| `password` | VARCHAR(255) | NOT NULL | Password (plain text for academic demo) |
| `role` | VARCHAR(20) | DEFAULT `'admin'` | User role |

**Default Admin Credentials:**
- **Username:** `admin`
- **Password:** `admin123`

---

### Table: `products`

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| `id` | INT | PRIMARY KEY, AUTO_INCREMENT | Unique product ID |
| `name` | VARCHAR(100) | NOT NULL | Product name |
| `price` | DECIMAL(10,2) | NOT NULL | Product price |
| `description` | TEXT | — | Product description |
| `image` | VARCHAR(255) | — | Image path (uploaded file) |
| `created_at` | TIMESTAMP | DEFAULT CURRENT_TIMESTAMP | Record creation time |

---

## ▶️ How to Run the Project Locally

### Prerequisites

- [Laragon](https://laragon.org/) (includes Apache, PHP, MySQL, phpMyAdmin)
- A modern web browser

### Step-by-Step Setup

**1. Clone the repository:**
```bash
git clone https://github.com/<your-username>/php-ecommerce-mini.git
```

**2. Move to Laragon's web root:**
```
Place the folder at: C:\laragon\www\php-ecommerce-mini\
```

**3. Start Laragon:**
- Open Laragon and click **"Start All"** to start Apache and MySQL.

**4. Import the database (choose one method):**

**Option A — Auto Setup (Recommended):**
Simply open the site in your browser. `config/db.php` will automatically create the `ecommerce_mini` database, tables, and seed data on first run.

**Option B — Manual SQL Import:**
- Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Create a database named `ecommerce_mini`
- Click **Import** → select `database/ecommerce.sql` → click **Go**

**5. Open the website:**
```
http://localhost/php-ecommerce-mini/
```

**6. Admin Login:**
```
URL:       http://localhost/php-ecommerce-mini/login.php
Username:  admin
Password:  admin123
```

---

## 🔄 Application Workflow

```
User visits homepage (index.php)
    └── Products fetched from MySQL → displayed in grid
    └── User clicks "Add to Cart" → stored in $_SESSION['cart']
    └── User views cart (user/cart.php) → can remove or clear items

Admin visits login page (login.php)
    └── Submits credentials → verified against `users` table in DB
    └── On success: $_SESSION['admin'] = true → redirect to dashboard
    └── Admin Dashboard → links to all CRUD operations

    ┌── Add Product    → form → validation → INSERT into products table
    ├── View Products  → SELECT all from products table
    ├── Edit Product   → form pre-filled from DB → UPDATE products table
    └── Delete Product → confirmation → DELETE from products table

Admin clicks Logout (logout.php)
    └── session_destroy() → redirect to login page
```

---

## 🛠️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Backend** | PHP 8.x (Core PHP, no framework) |
| **Database** | MySQL via MySQLi extension |
| **Frontend** | HTML5, CSS3, Vanilla JavaScript |
| **Server** | Apache (via Laragon) |
| **DB GUI** | phpMyAdmin (via Laragon) |

---

## 🔑 Key Concepts Demonstrated

- **PHP & MySQL Integration** using `mysqli_connect()`, `mysqli_query()`, `mysqli_fetch_assoc()`
- **CRUD Operations** — full Create, Read, Update, Delete for products
- **Session Management** — `session_start()`, `$_SESSION` for login state and cart
- **Form Handling** — `$_POST` / `$_GET` with server-side validation
- **File Uploads** — `$_FILES` with MIME type and dimension validation
- **Prepared Statements** concept demonstrated via query structuring
- **Separation of Concerns** — config, includes, admin, user separated into folders

---

## 📸 Screenshots

| Page | Description |
|------|-------------|
| Homepage | Product grid with "Add to Cart" buttons |
| Admin Login | Secure login form with validation |
| Admin Dashboard | Quick links to all management pages |
| Add Product | Form with live image preview and upload |
| Edit Product | Pre-filled form loaded from database |
| Product List (Admin) | Table with Edit / Delete actions |
| Shopping Cart | Session cart with quantity and total |

---

## ⚠️ Notes

- Passwords are stored as **plain text** in this project — intentional for academic demo simplicity. In production, use `password_hash()` and `password_verify()`.
- The `assets/images/` folder stores uploaded product images and is excluded from `.gitignore` patterns except for a `.gitkeep` placeholder.
- Database credentials in `config/db.php` are set to Laragon defaults (`root` / no password). Update if your setup differs.

---

## 👨‍💻 Author

*Submitted as part of Activity Learning Assignment — Dynamic E-Commerce Mini Website*  
*Course: Web Development using PHP & MySQL*  
*Institution: GMIU*
