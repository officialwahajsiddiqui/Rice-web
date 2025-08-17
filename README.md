# RiceProject

RiceProject is a PHP-based e-commerce web application for a rice trading business. It allows users to browse products, add them to a cart, place orders, and manage their accounts. The project includes both a customer-facing storefront and an admin dashboard for managing products, orders, and categories.

## Features

- User registration and login
- Product catalog with categories and product details
- Add to cart, update cart, and checkout functionality
- Order tracking and order confirmation
- Wishlist and popular products
- Admin dashboard for managing products, orders, and contacts
- Responsive design with modern UI

## Technologies Used

- PHP (procedural and PDO)
- MySQL (database)
- HTML5, CSS3, JavaScript, jQuery
- Bootstrap (for responsive design)

## Folder Structure

- `index.php` - Home page
- `shop-full-width.php` - Product listing/shop page
- `p_details.php` - Product details page
- `cart.php` - Shopping cart
- `checkout.php` - Checkout and order placement
- `wishlist.php` - Wishlist functionality
- `admin/` - Admin dashboard and management tools
- `assets/` - CSS, JS, images, and fonts
- `uploads/` - Uploaded product images

## Database Setup

1. Create a MySQL database named `rise_shop`.
2. Import the required tables: `users`, `products`, `category`, `orders`, `order_items`, etc.
3. Update database credentials in `connect.php` and `admin/db.php` if needed.

## Installation & Usage

1. Clone or download this repository to your XAMPP `htdocs` directory:
	```
	git clone https://github.com/officialwahajsiddiqui/Rice-web.git
	```
2. Start Apache and MySQL from XAMPP Control Panel.
3. Access the site at `http://localhost/RiceProject/` in your browser.
4. Register a new user or log in as admin (default credentials may be set in the database).

## Admin Dashboard

- Access via `http://localhost/RiceProject/admin/`
- Manage products, categories, orders, and view contact messages.

## Customization

- Update branding, images, and content in the `assets/` and `uploads/` folders.
- Modify styles in `assets/css/style.css`.

## License

This project is for educational purposes. Please check the template license for commercial use.