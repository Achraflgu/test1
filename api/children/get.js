const { createClient } = require('@vercel/postgres');

module.exports = async (req, res) => {
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

    // Create PostgreSQL client
    const client = createClient({
      connectionString: process.env.POSTGRES_URL,
    });

    await client.connect();

    if (user_id) {
      // Get all children for a user
      const children = await client.query(
        'SELECT * FROM children WHERE user_id = $1 ORDER BY created_at DESC',
        [user_id]
      );

      res.json({
        success: true,
        children: children.rows
      });
    } else if (kid_id) {
      // Get specific child
      const child = await client.query(
        'SELECT * FROM children WHERE id = $1',
        [kid_id]
      );

      if (child.rows.length === 0) {
        res.status(404).json({ error: 'Child not found' });
        return;
      }

      res.json({
        success: true,
        child: child.rows[0]
      });
    } else {
      res.status(400).json({ error: 'user_id or kid_id parameter required' });
    }

  } catch (error) {
    console.error('Get children error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
};
