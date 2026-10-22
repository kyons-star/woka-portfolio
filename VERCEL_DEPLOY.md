# Deploy the Laravel app to Vercel

The build error `STATIC_BUILD_NO_OUT_DIR` happens because Vercel detects Vite as
a static site and expects a `dist/` directory. Laravel's Vite plugin correctly
puts compiled assets in `public/build`; a static Vite deployment would still
not run Laravel routes, Blade pages, or authentication.

This project includes [`woka/Dockerfile.vercel`](./woka/Dockerfile.vercel) for Vercel's [Container Runtime](https://vercel.com/docs/functions/runtimes/container),
which runs Laravel with PHP-FPM and Nginx instead of treating the app as static
files.

## Configure Vercel

1. Push the commit containing `woka/Dockerfile.vercel` to the GitHub branch
   connected to your Vercel project.
2. In Vercel **Project → Settings → Build and Deployment**:
   - Set **Root Directory** to `woka`.
   - Set **Framework Preset** to **Container** (or clear the Vite preset).
   - Clear any custom **Output Directory** value such as `dist`.
   - Leave the build command unset; the container build runs `npm ci`,
     `npm run build`, and production Composer installation.
3. In **Settings → Environment Variables**, configure these for Production
   and Preview as needed:
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY`: generate locally with `cd woka && php artisan key:generate --show`,
     then paste it into Vercel without sharing it. Keep the key private and
     stable after deployment.
   - `APP_URL`: your HTTPS Vercel domain.
   - `PORT=10000`
   - `LOG_CHANNEL=stderr`
   - `DB_CONNECTION=pgsql`
   - `DB_HOST=aws-0-ap-south-1.pooler.supabase.com`
   - `DB_PORT=5432`
   - `DB_PGSQL_DATABASE=postgres`
   - `DB_USERNAME=woka_runtime.jdfdkijvhcmmqcajbffd`
   - `DB_PASSWORD`: the private password for the limited Supabase runtime role.
   - `DB_SSLMODE=require`
   - `CACHE_STORE=database`
   - `SESSION_DRIVER=database`
   - `SESSION_SECURE_COOKIE=true`
   - `SESSION_HTTP_ONLY=true`
   - `SESSION_SAME_SITE=lax`
   - `QUEUE_CONNECTION=database`
   - `FILESYSTEM_DISK=public`
4. Do not add `.env` to Git or provide the Supabase secret/service-role key to
   client-side variables such as `VITE_*`.
5. Redeploy, then check Vercel's build and function logs. Test `/`, `/login`,
   `/register`, then verify authentication and portfolio CRUD.

The project uses a Vercel Container Runtime, currently documented as Beta.
The app's uploaded profile photos use local Laravel storage; Vercel instances
are ephemeral, so uploads may not survive instance replacement or scaling.
For durable production photo storage, move uploads to Supabase Storage before
relying on user-uploaded pictures. The existing Supabase database and rows are
not reset or migrated automatically.
