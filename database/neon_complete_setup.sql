-- Complete Neon Database Setup for Children's Universe
-- Run this entire script in your Neon SQL Editor

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

-- Create indexes for better performance
CREATE INDEX idx_children_user_id ON children(user_id);
CREATE INDEX idx_activities_category ON activities(category);
CREATE INDEX idx_games_category ON games(category);
CREATE INDEX idx_stories_category ON stories(category);
CREATE INDEX idx_feedback_user_id ON feedback(user_id);
CREATE INDEX idx_notifications_user_id ON notifications(user_id);

-- Insert sample users
INSERT INTO users (username, email, password, is_parent, number_of_kids, isAdmin) VALUES
('admin', 'admin@childrenuniverse.com', 'admin123', true, 0, true),
('parent1', 'parent1@example.com', 'password123', true, 2, false),
('parent2', 'parent2@example.com', 'password123', true, 1, false);

-- Insert sample children
INSERT INTO children (user_id, kid_gender, kid_name, kid_age, kid_photo, hidden_stories_categories, hidden_games_categories, hidden_activities_categories) VALUES
(2, 'male', 'John', 5, 'uploads/defaultmale.jpg', '', '', ''),
(2, 'female', 'Sarah', 4, 'uploads/defaultfemale.jpg', '', '', ''),
(3, 'male', 'Alex', 6, 'uploads/defaultmale.jpg', '', '', '');

-- Insert sample activities
INSERT INTO activities (activity_title, description, photo, link_of_activities, category) VALUES
('Word Finder', 'This is a classic word-finder game where you have to find as many words as you can in a grid of letters. Use your brains and start finding! You get points for every word you find.', 'https://static.gamezop.com/r1K-J3TQ5Ar/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/r1K-J3TQ5Ar', 'Logic'),
('Black Jack Grid', 'Here''s Black Jack with a puzzling twist. Arrange cards horizontally and vertically to bring their sum to 21!', 'https://static.gamezop.com/SyIZjp3GulZ/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/SyIZjp3GulZ', 'PUZZLE'),
('Quiz', 'Compete with thousands of players across cricket, history, Bollywood and more categories in Gamezop''s Quiz Champions and win real money!', 'https://static.gamezop.com/Sy8y2aQ9CB/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/Sy8y2aQ9CB', 'Quiz'),
('Sudoku Classic', 'Gamezop brings to you one of the most popular brain games - Sudoku! fill a 9×9 grid with numbers so that each row, column and 3×3 section contain all of the digits between 1 and 9.', 'https://static.gamezop.com/SJgx126Qc0H/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/SJgx126Qc0H', 'Logic'),
('Oh No', 'Fill red and blue dots to solve puzzles! The challenge is to determine the color of every piece.', 'https://static.gamezop.com/BkqTS_1b/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/BkqTS_1b', 'PUZZLE'),
('Color Matching', 'Match colors with objects', 'images/color_activity.jpg', 'activities/color_matching.html', 'colors'),
('Number Counting', 'Learn to count from 1 to 10', 'images/counting_activity.jpg', 'activities/counting.html', 'numbers'),
('Shape Recognition', 'Identify different shapes', 'images/shapes_activity.jpg', 'activities/shapes.html', 'shapes');

-- Insert sample games
INSERT INTO games (game_title, description, link_of_games, photo, category) VALUES
('Aqua Thief', 'Dive into hours of fun as you help Aqua Thief in his quest to capture the underwater treasure!', 'https://zv1y2i8p.play.gamezop.com/g/BJ9ZE86I6Wg', 'https://static.gamezop.com/BJ9ZE86I6Wg/cover.jpg', 'Adventure'),
('Flying School', 'Help cute birds learn to fly. Drag and aim to make them fly from one nest to the other.', 'https://zv1y2i8p.play.gamezop.com/g/VJOGOyGb9l', 'https://static.gamezop.com/VJOGOyGb9l/cover.jpg', 'Adventure'),
('Go Chicken Go', 'There''s a group of chickens that need to cross the road, and they need to do that quick. Just try and avoid blood!', 'https://zv1y2i8p.play.gamezop.com/g/rJ57aMJDcJm', 'https://static.gamezop.com/rJ57aMJDcJm/cover.jpg', 'Adventure'),
('Enchanted Waters', 'Time is of the essence in this riveting maze runner where one wrong step can make you fall into the endless lake! Time your jumps perfectly to get through the maze without plummeting into the endless lake!', 'https://zv1y2i8p.play.gamezop.com/g/HJskh679Cr', 'https://static.gamezop.com/HJskh679Cr/cover.jpg', 'Adventure'),
('Snakes & Ladders', 'Ladders take you up, and snakes bring you down. Be the first to get to 100 to win!', 'https://zv1y2i8p.play.gamezop.com/g/rJWyhp79RS', 'https://static.gamezop.com/rJWyhp79RS/cover.jpg', 'Adventure'),
('Memory Game', 'Match pairs of cards', 'images/memory_game.jpg', 'games/memory.html', 'memory'),
('Puzzle Game', 'Complete jigsaw puzzles', 'images/puzzle_game.jpg', 'games/puzzle.html', 'puzzle'),
('Word Game', 'Learn new words', 'images/word_game.jpg', 'games/words.html', 'language');

