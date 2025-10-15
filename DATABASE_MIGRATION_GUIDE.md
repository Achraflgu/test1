# Database Migration Guide

## 🚨 Database Schema Issues Fixed

The errors you encountered were due to schema mismatches between the original MySQL structure and the PostgreSQL schema. Here's how to fix them:

## 🔧 Issues Found:

1. **Missing `username` column** in users table
2. **Missing `isAdmin` column** in users table  
3. **Column name mismatches** between expected and actual schema

## 📋 Solution Steps:

### Step 1: Update Your Neon Database Schema

1. **Go to your Neon dashboard**
2. **Open the SQL Editor**
3. **Run the corrected schema** from `database/corrected_postgres_schema.sql`

This will:
- ✅ Drop existing tables (if they exist)
- ✅ Create tables with correct column names
- ✅ Add the missing `username` column
- ✅ Add the missing `isAdmin` column
- ✅ Insert sample data
- ✅ Create proper indexes

### Step 2: Alternative - Manual Schema Update

If you prefer to keep existing data, run these SQL commands in Neon:

```sql
-- Add missing columns to users table
ALTER TABLE users ADD COLUMN IF NOT EXISTS username VARCHAR(255) DEFAULT NULL;
ALTER TABLE users ADD COLUMN IF NOT EXISTS isAdmin BOOLEAN DEFAULT FALSE;

-- Update existing users to have username (use email as username)
UPDATE users SET username = email WHERE username IS NULL;

-- Make sure isAdmin column exists and has default values
UPDATE users SET isAdmin = FALSE WHERE isAdmin IS NULL;
```

### Step 3: Verify Schema

After running the migration, verify your schema with:

```sql
-- Check users table structure
\d users;

-- Check children table structure  
\d children;

-- Check if data exists
SELECT * FROM users LIMIT 5;
SELECT * FROM children LIMIT 5;
```

## 🎯 Expected Schema:

### Users Table:
```sql
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) DEFAULT NULL,  -- ✅ Added
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_parent BOOLEAN DEFAULT NULL,
    number_of_kids INTEGER DEFAULT NULL,
    isAdmin BOOLEAN DEFAULT FALSE,       -- ✅ Added
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Children Table:
```sql
CREATE TABLE children (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,  -- ✅ Correct
    kid_gender VARCHAR(255) DEFAULT NULL,
    kid_name VARCHAR(255) DEFAULT NULL,
    kid_age INTEGER DEFAULT NULL,
    kid_photo VARCHAR(255) DEFAULT NULL,
    -- ... other columns
);
```

## 🚀 After Migration:

1. **Railway will automatically redeploy** with the updated code
2. **Test user registration** - should work without errors
3. **Test user login** - should work without errors
4. **Test child profile creation** - should work without errors

## 🔍 Troubleshooting:

### If you still get errors:

1. **Check column names** in your Neon database:
   ```sql
   SELECT column_name, data_type FROM information_schema.columns 
   WHERE table_name = 'users';
   ```

2. **Verify foreign key relationships**:
   ```sql
   SELECT * FROM information_schema.table_constraints 
   WHERE table_name = 'children' AND constraint_type = 'FOREIGN KEY';
   ```

3. **Check if tables exist**:
   ```sql
   SELECT table_name FROM information_schema.tables 
   WHERE table_schema = 'public';
   ```

## ✅ Success Indicators:

After successful migration:
- ✅ User registration works
- ✅ User login works  
- ✅ Child profiles can be created
- ✅ Admin panel accessible
- ✅ No database errors in Railway logs

Your application should now work perfectly with PostgreSQL on Railway! 🎉
