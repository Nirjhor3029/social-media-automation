# 🚀 Social Media Automation

A powerful and elegant social media automation tool built with Laravel. This application helps you manage and automate your social media presence with ease.

---

## 🛠️ Installation & Setup

Follow these steps to get the project up and running on your local machine or server.

### 1. Extract & Place
Extract the project archive and move it to your desired web server directory (e.g., `laragon/www/social-media-automation`).

### 2. Environment Configuration
Copy the example environment file to create your `.env` file:
```bash
cp .env.example .env
```
Now, open the `.env` file and configure your database credentials and other settings:
```env
DB_DATABASE=social_media_db
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Install Dependencies
Run composer to install the required PHP packages:
```bash
composer install
```

### 4. Database Migration & Seeding
Run the migrations and seed the database. **Note:** Seeding is crucial as it creates the initial administrative user.
```bash
php artisan migrate --seed
```

### 5. Generate Application Key
Generate a unique application key for security:
```bash
php artisan key:generate
```

### 6. Storage Link
If your project uses file or photo fields, create a symbolic link from `public/storage` to `storage/app/public`:
```bash
php artisan storage:link
```

---

## 🔐 Default Credentials

Once installed, you can log in using the following administrative credentials:

- **Username:** `admin@admin.com`
- **Password:** `password`

---

## 💡 Support & Documentation

For more information, troubleshooting common errors, or detailed guides, please refer to the official documentation.

- [Laravel Documentation](https://laravel.com/docs)
- [Project Installation Guide](https://example.com/docs/installation) *(Update with actual link if available)*

---

### 📝 License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
