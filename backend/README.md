# CRM Backend

Open-source, self-hosted CRM backend — PHP 8.3 | Laravel 11 | PostgreSQL 16 | Docker

---

## Table of Contents

- [Project Structure](#project-structure)
- [Architecture Overview](#architecture-overview)
- [Installation](#installation)
- [Docker Setup](#docker-setup)
- [Environment Configuration](#environment-configuration)
- [Running the Application](#running-the-application)
- [Running Migrations](#running-migrations)
- [Running Tests](#running-tests)
- [API Reference](#api-reference)
- [Adding Future Services](#adding-future-services)
- [Development Workflow](#development-workflow)

---

## Project Structure

```
crm-backend/
├── app/
│   ├── Abstracts/                  # Shared base classes
│   │   ├── BaseModel.php
│   │   ├── BaseRepository.php
│   │   ├── BaseRequest.php
│   │   └── BaseResource.php
│   ├── Exceptions/
│   │   ├── Handler.php             # JSON API error renderer
│   │   └── CrmException.php        # Base domain exception
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   └── HealthController.php
│   │   └── Middleware/
│   │       ├── AuthenticateJwt.php
│   │       ├── AuditLogger.php
│   │       ├── ApiRateLimiter.php
│   │       └── ForceJsonResponse.php
│   ├── Modules/                    # CRM domain modules (bounded contexts)
│   │   ├── Auth/
│   │   ├── Users/
│   │   ├── Roles/
│   │   ├── Permissions/
│   │   ├── Leads/
│   │   ├── Contacts/
│   │   ├── Accounts/
│   │   ├── Opportunities/
│   │   ├── Tasks/
│   │   ├── Activities/
│   │   ├── Communications/
│   │   ├── Documents/
│   │   ├── Notifications/
│   │   └── Audit/
│   │       (Each module has: Controllers/ Services/ Repositories/
│   │        Models/ DTOs/ Requests/ Resources/ Events/ Listeners/
│   │        Exceptions/ Policies/)
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── EventServiceProvider.php
│       ├── RepositoryServiceProvider.php
│       └── RouteServiceProvider.php
├── bootstrap/
│   ├── app.php
│   └── providers.php
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── cors.php
│   ├── database.php
│   ├── filesystems.php
│   ├── jwt.php
│   ├── logging.php
│   ├── permission.php
│   ├── queue.php
│   ├── sanctum.php
│   └── session.php
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docker/
│   ├── entrypoint.sh
│   ├── nginx/
│   ├── php/
│   ├── postgres/init/
│   └── supervisor/
├── public/
│   ├── .htaccess
│   └── index.php
├── routes/
│   ├── api.php
│   └── console.php
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/
│   ├── Feature/HealthCheckTest.php
│   ├── Integration/
│   ├── Unit/ArchitectureTest.php
│   ├── TestCase.php
│   └── Pest.php
├── .dockerignore
├── .env.example
├── .gitignore
├── artisan
├── composer.json
├── Dockerfile
├── docker-compose.yml
├── phpunit.xml
└── README.md
```

---

## Architecture Overview

### Module Pattern

Every CRM domain is isolated into a self-contained module under `app/Modules/{Module}/`:

| Layer | Location | Responsibility |
|---|---|---|
| Controller | `Controllers/` | HTTP request/response only — delegates to Service |
| Service | `Services/` | Business logic, orchestration, transactions |
| Repository | `Repositories/` | Data access — wraps Eloquent queries |
| Model | `Models/` | Eloquent entity + relationships |
| DTO | `DTOs/` | Typed data transfer objects (Spatie Data) |
| Request | `Requests/` | Form validation (extends BaseRequest) |
| Resource | `Resources/` | API response transformers (extends BaseResource) |
| Event/Listener | `Events/ Listeners/` | Domain events and side-effects |
| Exception | `Exceptions/` | Domain-specific exceptions |
| Policy | `Policies/` | Laravel authorization gates |

### CRM Domain Modules

| Module | Status | Description |
|---|---|---|
| auth | Stub | JWT login, register, logout, refresh, password reset |
| users | Stub | CRM user management |
| roles | Stub | Role management |
| permissions | Stub | Permission catalog |
| leads | Stub | Lead capture and pipeline |
| contacts | Stub | Contact management |
| accounts | Stub | Account/company management |
| opportunities | Stub | Sales pipeline and deals |
| tasks | Stub | Task assignment and tracking |
| activities | Stub | Activity logs (calls, meetings, emails) |
| communications | Stub | Email/SMS/call integrations |
| documents | Stub | Document storage (MinIO/S3) |
| notifications | Stub | In-app and push notifications |
| audit | Stub | Audit trail and compliance |

---

## Installation

### Prerequisites

- Docker Desktop v24+
- Docker Compose v2.20+
- Git

### Clone and Configure

```bash
# 1. Clone the repository
git clone https://github.com/your-org/crm-backend.git
cd crm-backend

# 2. Copy environment file
cp .env.example .env

# 3. Generate APP_KEY using Docker (no local PHP needed)
docker run --rm php:8.3-cli php -r "echo 'base64:'.base64_encode(random_bytes(32)).PHP_EOL;"
# Paste the output into APP_KEY= in your .env

# 4. Set DATABASE_PASSWORD in .env to a strong password
```

---

## Docker Setup

### Build and Start

```bash
# Build images and start all services in the background
docker compose up -d --build

# View all service logs
docker compose logs -f

# View API logs only
docker compose logs -f crm-api

# View database logs only
docker compose logs -f crm-db
```

### Stop

```bash
docker compose down

# Stop AND remove volumes (WARNING: deletes all database data)
docker compose down -v
```

### Rebuild After Code Changes

```bash
docker compose build crm-api
docker compose up -d crm-api
```

### Shell Access

```bash
# PHP API container shell
docker compose exec crm-api bash

# PostgreSQL interactive CLI
docker compose exec crm-db psql -U crm_user -d crm
```

---

## Environment Configuration

Copy `.env.example` to `.env` and fill in values. Never commit `.env` to version control.

### Required Variables

| Variable | Description | Default |
|---|---|---|
| APP_ENV | Application environment | local |
| APP_KEY | Laravel encryption key (base64, 32 bytes) | — |
| APP_URL | Public URL of the API | http://localhost:8000 |
| DATABASE_HOST | PostgreSQL host | crm-db |
| DATABASE_PORT | PostgreSQL port | 5432 |
| DATABASE_NAME | Database name | crm |
| DATABASE_USER | Database username | crm_user |
| DATABASE_PASSWORD | Database password (keep secret) | — |

### Optional Variables

| Variable | Description | Default |
|---|---|---|
| APP_DEBUG | Enable debug mode | false |
| APP_TIMEZONE | Application timezone | UTC |
| APP_PORT | Host port for API | 8000 |
| LOG_CHANNEL | Log output channel | stderr |
| LOG_LEVEL | Minimum log level | debug |

---

## Running the Application

```bash
# Start all services
docker compose up -d

# Health check — API liveness
curl http://localhost:8000/api/health

# Health check — PostgreSQL connectivity
curl http://localhost:8000/api/health/db

# Expected response:
# {"status":"ok","service":"CRM Backend","version":"1.0.0","env":"local","timestamp":"..."}
```

### Common Artisan Commands

```bash
# Run any artisan command inside the container
docker compose exec crm-api php artisan <command>

# Examples
docker compose exec crm-api php artisan route:list
docker compose exec crm-api php artisan config:show
docker compose exec crm-api php artisan about
docker compose exec crm-api php artisan optimize:clear
```

---

## Running Migrations

Migrations run **automatically** on container start via `docker/entrypoint.sh`.

To run manually:

```bash
# Run all pending migrations
docker compose exec crm-api php artisan migrate

# Run with verbose output
docker compose exec crm-api php artisan migrate --verbose

# Roll back the last batch
docker compose exec crm-api php artisan migrate:rollback

# Roll back all migrations (DESTRUCTIVE)
docker compose exec crm-api php artisan migrate:reset

# Show migration status
docker compose exec crm-api php artisan migrate:status

# Fresh install (drop all + re-migrate)
docker compose exec crm-api php artisan migrate:fresh
```

### Migration File Naming Convention

```
YYYY_MM_DD_HHMMSS_description.php

Foundation (run first — ordered by timestamp prefix):
  0001_01_01_000000_create_users_table.php
  0001_01_01_000001_create_password_reset_tokens_table.php
  0001_01_01_000002_create_permission_tables.php

Domain (added per module):
  2024_01_01_000001_create_audit_logs_table.php
```

---

## Running Tests

Uses Pest PHP with in-memory SQLite — no running PostgreSQL required.

```bash
# Run all tests
docker compose exec crm-api php artisan test

# Run with Pest directly
docker compose exec crm-api ./vendor/bin/pest

# Run Unit tests only
docker compose exec crm-api ./vendor/bin/pest --testsuite=Unit

# Run Feature tests only
docker compose exec crm-api ./vendor/bin/pest --testsuite=Feature

# Run with code coverage report
docker compose exec crm-api ./vendor/bin/pest --coverage

# Run a specific test file
docker compose exec crm-api ./vendor/bin/pest tests/Feature/HealthCheckTest.php

# Run tests matching a name filter
docker compose exec crm-api ./vendor/bin/pest --filter "health"
```

### Test Suites

| Suite | Location | Purpose |
|---|---|---|
| Unit | `tests/Unit/` | Isolated class tests (services, DTOs, repositories) |
| Feature | `tests/Feature/` | HTTP-layer tests (routes, controllers, JSON responses) |
| Integration | `tests/Integration/` | DB integration (repository queries against real schema) |

---

## API Reference

### Base URL

```
http://localhost:8000/api
```

### Authentication

All protected endpoints require a JWT Bearer token:

```
Authorization: Bearer <your_jwt_token>
```

### System Endpoints (no auth required)

| Method | Endpoint | Description |
|---|---|---|
| GET | /api/health | API liveness check |
| GET | /api/health/db | PostgreSQL connectivity check |
| GET | /api/up | Laravel built-in health check |

### Auth Endpoints (v1)

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| POST | /api/v1/auth/login | No | Obtain JWT token |
| POST | /api/v1/auth/register | No | Register new user |
| POST | /api/v1/auth/forgot-password | No | Request password reset |
| POST | /api/v1/auth/reset-password | No | Complete password reset |
| POST | /api/v1/auth/logout | JWT | Invalidate JWT token |
| POST | /api/v1/auth/refresh | JWT | Refresh JWT token |
| GET | /api/v1/auth/me | JWT | Get current user profile |
| PUT | /api/v1/auth/change-password | JWT | Change own password |

### CRM Resource Endpoints (v1) — all require JWT + listed permission

| Resource | Base Path | Permission |
|---|---|---|
| Users | /api/v1/users | users.view |
| Roles | /api/v1/roles | roles.view |
| Permissions | /api/v1/permissions | roles.view |
| Leads | /api/v1/leads | leads.view |
| Contacts | /api/v1/contacts | contacts.view |
| Accounts | /api/v1/accounts | accounts.view |
| Opportunities | /api/v1/opportunities | opportunities.view |
| Tasks | /api/v1/tasks | tasks.view |
| Activities | /api/v1/activities | activities.view |
| Communications | /api/v1/communications | communications.view |
| Documents | /api/v1/documents | documents.view |
| Audit Logs | /api/v1/audit-logs | audit.view |

### Response Envelope

Success:
```json
{
  "data": { "..." },
  "meta": {
    "api_version": "v1",
    "timestamp": "2024-01-01T00:00:00+00:00"
  }
}
```

Error:
```json
{
  "status": "error",
  "code": "validation_failed",
  "message": "The given data was invalid.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

---

## Adding Future Services

The `docker-compose.yml` has pre-configured (commented) service blocks.
To enable a service, uncomment its block and the corresponding volume, then update `.env`.

### Redis

```bash
# In docker-compose.yml: uncomment crm-redis service and crm_redis_data volume
# In .env:
REDIS_PASSWORD=your_strong_password
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

### MinIO (S3-compatible Object Storage)

```bash
# In docker-compose.yml: uncomment crm-minio service and crm_minio_data volume
# In .env:
MINIO_ROOT_USER=your_minio_user
MINIO_ROOT_PASSWORD=your_minio_password
```

### NestJS Microservice

```bash
# 1. Create services/nestjs/ with your NestJS app + Dockerfile
# 2. Uncomment crm-nestjs service block in docker-compose.yml
```

### Asterisk VoIP

```bash
# 1. Create docker/asterisk/config/ with Asterisk configuration files
# 2. Uncomment crm-asterisk service block in docker-compose.yml
```

---

## Development Workflow

```bash
# Full reset after pulling changes
docker compose down
docker compose up -d --build
docker compose exec crm-api php artisan migrate

# Clear all caches
docker compose exec crm-api php artisan optimize:clear

# Format code with Laravel Pint
docker compose exec crm-api ./vendor/bin/pint

# List all API routes
docker compose exec crm-api php artisan route:list --path=api
```

---

## Build Sets Roadmap

| Set | Scope | Status |
|---|---|---|
| 1A — Foundation and Docker | Architecture, Docker, health checks, route stubs | Done |
| 1B — Auth Module | JWT login/register, RBAC, permissions seeder | Next |
| 1C — Users and Roles | User CRUD, role management, policy layer | Planned |
| 2A — Leads | Lead capture, pipeline stages, conversion | Planned |
| 2B — Contacts and Accounts | Contact/account CRUD, relationships | Planned |
| 3A — Opportunities | Deal tracking, win/loss reporting | Planned |
| 3B — Tasks and Activities | Task management, activity timeline | Planned |
| 4A — Communications | Email/SMS integration hooks | Planned |
| 4B — Documents | File upload (MinIO), versioning | Planned |
| 5A — Notifications | In-app notifications, webhooks | Planned |
| 5B — Audit | Full audit trail, compliance reports | Planned |

---

## License

MIT
