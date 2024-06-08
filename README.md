# User Management System

This repository contains a simple User Management System implemented in PHP.

## Setup Instructions

### Clone the repository

```bash
git clone https://github.com/asifmuztaba/user-management.git
cd user-management
```

### Install dependencies

```bash
composer install
```

### Set up environment variables

Copy the `.env.example` file to `.env` and edit it with appropriate values:

```bash
cp .env.example .env
# Edit .env file with appropriate values
```

### Run migrations

Run the migration script to set up the database schema:

```bash
php src/Console/make.php makemigration:migrationname
php src/Console/make.php migrate:migrationfile
php src/Console/make.php migrateall
```

### Start Docker containers

Start the Docker containers using Docker Compose:

```bash
docker-compose up -d
```

### Access the application

Open your browser and navigate to http://localhost:8080 to access the application.

### Run tests

To run tests, use PHPUnit:

```bash
[Run all test files at once ] ./vendor/bin/phpunit
[Run specific test files] ./vendor/bin/phpunit TestFile
```

Replace `src/Tests` with the actual directory where your test files are located.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

This `README.md` file provides clear and concise instructions for setting up the project locally, running migrations,
starting Docker containers, accessing the application, and running tests. Adjust paths and commands as necessary based
on your actual project structure and requirements.