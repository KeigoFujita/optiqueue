# Optiqueue

Eyewear e-commerce. Laravel 13, PHP 8.3, Pest 4, Tailwind CSS v4, Vite 8, chart.js 4.

## Commands

| Command | What it does |
|---|---|
| `composer run test` | `config:clear` then `artisan test` — runs all 3 suites (Unit, Feature, Architecture) |
| `composer run dev` | Runs `artisan serve` + `queue:listen --tries=1` + `npm run dev` concurrently |
| `./vendor/bin/pint` | Laravel Pint (PSR-12 linter) |
| `composer run setup` | Full fresh setup: `composer install`, `.env`, `key:generate`, `migrate --force`, `npm install`, `npm run build` |

## When I ask you to commit

1. Run `composer run test` first. Fix failures before committing.
2. Use conventional commits: `feat:`, `fix:`, `refactor:`, `chore:`, `docs:`, `style:`, `perf:`, `test:` — lowercase, descriptive.
3. Stage only relevant files (no `.env`, `node_modules/`, `vendor/`, build artifacts, IDE config).
4. One commit per logical change.

## Architecture

- **Two auth systems**: Admins use session auth on `users` table (`/admin`, `auth` middleware). Customers use OTP-by-email (no session, no password, `customers.verified_at`).
- **Checkout flow**: Browse frames → select lens/accessory → enter email → OTP → place order. No product detail page — `ProductController@show` redirects to checkout.
- **Manual DB transactions** in CheckoutController (`DB::beginTransaction()`, not `DB::transaction()`).
- **Stock deduction**: `where('stocks', '>=', $qty)->decrement()` as a conditional check.
- **Order numbers**: `'ORD-'.strtoupper(uniqid())` — non-sequential.
- **Image uploads**: Stored by type subdir on `public` disk (`frames/men/`, `frames/women/`, `lenses/`, `accessories/`).
- **User model** uses PHP 8 attributes (`#[Fillable]`, `#[Hidden]`) — not traditional `$fillable` arrays.
- **Prices** stored as integers (cents). `products.stocks` is also an integer.
- **No custom jobs** — all mail sent synchronously despite having `Queueable` trait.
- **Dashboard** has inline linear regression for sales targets. chart.js loaded as `window.Chart`, all chart JS inline in Blade.
- **Architecture tests** use Pest's `arch()` fluent assertions (e.g., `expect('dd')->not->toBeUsed()`).

## Testing

- **Pest PHP** with `describe()`/`it()` nesting, `LazilyRefreshDatabase` in Feature tests, no DB refresh in Architecture tests.
- `phpunit.xml` sets testing DB to MySQL `optiqueue_testing` (not SQLite). Runs `config:clear` before suite.
- Existing test patterns: `beforeEach()` for fakes, `Customer::factory()->verified()->create(...)`, `Product::factory()->frame()->create(...)`, fluent JSON assertions.
