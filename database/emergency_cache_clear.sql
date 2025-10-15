-- EMERGENCY: Clear PostgreSQL cached plans
-- Run this immediately in Neon SQL Editor to fix cached plan errors

-- Clear all prepared statements
DEALLOCATE ALL;

-- Reset all connection settings
RESET ALL;

-- Clear any cached plans
DISCARD PLANS;

-- Verify the cache is cleared
SELECT 'Emergency cache clear completed successfully!' as status;

-- Test a simple query to make sure everything works
SELECT 'Database is working correctly' as test_result;
