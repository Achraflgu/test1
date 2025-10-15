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
    const { email, password, is_parent, number_of_kids } = req.body;
    
    if (!email || !password) {
      res.status(400).json({ error: 'Email and password are required' });
      return;
    }

    // Create PostgreSQL client
    const client = createClient({
      connectionString: process.env.POSTGRES_URL,
    });

    await client.connect();

    // Check if user already exists
    const existingUser = await client.query(
      'SELECT id FROM users WHERE email = $1',
      [email]
    );

    if (existingUser.rows.length > 0) {
      res.status(409).json({ error: 'User already exists' });
      return;
    }

    // Create new user
    const result = await client.query(
      'INSERT INTO users (email, password, is_parent, number_of_kids) VALUES ($1, $2, $3, $4) RETURNING id',
      [email, password, is_parent, number_of_kids]
    );

    const response = {
      success: true,
      message: 'User created successfully',
      user_id: result.rows[0].id
    };

    res.json(response);

  } catch (error) {
    console.error('Registration error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
};
