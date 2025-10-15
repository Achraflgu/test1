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

  if (req.method !== 'GET') {
    res.status(405).json({ error: 'Method not allowed' });
    return;
  }

  try {
    const { user_id, kid_id } = req.query;

    if (user_id) {
      // Get all children for a user
      const result = await pool.query(
        'SELECT * FROM children WHERE user_id = $1 ORDER BY created_at DESC',
        [user_id]
      );

      res.status(200).json({
        success: true,
        children: result.rows
      });
    } else if (kid_id) {
      // Get specific child
      const result = await pool.query(
        'SELECT * FROM children WHERE id = $1',
        [kid_id]
      );

      if (result.rows.length === 0) {
        res.status(404).json({ error: 'Child not found' });
        return;
      }

      res.status(200).json({
        success: true,
        child: result.rows[0]
      });
    } else {
      res.status(400).json({ error: 'user_id or kid_id parameter required' });
    }

  } catch (error) {
    console.error('Get children error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
}
