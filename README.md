# Feastbook - Medieval Recipe Collection

A Laravel-based recipe management application with a medieval theme.

## Requirements

- Docker & Docker Compose

## Quick Start

1. **Start the containers:**
   ```bash
   docker-compose up -d
   ```

2. **Run migrations and seed the database:**
   ```bash
   docker-compose exec app php artisan migrate --seed
   ```

3. **Access the application:**
   - **Public site:** http://localhost:8080
   - **Admin panel:** http://localhost:8080/admin

## Default Admin Credentials

- **Email:** admin@feastbook.local
- **Password:** password

## Features

### Public Features
- Browse all recipes on the home page with card layout
- View detailed recipe pages with:
  - Recipe photo and description
  - Category badge and last made date
  - Interactive ingredient checkboxes (state saved in browser)
  - Step-by-step cooking instructions

### Admin Features
- Dashboard with recipe and category stats
- Full CRUD for recipes:
  - Name, description, and cooking instructions
  - Photo upload
  - Category assignment
  - Last made date tracking
  - Dynamic ingredient management with metric units (g, kg, ml, L, pcs, tbsp, tsp)
- Category management (create, edit, delete)

## Tech Stack

- **Backend:** Laravel 12 with Blade templates
- **Database:** PostgreSQL 18
- **Web Server:** Nginx
- **CSS:** Tailwind CSS (via CDN)
- **Authentication:** Laravel Breeze

## Database Schema

| Table | Description |
|-------|-------------|
| users | Admin authentication |
| categories | Recipe categories (Appetizers, Main Courses, etc.) |
| recipes | Recipe details with photo, description, instructions |
| ingredients | Recipe ingredients with quantity and metric units |

## Docker Services

| Service | Container | Port |
|---------|-----------|------|
| PHP-FPM | feastbook-app | 9000 (internal) |
| Nginx | feastbook-nginx | 8080 |
| PostgreSQL | feastbook-postgres | 5432 |

## Common Commands

```bash
# Start containers
docker-compose up -d

# Stop containers
docker-compose down

# View logs
docker-compose logs -f

# Run artisan commands
docker-compose exec app php artisan <command>

# Fresh migration with seeders
docker-compose exec app php artisan migrate:fresh --seed

# Clear all caches
docker-compose exec app php artisan optimize:clear
```

## Replacing Placeholder Images

Replace the following files with your own images:
- `public/images/header-medieval.jpg` - Header banner image (recommended: 1920x600)
- `public/images/logo.svg` - Site logo (SVG or replace with PNG/JPG)

## Project Structure

```
feastbook/
├── app/
│   ├── Http/Controllers/
│   │   ├── RecipeController.php        # Public recipe pages
│   │   └── Admin/
│   │       ├── DashboardController.php
│   │       ├── RecipeController.php
│   │       └── CategoryController.php
│   └── Models/
│       ├── Recipe.php
│       ├── Category.php
│       └── Ingredient.php
├── database/
│   ├── migrations/                      # Database schema
│   └── seeders/                         # Sample data with 4 medieval recipes
├── resources/views/
│   ├── layouts/
│   │   ├── public.blade.php            # Public layout with medieval theme
│   │   └── admin.blade.php             # Admin panel layout
│   ├── home.blade.php                   # Recipe card grid
│   ├── recipes/show.blade.php           # Single recipe with ingredients & instructions
│   └── admin/
│       ├── dashboard.blade.php
│       ├── recipes/                     # Recipe CRUD views
│       └── categories/                  # Category CRUD views
├── public/images/                       # Logo and header images
├── docker/                              # Docker configuration
└── docker-compose.yml
```

## License

This project is open-sourced software.
