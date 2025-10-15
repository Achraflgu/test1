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
    const { category = 'all', kid_id, limit = 5 } = req.query;

    // Create PostgreSQL client
    const client = createClient({
      connectionString: process.env.POSTGRES_URL,
    });

    await client.connect();

    let whereClause = '';
    let params = [];
    let paramCount = 0;

    // If kidId is provided, check for hidden categories
    if (kid_id) {
      const hiddenCategories = await client.query(
        'SELECT hidden_activities_categories FROM children WHERE id = $1',
        [kid_id]
      );

      let hiddenCats = [];
      if (hiddenCategories.rows.length > 0 && hiddenCategories.rows[0].hidden_activities_categories) {
        hiddenCats = hiddenCategories.rows[0].hidden_activities_categories.split(',').map(cat => cat.trim());
      }

      if (category !== 'all') {
        if (hiddenCats.includes(category)) {
          res.status(403).json({ error: 'Category is hidden for this child' });
          return;
        }
        whereClause = 'WHERE category = $1';
        params.push(category);
        paramCount = 1;
      } else {
        if (hiddenCats.length > 0) {
          const placeholders = hiddenCats.map((_, index) => `$${paramCount + index + 1}`).join(',');
          whereClause = `WHERE category IS NULL OR category NOT IN (${placeholders})`;
          params.push(...hiddenCats);
          paramCount = hiddenCats.length;
        }
      }
    } else {
      if (category !== 'all') {
        whereClause = 'WHERE category = $1';
        params.push(category);
        paramCount = 1;
      }
    }

    // Add limit
    params.push(parseInt(limit));
    const limitParam = `$${paramCount + 1}`;

    const activities = await client.query(
      `SELECT * FROM activities ${whereClause} ORDER BY RAND() LIMIT ${limitParam}`,
      params
    );

    res.json({
      success: true,
      activities: activities.rows,
      count: activities.rows.length
    });

  } catch (error) {
    console.error('Get activities error:', error);
    res.status(500).json({ error: 'Internal server error' });
  }
};
