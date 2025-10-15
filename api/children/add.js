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
  res.setHeader('Access-Control-Allow-Methods', 'POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

  if (req.method === 'OPTIONS') {
    res.status(200).end();
    return;
  }

  if (req.method !== 'POST') {
    res.status(405).json({ error: 'Method not allowed' });
    return;
  }

  try {
    const { user_id, kid_name, kid_gender, kid_age, kid_photo } = req.body;
    
    if (!user_id || !kid_name || !kid_gender || !kid_age) {
      res.status(400).json({ error: 'Required fields: user_id, kid_name, kid_gender, kid_age' });
      return;
    }

    // Validate gender
    if (!['male', 'female'].includes(kid_gender)) {
      res.status(400).json({ error: 'Invalid gender. Must be male or female' });
      return;
    }

    // Validate age
    if (kid_age < 3 || kid_age > 6) {
      res.status(400).json({ error: 'Age must be between 3 and 6' });
      return;
    }

    // Create new child profile
    const result = await pool.query(
      'INSERT INTO children (user_id, kid_name, kid_gender, kid_age, kid_photo) VALUES ($1, $2, $3, $4, $5) RETURNING id',
      [user_id, kid_name, kid_gender, kid_age, kid_photo]
    );

    const response = {
      success: true,
      message: 'Child profile created successfully',
      child_id: result.rows[0].id
    };

    res.status(200).json(response);

  } catch (error) {
    console.error('Add child error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
}
