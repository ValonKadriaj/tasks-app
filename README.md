# Clone & Setup

Follow these steps to clone this repository and set up the Laravel application locally (using Bash on Windows):

-   Clone the repo:

```bash
git clone <your-repo-url.git> tasks-app
cd tasks-app
```

-   Install PHP dependencies with Composer:

```bash
composer install
```

-   Copy the environment file and generate an app key:

```bash
cp .env.example .env
php artisan key:generate
```

-   Configure your database in the `.env` file (set `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) for MySQL.

-   Run database migrations:

```bash
php artisan migrate
```

-   (Optional) Install frontend dependencies and build assets:

```bash
npm install
npm run build
```

-   Serve the app locally:

```bash
php artisan serve
```

Open http://127.0.0.1:8000 in your browser.

Notes:

-   Replace `<your-repo-url.git>` with the repository URL (GitHub/Bitbucket/GitLab).
-   If you edited migrations or re-created the database, you can use `php artisan migrate:fresh` to drop & re-run all migrations.
-   On Windows using WSL or Git Bash is recommended for smoother command-line experience.

---

To add this to the main `README.md` you can copy the section above and paste it near the end of `README.md`. If you want, I can try again to patch `README.md` directly or replace it with this full content — tell me which you prefer.
