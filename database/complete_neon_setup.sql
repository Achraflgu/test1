-- Complete Neon Database Setup Script
-- This script creates all necessary tables including the missing historic_data table

-- Drop existing tables if they exist (be careful with this in production)
-- DROP TABLE IF EXISTS historic_data CASCADE;
-- DROP TABLE IF EXISTS feedback CASCADE;
-- DROP TABLE IF EXISTS notifications CASCADE;
-- DROP TABLE IF EXISTS stories CASCADE;
-- DROP TABLE IF EXISTS games CASCADE;
-- DROP TABLE IF EXISTS activities CASCADE;
-- DROP TABLE IF EXISTS children CASCADE;
-- DROP TABLE IF EXISTS users CASCADE;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_parent BOOLEAN DEFAULT false,
    number_of_kids INTEGER DEFAULT 0,
    isAdmin BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create children table
CREATE TABLE IF NOT EXISTS children (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    kid_gender VARCHAR(10) NOT NULL,
    kid_name VARCHAR(255) NOT NULL,
    kid_age INTEGER NOT NULL,
    kid_photo VARCHAR(500),
    hidden_stories_categories TEXT,
    hidden_games_categories TEXT,
    hidden_activities_categories TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create stories table
CREATE TABLE IF NOT EXISTS stories (
    id SERIAL PRIMARY KEY,
    story_title VARCHAR(255) NOT NULL,
    description TEXT,
    photo VARCHAR(500),
    link_of_stories VARCHAR(500),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create games table
CREATE TABLE IF NOT EXISTS games (
    id SERIAL PRIMARY KEY,
    game_title VARCHAR(255) NOT NULL,
    description TEXT,
    photo VARCHAR(500),
    link_of_games VARCHAR(500),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create activities table
CREATE TABLE IF NOT EXISTS activities (
    id SERIAL PRIMARY KEY,
    activity_title VARCHAR(255) NOT NULL,
    description TEXT,
    photo VARCHAR(500),
    link_of_activities VARCHAR(500),
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create feedback table
CREATE TABLE IF NOT EXISTS feedback (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create notifications table
CREATE TABLE IF NOT EXISTS notifications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT false,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create historic_data table for tracking user activity
CREATE TABLE IF NOT EXISTS historic_data (
    id SERIAL PRIMARY KEY,
    kid_id INTEGER NOT NULL,
    date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    page_name VARCHAR(255),
    FOREIGN KEY (kid_id) REFERENCES children(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_children_user_id ON children(user_id);
CREATE INDEX IF NOT EXISTS idx_activities_category ON activities(category);
CREATE INDEX IF NOT EXISTS idx_games_category ON games(category);
CREATE INDEX IF NOT EXISTS idx_stories_category ON stories(category);
CREATE INDEX IF NOT EXISTS idx_feedback_user_id ON feedback(user_id);
CREATE INDEX IF NOT EXISTS idx_notifications_user_id ON notifications(user_id);
CREATE INDEX IF NOT EXISTS idx_historic_data_kid_id ON historic_data(kid_id);
CREATE INDEX IF NOT EXISTS idx_historic_data_date_time ON historic_data(date_time);

-- Insert sample data
INSERT INTO users (username, email, password, is_parent, number_of_kids, isAdmin) VALUES
('admin', 'admin@example.com', 'admin123', true, 2, true),
('parent1', 'parent1@example.com', 'parent123', true, 1, false);

INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo) VALUES
(1, 'male', 'John', 8, 'uploads/boy1.jpg'),
(1, 'female', 'Sarah', 6, 'uploads/girl1.jpg'),
(2, 'male', 'Mike', 7, 'uploads/boy2.jpg');

INSERT INTO stories (story_title, description, photo, link_of_stories, category) VALUES
('The Little Red Hen', 'A story about hard work and sharing', 'images/red_hen.jpg', 'stories/red_hen.html', 'animals'),
('Goldilocks and the Three Bears', 'A classic fairy tale', 'images/goldilocks.jpg', 'stories/goldilocks.html', 'fairy_tales'),
('The Three Little Pigs', 'A story about building houses', 'images/three_pigs.jpg', 'stories/three_pigs.html', 'animals');

INSERT INTO games (game_title, description, photo, link_of_games, category) VALUES
('Math Adventure', 'Learn math through fun games', 'images/math_game.jpg', 'games/math_adventure.html', 'educational'),
('Puzzle Master', 'Challenge your mind with puzzles', 'images/puzzle.jpg', 'games/puzzle_master.html', 'puzzle'),
('Color Match', 'Match colors and learn', 'images/color_game.jpg', 'games/color_match.html', 'educational');

INSERT INTO activities (activity_title, description, photo, link_of_activities, category) VALUES
('Drawing Fun', 'Learn to draw step by step', 'images/drawing.jpg', 'activities/drawing_fun.html', 'art'),
('Science Experiment', 'Fun science experiments', 'images/science.jpg', 'activities/science_exp.html', 'science'),
('Music Time', 'Learn about music and instruments', 'images/music.jpg', 'activities/music_time.html', 'music');

-- Insert sample historic data
INSERT INTO historic_data (kid_id, date_time, page_name) VALUES
(1, NOW(), 'acceuil_male.php'),
(1, NOW() - INTERVAL '1 hour', 'stories.html'),
(1, NOW() - INTERVAL '2 hours', 'games.html'),
(2, NOW(), 'acceuil_female.php'),
(2, NOW() - INTERVAL '30 minutes', 'activities.html');
