-- URGENT FIX: Add missing historic_data table to Neon database
-- Copy and paste this entire script into your Neon SQL editor

-- Step 1: Create the historic_data table
CREATE TABLE IF NOT EXISTS historic_data (
    id SERIAL PRIMARY KEY,
    kid_id INTEGER NOT NULL,
    date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    page_name VARCHAR(255)
);

-- Step 2: Add foreign key constraint (if children table exists)
-- If this fails, it means the children table doesn't exist yet
DO $$
BEGIN
    IF EXISTS (SELECT 1 FROM information_schema.tables WHERE table_name = 'children') THEN
        ALTER TABLE historic_data 
        ADD CONSTRAINT fk_historic_data_kid_id 
        FOREIGN KEY (kid_id) REFERENCES children(id) ON DELETE CASCADE;
    END IF;
END $$;

-- Step 3: Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_historic_data_kid_id ON historic_data(kid_id);
CREATE INDEX IF NOT EXISTS idx_historic_data_date_time ON historic_data(date_time);

-- Step 4: Insert some sample data to test
INSERT INTO historic_data (kid_id, date_time, page_name) VALUES
(1, NOW(), 'acceuil_male.php'),
(1, NOW() - INTERVAL '1 hour', 'stories.html'),
(1, NOW() - INTERVAL '2 hours', 'games.html');

-- Verify the table was created
SELECT 'historic_data table created successfully!' as status;
SELECT COUNT(*) as record_count FROM historic_data;
