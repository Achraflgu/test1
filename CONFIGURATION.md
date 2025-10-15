# Configuration Guide

## Environment Variables

Set these variables in your Vercel dashboard under Settings > Environment Variables:

### Required Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `DB_HOST` | PostgreSQL database host | `ep-cool-darkness-123456.us-east-1.aws.neon.tech` |
| `DB_NAME` | Database name | `children_universe` |
| `DB_USER` | Database username | `neondb_owner` |
| `DB_PASS` | Database password | `your_secure_password` |
| `DB_PORT` | Database port | `5432` |

### Optional Variables

| Variable | Description | Example |
|----------|-------------|---------|
| `APP_ENV` | Application environment | `production` |
| `APP_DEBUG` | Debug mode | `false` |
| `JWT_SECRET` | JWT secret key | `your_jwt_secret_key` |
| `ENCRYPTION_KEY` | Encryption key | `your_encryption_key` |

## Database Setup

### 1. Create PostgreSQL Database

Choose one of these providers:

#### Option A: Neon (Recommended)
1. Go to [neon.tech](https://neon.tech)
2. Sign up for a free account
3. Create a new project
4. Copy the connection details

#### Option B: Supabase
1. Go to [supabase.com](https://supabase.com)
2. Create a new project
3. Go to Settings > Database
4. Copy the connection details

#### Option C: Railway
1. Go to [railway.app](https://railway.app)
2. Create a new project
3. Add PostgreSQL service
4. Copy the connection details

### 2. Run Database Schema

```bash
# Using psql command line
psql -h your_host -U your_username -d your_database -f database/postgres_schema.sql

# Or using a GUI tool like pgAdmin
# Open the postgres_schema.sql file and run it
```

### 3. Verify Database Setup

```sql
-- Check if tables were created
\dt

-- Check if sample data was inserted
SELECT COUNT(*) FROM activities;
SELECT COUNT(*) FROM games;
SELECT COUNT(*) FROM stories;
```

## Vercel Configuration

### 1. Deploy to Vercel

```bash
# Install Vercel CLI
npm install -g vercel

# Login to Vercel
vercel login

# Deploy
vercel --prod
```

### 2. Set Environment Variables

1. Go to your Vercel dashboard
2. Select your project
3. Go to Settings > Environment Variables
4. Add all required variables
5. Redeploy if needed

### 3. Custom Domain (Optional)

1. Go to Settings > Domains
2. Add your custom domain
3. Configure DNS settings
4. Wait for SSL certificate

## Testing

### 1. Test Database Connection

Visit: `https://your-app.vercel.app/api/test/db`

### 2. Test API Endpoints

```bash
# Test login
curl -X POST https://your-app.vercel.app/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'

# Test content
curl https://your-app.vercel.app/api/content/stories
```

### 3. Test Frontend

1. Visit your Vercel URL
2. Try registering a new account
3. Add a child profile
4. Browse content

## Troubleshooting

### Common Issues

1. **Database Connection Failed**
   - Check environment variables
   - Verify database is accessible
   - Check firewall settings

2. **API Endpoints Not Working**
   - Check Vercel function logs
   - Verify file paths
   - Test endpoints individually

3. **Static Files Not Loading**
   - Check file paths in HTML
   - Verify vercel.json configuration
   - Check file permissions

### Debug Commands

```bash
# Check Vercel logs
vercel logs

# Test locally
vercel dev

# Check deployment status
vercel ls
```

## Security Checklist

- [ ] Database credentials are secure
- [ ] Environment variables are set
- [ ] HTTPS is enabled (automatic with Vercel)
- [ ] Input validation is implemented
- [ ] Error messages don't expose sensitive data
- [ ] CORS is properly configured

## Performance Optimization

- [ ] Database indexes are created
- [ ] Images are optimized
- [ ] CDN is configured (automatic with Vercel)
- [ ] Caching is implemented
- [ ] Database queries are optimized

## Monitoring

### Vercel Analytics
- Go to Analytics tab in Vercel dashboard
- Monitor page views and performance
- Check error rates

### Database Monitoring
- Monitor connection count
- Check query performance
- Set up alerts for issues

## Backup Strategy

1. **Database Backups**
   - Most providers offer automatic backups
   - Export data regularly
   - Test restore procedures

2. **Code Backups**
   - Use Git for version control
   - Push to GitHub regularly
   - Tag releases

3. **File Backups**
   - Backup uploaded images
   - Use cloud storage
   - Implement redundancy
