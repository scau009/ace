# ACE App

A Symfony 7.3 application with user authentication and Tailwind CSS styling.

## Features

- User Registration and Login
- Symfony Security Component
- Tailwind CSS with AssetMapper
- PostgreSQL Database
- Docker Support

## Requirements

- Docker & Docker Compose
- Node.js & npm (for Tailwind CSS compilation)

## Setup

1. Start Docker containers:
```bash
docker compose up -d
```

2. Install PHP dependencies:
```bash
docker compose exec php composer install
```

3. Install Node.js dependencies:
```bash
npm install
```

4. Build Tailwind CSS:
```bash
npm run build:css
```

5. Run database migrations:
```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

## Development

### Watch CSS changes:
```bash
npm run watch:css
```

### Build CSS for production:
```bash
npm run build:css
```

## Access

- Application: http://localhost:8080
- Database: localhost:5432 (user: root, password: ace123123, db: ace)

## Routes

- `/` - Home page
- `/register` - User registration
- `/login` - User login
- `/logout` - User logout
