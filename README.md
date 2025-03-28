# Jobs2

This is a job management application developed with Laravel 11, using Lando as the local development environment.

## Technologies Used

- **Laravel 11**: PHP framework for full application development.
- **PHP 8.3**: Latest PHP version.
- **MySQL 8.0**: Relational database.
- **Tailwind CSS**: CSS framework for responsive design.
- **Lando**: Tool for managing the development environment.
- **Docker**: Application containerization.
- **Vite**: Modern bundler for frontend assets.

## About the Project

This project presents a job management system, demonstrating proficiency in Laravel 11, modern PHP practices, and DevOps tools such as Lando and Docker.

## Project Structure

The project follows the standard Laravel structure with some custom organization:

- `/app` - Core application code
- `/routes` - API and web routes
- `/resources` - Frontend assets and views
- `/database` - Migrations and seeders
- `/config` - Application configuration
- `/tests` - Automated tests

## Requirements

- [Lando](https://docs.lando.dev/getting-started/installation.html) (v3.x or higher)
- [Docker](https://www.docker.com/get-started)
- [Git](https://git-scm.com/downloads)

## Environment Configuration

### Repository Clone

```bash
git clone https://github.com/yourusername/Jobs2.git
cd Jobs2
```

### Lando Configuration

The Lando environment is already pre-configured in the `.lando.yml` file with:
- PHP 8.3
- Nginx
- MySQL 8.0
- Node.js 18

Initialize the environment:

```bash
lando start
```

### Installing Dependencies and Configuring the Application

Run the installation command that configures the entire environment:

```bash
lando install
```

This command will perform:
- Installation of Composer dependencies
- Creation and configuration of the `.env` file
- Generation of the application key
- Execution of migrations and seeders
- Installation of NPM packages
- Creation of storage symbolic links

The application will be available at:
- **Main URL:** https://jobs2.lndo.site/
- **Database:** accessible via `database.jobs2.internal`

## Useful Commands

### Lando

```bash
# Start the Lando environment
lando start

# Stop the Lando environment
lando stop

# Rebuild the Lando environment
lando rebuild

# Access Laravel Tinker
lando tinker

# Run migrations
lando migrate

# Rollback migration (1 step)
lando rollback

# Run PHP commands
lando php artisan [command]

# Run Composer commands
lando composer [command]

# Run NPM commands
lando npm [command]
```

## Implemented Features

- **Job management:** List, create, edit, and delete job postings.
- **Application tracking:** Monitor the progress of applications.
- **Authentication and authorization:** Complete login system and permission management.
- **Responsive design:** Interface adaptable to different devices using Tailwind CSS.
- **RESTful API:** Endpoints for integration with other systems.

## Environment Variables

The project uses the standard Laravel environment configuration. An example configuration is provided in the `.env.example` file.

## Tests

Run the automated test suite with:

```bash
lando php artisan test
```

## Notes

Make sure the Lando services are running before accessing the application. For more information, consult the [official Lando documentation](https://docs.lando.dev/).

## License

This project is distributed under the MIT license.

---

*This project was created as part of a job application process, demonstrating skills in Laravel development and modern PHP practices.*
