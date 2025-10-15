-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2023 at 06:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `damm`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `activity_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `link_of_activities` varchar(255) DEFAULT NULL,
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `activity_title`, `description`, `photo`, `link_of_activities`, `category`) VALUES
(5, 'Word Finder', 'This is a classic word-finder game where you have to find as many words as you can in a grid of letters. Use your brains and start finding! You get points for every word you find.', 'https://static.gamezop.com/r1K-J3TQ5Ar/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/r1K-J3TQ5Ar', 'Logic'),
(6, 'Black Jack Grid', 'Here\'s Black Jack with a puzzling twist. Arrange cards horizontally and vertically to bring their sum to 21!', 'https://static.gamezop.com/SyIZjp3GulZ/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/SyIZjp3GulZ', 'PUZZLE'),
(7, 'Quiz', 'Compete with thousands of players across cricket, history, Bollywood and more categories in Gamezop\'s Quiz Champions and win real money!', 'https://static.gamezop.com/Sy8y2aQ9CB/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/Sy8y2aQ9CB', 'Quiz'),
(8, 'Sudoku Classic', 'Gamezop brings to you one of the most popular brain games - Sudoku! fill a 9×9 grid with numbers so that each row, column and 3×3 section contain all of the digits between 1 and 9.', 'https://static.gamezop.com/SJgx126Qc0H/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/SJgx126Qc0H', 'Logic'),
(9, 'Oh No', 'Fill red and blue dots to solve puzzles! The challenge is to determine the color of every piece.', 'https://static.gamezop.com/BkqTS_1b/cover.jpg', 'https://zv1y2i8p.play.gamezop.com/g/BkqTS_1b', 'PUZZLE');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `kid_gender` varchar(255) DEFAULT NULL,
  `kid_name` varchar(255) DEFAULT NULL,
  `kid_age` int(11) DEFAULT NULL,
  `kid_photo` varchar(255) DEFAULT NULL,
  `hidden_stories_categories` text DEFAULT NULL,
  `hidden_games_categories` text DEFAULT NULL,
  `hidden_activities_categories` text DEFAULT NULL,
  `allowed_stories_categories` varchar(255) DEFAULT NULL,
  `allowed_games_categories` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `user_id`, `kid_gender`, `kid_name`, `kid_age`, `kid_photo`, `hidden_stories_categories`, `hidden_games_categories`, `hidden_activities_categories`, `allowed_stories_categories`, `allowed_games_categories`) VALUES
(7, 10, 'male', 'MalekK', 4, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 11, 'female', 'lol', 2, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 40, 'male', 'aziz', 2, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 40, 'male', 'aziza', 2, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 40, 'male', 'aziza', 2, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 11, 'male', 'DAZQ', 5, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 46, 'male', 'yassin', 3, NULL, NULL, NULL, NULL, NULL, NULL),
(37, 46, 'female', 'yassmin', 5, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 47, 'male', 'med', 5, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 47, 'female', 'yassmin', 4, NULL, NULL, NULL, NULL, NULL, NULL),
(40, 48, 'male', 'BRAHIM', 3, 'uploads/6f2dd748744859a41b07aad191f704a6.jpg', 'Fantasy,zegzefzef', '', 'cc', NULL, NULL),
(41, 48, 'female', 'asma', 3, 'uploads/0e7139c25dcb29f78d3a75da637044cf.jpg', NULL, NULL, NULL, NULL, NULL),
(64, 48, 'male', 'yassin', 3, 'uploads/58c4e85af24516a0cebe42febabf9345.jpg', NULL, NULL, NULL, NULL, NULL),
(68, 46, 'male', 'SD', 3, 'uploads/348358287_1528363021026554_1795389337310936902_n.jpg', NULL, NULL, NULL, NULL, NULL),
(69, 49, 'male', 'BRAHIM', 3, 'uploads/naruto-shippuden-figurine-pain-tendo-wall-statue.jpg', NULL, NULL, NULL, NULL, NULL),
(70, 49, 'female', 'mehrziya', 4, 'uploads/maxresdefault.jpg', NULL, NULL, NULL, NULL, NULL),
(72, 49, 'male', 'louay', 3, 'uploads/42f10c6d4c6b50a7708ad345181fa31588557336v2_00.jpg', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `rating` varchar(20) NOT NULL,
  `comments` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `age`, `email`, `phone`, `rating`, `comments`) VALUES
(1, 'ada', 23, 'achrafgu92@gmail.com', '52714917', 'none', ''),
(2, 'ada', 23, 'achrafgu92@gmail.com', '52714917', 'none', ''),
(3, 'AZD', 12, 'achrafguemati557@gmail.com', '52714917', 'none', '213AZDFAZD'),
(4, 'AZD', 12, 'achrafguemati557@gmail.com', '52714917', 'none', '213AZDFAZD'),
(5, 'AZD', 12, 'achrafguemati557@gmail.com', '52714917', 'none', '213AZDFAZD'),
(6, 'aa', 0, 'aa', 'aa', 'none', 'aa'),
(7, 'aaSDQ', 12, 'aaQSD', '1234124', 'none', '124AZDAZD'),
(8, 'aaSDQ', 12, 'aaQSD', '1234124', 'none', '124AZDAZD'),
(9, 'QQQ', 12, 'QQQ', '2412413', 'none', 'AZDAZDAZD'),
(10, 'QQQ', 12, 'QQQ', '2412413', 'none', 'AZDAZDAZD'),
(11, 'HHH', 13, 'HHH', '12412341', 'Very Good', 'HHGHHH'),
(12, 'HHH', 13, 'HHH', '12412341', 'Very Good', 'HHGHHH'),
(13, 'HHH', 13, 'HHH', '12412341', 'Very Good', 'HHGHHH'),
(14, 'HHH', 13, 'HHH', '12412341', 'Very Good', 'HHGHHH'),
(15, 'JHON SISI', 23, 'guematiaziz@gmail.com', '52714917', 'Very Bad', 'ézadazd'),
(16, 'JHON SISI', 23, 'guematiaziz@gmail.com', '52714917', 'Very Bad', 'ézadazd'),
(17, 'JHON SISI', 23, 'guematiaziz@gmail.com', '52714917', 'Very Bad', 'ézadazd');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `id` int(11) NOT NULL,
  `game_title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `link_of_games` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `game_title`, `description`, `link_of_games`, `photo`, `category`) VALUES
