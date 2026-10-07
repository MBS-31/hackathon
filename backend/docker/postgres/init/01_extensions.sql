-- =============================================================================
-- PostgreSQL Initialization Script
-- Runs once when the crm-db container is first created.
-- =============================================================================

-- Enable useful PostgreSQL extensions
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";    -- UUID generation
CREATE EXTENSION IF NOT EXISTS "pg_trgm";      -- Trigram text search (for fuzzy search)
CREATE EXTENSION IF NOT EXISTS "btree_gin";    -- Composite GIN indexes

-- Set the search path
SET search_path TO public;

-- Log that initialization completed
DO $$
BEGIN
    RAISE NOTICE 'CRM Database initialized with extensions: uuid-ossp, pg_trgm, btree_gin';
END $$;
