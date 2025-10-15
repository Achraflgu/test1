-- Corrected PostgreSQL Database Schema for Children's Universe
-- This schema matches the original MySQL structure

-- Drop existing tables if they exist (be careful in production!)
DROP TABLE IF EXISTS children CASCADE;
DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS activities CASCADE;
DROP TABLE IF EXISTS games CASCADE;
DROP TABLE IF EXISTS stories CASCADE;
DROP TABLE IF EXISTS feedback CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;

-- Create users table (matching original MySQL structure)
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_parent BOOLEAN DEFAULT NULL,
    number_of_kids INTEGER DEFAULT NULL,
    isAdmin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create children table
CREATE TABLE children (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    kid_gender VARCHAR(255) DEFAULT NULL,
    kid_name VARCHAR(255) DEFAULT NULL,
    kid_age INTEGER DEFAULT NULL,
    kid_photo VARCHAR(255) DEFAULT NULL,
    hidden_stories_categories TEXT DEFAULT NULL,
    hidden_games_categories TEXT DEFAULT NULL,
    hidden_activities_categories TEXT DEFAULT NULL,
    allowed_stories_categories VARCHAR(255) DEFAULT NULL,
    allowed_games_categories TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create activities table
CREATE TABLE activities (
    id SERIAL PRIMARY KEY,
    activity_title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    link_of_activities VARCHAR(255) DEFAULT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create games table
CREATE TABLE games (
    id SERIAL PRIMARY KEY,
    game_title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    link_of_games VARCHAR(255) DEFAULT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create stories table
CREATE TABLE stories (
    id SERIAL PRIMARY KEY,
    story_title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    link_of_stories VARCHAR(255) DEFAULT NULL,
    category VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create feedback table
CREATE TABLE feedback (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    feedback_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create notifications table
CREATE TABLE notifications (
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(id) ON DELETE CASCADE,
    message TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO users (username, email, password, is_parent, number_of_kids, isAdmin) VALUES
('admin', 'admin@example.com', 'admin123', true, 0, true),
('parent1', 'parent1@example.com', 'password123', true, 2, false);

INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo) VALUES
(2, 'male', 'John', 5, 'uploads/defaultmale.jpg'),
(2, 'female', 'Sarah', 4, 'uploads/defaultfemale.jpg');

INSERT INTO activities (activity_title, description, photo, link_of_activities, category) VALUES
('Color Matching', 'Match colors with objects', 'images/color_activity.jpg', 'activities/color_matching.html', 'colors'),
('Number Counting', 'Learn to count from 1 to 10', 'images/counting_activity.jpg', 'activities/counting.html', 'numbers'),
('Shape Recognition', 'Identify different shapes', 'images/shapes_activity.jpg', 'activities/shapes.html', 'shapes');

INSERT INTO games (game_title, description, photo, link_of_games, category) VALUES
('Memory Game', 'Match pairs of cards', 'images/memory_game.jpg', 'games/memory.html', 'memory'),
('Puzzle Game', 'Complete jigsaw puzzles', 'images/puzzle_game.jpg', 'games/puzzle.html', 'puzzle'),
('Word Game', 'Learn new words', 'images/word_game.jpg', 'games/words.html', 'language');

INSERT INTO stories (story_title, description, photo, link_of_stories, category) VALUES
('The Little Red Hen', 'A story about hard work and sharing', 'images/red_hen.jpg', 'stories/red_hen.html', 'animals'),
('Goldilocks and the Three Bears', 'A classic fairy tale', 'images/goldilocks.jpg', 'stories/goldilocks.html', 'fairy_tales'),
('The Three Little Pigs', 'A story about building houses', 'images/three_pigs.jpg', 'stories/three_pigs.html', 'animals');

-- Create historic_data table for tracking user activity
CREATE TABLE IF NOT EXISTS historic_data (
    id SERIAL PRIMARY KEY,
    kid_id INTEGER NOT NULL,
    date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    page_name VARCHAR(255),
    FOREIGN KEY (kid_id) REFERENCES children(id) ON DELETE CASCADE
);

-- Create indexes for better performance
CREATE INDEX idx_children_user_id ON children(user_id);
CREATE INDEX idx_activities_category ON activities(category);
CREATE INDEX idx_games_category ON games(category);
CREATE INDEX idx_stories_category ON stories(category);
CREATE INDEX idx_feedback_user_id ON feedback(user_id);
CREATE INDEX idx_notifications_user_id ON notifications(user_id);
CREATE INDEX idx_historic_data_kid_id ON historic_data(kid_id);
CREATE INDEX idx_historic_data_date_time ON historic_data(date_time);
