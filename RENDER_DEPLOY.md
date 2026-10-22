# Deploy Woka to Render with Supabase

This repository is a monorepo: Render's Blueprint is at the repository root
and the Laravel application is in `woka/`. The Blueprint deploys a free Docker
web service in Singapore and uses Supabase PostgreSQL in Mumbai.

## Before creating the Render service

1. Rotate the Supabase database password and the Supabase secret key that were
   shared in chat. Do not put either credential in Git or in `render.yaml`.
2. In Supabase **SQL Editor**, run `woka/deploy/supabase-runtime-role.sql`.
   Replace its password placeholder with a new, unique runtime-role password
   in the SQL editor. This grants the Laravel server access only to the
   application's tables, enables RLS, and removes access to those tables from
   the `anon` and `authenticated` API roles. Keep the new password private.
3. The application currently has all four migrations applied in the existing
   Supabase database. Do not run `migrate:fresh` or reset the project. The
   Render startup command deliberately does not run migrations.

## Create the Render service

1. In Render, choose **New → Blueprint** and connect
   `kyons-star/woka-portfolio`, branch `main`.
2. Review `render.yaml` before confirming. It creates a Free web service. Free
   services sleep after 15 minutes without traffic, may take about a minute to
   wake, and have ephemeral storage. Uploaded profile photos may be lost after
   sleep, restart, or redeploy; the Supabase database continues to retain user
   and portfolio records.
3. When prompted for unsynchronized values, enter:
   - `APP_URL`: the HTTPS URL Render assigns to this web service.
   - `DB_USERNAME`: `woka_runtime.jdfdkijvhcmmqcajbffd`.
   - `DB_PASSWORD`: the new runtime-role password entered in Supabase SQL
     Editor.
   Render generates `APP_KEY` automatically; the application normalizes its
   generated Base64 key to Laravel's expected format.
4. Do not enter a Supabase secret/service-role key. Laravel connects directly
   to PostgreSQL; it does not need the publishable key for this connection.
5. Click **Apply**. Render builds the Docker image and deploys the web service.
   Check the service's **Events** and **Logs** tabs; wait for the `/up`
   health check to pass.

## Verify deployment

Open the Render HTTPS URL and test registration, login, portfolio creation,
editing, style switching, and deletion. In Supabase Table Editor, check that
rows are written to `users` and `portfolios`. Check that uploaded pictures
remain available after a deploy.

The app enforces portfolio ownership in Laravel before viewing or changing a
portfolio. The runtime database role is not a superuser and RLS grants it
backend access only. Do not use the Supabase publishable key to query private
portfolio tables from browser code.

## Future schema changes

Do not run migrations automatically on service startup. Review schema changes
against the existing Supabase schema first. Run approved migrations with an
administrator connection, then grant the runtime role access and add an RLS
policy for any new application table before deploying code that uses it.
