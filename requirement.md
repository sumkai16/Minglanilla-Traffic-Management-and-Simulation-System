# Minglanilla Traffic Management and Simulation System (MTMSS)

## Backend
- PHP: `^8.2` (current: `8.2.12`)
- Laravel Framework: `12.52.0`
- Laravel Breeze: `2.3.8`
- Spatie Activitylog: `4.12.3`
- Laravel Log Viewer: `2.5.0`
- Laravel Pail: `1.2.6`
- Laravel Pint: `1.27.1`
- Laravel Sail: `1.53.0`

## Frontend
- Blade (Laravel templating)
- Tailwind CSS: `3.4.19`
- Vite: `7.3.1`
- Alpine.js: `3.15.8`
- Leaflet: `1.9.4`
- Leaflet.draw: `1.0.4`
- Axios: `1.14.0`

## Database
- MySQL (default DB connection)

## Mail / SMTP
- Driver: SMTP
- Host: `smtp.gmail.com`
- Configured via Laravel Mailer (`MAIL_MAILER=smtp`)

## APIs / External Services
- TomTom Traffic Flow (map tiles)
  - `https://api.tomtom.com/traffic/map/4/tile/flow/relative0/{z}/{x}/{y}.png?key=...`
  - Note: TomTom API key is required for traffic overlay
- OSRM (road snapping: nearest point)
  - `https://router.project-osrm.org/nearest/v1/driving/{lng},{lat}?number=1`
  - Used to snap advisory points to roads

## Testing
- Pest: `3.8.5`
- Pest Plugin for Laravel: `3.2.0`
- PHPUnit: `11.5.50` (pulled in via Pest)
- Mockery: `1.6.12`
- Faker (fakerphp/faker): `1.24.1`

## Other Development Tools
- Composer: `2.9.4`
- Node.js: `24.13.0`
- npm: `11.6.2`
- XAMPP: used for local PHP runtime (PHP path: `C:\xampp\php\php.exe`)
- Laravel dev run (commands)
  - `php artisan serve`
  - `npm run dev` (Vite)

  
## Quick version checks (optional)
- `php -v`
- `php artisan --version`
- `composer -V`
- `node -v`
- `npm -v`
- `npm ls tailwindcss vite alpinejs leaflet leaflet-draw`