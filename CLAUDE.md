# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project overview

"Graczzielony" is a Polish-language Laravel + Inertia.js + Vue 3 web app for ranking and voting on board games, built on the `laravel/vue-starter-kit` skeleton. Its core feature: users search for board games (via the BoardGameGeek/BGG API), vote for their favorites, and a monthly ranking is computed, then archived.

## Common commands

Run PHP and frontend dev servers together (server, queue listener, Vite):
```
composer run dev
```
Or with SSR:
```
composer run dev:ssr
```

Frontend only:
```
npm run dev          # Vite dev server
npm run build         # production build
npm run build:ssr     # production build incl. SSR bundle
npm run lint          # eslint --fix
npm run format         # prettier --write resources/
npm run format:check   # prettier --check resources/
```

Backend tests (Pest, configured via `tests/Pest.php` / `phpunit.xml`):
```
php artisan test                      # full suite
php artisan test --filter=TestName    # single test
vendor/bin/pest tests/Feature/Path/To/SomeTest.php   # single file
```
Feature tests use `RefreshDatabase` and an in-memory sqlite connection (set in `phpunit.xml`); `tests/Unit` does not get `RefreshDatabase` applied.

PHP code style:
```
vendor/bin/pint          # Laravel Pint, fixes PHP formatting
```

## Architecture

**Backend layering** — controllers are thin and delegate to a Service -> Repository chain, with Actions for standalone scheduled/invokable operations:
- `app/Http/Controllers/Public/Ranking/*` — public voting/ranking endpoints (no auth required)
- `app/Http/Controllers/Admin/Blog/*` — blog authoring (EditorJS-based editor, image upload endpoint in `routes/blog.php`)
- `app/Services/Public/Ranking/*` — business logic (`GamesRankingService` computes ranking placement w/ tie handling, `VoteService` orchestrates a vote submission, `SearchGameService` calls the BGG API via `ekwita/bgg-api-client`)
- `app/Repositories/Public/Ranking/*` — persistence for `Game`/`Vote` models
- `app/Actions/ArchiveTopGames.php` — invokable action that snapshots the top-10 ranked games (with tie handling) into `ArchivedRanking`/`ArchivedGame`, then truncates `Vote` and resets `Game.votes`/`Game.score` to zero. This is destructive — it wipes the live ranking data. It's wired in `routes/console.php` via `Schedule::call(ArchiveTopGames::class)`; note the schedule currently registers it both `->everyMinute()` and `->monthly()` — check current intent before assuming this is correct if you touch the scheduling.

**Domain model**: `Game` (current/live ranking-period standing: `score`, `votes`) has many `Vote` (per-user submission, `points`). At archive time the top-10 by `(score, votes)` — including ties — are copied into `ArchivedRanking` (one per month) -> `ArchivedGame` (one row per archived position). `GameDTO` is used to shuttle BGG search results (id/name/year/image) from `SearchGameService` to the frontend before a game exists locally.

**Ranking/tie logic**: both `GamesRankingService::showRanking()` (live ranking, capped at 10 *visible places*, not 10 games — ties can show more than 10 rows) and `ArchiveTopGames` independently implement the same "dense-ish" placement-with-ties algorithm by walking games sorted by `(score desc, votes desc)`. If one changes, check whether the other needs to change too.

**External API**: `SearchGameService` talks to BoardGameGeek via the `ekwita/bgg-api-client` package (private VCS repo `git@github.com:Ekwita/bgg-php-api-client.git`, required as `ekwita/bgg-api-client: dev-apis` in `composer.json`). It reads `BGG_API_KEY` from the environment (not present in `.env.example` — must be set locally to exercise search).

**Frontend**: Inertia.js Vue 3 SPA, pages live in `resources/js/pages/**/*.vue` and are resolved by name from PHP controllers (`Inertia::render('ranking/Vote')` -> `resources/js/pages/ranking/Vote.vue`). Reusable UI primitives (`resources/js/components/ui/*`) are a shadcn-vue-style component set built on `radix-vue`; these are excluded from eslint (`eslint.config.js` ignores `resources/js/components/ui/*`) and generally shouldn't need hand-editing. Routing helpers come from `ziggy-js` (Laravel route names usable in JS). Rich text/blog content uses `@editorjs/*` (header, image plugins).

**Rate limiting**: vote submission (`POST /vote/store`) is throttled via a named limiter `vote` (100/min), defined in `AppServiceProvider::boot()`, applied in `routes/web.php` via `middleware(['throttle:vote'])`.

**Routes** are split across `routes/web.php` (public pages, ranking/voting), `routes/blog.php` (blog CRUD + image upload), `routes/auth.php`, `routes/settings.php`, and `routes/console.php` (Artisan/scheduled commands) — all loaded from `web.php`'s `require` calls (blog.php is loaded elsewhere; check `bootstrap/app.php` if routes seem missing).
