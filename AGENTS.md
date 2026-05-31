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

### Framework & configuration
- **Pest PHP 4** with `describe()`/`it()` nesting. `LazilyRefreshDatabase` in Feature tests, no DB refresh in Architecture tests.
- `phpunit.xml` sets testing DB to MySQL `optiqueue_testing` (not SQLite). Runs `config:clear` before suite.
- `composer run test` runs all three suites: Unit, Feature, Architecture.

### Test file placement
| Test type | Directory | What belongs there |
|---|---|---|
| Feature (controller) | `tests/Feature/Http/Controllers/` | One file per controller. Test the controller's business logic: happy paths, validation, edge cases, output assertions. **Do not** test middleware behavior here. |
| Feature (middleware) | `tests/Feature/Http/Middleware/` | Dedicated per-middleware files. Test middleware behavior once across all HTTP verbs (GET, POST, PUT, DELETE). Controller tests must never repeat middleware assertions. |
| Architecture | `tests/Architecture/` | Structural rules: forbidden functions, namespace/class constraints, extension checks. No DB access. |
| Unit | `tests/Unit/` | Isolated classes: models, services, helpers. No HTTP layer. |

### Test ordering within a file (industry convention)
Follow this progression in every controller test file:

1. **Happy path** — core functionality under ideal conditions. Establishes the baseline.
2. **Filtering / searching / parameter variations** — different inputs that should succeed.
3. **Edge cases** — empty datasets, non-existent resources (404), immutable state transitions, boundary values.
4. **Validation & input rejection** — missing fields, invalid formats, out-of-range values. Always last.

### Middleware testing (hybrid approach)
Middleware behavior is tested in exactly two places, never in controller tests:

1. **Dedicated middleware Feature test** — Verifies the middleware's HTTP behavior once (e.g., guests receive 302 redirect, authenticated users pass through). Test every HTTP verb used by protected routes. Use `->with()` datasets to avoid repetition.
2. **Architecture test** — Verifies structural constraints (e.g., admin controllers extend the base Controller, are in the correct namespace).

When adding a new middleware to a route group:
- Add one test method (or dataset entry) to the middleware Feature test.
- Add one architecture assertion if structural constraints apply.
- **Never** add middleware assertions to controller tests.

### Test structure conventions
- Nest tests under `describe()` blocks matching the controller method name (e.g., `describe('store()', ...)`).
- Use `beforeEach()` for shared setup: fakes, factory-created models, acting-as-authenticated users.
- Use Pest's `->with()` datasets to test multiple input variants with a single test body.
- Use `->only()` to restrict a `describe()` block to specific tests during development.
- Fluent JSON assertions: `assertJsonStructure()` for shape, `assertJsonFragment()` for values, `assertJsonPath()` for nested checks.
- Store `auth` middleware checks **exclusively** in `tests/Feature/Http/Middleware/AuthenticateTest.php`.

### Naming conventions
- Test files: match the class under test (`DashboardController` → `DashboardControllerTest.php`).
- `it()` descriptions: declarative, present-tense, no period at the end (e.g., `'renders the dashboard with default week period'`, not `'test rendering the dashboard'`).
- `describe()` labels: the method or concept name (e.g., `'index()'`, `'updateStatus()'`, `'guest access'`).

### Architecture test rules
- Every admin controller must extend `App\Http\Controllers\Controller`.
- `dd()`, `dump()`, `var_dump()` must never appear in production code.
- Decorator patterns (e.g., `#[Fillable]`) over traditional arrays where the project convention applies.

### Common patterns
- `User::factory()->create()` for admin users. Assign to `$this->admin` in `beforeEach()`.
- `Customer::factory()->verified()->create(...)` for verified customers.
- `Product::factory()->frame()->create(...)` / `->lens()` / `->accessory()` for typed products.
- `Order::factory()->pending()->create()` / `->processing()` / `->ready()` / `->pickedUp()` / `->cancelled()` for stateful orders.
- `Mail::fake()` in `beforeEach()` before testing mail-sending endpoints.
- `Storage::fake('public')` before testing file uploads.
- `$this->actingAs($this->admin)` to simulate an authenticated admin session.
