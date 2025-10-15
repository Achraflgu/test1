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
    const { category = 'all', kid_id, limit = 5 } = req.query;

    let query = 'SELECT * FROM stories';
    let params = [];
    let paramCount = 0;

    // If kidId is provided, check for hidden categories
    if (kid_id) {
      const hiddenResult = await pool.query(
        'SELECT hidden_stories_categories FROM children WHERE id = $1',
        [kid_id]
      );

      let hiddenCats = [];
      if (hiddenResult.rows.length > 0 && hiddenResult.rows[0].hidden_stories_categories) {
        hiddenCats = hiddenResult.rows[0].hidden_stories_categories.split(',').map(cat => cat.trim());
      }

      if (category !== 'all') {
        if (hiddenCats.includes(category)) {
          res.status(403).json({ error: 'Category is hidden for this child' });
          return;
        }
        query += ' WHERE category = $1';
        params.push(category);
        paramCount++;
      } else {
        if (hiddenCats.length > 0) {
          const placeholders = hiddenCats.map((_, index) => `$${paramCount + index + 1}`).join(',');
          query += ` WHERE category IS NULL OR category NOT IN (${placeholders})`;
          params.push(...hiddenCats);
          paramCount += hiddenCats.length;
        }
      }
    } else {
      if (category !== 'all') {
        query += ' WHERE category = $1';
        params.push(category);
        paramCount++;
      }
    }

    // Add limit
    query += ` ORDER BY RAND() LIMIT $${paramCount + 1}`;
    params.push(parseInt(limit));

    const result = await pool.query(query, params);

    res.status(200).json({
      success: true,
      stories: result.rows,
      count: result.rows.length
    });

  } catch (error) {
    console.error('Get stories error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
}