(44, 'Aqua Thief', 'Dive into hours of fun as you help Aqua Thief in his quest to capture the underwater treasure!', 'https://zv1y2i8p.play.gamezop.com/g/BJ9ZE86I6Wg', 'https://static.gamezop.com/BJ9ZE86I6Wg/cover.jpg', 'Adventure'),
(45, 'Flying School', 'Help cute birds learn to fly. Drag and aim to make them fly from one nest to the other.', 'https://zv1y2i8p.play.gamezop.com/g/VJOGOyGb9l', 'https://static.gamezop.com/VJOGOyGb9l/cover.jpg', 'Adventure'),
(46, 'Go Chicken Go', 'There\'s a group of chickens that need to cross the road, and they need to do that quick. Just try and avoid blood!', 'https://zv1y2i8p.play.gamezop.com/g/rJ57aMJDcJm', 'https://static.gamezop.com/rJ57aMJDcJm/cover.jpg', 'Adventure'),
(47, 'Enchanted Waters', 'Time is of the essence in this riveting maze runner where one wrong step can make you fall into the endless lake! Time your jumps perfectly to get through the maze without plummeting into the endless lake!', 'https://zv1y2i8p.play.gamezop.com/g/HJskh679Cr', 'https://static.gamezop.com/HJskh679Cr/cover.jpg', 'Adventure'),
(48, 'Snakes & Ladders', 'Ladders take you up, and snakes bring you down. Be the first to get to 100 to win!', 'https://zv1y2i8p.play.gamezop.com/g/rJWyhp79RS', 'https://static.gamezop.com/rJWyhp79RS/cover.jpg', 'Adventure'),
(49, 'Terra Infirma', 'Skate without falling over as the Earth moves beneath you! Swipe up and down as fast as you can.', 'https://zv1y2i8p.play.gamezop.com/g/HkBWwMUFOye', 'https://static.gamezop.com/HkBWwMUFOye/cover.jpg', 'Adventure'),
(50, 'Rope Ninja', 'Time to show your ninja skills and catch as many birds as you can. Mind the coins you can collect!', 'https://zv1y2i8p.play.gamezop.com/g/r10-NLT86bx', 'https://static.gamezop.com/r10-NLT86bx/cover.jpg', 'Adventure'),
(51, 'Snappy Spy', 'Switch gravity with a touch and avoid obstacles. Remember to get some sushi for extra points!', 'https://zv1y2i8p.play.gamezop.com/g/SysZvGUt_ye', 'https://static.gamezop.com/SysZvGUt_ye/cover.jpg', 'Adventure'),
(52, 'Sheriff\'s Wrath', 'How dare these dacoits wreak havoc in your county! Pull out your gun and shoot those goons down.', 'https://zv1y2i8p.play.gamezop.com/g/BJlMwGUY_yl', 'https://static.gamezop.com/BJlMwGUY_yl/cover.jpg', 'Action'),
(53, 'Aliens Attack', 'Blast extraterrestrials out of the sky in this action game! Be careful of the Boss Fights!', 'https://zv1y2i8p.play.gamezop.com/g/N1tgz_kzW5x', 'https://static.gamezop.com/N1tgz_kzW5x/cover.jpg', 'Action'),
(54, 'Punch Heroes', 'Karate out the enemies of our lone warrior fighting in the middle. But one miss and it\'s all over!', 'https://zv1y2i8p.play.gamezop.com/g/Sy64_WbU', 'https://static.gamezop.com/Sy64_WbU/cover.jpg', 'Action'),
(55, 'Ninja Speed Runner', 'It\'s time to test your Ninja Running Skills! Dash through enemy territory as far as you can... ohh and don\'t get hit by their Shurikens!', 'https://zv1y2i8p.play.gamezop.com/g/QPcVkaHi1', 'https://static.gamezop.com/QPcVkaHi1/cover.jpg', 'Action'),
(56, 'Slap Fest', 'Attack! Retreat! Slap! Be quick and make your opponent scream in pain.\n\n\n', 'https://zv1y2i8p.play.gamezop.com/g/ryN9EGAQa', 'https://static.gamezop.com/ryN9EGAQa/cover.jpg', 'Action'),
(57, 'Shadow Run', 'Guide the ninja to move swiftly between pointed obstacles and climb reach great heights!', 'https://zv1y2i8p.play.gamezop.com/g/S1kGWUim8Ux', 'https://static.gamezop.com/S1kGWUim8Ux/cover.jpg', 'Action'),
(58, 'Slit Sight', 'Fun precision game where you have to shoot a ball without touching the spinning obstacles.', 'https://zv1y2i8p.play.gamezop.com/g/Bk25EzR7T', 'https://static.gamezop.com/Bk25EzR7T/cover.jpg', 'Puzzle & Logic'),
(59, 'Word Finder', 'This is a classic word-finder game where you have to find as many words as you can in a grid of letters. Use your brains and start finding! You get points for every word you find.', 'https://zv1y2i8p.play.gamezop.com/g/r1K-J3TQ5Ar', 'https://static.gamezop.com/r1K-J3TQ5Ar/cover.jpg', 'Puzzle & Logic'),
(60, 'Oh Yes', 'It is a little logic game where you have to fill the grid with either red or blue tiles.', 'https://zv1y2i8p.play.gamezop.com/g/SkyRBO1b', 'https://static.gamezop.com/SkyRBO1b/cover.jpg', 'Puzzle & Logic'),
(61, 'Tower Loot', 'Remove wooden objects off the game board to get a treasure chest next to the magician.', 'https://zv1y2i8p.play.gamezop.com/g/B1MXhUFQke', 'https://static.gamezop.com/B1MXhUFQke/cover.jpg', 'Puzzle & Logic'),
(62, 'Juicy Dash', 'Juicy, tasty, match-3 madness. Prove your skills and match as many fruits as possible.', 'https://zv1y2i8p.play.gamezop.com/g/H1lZem8hq', 'https://static.gamezop.com/H1lZem8hq/cover.jpg', 'Puzzle & Logic'),
(63, 'Pixel Slime', 'Help this slimy green blob to jump over spikes and gaps to reach the exit in each level!', 'https://zv1y2i8p.play.gamezop.com/g/Sk728YXJx', 'https://static.gamezop.com/Sk728YXJx/cover.jpg', 'Puzzle & Logic'),
(64, 'Cubes Got Moves', 'Roll over the cubes to their right spots. Cubes have different faces - put the correct faces on the correct spots to win.', 'https://zv1y2i8p.play.gamezop.com/g/S1JXaMJDqJX', 'https://static.gamezop.com/S1JXaMJDqJX/cover.jpg', 'Puzzle & Logic'),
(65, 'Fidgety Frog', 'The frog breaks wind to rise above bars. Help him go higher without getting smashed to smithereens!', 'https://zv1y2i8p.play.gamezop.com/g/NkxfOJM-qg', 'https://static.gamezop.com/NkxfOJM-qg/cover.jpg', 'Arcade'),
(66, 'Grumpy Gorilla', 'This beast is addicted to chopping trees. Ensure he\'s on the right side else he\'d bang his head!', 'https://zv1y2i8p.play.gamezop.com/g/N1sZfO1fWqg', 'https://static.gamezop.com/N1sZfO1fWqg/cover.jpg', 'Arcade'),
(67, 'Cuby Dash', 'Here\'s a snake that likes... carrots! Swiftly move left and right, collect as many carrots as you can!', 'https://zv1y2i8p.play.gamezop.com/g/Sy6b98udz0', 'https://static.gamezop.com/Sy6b98udz0/cover.jpg', 'Arcade'),
(68, 'Fruit Chop', 'Swipe the screen to chop fruits but don\'t hit the bombs! So unsheathe your sword and get ready to play the most fun fruit slice game online.', 'https://zv1y2i8p.play.gamezop.com/g/rkWfy2pXq0r', 'https://static.gamezop.com/rkWfy2pXq0r/cover.jpg', 'Arcade'),
(69, 'Ludo With Friends', 'Here\'s the best multiplayer Ludo game! Play with your friends or with thousands of other players online.', 'https://zv1y2i8p.play.gamezop.com/g/SkhljT2fdgb', 'https://static.gamezop.com/SkhljT2fdgb/cover.jpg', 'Strategy'),
(70, 'Carrom Hero', 'Here\'s the most fun Carrom game online! Play against thousands of players in 2 unique modes: Freestyle and Professional!', 'https://zv1y2i8p.play.gamezop.com/g/H1Hgyn6XqAS', 'https://static.gamezop.com/H1Hgyn6XqAS/cover.jpg', 'Strategy'),
(71, 'Algerian Solitaire', 'Play the timeless Solitaire game in an Algerian desert setting! This version of Solitaire has 2 decks for double the challenge and double the punch!', 'https://zv1y2i8p.play.gamezop.com/g/rJu76zkD917', 'https://static.gamezop.com/rJu76zkD917/cover.jpg', 'Strategy'),
(72, 'Solitaire Gold', 'Solitaire Gold follows classic Solitaire rules: the catch is you only get 5 mins to play. The sooner you finish, the bigger the bonus you receive! Come, give it a try!', 'https://zv1y2i8p.play.gamezop.com/g/rkPlk2T7qAr', 'https://static.gamezop.com/rkPlk2T7qAr/cover.jpg', 'Strategy'),
(73, 'Save Your Pinky', 'Aim the knife between your fingers in this game. No margin for error: inaccuracy causes pain.', 'https://zv1y2i8p.play.gamezop.com/g/H1pbZUoXIUl', 'https://static.gamezop.com/H1pbZUoXIUl/cover.jpg', 'Strategy'),
(74, 'Crazy Pizza', 'It\'s another busy night at the pizzeria. Match 3 or more pizzas to prosper in this strategy game.', 'https://zv1y2i8p.play.gamezop.com/g/SyN0KSWuV', 'https://static.gamezop.com/SyN0KSWuV/cover.jpg', 'Strategy'),
(75, 'Rafting Adventure', 'Prevent the young man from slamming into the shores of this gorgeous but deadly canyon.', 'https://zv1y2i8p.play.gamezop.com/g/4JcZiV3XWql', 'https://static.gamezop.com/4JcZiV3XWql/cover.jpg', 'Sports & Racing'),
(76, 'Dribble Kings', 'Run and find the best trajectory to dodge obstacles. Don\'t let those quarterbacks take the ball!', 'https://zv1y2i8p.play.gamezop.com/g/SkJf58Ouf0', 'https://static.gamezop.com/SkJf58Ouf0/cover.jpg', 'Sports & Racing'),
(77, 'Foosball Kick', 'Foosball with a twist: use the red player when the ball is red and the yellow player when the ball is yellow. Sounds simple? Let\'s see you score 20 in the game!', 'https://zv1y2i8p.play.gamezop.com/g/Sk1Wyn6XqRH', 'https://static.gamezop.com/Sk1Wyn6XqRH/cover.jpg', 'Sports & Racing'),
(78, 'Let\'s Go Fishing', 'Become a fishing master by capturing maximum number of yummy fish in this adventure game.', 'https://zv1y2i8p.play.gamezop.com/g/B1hCYSbdN', 'https://static.gamezop.com/B1hCYSbdN/cover.jpg', 'Sports & Racing'),
(79, 'Archery Champs', 'Here\'s the most fun online archery game for you! Play against thousands of online players 1 on 1. Choose from multiple bows, arrows, and sights as you go for the bullseye!', 'https://zv1y2i8p.play.gamezop.com/g/Bk9ynTQqCB', 'https://static.gamezop.com/Bk9ynTQqCB/cover.jpg', 'Sports & Racing');

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `story_title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `link_of_stories` varchar(255) NOT NULL,
  `category` varchar(50) NOT NULL,
  `hidden_stories_categories` varchar(255) DEFAULT NULL,
  `allowed_stories_categories` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stories`
