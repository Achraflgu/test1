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
    const { email, password } = req.body;
    
    if (!email || !password) {
      res.status(400).json({ error: 'Email and password are required' });
      return;
    }

    // Create PostgreSQL client
    const client = createClient({
      connectionString: process.env.POSTGRES_URL,
    });

    await client.connect();

    // Get user from database
    const userResult = await client.query(
      'SELECT * FROM users WHERE email = $1',
      [email]
    );

    if (userResult.rows.length === 0) {
      res.status(401).json({ error: 'Invalid credentials' });
      return;
    }

    const user = userResult.rows[0];

    // For now, using simple password comparison (in production, use bcrypt)
    if (password !== user.password) {
      res.status(401).json({ error: 'Invalid credentials' });
      return;
    }

    // Get children for this user
    const childrenResult = await client.query(
      'SELECT * FROM children WHERE user_id = $1 ORDER BY created_at DESC',
      [user.id]
    );

    // Remove password from response
    delete user.password;

    const response = {
      success: true,
      user: user,
      children: childrenResult.rows,
      isAdmin: user.isadmin
    };

    res.json(response);

  } catch (error) {
    console.error('Login error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
};
