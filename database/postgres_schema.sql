-- PostgreSQL Database Schema for Children's Universe
-- Converted from MySQL to PostgreSQL

-- Create database (run this separately)
-- CREATE DATABASE children_universe;

-- Connect to the database
-- \c children_universe;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    is_parent BOOLEAN DEFAULT NULL,
    number_of_kids INTEGER DEFAULT NULL,
    isAdmin BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create children table
CREATE TABLE IF NOT EXISTS children (
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
CREATE TABLE IF NOT EXISTS activities (
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
CREATE TABLE IF NOT EXISTS games (
    id SERIAL PRIMARY KEY,
    game_title VARCHAR(255) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    link_of_games VARCHAR(255) DEFAULT NULL,
    photo VARCHAR(255) DEFAULT NULL,
    category VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create stories table
CREATE TABLE IF NOT EXISTS stories (
    id SERIAL PRIMARY KEY,
    story_title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    photo VARCHAR(255) NOT NULL,
    link_of_stories VARCHAR(255) NOT NULL,
    category VARCHAR(50) NOT NULL,
    hidden_stories_categories VARCHAR(255) DEFAULT NULL,
    allowed_stories_categories VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create feedback table
CREATE TABLE IF NOT EXISTS feedback (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    age INTEGER NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(255) NOT NULL,
    rating VARCHAR(20) NOT NULL,
    comments TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create indexes for better performance
CREATE INDEX IF NOT EXISTS idx_children_user_id ON children(user_id);
CREATE INDEX IF NOT EXISTS idx_activities_category ON activities(category);
CREATE INDEX IF NOT EXISTS idx_games_category ON games(category);
CREATE INDEX IF NOT EXISTS idx_stories_category ON stories(category);
CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);

-- Insert sample data for activities
INSERT INTO activities (activity_title, description, photo, link_of_activities, category) VALUES
('Word Finder', 'This is a classic word-finder game where you have to find as many words as you can in a grid of letters. Use your brains and start finding! You get points for every word you find.', 'https://static.gamezop.com/r1K-J3TQ5Ar/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/r1K-J3TQ5Ar', 'Logic'),
('Black Jack Grid', 'Here''s Black Jack with a puzzling twist. Arrange cards horizontally and vertically to bring their sum to 21!', 'https://static.gamezop.com/SyIZjp3GulZ/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/SyIZjp3GulZ', 'PUZZLE'),
('Quiz', 'Compete with thousands of players across cricket, history, Bollywood and more categories in Gamezop''s Quiz Champions and win real money!', 'https://static.gamezop.com/Sy8y2aQ9CB/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/Sy8y2aQ9CB', 'Quiz'),
('Sudoku Classic', 'Gamezop brings to you one of the most popular brain games - Sudoku! fill a 9×9 grid with numbers so that each row, column and 3×3 section contain all of the digits between 1 and 9.', 'https://static.gamezop.com/SJgx126Qc0H/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/SJgx126Qc0H', 'Logic'),
('Oh No', 'Fill red and blue dots to solve puzzles! The challenge is to determine the color of every piece.', 'https://static.gamezop.com/BkqTS_1b/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/BkqTS_1b', 'PUZZLE')
ON CONFLICT (id) DO NOTHING;

-- Insert sample data for games
INSERT INTO games (game_title, description, link_of_games, photo, category) VALUES
('Aqua Thief', 'Dive into hours of fun as you help Aqua Thief in his quest to capture the underwater treasure!', 'https://zv1y2i8p.play.gamezop.com/g/BJ9ZE86I6Wg', 'https://static.gamezop.com/BJ9ZE86I6Wg/cover.jpg', 'Adventure'),
('Flying School', 'Help cute birds learn to fly. Drag and aim to make them fly from one nest to the other.', 'https://zv1y2i8p.play.gamezop.com/g/VJOGOyGb9l', 'https://static.gamezop.com/VJOGOyGb9l/cover.jpg', 'Adventure'),
('Go Chicken Go', 'There''s a group of chickens that need to cross the road, and they need to do that quick. Just try and avoid blood!', 'https://zv1y2i8p.play.gamezop.com/g/rJ57aMJDcJm', 'https://static.gamezop.com/rJ57aMJDcJm/cover.jpg', 'Adventure'),
('Enchanted Waters', 'Time is of the essence in this riveting maze runner where one wrong step can make you fall into the endless lake! Time your jumps perfectly to get through the maze without plummeting into the endless lake!', 'https://zv1y2i8p.play.gamezop.com/g/HJskh679Cr', 'https://static.gamezop.com/HJskh679Cr/cover.jpg', 'Adventure'),
('Snakes & Ladders', 'Ladders take you up, and snakes bring you down. Be the first to get to 100 to win!', 'https://zv1y2i8p.play.gamezop.com/g/rJWyhp79RS', 'https://static.gamezop.com/rJWyhp79RS/cover.jpg', 'Adventure')
ON CONFLICT (id) DO NOTHING;

-- Insert sample data for stories
INSERT INTO stories (story_title, description, photo, link_of_stories, category) VALUES
('Shaun the Sheep', 'Shaun the sheep, a mischievous animal who lives on a farm with the rest of his flock, finds himself each time faced with a new disaster.', 'https://cdn.iview.abc.net.au/thumbs/i/X0_617f5aa59a04e_2000.jpg', 'https://www.youtube.com/embed/NkxRssE4330', 'Comedy'),
('Masha and the Bear', 'Masha and the Bear is a Russian comedy 3D animated television series created in 2009 by the Animaccord studio. Each episode lasts between seven and eight minutes.', 'https://m.media-amazon.com/images/M/MV5BOTBkNWQ3OWEtYjUyNy00ODBmLWE3ZTMtOWJhZWYyMmE2MGI1XkEyXkFqcGdeQXVyNzMwOTY2NTI@._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/embed/Si5auXCYWDI', 'Adventure'),
('Curious George', 'The Man in the Yellow Hat goes to Africa to find a priceless artifact, but he returns with George, a curious chimpanzee who likes to party.', 'https://m.media-amazon.com/images/M/MV5BZDQ2ZDRiMjgtZDE2ZC00MjM1LThkYTYtZDUxYWRiODMzNTVjXkEyXkFqcGdeQXVyMTEyMjM2NDc2._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/embed/pzKJ-yhg9JY', 'Adventure'),
('Rabbids Invasion', 'The Rabbids discover the world around them. Their memory and understanding being particularly limited, they systematically find themselves in bizarre situations.', 'https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p10426400_i_v7_aa.jpg', 'https://www.youtube.com/embed/yllvDuqg62Y', 'Adventure'),
('Mr Bean', 'The new adventures of Mr. Bean in inevitably funny situations.', 'https://m.media-amazon.com/images/M/MV5BMTY2NGRlZTgtZWU1ZC00NzhkLTgyMmYtYTQyZDgzYmE0ZmYzXkEyXkFqcGdeQXVyNTgyNTA4MjM@._V1_.jpg', 'https://www.youtube.com/embed/18pw1rQ33t0', 'Comedy')
ON CONFLICT (id) DO NOTHING;

-- Create function to update updated_at timestamp
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Create triggers for updated_at
CREATE TRIGGER update_users_updated_at BEFORE UPDATE ON users FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_children_updated_at BEFORE UPDATE ON children FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_activities_updated_at BEFORE UPDATE ON activities FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_games_updated_at BEFORE UPDATE ON games FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_stories_updated_at BEFORE UPDATE ON stories FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
CREATE TRIGGER update_feedback_updated_at BEFORE UPDATE ON feedback FOR EACH ROW EXECUTE FUNCTION update_updated_at_column();
