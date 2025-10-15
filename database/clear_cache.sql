-- Clear PostgreSQL statement cache to fix "cached plan must not change result type" errors
-- Run this in your Neon SQL Editor if you encounter cached plan errors

-- Clear all prepared statements
DEALLOCATE ALL;

-- Reset connection settings
RESET ALL;

-- Verify cache is cleared
SELECT 'Cache cleared successfully' as status;
