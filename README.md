# Saylors-Mirissa (Laravel)

This repository is a Laravel application. Below are concise setup, migration, and seeding instructions so you can get the database and dev environment running locally.

## Prerequisites

- PHP (8.x recommended)
- Composer
- Node.js + npm (for building assets)
- A database (MySQL, Postgres, or SQLite)

## Quick setup

1. Install PHP dependencies

```bash
composer install
```

2. Install frontend deps and build (optional for dev)

```bash
npm install
npm run dev
```

3. Environment

Copy or create your `.env` file and configure DB settings. If the repo contains an `.env.example` file:

```bash
cp .env.example .env
```

Ensure database credentials in `.env` are correct. For SQLite you can create a file:

```bash
touch database/database.sqlite
# then set DB_CONNECTION=sqlite in .env
```

4. Generate the app key

```bash
php artisan key:generate
```

## Migrate and seed

Run all migrations and seeders in one command:

```bash
php artisan migrate --seed
```

Alternative: migrate and then seed explicitly

```bash
php artisan migrate
php artisan db:seed
```

Run a single seeder class (examples in this repo):

```bash
php artisan db:seed --class=ExperienceSeeder
php artisan db:seed --class=MapPointSeeder
php artisan db:seed --class=RoomSeeder
```

Reset and re-seed the database (dangerous: drops all tables):

```bash
php artisan migrate:fresh --seed
```

Rollback the last migration batch:

```bash
php artisan migrate:rollback
```

## Useful commands

- Create storage symlink for public access to storage files:

```bash
php artisan storage:link
```

- Run the built-in dev server:

```bash
php artisan serve
```

- Run tests (Pest or PHPUnit):

```bash
./vendor/bin/pest
# or
php artisan test
```

## Seeders in this repository

Look in `database/seeders/` for available seeders. At time of writing this repo includes:

- `DatabaseSeeder.php`
- `ExperienceSeeder.php`
- `MapPointSeeder.php`
- `RoomSeeder.php`

Run specific seeders with `php artisan db:seed --class=YourSeederClass` as shown above.

## Troubleshooting

- If migrations fail with SQL errors, verify `.env` DB credentials and that the database exists.
- For permission errors when writing to `storage` or `bootstrap/cache`, run:

```bash
sudo chown -R $USER:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache
```

- If you change `.env`, restart services or re-run `php artisan config:clear` and `php artisan cache:clear`:

```bash
php artisan config:clear
php artisan cache:clear
```

## Next steps

- After migrations and seeding, visit the app via `php artisan serve` or your configured web server.
- If you'd like, I can: run migrations on this machine, create a script to automate setup, or add a Docker setup — tell me which.

---

