# 🔧 Troubleshooting Guide

## Common Issues and Solutions

### 1. "cached plan must not change result type" Error

**Problem**: PostgreSQL prepared statement cache gets confused after schema changes.

**Solutions**:

#### Option A: Run Cache Clear Script
1. Go to your **Neon SQL Editor**
2. Run the script from `database/clear_cache.sql`:
   ```sql
   DEALLOCATE ALL;
   RESET ALL;
   ```

#### Option B: Restart Your Railway App
1. Go to your **Railway dashboard**
2. Click **"Redeploy"** on your project
3. This will restart the app with fresh connections

#### Option C: Use the Updated Code
The updated code now automatically handles this error by recreating the database connection when this specific error occurs.

### 2. Database Schema Issues

**Problem**: Missing columns or incorrect table structure.

**Solution**:
1. Run the complete setup script: `database/neon_complete_setup.sql`
2. Or run the data-only script: `database/neon_insert_data.sql`

### 3. Connection Issues

**Problem**: Cannot connect to Neon database.

**Check**:
1. **Environment Variables** in Railway dashboard:
   ```
   DATABASE_URL=postgresql://neondb_owner:npg_xyEhR4J2noge@ep-fragrant-snow-ad5dpiqs-pooler.c-2.us-east-1.aws.neon.tech/neondb?sslmode=require
   ```

2. **Neon Database Status**: Make sure your Neon database is running

3. **Network Access**: Check if your Neon database allows connections from Railway

### 4. Login Issues

**Problem**: Cannot login with test accounts.

**Test Accounts**:
- **Admin**: `admin@childrenuniverse.com` / `admin123`
- **Parent**: `parent1@example.com` / `password123`

**Check**:
1. Make sure the users table has data
2. Run: `SELECT * FROM users;` in Neon SQL Editor

### 5. Missing Data

**Problem**: No activities, games, or stories showing.

**Solution**:
1. Run the data insertion script: `database/neon_insert_data.sql`
2. Check if data exists: `SELECT COUNT(*) FROM activities;`

### 6. File Upload Issues

**Problem**: Cannot upload child photos.

**Check**:
1. **Upload Directory**: Make sure `uploads/` directory exists
2. **Permissions**: Check file permissions on Railway
3. **File Size**: Check if files are too large

### 7. Admin Panel Issues

**Problem**: Cannot access admin panel.

**Check**:
1. **User Role**: Make sure user has `isAdmin = true`
2. **Database**: Check if `isAdmin` column exists
3. **Login**: Make sure you're logged in as admin user

## 🔍 Debugging Steps

### Step 1: Check Railway Logs
1. Go to **Railway dashboard**
2. Click on your project
3. Go to **"Deployments"** tab
4. Click on the latest deployment
5. Check **"Logs"** for any errors

### Step 2: Check Database Connection
Run this in Neon SQL Editor:
```sql
SELECT current_database(), current_user, version();
```

### Step 3: Check Table Structure
```sql
-- Check users table
\d users;

-- Check children table
\d children;

-- Check if data exists
SELECT COUNT(*) FROM users;
SELECT COUNT(*) FROM children;
```

### Step 4: Test Database Queries
```sql
-- Test user login query
SELECT * FROM users WHERE email = 'admin@childrenuniverse.com';

-- Test children query
SELECT * FROM children WHERE user_id = 1;
```

## 🚀 Quick Fixes

### If Nothing Works:
1. **Complete Reset**:
   - Run `database/neon_complete_setup.sql` in Neon
   - Redeploy your Railway app
   - Test with admin account

2. **Environment Variables**:
   - Double-check all environment variables in Railway
   - Make sure `DATABASE_URL` is correct

3. **Database Status**:
   - Check if Neon database is active
   - Verify connection string is correct

## 📞 Support

If you're still having issues:
1. **Check Railway logs** for specific error messages
2. **Check Neon logs** for database errors
3. **Verify environment variables** are set correctly
4. **Test database connection** directly in Neon SQL Editor

## ✅ Success Indicators

Your app is working correctly when:
- ✅ User registration works
- ✅ User login works
- ✅ Child profiles can be created
- ✅ Activities, games, and stories load
- ✅ Admin panel is accessible
- ✅ No errors in Railway logs
