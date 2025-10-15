# Railway Deployment Guide

## 🚀 Deploy Your Children's Universe Project to Railway

Railway provides excellent PHP support and works perfectly with your existing PHP structure and Neon PostgreSQL database.

## 📋 Prerequisites

1. **Railway Account**: Sign up at [railway.app](https://railway.app)
2. **Neon Database**: Set up at [neon.tech](https://neon.tech)
3. **GitHub Repository**: Your code is already pushed to GitHub

## 🛠️ Step-by-Step Deployment

### 1. Set up Neon Database

1. Go to [neon.tech](https://neon.tech) and create a free account
2. Create a new project
3. Create a database named `children_universe`
4. Run the SQL schema from `database/postgres_schema.sql`
5. Note down your connection details:
   - **Host**: `ep-xxxxx-xxxxx.us-east-1.aws.neon.tech`
   - **Database**: `children_universe`
   - **Username**: `neondb_owner`
   - **Password**: Your generated password
   - **Port**: `5432`

### 2. Deploy to Railway

1. **Go to Railway**: Visit [railway.app](https://railway.app)
2. **Sign up with GitHub**: Connect your GitHub account
3. **Create New Project**: Click "New Project"
4. **Deploy from GitHub**: Select "Deploy from GitHub repo"
5. **Select Repository**: Choose `Achraflgu/test1`
6. **Railway will automatically detect PHP** and start building

### 3. Configure Environment Variables

In your Railway project dashboard:

1. Go to **Variables** tab
2. Add these environment variables:

| Variable | Value | Example |
|----------|-------|---------|
| `DB_HOST` | Your Neon host | `ep-cool-darkness-123456.us-east-1.aws.neon.tech` |
| `DB_NAME` | Database name | `children_universe` |
| `DB_USER` | Your Neon username | `neondb_owner` |
| `DB_PASS` | Your Neon password | `your_secure_password` |
| `DB_PORT` | Database port | `5432` |

### 4. Deploy and Test

1. **Deploy**: Railway will automatically deploy when you push to GitHub
2. **Get URL**: Railway will provide you with a public URL
3. **Test Your App**: Visit your Railway URL
4. **Test Database**: Try logging in or registering

## 🔧 Railway Configuration Files

The following files have been added for Railway deployment:

- **`railway.json`**: Railway-specific configuration
- **`nixpacks.toml`**: Build configuration for PHP
- **`composer.json`**: PHP dependencies
- **`.railwayignore`**: Files to ignore during deployment

## 📊 What Works on Railway

✅ **PHP Files**: All your existing PHP code
✅ **Database**: PostgreSQL with Neon
✅ **Static Files**: HTML, CSS, JS, images
✅ **File Uploads**: Upload functionality
✅ **Sessions**: PHP sessions work
✅ **Admin Panel**: Full admin functionality

## 🌐 Accessing Your App

After deployment, Railway will provide you with:
- **Public URL**: `https://your-app-name.railway.app`
- **Custom Domain**: You can add your own domain later

## 🔍 Troubleshooting

### Common Issues:

1. **Database Connection Failed**
   - Check environment variables are set correctly
   - Verify Neon database is running
   - Check firewall settings

2. **Build Fails**
   - Check `composer.json` for missing dependencies
   - Verify PHP version compatibility

3. **File Upload Issues**
   - Check file permissions
   - Verify upload directory exists

### Debug Commands:

```bash
# Check Railway logs
railway logs

# Connect to Railway shell
railway shell

# Check environment variables
railway variables
```

## 🚀 Advantages of Railway over Vercel

- ✅ **Native PHP Support**: No runtime issues
- ✅ **PostgreSQL Ready**: Works perfectly with Neon
- ✅ **File System Access**: Full file system support
- ✅ **Sessions**: PHP sessions work correctly
- ✅ **Easy Deployment**: Just connect GitHub repo
- ✅ **Environment Variables**: Simple configuration
- ✅ **Free Tier**: No cost for small projects

## 📞 Support

- **Railway Docs**: [docs.railway.app](https://docs.railway.app)
- **Neon Docs**: [neon.tech/docs](https://neon.tech/docs)
- **GitHub Issues**: Create an issue in your repository

## 🎉 Success!

Once deployed, your Children's Universe platform will be live with:
- Full PHP functionality
- PostgreSQL database with Neon
- Admin panel working
- User registration and login
- Content management
- File uploads
- All existing features working perfectly!

Your app will be accessible at: `https://your-app-name.railway.app`
