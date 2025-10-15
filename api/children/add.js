const { createClient } = require('@vercel/postgres');

module.exports = async (req, res) => {
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

    // Create PostgreSQL client
    const client = createClient({
      connectionString: process.env.POSTGRES_URL,
    });

    await client.connect();

    // Create new child profile
    const result = await client.query(
      'INSERT INTO children (user_id, kid_name, kid_gender, kid_age, kid_photo) VALUES ($1, $2, $3, $4, $5) RETURNING id',
      [user_id, kid_name, kid_gender, kid_age, kid_photo]
    );

    res.json({
      success: true,
      message: 'Child profile created successfully',
      child_id: result.rows[0].id
    });

  } catch (error) {
    console.error('Add child error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
};
