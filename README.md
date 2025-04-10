


# 🏗️ Warehouse Management System (PHP)

A lightweight PHP-based warehouse management system for handling inventory, categories, suppliers, and warehouse locations.

## 📁 Project Structure

```
WAREHOUSE_SYSTEM_PHP/
├── actions/
│   ├── add_category.php
│   ├── add_product.php
│   ├── add_supplier.php
│   ├── add_warehouse.php
│   ├── delete_product.php
│   └── edit_product.php
├── pages/
│   ├── categories.php
│   ├── products.php
│   ├── suppliers.php
│   └── warehouses.php
├── styles/               # CSS styles
├── db.php                # Database connection
└── index.php             # Main dashboard
```

## 🚀 Features

- **Categories**: Manage product categories
- **Products**: Add, edit, delete, and view products
- **Suppliers**: Keep track of suppliers
- **Warehouses**: Manage warehouse locations

## ⚙️ Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/warehouse-system-php.git
   ```

2. Place it inside your web server's root directory (e.g. `htdocs` for XAMPP).

3. Import the database:
   - Import your `.sql` file (if available) into phpMyAdmin.

4. Configure `db.php` with your database credentials:
   ```php
   $conn = new mysqli("localhost", "username", "password", "database_name");
   ```

5. Start your server and open `http://localhost/warehouse-system-php/` in your browser.

## 💡 Notes

- No frameworks required – just core PHP.
- Compatible with any basic LAMP/WAMP stack.

## 📫 Contact

For questions or feedback, feel free to reach out: [dobrygeorgiev300@gmail.com]

---

Happy Warehousing! 📦
