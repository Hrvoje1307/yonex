# 🏸 Sports Equipment E-commerce Website

A modern and responsive e-commerce platform for selling **badminton and tennis equipment**. Designed to provide users with a smooth and secure online shopping experience.

---

## ✨ Features

- ✅ Clean and user-friendly interface
- 🛍️ Product listing with images and detailed descriptions
- 🔐 Login, registration, and secure session management
- 📱 Responsive design (mobile, tablet, desktop)
- 🔎 Search functionality and category filtering
- 🛒 Shopping cart with quantity adjustment
- ❤️ Wishlist (favorites) system
- 👨‍💼 Admin dashboard for managing users and orders

---

## 🛠️ Technologies Used

- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Backend:** PHP (Object-Oriented Programming)
- **Database:** MySQL

---

## ⚙️ Installation

1. **Clone the repository**:

   ```bash
   git clone https://github.com/Hrvoje1307/yonex
   ```

2. **Start your local server** (XAMPP, WAMP, MAMP, etc.)

3. **Import the database**:

   - Locate `app/config/database.sql`
   - Import it into your MySQL server via phpMyAdmin or CLI

4. **Add environment config**:

   - Place the `.env` file in `app/classes/`
   - Inside `.env`, add your database credentials:
     ```
     DB_HOST=localhost
     DB_NAME=your_db_name
     DB_USER=your_username
     DB_PASS=your_password
     ```

5. **Access the site**:
   - Open your browser and go to `http://localhost/yonex` (or the corresponding folder)

---

## 🚀 Usage

- Browse and search for badminton or tennis equipment
- Add products to your favorites
- Modify product quantities in the cart
- Proceed to checkout (payment gateway ready for integration)

---

## 📂 File Structure Overview

```
/app
  /classes          → PHP classes (DB connection, User, Product...)
  /config           → DB SQL dump and config files
/assets             → Images, CSS, JS
/public             → Main entry (index.php, cart, product pages...)
/README.md
/LICENSE.txt
```

---

## 📩 Contact

For questions, feedback or licensing inquiries:

- 📧 Email: [cuckovichrvoje@gmail.com](mailto:cuckovichrvoje@gmail.com)
- 💼 LinkedIn: [Hrvoje Čučković](https://www.linkedin.com/in/hrvoje-%C4%8Du%C4%8Dkovi%C4%87-061a1b211/)

---

## 🛡️ License & Usage

This project is licensed for **personal or educational use only**.  
Commercial use, resale, or redistribution is **strictly prohibited**  
without written permission from the author.

To request commercial licensing, please contact:  
📧 [cuckovichrvoje@gmail.com](mailto:cuckovichrvoje@gmail.com)
