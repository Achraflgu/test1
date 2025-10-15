-- Add historic_data table to existing database
-- Run this script on your Neon database to create the missing table

CREATE TABLE IF NOT EXISTS historic_data (
    id SERIAL PRIMARY KEY,
    kid_id INTEGER NOT NULL,
    date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    page_name VARCHAR(255),
    FOREIGN KEY (kid_id) REFERENCES children(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_historic_data_kid_id ON historic_data(kid_id);
CREATE INDEX IF NOT EXISTS idx_historic_data_date_time ON historic_data(date_time);

-- Insert some sample data (optional)
INSERT INTO historic_data (kid_id, date_time, page_name) VALUES
(1, NOW(), 'acceuil_male.php'),
(1, NOW() - INTERVAL '1 hour', 'stories.html'),
(1, NOW() - INTERVAL '2 hours', 'games.html'),
(2, NOW(), 'acceuil_female.php'),
(2, NOW() - INTERVAL '30 minutes', 'activities.html');
