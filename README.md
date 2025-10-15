# Children's Universe - Vercel Deployment

A children's educational platform with stories, games, and activities, rebuilt for Vercel deployment with PostgreSQL backend.

## Features

- **User Authentication**: Login and registration system
- **Child Profiles**: Multiple child profiles per parent account
- **Content Management**: Stories, games, and activities with categories
- **Admin Panel**: Content management interface
- **Responsive Design**: Works on all devices
- **PostgreSQL Backend**: Scalable database solution

## Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (jQuery), Bootstrap 4
- **Backend**: PHP 8+ with PDO
- **Database**: PostgreSQL
- **Deployment**: Vercel
- **API**: RESTful API endpoints

## Project Structure

```
├── api/                          # Vercel serverless functions
│   ├── auth/                     # Authentication endpoints
│   │   ├── login.php
│   │   └── register.php
│   ├── children/                 # Child profile management
│   │   ├── add.php
│   │   └── get.php
│   └── content/                  # Content APIs
│       ├── activities.php
│       ├── games.php
│       └── stories.php
├── config/                       # Configuration files
│   └── database.php              # Database connection
├── database/                     # Database schema
│   └── postgres_schema.sql       # PostgreSQL schema
├── Assets/                       # Static assets
├── images/                       # Image files
├── css/                          # CSS files
├── js/                           # JavaScript files
├── *.html                        # Main pages
├── vercel.json                   # Vercel configuration
└── package.json                  # Dependencies
```

## Database Setup

1. **Create PostgreSQL Database**:
   ```sql
   CREATE DATABASE children_universe;
   ```

2. **Run Schema**:
   ```bash
   psql -d children_universe -f database/postgres_schema.sql
   ```

3. **Environment Variables** (set in Vercel dashboard):
   - `DB_HOST`: Your PostgreSQL host
   - `DB_NAME`: Database name (children_universe)
   - `DB_USER`: Database username
   - `DB_PASS`: Database password
   - `DB_PORT`: Database port (5432)

## Vercel Deployment

### Prerequisites

1. **Vercel Account**: Sign up at [vercel.com](https://vercel.com)
2. **PostgreSQL Database**: Use services like:
   - [Neon](https://neon.tech) (recommended)
   - [Supabase](https://supabase.com)
   - [Railway](https://railway.app)
   - [PlanetScale](https://planetscale.com)

### Deployment Steps

1. **Install Vercel CLI**:
   ```bash
   npm install -g vercel
   ```

2. **Login to Vercel**:
   ```bash
   vercel login
   ```

3. **Deploy**:
   ```bash
   vercel --prod
   ```

4. **Set Environment Variables**:
   - Go to your Vercel dashboard
   - Navigate to your project
   - Go to Settings > Environment Variables
   - Add the database connection variables

### Alternative: GitHub Integration

1. **Push to GitHub**:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git remote add origin https://github.com/yourusername/children-universe.git
   git push -u origin main
   ```

2. **Connect to Vercel**:
   - Go to [vercel.com](https://vercel.com)
   - Click "New Project"
   - Import from GitHub
   - Select your repository
   - Configure environment variables
   - Deploy

## API Endpoints

### Authentication
- `POST /api/auth/login` - User login
- `POST /api/auth/register` - User registration

### Children
- `GET /api/children/get?user_id={id}` - Get children for user
- `GET /api/children/get?kid_id={id}` - Get specific child
- `POST /api/children/add` - Add new child profile

### Content
- `GET /api/content/stories?kid_id={id}&limit={n}` - Get stories
- `GET /api/content/games?kid_id={id}&limit={n}` - Get games
- `GET /api/content/activities?kid_id={id}&limit={n}` - Get activities

## Usage

1. **Access the Application**: Visit your Vercel deployment URL
2. **Register**: Create a new account
3. **Add Child Profile**: Add your child's information
4. **Explore Content**: Browse stories, games, and activities
5. **Admin Access**: Use admin credentials to manage content

## Development

### Local Development

1. **Install Dependencies**:
   ```bash
   npm install
   ```

2. **Start Development Server**:
   ```bash
   vercel dev
   ```

3. **Access**: http://localhost:3000

### Adding New Features

1. **API Endpoints**: Add new PHP files in the `api/` directory
2. **Frontend Pages**: Create new HTML files
3. **Database Changes**: Update the PostgreSQL schema
4. **Styling**: Modify CSS files or add new ones

## Security Considerations

- **Password Hashing**: Implement proper password hashing in production
- **Input Validation**: Add server-side validation for all inputs
- **CORS**: Configure CORS properly for production
- **HTTPS**: Vercel provides HTTPS by default
- **Database Security**: Use connection pooling and prepared statements

## Troubleshooting

### Common Issues

1. **Database Connection Failed**:
   - Check environment variables
   - Verify database credentials
   - Ensure database is accessible

2. **API Endpoints Not Working**:
   - Check Vercel function logs
   - Verify file paths in `vercel.json`
   - Test endpoints individually

3. **Static Files Not Loading**:
   - Check file paths in HTML
   - Verify `vercel.json` routes configuration
   - Ensure files are in the correct directories

### Debugging

1. **Vercel Logs**:
   ```bash
   vercel logs
   ```

2. **Local Testing**:
   ```bash
   vercel dev
   ```

3. **Database Testing**: Use tools like pgAdmin or DBeaver

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

For support, email support@childrensuniverse.com or create an issue on GitHub.

## Changelog

### Version 1.0.0
- Initial release
- Vercel deployment ready
- PostgreSQL backend
- RESTful API
- Responsive design
- Admin panel
