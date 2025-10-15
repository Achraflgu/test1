# Railway Environment Variables Setup

## 🔧 Environment Variables for Railway Deployment

Use these environment variables in your Railway project dashboard:

### Option 1: Single DATABASE_URL (Recommended)
```
DATABASE_URL=postgresql://neondb_owner:npg_xyEhR4J2noge@ep-fragrant-snow-ad5dpiqs-pooler.c-2.us-east-1.aws.neon.tech/neondb?sslmode=require
```

### Option 2: Individual Variables
```
PGHOST=ep-fragrant-snow-ad5dpiqs-pooler.c-2.us-east-1.aws.neon.tech
PGDATABASE=neondb
PGUSER=neondb_owner
PGPASSWORD=npg_xyEhR4J2noge
PGPORT=5432
```

## 🚀 How to Set Environment Variables in Railway

### Step 1: Go to Railway Dashboard
1. Visit [railway.app](https://railway.app)
2. Sign in with your GitHub account
3. Select your deployed project

### Step 2: Add Environment Variables
1. Click on your project
2. Go to the **Variables** tab
3. Click **+ New Variable**
4. Add the variables one by one:

| Variable Name | Variable Value |
|---------------|----------------|
| `DATABASE_URL` | `postgresql://neondb_owner:npg_xyEhR4J2noge@ep-fragrant-snow-ad5dpiqs-pooler.c-2.us-east-1.aws.neon.tech/neondb?sslmode=require` |

OR use individual variables:

| Variable Name | Variable Value |
|---------------|----------------|
| `PGHOST` | `ep-fragrant-snow-ad5dpiqs-pooler.c-2.us-east-1.aws.neon.tech` |
| `PGDATABASE` | `neondb` |
| `PGUSER` | `neondb_owner` |
| `PGPASSWORD` | `npg_xyEhR4J2noge` |
| `PGPORT` | `5432` |

### Step 3: Deploy
1. After adding variables, Railway will automatically redeploy
2. Your app will now connect to the Neon database
3. Visit your Railway URL to test

## 🎯 Database Setup

### 1. Create Database Schema
Before deploying, make sure to run the SQL schema in your Neon database:

1. Go to your Neon dashboard
2. Open the SQL Editor
3. Copy and paste the contents of `database/postgres_schema.sql`
4. Execute the SQL to create tables and sample data

### 2. Test Database Connection
After deployment, you can test the database connection by:
1. Visiting your Railway URL
2. Trying to register a new user
3. Checking if data is saved in Neon dashboard

## 🔍 Troubleshooting

### Database Connection Issues
- Verify environment variables are set correctly
- Check that the Neon database is running
- Ensure the database name is `neondb` (not `children_universe`)

### Common Errors
- **Connection refused**: Check PGHOST value
- **Authentication failed**: Verify PGUSER and PGPASSWORD
- **Database not found**: Check PGDATABASE value

### Debug Commands
```bash
# Check Railway logs
railway logs

# Connect to Railway shell
railway shell

# Check environment variables
echo $DATABASE_URL
```

## ✅ Success Indicators

Your deployment is successful when:
- ✅ Railway shows "Deployed" status
- ✅ No errors in Railway logs
- ✅ You can access your app at the Railway URL
- ✅ User registration works
- ✅ Data appears in Neon database

## 🎉 Your App URL

Once deployed, your app will be available at:
`https://your-project-name.railway.app`

Replace `your-project-name` with your actual Railway project name.