--

INSERT INTO `stories` (`id`, `story_title`, `description`, `photo`, `link_of_stories`, `category`, `hidden_stories_categories`, `allowed_stories_categories`) VALUES
(42, 'Shaun the Sheep', 'Shaun the sheep, a mischievous animal who lives on a farm with the rest of his flock, finds himself each time faced with a new disaster.', 'https://cdn.iview.abc.net.au/thumbs/i/X0_617f5aa59a04e_2000.jpg', 'https://www.youtube.com/embed/NkxRssE4330', 'Comedy', NULL, NULL),
(43, 'Masha and the Bear', 'Masha and the Bear is a Russian comedy 3D animated television series created in 2009 by the Animaccord studio. Each episode lasts between seven and eight minutes.', 'https://m.media-amazon.com/images/M/MV5BOTBkNWQ3OWEtYjUyNy00ODBmLWE3ZTMtOWJhZWYyMmE2MGI1XkEyXkFqcGdeQXVyNzMwOTY2NTI@._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/embed/Si5auXCYWDI', 'Adventure', NULL, NULL),
(44, 'Curious George', 'The Man in the Yellow Hat goes to Africa to find a priceless artifact, but he returns with George, a curious chimpanzee who likes to party.', 'https://m.media-amazon.com/images/M/MV5BZDQ2ZDRiMjgtZDE2ZC00MjM1LThkYTYtZDUxYWRiODMzNTVjXkEyXkFqcGdeQXVyMTEyMjM2NDc2._V1_FMjpg_UX1000_.jpg', 'https://www.youtube.com/embed/pzKJ-yhg9JY', 'Adventure', NULL, NULL),
(45, 'Rabbids Invasion', 'The Rabbids discover the world around them. Their memory and understanding being particularly limited, they systematically find themselves in bizarre situations.', 'https://resizing.flixster.com/-XZAfHZM39UwaGJIFWKAE8fS0ak=/v3/t/assets/p10426400_i_v7_aa.jpg', 'https://www.youtube.com/embed/yllvDuqg62Y', 'Adventure', NULL, NULL),
(46, 'Mr Bean', 'The new adventures of Mr. Bean in inevitably funny situations.', 'https://m.media-amazon.com/images/M/MV5BMTY2NGRlZTgtZWU1ZC00NzhkLTgyMmYtYTQyZDgzYmE0ZmYzXkEyXkFqcGdeQXVyNTgyNTA4MjM@._V1_.jpg', 'https://www.youtube.com/embed/18pw1rQ33t0', 'Comedy', NULL, NULL),
(47, 'Ice Age Saga', 'Ice Age or The Ice Age in Quebec is an American series of animated films,', 'https://qph.cf2.quoracdn.net/main-qimg-ab3077d366cc1be64803dfa9a1afcb88-lq', 'https://www.youtube.com/embed/8vb1-VoGXMI', 'Adventure', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_parent` tinyint(1) DEFAULT NULL,
  `number_of_kids` int(11) DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `is_parent`, `number_of_kids`, `isAdmin`) VALUES
(10, 'hichdasta@gmail.com', 'lol', 1, 1, 0),
(11, 'ac@gmail.com', 'lol', NULL, 1, 1),
(33, 'abcé@gmail.com', 'ggaga', 1, 1, 0),
(34, 'abcdd@gmail.com', 'lol', 1, 2, 0),
(35, 'wdfdsqf@gmail.com', 'zdaf', 1, 1, 0),
(37, 'AZDAZD@gmail.com', 'AZDAZD', 1, 1, 0),
(40, 'abcéé@gmail.com', 'azdazd', NULL, 2, 0),
(46, 'rimmousa@gmail.com', 'lol', 1, 2, 0),
(47, 'yassinsakouki@gmail.com', 'lol', 1, 2, 0),
(48, 'test123@gmail.com', 'lol', 1, 2, 0),
(49, 'vv@gmail.com', 'lol', 1, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `children`
--
ALTER TABLE `children`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
