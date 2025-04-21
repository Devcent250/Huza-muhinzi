# Huza Muhinzi

Huza Muhinzi is a web application that connects farmers with suppliers and cooperative members to facilitate agricultural trade in Rwanda.

## Features

- Multi-role user system (Admin, Farmer, Supplier, Cooperative Member)
- Product management for farmers
- Order processing system
- Real-time notifications
- SMS and USSD accessibility
- Multilingual support (English and Kinyarwanda)

## Requirements

- PHP 8.1 or higher
- MySQL 5.7 or higher
- Composer
- Node.js & NPM

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Devcent250/Huza-muhinzi.git
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy the example environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in the .env file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=huza_muhinzi
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run database migrations:
```bash
php artisan migrate
```

7. Start the development server:
```bash
php artisan serve
```

## Usage

- Farmers can list their products and manage orders
- Suppliers can browse products and place orders
- Cooperative members can manage their cooperative's activities
- Admins can oversee all system activities

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Contact

Vincent NIYONSHUTI - [@Devcent250](https://github.com/Devcent250)
