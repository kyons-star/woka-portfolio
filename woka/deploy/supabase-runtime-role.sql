-- Run once in the Supabase SQL Editor as a database administrator.
-- Replace the placeholder with a new, unique password before running.
-- Configure Render with DB_USERNAME=woka_runtime.jdfdkijvhcmmqcajbffd and
-- the same password as DB_PASSWORD. Never commit or share the password.

CREATE ROLE woka_runtime
    LOGIN
    PASSWORD 'REPLACE_WITH_A_UNIQUE_RANDOM_PASSWORD'
    NOSUPERUSER
    NOCREATEDB
    NOCREATEROLE
    NOINHERIT
    NOREPLICATION
    NOBYPASSRLS;

GRANT CONNECT ON DATABASE postgres TO woka_runtime;
GRANT USAGE ON SCHEMA public TO woka_runtime;

REVOKE ALL PRIVILEGES ON TABLE
    public.users,
    public.portfolios,
    public.sessions,
    public.cache,
    public.cache_locks,
    public.jobs,
    public.job_batches,
    public.failed_jobs,
    public.migrations
FROM PUBLIC, anon, authenticated;

GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE
    public.users,
    public.portfolios,
    public.sessions,
    public.cache,
    public.cache_locks,
    public.jobs,
    public.job_batches,
    public.failed_jobs
TO woka_runtime;

REVOKE ALL PRIVILEGES ON SEQUENCE
    public.users_id_seq,
    public.portfolios_id_seq,
    public.jobs_id_seq,
    public.failed_jobs_id_seq
FROM PUBLIC, anon, authenticated;

GRANT USAGE, SELECT ON SEQUENCE
    public.users_id_seq,
    public.portfolios_id_seq,
    public.jobs_id_seq,
    public.failed_jobs_id_seq
TO woka_runtime;

ALTER TABLE public.users ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.portfolios ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.sessions ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.cache ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.cache_locks ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.jobs ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.job_batches ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.failed_jobs ENABLE ROW LEVEL SECURITY;
ALTER TABLE public.migrations ENABLE ROW LEVEL SECURITY;

CREATE POLICY woka_runtime_access ON public.users
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
CREATE POLICY woka_runtime_access ON public.portfolios
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
CREATE POLICY woka_runtime_access ON public.sessions
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
CREATE POLICY woka_runtime_access ON public.cache
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
CREATE POLICY woka_runtime_access ON public.cache_locks
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
CREATE POLICY woka_runtime_access ON public.jobs
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
CREATE POLICY woka_runtime_access ON public.job_batches
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
CREATE POLICY woka_runtime_access ON public.failed_jobs
    FOR ALL TO woka_runtime USING (true) WITH CHECK (true);
