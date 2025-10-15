const { Pool } = require('pg');

const pool = new Pool({
  host: process.env.DB_HOST,
  database: process.env.DB_NAME,
  user: process.env.DB_USER,
  password: process.env.DB_PASS,
  port: process.env.DB_PORT || 5432,
  ssl: process.env.NODE_ENV === 'production' ? { rejectUnauthorized: false } : false
});

export default async function handler(req, res) {
  // Set CORS headers
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') {
    res.status(200).end();
    return;
  }

  try {
    // Test database connection
    const result = await pool.query('SELECT NOW() as current_time');
    
    // Check if users table exists and has data
    const usersResult = await pool.query('SELECT COUNT(*) as user_count FROM users');
    const activitiesResult = await pool.query('SELECT COUNT(*) as activity_count FROM activities');
    const gamesResult = await pool.query('SELECT COUNT(*) as game_count FROM games');
    const storiesResult = await pool.query('SELECT COUNT(*) as story_count FROM stories');

    res.status(200).json({
      success: true,
      message: 'Database connection successful',
      currentTime: result.rows[0].current_time,
      stats: {
        users: parseInt(usersResult.rows[0].user_count),
        activities: parseInt(activitiesResult.rows[0].activity_count),
        games: parseInt(gamesResult.rows[0].game_count),
        stories: parseInt(storiesResult.rows[0].story_count)
      },
      environment: {
        DB_HOST: process.env.DB_HOST ? 'Set' : 'Not set',
        DB_NAME: process.env.DB_NAME ? 'Set' : 'Not set',
        DB_USER: process.env.DB_USER ? 'Set' : 'Not set',
        DB_PASS: process.env.DB_PASS ? 'Set' : 'Not set',
        DB_PORT: process.env.DB_PORT || '5432'
      }
    });

  } catch (error) {
    console.error('Database test error:', error);
    res.status(500).json({
      success: false,
      error: 'Database connection failed',
      message: error.message,
      environment: {
        DB_HOST: process.env.DB_HOST ? 'Set' : 'Not set',
        DB_NAME: process.env.DB_NAME ? 'Set' : 'Not set',
        DB_USER: process.env.DB_USER ? 'Set' : 'Not set',
        DB_PASS: process.env.DB_PASS ? 'Set' : 'Not set',
        DB_PORT: process.env.DB_PORT || '5432'
      }
    });
  }
}
