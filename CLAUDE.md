# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Decision Support System (SPK - Sistem Pendukung Keputusan) implementing the **WASPAS (Weighted Aggregated Sum Product Assessment)** method for candidate assessment and position placement. Built with Laravel 10, Livewire 3, and Tailwind CSS.

The WASPAS method combines two approaches:
- **WSM (Weighted Sum Model)**: Q1 = Σ(normalized_value × weight)
- **WPM (Weighted Product Model)**: Q2 = Π(normalized_value ^ weight)
- **Final Score**: Qi = 0.5×Q1 + 0.5×Q2

## Tech Stack

- **Backend**: Laravel 10 (PHP 8.1+)
- **Frontend**: Livewire 3, Volt, Tailwind CSS 4
- **Auth**: Laravel Breeze
- **Permissions**: Spatie Laravel Permission
- **Database**: MySQL

## Development Commands

### Initial Setup
```bash
# Copy environment file
cp .env.example .env

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Seed database with initial data
php artisan db:seed
```

### Development
```bash
# Start development server
php artisan serve

# Compile assets (development)
npm run dev

# Build for production
npm run build

# Run migrations
php artisan migrate

# Refresh database and seed
php artisan migrate:fresh --seed
```

### Testing
```bash
# Run tests
php artisan test

# Run specific test
vendor/bin/phpunit --filter TestClassName
```

### Code Quality
```bash
# Format code with Laravel Pint
./vendor/bin/pint

# Format specific file
./vendor/bin/pint path/to/file.php
```

## Architecture

### Role-Based Menu Access System

The application uses a sophisticated menu access control system combining Spatie Permissions and custom middleware:

1. **Menu-Role Pivot**: Menus are linked to roles via `menu_role` pivot table
2. **CheckMenuAccess Middleware** (`app/Http/Middleware/CheckMenuAccess.php`):
   - Super Admin bypasses all checks
   - Validates route access against user's role(s)
   - Returns 403 if user lacks access to a menu route
3. **Dynamic Sidebar** (`app/Http/Livewire/Sidebar.php`):
   - Filters menus based on user's roles
   - Supports hierarchical menu structure (parent/children)
   - Only shows active menus

### WASPAS Calculation Flow

The WASPAS calculation is implemented in `app/Http/Livewire/WaspasProses.php`:

1. **Matrix Building**: Construct decision matrix X from `nilais` table (kandidat × kriteria)
2. **Normalization**: Calculate matrix R
   - **Benefit criteria**: R = value / max_value
   - **Cost criteria**: R = min_value / value
3. **Weighted Aggregation**:
   - Q1 (WSM) = Σ(normalized × weight)
   - Q2 (WPM) = Π(normalized^weight) — uses epsilon (0.0001) to prevent zero products
4. **Final Score**: Qi = 0.5×Q1 + 0.5×Q2
5. **Ranking**: Sorted descending by Qi

### Core Models and Relationships

**Kandidat (Candidate)**:
- Represents employees eligible for position assessment
- Relationships: `golongan`, `jenis_jabatan`, `jabatan_fungsional`, `jabatan_pelaksana`, `eselon`, `tingkat_pendidikan`, `bidang_ilmu`, `jurusan_pendidikan`, `unit_kerja`
- Has many `nilais` (assessment scores) and `waspasNilais` (WASPAS results)

**Kriteria (Criteria)**:
- Assessment criteria with weight (`bobot`) and type (`jenis`: Benefit/Cost)
- Has many `kriteriaNilais` (criteria value mappings) and `nilais` (scores)

**WaspasNilai**:
- Stores calculated WASPAS scores for candidates
- Links to `JabatanTarget` (target position) and `Kandidat` via NIP

**SyaratJabatan (Position Requirements)**:
- Defines minimum requirements for positions by eselon
- Fields: minimal golongan, minimal pendidikan, optional minimal eselon/jenjang fungsional

### Livewire Components Structure

All components in `app/Http/Livewire/`:
- **Dashboard**: Main dashboard view
- **Kandidat**: Candidate management CRUD
- **Kriteria**: Criteria management with weights and type (Benefit/Cost)
- **Penilaian**: Input assessment scores (kandidat × kriteria matrix)
- **WaspasProses**: Performs WASPAS calculation and displays normalized values, Q1, Q2, Qi
- **WaspasHasil**: Final results and ranking display
- **BidangIlmu**, **JabatanTarget**, **SyaratJabatan**: Master data management
- **Sidebar**: Dynamic menu rendering with role-based filtering
- **UserManager**: User and role management

### Database Seeding Order

Critical seeding order in `DatabaseSeeder.php`:
1. Roles and Users (RoleSeeder → UserSeeder)
2. Menus and Permissions (MenuSeeder → RolePermissionSeeder → MenuRoleSeeder)
3. Master data (JenisJabatan, Golongan, Eselon, TingkatPendidikan, BidangIlmu)
4. Assessment data (Kriteria → Kandidat → Nilai)
5. Position requirements (SyaratJabatan, JabatanFungsional, etc.)
6. Target positions and criteria mappings

## Important Implementation Notes

### WASPAS Weight Format
Weights in `kriterias.bobot` are stored as percentages (e.g., 30 for 30%). The calculation divides by 100: `$weight = $kriteria->bobot / 100`.

### Normalization Type Detection
Criteria normalization uses the `jenis` column (enum: 'Benefit', 'Cost'). The code converts to lowercase for comparison, defaulting to 'benefit' if null.

### Epsilon in WPM Calculation
The WPM calculation adds epsilon (0.0001) to normalized values to prevent the entire product from becoming zero when any criterion has a normalized value of 0: `pow($norm + 0.0001, $weight)`.

### Menu Route Mapping
Routes must match the `route` column in the `menus` table for access control to work. The middleware checks `$request->route()->getName()` against menu routes.

### Authentication Flow
- Root route (`/`) redirects to login
- Laravel Breeze handles authentication
- Custom logout action in `app/Livewire/Actions/Logout.php`
- All protected routes use `auth` and `menu.access` middleware

## File Locations

- Models: `app/Models/`
- Livewire Components: `app/Http/Livewire/`
- Views: `resources/views/livewire/`
- Migrations: `database/migrations/`
- Seeders: `database/seeders/`
- Middleware: `app/Http/Middleware/`
- Routes: `routes/web.php`
