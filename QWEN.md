# SPK-WASPAS - Decision Support System using WASPAS Method

## Project Overview

SPK-WASPAS is a web-based Decision Support System (Sistem Pendukung Keputusan) built with the Laravel PHP framework that implements the WASPAS (Weighted Aggregated Sum Product Assessment) method. This system is designed for multi-criteria decision making, particularly for candidate selection processes where various attributes need to be evaluated quantitatively.

The application focuses on personnel selection or candidate evaluation with features for managing criteria, candidates, ratings, and the WASPAS calculation process. It includes role-based access control with permissions and a hierarchical menu system.

### Architecture & Technologies

- **Backend Framework:** Laravel 10.x
- **Frontend Framework:** Vite, Tailwind CSS, Alpine.js
- **Livewire:** For dynamic UI components and real-time interactions
- **Livewire Volt:** Additional Livewire functionality
- **Database:** MySQL (can be configured with other databases)
- **Authentication:** Laravel Breeze
- **Authorization:** Spatie Laravel Permission package
- **Testing:** PHPUnit

### Core Features

1. **Dashboard** - Central overview of the system
2. **User Management** - Role-based access with permissions
3. **Candidate Management (Kandidat)** - Manage candidates with detailed profiles including NIP, personal details, education, position details
4. **Criteria Management (Kriteria)** - Define evaluation criteria with weights
5. **Rating System (Penilaian)** - Input scores for candidates against each criterion
6. **WASPAS Processing** - Calculate results using the WASPAS algorithm combining Weighted Sum Model (WSM) and Weighted Product Model (WPM)
7. **Results Display** - Show ranked results from the WASPAS calculation

## Database Schema

The system utilizes several key tables:
- `kriterias` - Stores evaluation criteria with weights
- `kandidats` - Stores candidate information (NIP, name, position, education, etc.)
- `nilais` - Stores ratings for each candidate against each criterion
- `waspas_nilais` - Stores the calculated WASPAS results (WSM and WPM scores)
- Role and permission tables from spatie/laravel-permission
- Menu system tables for navigation

## Building and Running

### Prerequisites
- PHP 8.1+
- Composer
- Node.js and npm/yarn
- MySQL or compatible database

### Setup Instructions

1. **Install PHP Dependencies**
   ```bash
   composer install
   ```

2. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   
   Configure your database connection in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Run Migrations**
   ```bash
   php artisan migrate
   ```

5. **Start Development Server**
   ```bash
   # Terminal 1: Start Laravel development server
   php artisan serve
   
   # Terminal 2: Build/watch frontend assets
   npm run dev
   ```

### Frontend Assets
- Use `npm run dev` for development (hot reload)
- Use `npm run build` for production build

### Testing
```bash
# Run backend tests
php artisan test

# Or run PHPUnit directly
./vendor/bin/phpunit
```

## Development Conventions

- **PHP Code Style:** Follows PSR-12 standards with Laravel conventions
- **Frontend Style:** Uses Tailwind CSS utility-first approach
- **Component Architecture:** Primarily uses Livewire for dynamic components
- **Database Migrations:** Each table has corresponding migration file in `database/migrations/`
- **Model Names:** PascalCase names in the `app/Models/` directory
- **Livewire Components:** Located in `app/Http/Livewire/` directory
- **Routes:** Defined in `routes/web.php` and `routes/api.php`

## Key Components

### WASPAS Algorithm Implementation
The system implements the WASPAS method in `WaspasProses` and `WaspasHasil` Livewire components (routes `/waspas/proses` and `/waspas/hasil` respectively). The calculated values are stored in the `waspas_nilais` table with both WSM (Weighted Sum Model) and WPM (Weighted Product Model) scores.

### Authentication & Authorization
- Uses Laravel Breeze for authentication foundation
- Implements spatie/laravel-permission for role-based permissions
- Custom middleware (`menu.access`) for menu-based access control

### Role-Based Menu System
Configured in `config/menu.php`, allowing administrators to define menus with hierarchical structure and permission checks.

## File Structure

- `app/` - Main application code (Models, Controllers, Livewire components, etc.)
- `routes/` - Application routes
- `resources/views/` - Blade templates
- `database/` - Migrations, seeds, and factories
- `config/menu.php` - Dynamic menu configuration
- `public/` - Public assets
- `storage/` - File storage for uploads, logs, etc.
- `tests/` - Unit and feature tests

## Important Notes

- The system is specifically designed for personnel selection processes
- Criteria weights must sum to 1.0 for accurate WASPAS calculations
- The database schema supports complex candidate attributes including educational background, position details, and professional development
- The application follows security best practices with Laravel's built-in protection mechanisms