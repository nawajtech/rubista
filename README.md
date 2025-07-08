# Rubista - E-commerce Platform

A modern e-commerce platform built with Laravel 12, featuring category-wise product management, user authentication, and admin panel.

## Features

### Frontend Features
- **Homepage**: Displays featured products, latest products, and categories
- **Product Catalog**: Browse products by category with pagination
- **Product Details**: Detailed product pages with related products
- **Search**: Search functionality across products
- **User Authentication**: Registration and login system
- **Responsive Design**: Mobile-friendly interface with Bootstrap 5

### Admin Panel Features
- **Dashboard**: Statistics and overview of products, categories, and users
- **Category Management**: CRUD operations for product categories
- **Product Management**: Complete product management with image uploads
- **User Management**: View registered users
- **Admin Authentication**: Secure admin access with middleware protection

### Technical Features
- **Laravel 12**: Latest Laravel framework
- **Modern UI**: Bootstrap 5 with Bootstrap Icons
- **Image Handling**: File upload and storage management
- **Database Relations**: Proper model relationships
- **Validation**: Form validation and error handling
- **SEO Friendly**: Clean URLs with slugs
- **Middleware Protection**: Admin routes protection

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- MySQL/MariaDB
- Node.js and npm (for asset compilation)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd Rubista
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database configuration**
   - Update your `.env` file with database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=rubista
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

5. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Create storage link**
   ```bash
   php artisan storage:link
   ```

7. **Compile assets**
   ```bash
   npm run dev
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Credentials

### Admin Account
- **Email**: admin@rubista.com
- **Password**: password

### User Account
- **Email**: user@rubista.com
- **Password**: password

## Project Structure

```
Rubista/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/           # Admin controllers
│   │   │   ├── AuthController.php
│   │   │   └── HomeController.php
│   │   └── Middleware/
│   │       └── AdminMiddleware.php
│   └── Models/
│       ├── Category.php
│       ├── Product.php
│       └── User.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── admin/               # Admin panel views
│       ├── auth/                # Authentication views
│       └── layouts/             # Layout templates
└── routes/
    └── web.php
```

## Database Schema

### Users Table
- `id` - Primary key
- `name` - User's full name
- `email` - User's email (unique)
- `password` - Hashed password
- `is_admin` - Admin flag (boolean)
- `timestamps`

### Categories Table
- `id` - Primary key
- `name` - Category name
- `slug` - URL-friendly slug (unique)
- `description` - Category description
- `image` - Category image path
- `status` - Active/inactive status
- `timestamps`

### Products Table
- `id` - Primary key
- `name` - Product name
- `slug` - URL-friendly slug (unique)
- `description` - Full product description
- `short_description` - Brief description
- `price` - Regular price
- `sale_price` - Sale price (optional)
- `sku` - Stock keeping unit (unique)
- `stock_quantity` - Available quantity
- `image` - Product image path
- `gallery` - Additional images (JSON)
- `status` - Active/inactive status
- `featured` - Featured product flag
- `category_id` - Foreign key to categories
- `timestamps`

## Routes

### Frontend Routes
- `GET /` - Homepage
- `GET /category/{slug}` - Category products
- `GET /product/{slug}` - Product details
- `GET /search` - Search results
- `GET /login` - Login form
- `GET /register` - Registration form

### Admin Routes (Protected)
- `GET /admin` - Admin dashboard
- `GET /admin/categories` - Categories listing
- `GET /admin/products` - Products listing
- All CRUD operations for categories and products

## Features in Detail

### Category Management
- Create, read, update, delete categories
- Image upload for categories
- Slug generation
- Status management (active/inactive)
- Product count tracking

### Product Management
- Full CRUD operations
- Image upload and management
- Category assignment
- Pricing with sale prices
- Stock management
- Featured product designation
- SEO-friendly URLs

### User Management
- Registration and login
- Admin/user role distinction
- Password hashing
- Session management

### Search and Filtering
- Product search by name and description
- Category-based filtering
- Pagination for large datasets

## Customization

### Adding New Features
1. Create new models with `php artisan make:model ModelName -m`
2. Create controllers with `php artisan make:controller ControllerName`
3. Add routes in `routes/web.php`
4. Create corresponding views

### Styling
- Modify `resources/css/app.css` for custom styles
- Bootstrap 5 classes are available throughout
- Update layouts in `resources/views/layouts/`

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support, please open an issue in the repository or contact the development team.

---

**Built with ❤️ using Laravel 12**
