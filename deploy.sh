#!/bin/bash

# Children's Universe - Vercel Deployment Script
# This script helps deploy the application to Vercel

echo "🚀 Children's Universe - Vercel Deployment Script"
echo "=================================================="

# Check if Vercel CLI is installed
if ! command -v vercel &> /dev/null; then
    echo "❌ Vercel CLI is not installed. Please install it first:"
    echo "   npm install -g vercel"
    exit 1
fi

# Check if user is logged in to Vercel
if ! vercel whoami &> /dev/null; then
    echo "🔐 Please log in to Vercel:"
    vercel login
fi

echo "📦 Installing dependencies..."
npm install

echo "🔧 Building project..."
# No build step required for static files

echo "🚀 Deploying to Vercel..."
vercel --prod

echo "✅ Deployment complete!"
echo ""
echo "📋 Next steps:"
echo "1. Set up your PostgreSQL database"
echo "2. Configure environment variables in Vercel dashboard:"
echo "   - DB_HOST: Your PostgreSQL host"
echo "   - DB_NAME: children_universe"
echo "   - DB_USER: Your database username"
echo "   - DB_PASS: Your database password"
echo "   - DB_PORT: 5432"
echo "3. Run the database schema: database/postgres_schema.sql"
echo "4. Test your deployment!"
echo ""
echo "🌐 Your app should be live at the URL provided above."