-- Insert sample stories
INSERT INTO stories (story_title, description, photo, link_of_stories, category) VALUES
('Shaun the Sheep', 'Shaun the sheep, a mischievous animal who lives on a farm with the rest of his flock, finds himself each time faced with a new disaster.', 'https://cdn.iview.abc.net.au/thumbs/i/X0_617f5aa59a04e_2000.jpg', 'https://www.youtube.com/embed/NkxRssE4330', 'Comedy'),
('Masha and the Bear', 'Masha and the Bear is a Russian comedy 3D animated television series created in 2009 by the Animaccord studio. Each episode lasts between seven and eight minutes.', 'https://m.media-amazon.com/images/M/MV5BOTBkNWQ3OWEtYjUyNy00ODBmLWE3ZTMtOWJhZWYyMmE2MGI1XkEyXkFqcGdeQXVyNzMwOTY2NTI@._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/embed/Si5auXCYWDI', 'Adventure'),
('Curious George', 'The Man in the Yellow Hat goes to Africa to find a priceless artifact, but he returns with George, a curious chimpanzee who likes to party.', 'https://m.media-amazon.com/images/M/MV5BZDQ2ZDRiMjgtZDE2ZC00MjM1LThkYTYtZDUxYWRiODMzNTVjXkEyXkFqcGdeQXVyMTEyMjM2NDc2._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/embed/pzKJ-yhg9JY', 'Adventure'),
('Rabbids Invasion', 'The Rabbids discover the world around them. Their memory and understanding being particularly limited, they systematically find themselves in bizarre situations.', 'https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p10426400_i_v7_aa.jpg', 'https://www.youtube.com/embed/yllvDuqg62Y', 'Adventure'),
('Mr Bean', 'The new adventures of Mr. Bean in inevitably funny situations.', 'https://m.media-amazon.com/images/M/MV5BMTY2NGRlZTgtZWU1ZC00NzhkLTgyMmYtYTQyZDgzYmE0ZmYzXkEyXkFqcGdeQXVyNTgyNTA4MjM@._V1_.jpg', 'https://www.youtube.com/embed/18pw1rQ33t0', 'Comedy'),
('The Little Red Hen', 'A story about hard work and sharing', 'images/red_hen.jpg', 'stories/red_hen.html', 'animals'),
('Goldilocks and the Three Bears', 'A classic fairy tale', 'images/goldilocks.jpg', 'stories/goldilocks.html', 'fairy_tales'),
('The Three Little Pigs', 'A story about building houses', 'images/three_pigs.jpg', 'stories/three_pigs.html', 'animals');

-- Insert sample feedback
INSERT INTO feedback (user_id, feedback_text) VALUES
(2, 'Great platform for kids! My children love the stories and games.'),
(3, 'Very educational and fun. Highly recommended for parents.');

-- Insert sample notifications
INSERT INTO notifications (user_id, message, is_read) VALUES
(2, 'Welcome to Children''s Universe! Start exploring stories and games with your kids.', false),
(3, 'New activities have been added to the platform. Check them out!', false);

-- Verify the setup
SELECT 'Setup Complete!' as status;
SELECT 'Users' as table_name, COUNT(*) as count FROM users
UNION ALL
SELECT 'Children', COUNT(*) FROM children
UNION ALL
SELECT 'Activities', COUNT(*) FROM activities
UNION ALL
SELECT 'Games', COUNT(*) FROM games
UNION ALL
SELECT 'Stories', COUNT(*) FROM stories
UNION ALL
SELECT 'Feedback', COUNT(*) FROM feedback
UNION ALL
SELECT 'Notifications', COUNT(*) FROM notifications;
