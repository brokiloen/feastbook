# Feastbook - Medieval Recipe Collection

Laravel 12 app with PostgreSQL, Nginx, Blade templates, and Tailwind CSS (CDN).

## Local Development

```bash
docker-compose up -d
docker-compose exec app php artisan migrate --seed
# App: http://localhost:8080
# Admin: http://localhost:8080/admin (admin@feastbook.local / password)
```

Docker services: app (PHP-FPM 8.3), nginx (:8080), postgres (:5432).
Local DB: host=postgres, db=feastbook, user=feastbook, pass=secret.

## Production (AWS EC2)

- **Host:** 52.57.164.88 (feastbook.iivanov.net)
- **SSH:** `ssh feastbook` (alias configured in ~/.ssh/config, key at ~/keys/feastbook.pem)
- **Web root:** /var/www/feastbook
- **OS:** Amazon Linux 2023
- **Stack:** Nginx + PHP-FPM 8.3 + PostgreSQL 18 (all systemd services)
- **Storage:** recipe images in storage/app/public/recipes/, symlinked to public/storage

### Deploying

Push to `master` triggers GitHub Actions CI/CD (.github/workflows/deploy.yml).
It pulls code, runs composer/npm install, builds assets, runs migrations, clears caches, reloads php-fpm.

### Production Logs

```bash
ssh feastbook "tail -f /var/www/feastbook/storage/logs/laravel.log"  # Laravel
ssh feastbook "sudo tail -f /var/log/nginx/error.log"                # Nginx
ssh feastbook "sudo tail -f /var/log/php-fpm/www-error.log"          # PHP-FPM
```

### Service Management

```bash
ssh feastbook "sudo systemctl restart nginx|php-fpm|postgresql"
```

### File Permissions

Owner: ec2-user:nginx. Storage and bootstrap/cache must be 775.

## Key Routes

- / (home), /recipe/{slug} (detail), /login, /admin, /admin/recipes, /admin/categories

## Project Structure

- Controllers: app/Http/Controllers/ (public) and Admin/ (CRUD)
- Models: Recipe, Category (many-to-many), Ingredient
- Views: resources/views/ (layouts/public.blade.php, layouts/admin.blade.php)
- Recipes have: name, slug (auto-generated), description, instructions (rich text), photo, servings, last_made, categories, ingredients (with sections)
