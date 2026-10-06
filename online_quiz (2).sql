-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2026 at 05:50 PM
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
-- Database: `online_quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `question_text` text NOT NULL,
  `option_a` varchar(255) NOT NULL,
  `option_b` varchar(255) NOT NULL,
  `option_c` varchar(255) NOT NULL,
  `option_d` varchar(255) NOT NULL,
  `correct_answer` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `quiz_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_answer`) VALUES
(1, 1, 'Which Article of the Indian Constitution deals with equality before law?', 'Article 12', 'Article 14', 'Article 19', 'Article 21', 'B'),
(2, 1, 'The Battle of Plassey was fought in which year?', '1757', '1761', '1857', '1764', 'A'),
(3, 1, 'Which is the largest Indian state by area?', 'Maharashtra', 'Madhya Pradesh', 'Rajasthan', 'Uttar Pradesh', 'C'),
(4, 1, 'The Tropic of Cancer passes through how many Indian states?', '6', '7', '8', '9', 'C'),
(5, 1, 'Which institution is the central bank of India?', 'SBI', 'RBI', 'SEBI', 'NABARD', 'B'),
(6, 1, 'Fundamental Duties were added by which Constitutional Amendment?', '24th', '42nd', '44th', '73rd', 'B'),
(7, 1, 'Which gas is most abundant in Earth’s atmosphere?', 'Oxygen', 'Carbon dioxide', 'Nitrogen', 'Hydrogen', 'C'),
(8, 1, 'Green Revolution in India is mainly associated with increased production of:', 'Food grains', 'Tea', 'Cotton only', 'Rubber', 'A'),
(9, 1, 'Who appoints the Governor of an Indian state?', 'Chief Minister', 'Prime Minister', 'President', 'Chief Justice of India', 'C'),
(10, 1, 'Which river is known as the Sorrow of Bihar?', 'Ganga', 'Kosi', 'Godavari', 'Narmada', 'B'),
(11, 2, 'The capital of Maharashtra is:', 'Nagpur', 'Mumbai', 'Pune', 'Nashik', 'B'),
(12, 2, 'Maharashtra Day is observed on:', '1 January', '26 January', '1 May', '15 August', 'C'),
(13, 2, 'Which fort is associated with Chhatrapati Shivaji Maharaj’s coronation?', 'Raigad', 'Sinhagad', 'Pratapgad', 'Shivneri', 'A'),
(14, 2, 'The Godavari originates near:', 'Mahabaleshwar', 'Trimbakeshwar', 'Nashik city', 'Panchgani', 'B'),
(15, 2, 'Ajanta Caves are in which district?', 'Pune', 'Nagpur', 'Chhatrapati Sambhajinagar', 'Satara', 'C'),
(16, 2, 'Which city is often called the cultural capital of Maharashtra?', 'Pune', 'Kolhapur', 'Solapur', 'Amravati', 'A'),
(17, 2, 'The Maharashtra Legislative Assembly is located in:', 'Mumbai', 'Pune', 'Nagpur', 'Nashik', 'A'),
(18, 2, 'Which sea lies west of Maharashtra?', 'Arabian Sea', 'Bay of Bengal', 'Red Sea', 'Andaman Sea', 'A'),
(19, 2, 'Much of Maharashtra’s Deccan basalt is associated with:', 'Volcanic rocks', 'Marble', 'Granite only', 'Sandstone', 'A'),
(20, 2, 'Which movement began in 1942?', 'Non-Cooperation', 'Civil Disobedience', 'Quit India', 'Swadeshi', 'C'),
(21, 3, 'What is the SI unit of force?', 'Joule', 'Newton', 'Watt', 'Pascal', 'B'),
(22, 3, 'Who wrote India’s national anthem?', 'Bankim Chandra Chattopadhyay', 'Rabindranath Tagore', 'Sarojini Naidu', 'Subhas Chandra Bose', 'B'),
(23, 3, 'Which planet is known as the Red Planet?', 'Venus', 'Mars', 'Jupiter', 'Mercury', 'B'),
(24, 3, 'What is the currency of Japan?', 'Won', 'Yuan', 'Yen', 'Ringgit', 'C'),
(25, 3, 'Which organs filter blood in the human body?', 'Heart', 'Lungs', 'Kidneys', 'Stomach', 'C'),
(26, 3, 'The Constitution of India came into force on:', '15 August 1947', '26 November 1949', '26 January 1950', '2 October 1950', 'C'),
(27, 3, 'Which is the longest river in India?', 'Ganga', 'Yamuna', 'Narmada', 'Tapi', 'A'),
(28, 3, 'Which metal is liquid at room temperature?', 'Iron', 'Mercury', 'Copper', 'Aluminium', 'B'),
(29, 3, 'Who was the first Indian to win an individual Olympic gold medal?', 'Abhinav Bindra', 'Neeraj Chopra', 'Leander Paes', 'Rajyavardhan Rathore', 'A'),
(30, 3, 'Which vitamin is produced in the skin in sunlight?', 'Vitamin A', 'Vitamin B12', 'Vitamin C', 'Vitamin D', 'D'),
(31, 4, 'Which is the largest ocean?', 'Atlantic', 'Indian', 'Pacific', 'Arctic', 'C'),
(32, 4, 'How many continents are commonly recognized?', '5', '6', '7', '8', 'C'),
(33, 4, 'What is India’s national animal?', 'Lion', 'Tiger', 'Elephant', 'Peacock', 'B'),
(34, 4, 'What is India’s national bird?', 'Sparrow', 'Peacock', 'Eagle', 'Parrot', 'B'),
(35, 4, 'Which is India’s highest civilian award?', 'Padma Shri', 'Padma Bhushan', 'Bharat Ratna', 'Padma Vibhushan', 'C'),
(36, 4, 'Which is the largest planet?', 'Earth', 'Saturn', 'Jupiter', 'Neptune', 'C'),
(37, 4, 'How many days are in a leap year?', '365', '366', '364', '367', 'B'),
(38, 4, 'Which instrument measures temperature?', 'Barometer', 'Thermometer', 'Hygrometer', 'Ammeter', 'B'),
(39, 4, 'Which is the fastest land animal?', 'Lion', 'Cheetah', 'Horse', 'Leopard', 'B'),
(40, 4, 'Which language primarily structures web pages?', 'HTML', 'SQL', 'PHP', 'Python', 'A'),
(41, 5, 'What is 25 × 4?', '50', '75', '100', '125', 'C'),
(42, 5, 'What is 3/4 as a decimal?', '0.25', '0.5', '0.75', '1.25', 'C'),
(43, 5, 'Perimeter of a square with side 6 cm?', '12 cm', '18 cm', '24 cm', '36 cm', 'C'),
(44, 5, 'What is 15% of 200?', '15', '20', '30', '40', 'C'),
(45, 5, 'Next prime after 17?', '18', '19', '21', '23', 'B'),
(46, 5, 'Sum of angles in a triangle?', '90°', '180°', '270°', '360°', 'B'),
(47, 5, 'If x + 7 = 15, x = ?', '6', '7', '8', '9', 'C'),
(48, 5, 'Area of 8 cm × 5 cm rectangle?', '13 cm²', '26 cm²', '40 cm²', '80 cm²', 'C'),
(49, 5, 'Square root of 144?', '10', '11', '12', '14', 'C'),
(50, 5, 'In a 2:3 ratio totaling 25, one part is:', '4', '5', '6', '8', 'B'),
(51, 6, 'Which organ pumps blood?', 'Lungs', 'Heart', 'Kidney', 'Brain', 'B'),
(52, 6, 'Plants prepare food mainly by:', 'Respiration', 'Photosynthesis', 'Digestion', 'Fermentation', 'B'),
(53, 6, 'Water boils at sea level at about:', '0°C', '50°C', '100°C', '150°C', 'C'),
(54, 6, 'Which force pulls objects toward Earth?', 'Magnetic', 'Friction', 'Gravity', 'Buoyant', 'C'),
(55, 6, 'Which plant part absorbs water?', 'Flower', 'Root', 'Fruit', 'Leaf', 'B'),
(56, 6, 'Basic unit of life?', 'Atom', 'Cell', 'Tissue', 'Organ', 'B'),
(57, 6, 'Humans need which gas for respiration?', 'Nitrogen', 'Oxygen', 'Carbon dioxide', 'Helium', 'B'),
(58, 6, 'Planet closest to Sun?', 'Venus', 'Earth', 'Mercury', 'Mars', 'C'),
(59, 6, 'A pH below 7 is generally:', 'Acidic', 'Neutral', 'Basic', 'Metallic', 'A'),
(60, 6, 'A ramp is an example of:', 'Lever', 'Pulley', 'Inclined plane', 'Wheel and axle', 'C'),
(61, 7, 'Choose the noun: The dog is running.', 'The', 'dog', 'is', 'running', 'B'),
(62, 7, 'Past tense of go?', 'goed', 'going', 'went', 'gone', 'C'),
(63, 7, 'Which is an adjective?', 'quickly', 'beauty', 'beautiful', 'run', 'C'),
(64, 7, 'Choose the article: ___ apple a day.', 'A', 'An', 'The', 'No article', 'B'),
(65, 7, 'Opposite of ancient?', 'old', 'modern', 'historic', 'past', 'B'),
(66, 7, 'Plural of child?', 'childs', 'childes', 'children', 'childrens', 'C'),
(67, 7, 'Synonym of happy?', 'sad', 'joyful', 'angry', 'tired', 'B'),
(68, 7, 'Identify the verb: Ravi reads a book.', 'Ravi', 'reads', 'a', 'book', 'B'),
(69, 7, 'Choose the correct sentence.', 'She go to school.', 'She going school.', 'She goes to school.', 'She gone school.', 'C'),
(70, 7, 'A question normally ends with:', '.', ';', '!', '?', 'D'),
(71, 8, 'मराठी भाषेतील स्वर कोणता?', 'क', 'अ', 'त', 'म', 'B'),
(72, 8, 'घर हा कोणत्या प्रकारचा शब्द आहे?', 'नाम', 'क्रियापद', 'विशेषण', 'अव्यय', 'A'),
(73, 8, 'सुंदर हा कोणत्या प्रकारचा शब्द आहे?', 'नाम', 'सर्वनाम', 'विशेषण', 'क्रियापद', 'C'),
(74, 8, 'मी शाळेत जातो. या वाक्यातील क्रियापद?', 'मी', 'शाळेत', 'जातो', 'या', 'C'),
(75, 8, 'मोठा याचा विरुद्धार्थी शब्द?', 'लहान', 'उंच', 'जाड', 'लांब', 'A'),
(76, 8, 'जल याचा समानार्थी शब्द?', 'पाणी', 'आग', 'वारा', 'माती', 'A'),
(77, 8, 'मुले खेळतात. या वाक्यात कर्ता?', 'खेळतात', 'मुले', 'वाक्यात', 'कोण', 'B'),
(78, 8, 'क कोणत्या वर्गात येतो?', 'स्वर', 'व्यंजन', 'अंक', 'चिन्ह', 'B'),
(79, 8, 'आम्ही हे कोणते सर्वनाम?', 'पुरुषवाचक', 'दर्शक', 'प्रश्नार्थक', 'संबंधी', 'A'),
(80, 8, 'फूल याचे अनेकवचन?', 'फुला', 'फुले', 'फुली', 'फूलें', 'B'),
(81, 9, 'राम स्कूल जाता है। संज्ञा कौन-सी है?', 'जाता', 'राम', 'है', 'स्कूल', 'B'),
(82, 9, 'सुंदर किस प्रकार का शब्द है?', 'संज्ञा', 'सर्वनाम', 'विशेषण', 'क्रिया', 'C'),
(83, 9, 'दिन का विलोम?', 'सुबह', 'रात', 'सूरज', 'प्रकाश', 'B'),
(84, 9, 'जल का पर्यायवाची?', 'पानी', 'आग', 'हवा', 'धरती', 'A'),
(85, 9, 'मैं कौन-सा सर्वनाम है?', 'पुरुषवाचक', 'निजवाचक', 'प्रश्नवाचक', 'सम्बन्धवाचक', 'A'),
(86, 9, 'बच्चे खेल रहे हैं। क्रिया?', 'बच्चे', 'खेल', 'खेल रहे हैं', 'हैं', 'C'),
(87, 9, 'लड़का का बहुवचन?', 'लड़की', 'लड़के', 'लड़कियाँ', 'लड़कों', 'B'),
(88, 9, 'मीठा का विलोम?', 'खट्टा', 'नमकीन', 'कड़वा', 'सादा', 'C'),
(89, 9, 'विद्यालय का अर्थ?', 'अस्पताल', 'स्कूल', 'बाजार', 'घर', 'B'),
(90, 9, 'प्रश्नवाचक वाक्य के अंत में कौन-सा चिन्ह?', '।', ',', '?', ':', 'C'),
(91, 10, 'India is in which continent?', 'Europe', 'Asia', 'Africa', 'Australia', 'B'),
(92, 10, 'The Constitution is the supreme law of:', 'A village', 'A country', 'A school', 'A company', 'B'),
(93, 10, 'The Sun appears to rise in the:', 'West', 'North', 'East', 'South', 'C'),
(94, 10, 'Head of a municipal corporation is generally called:', 'Sarpanch', 'Mayor', 'Governor', 'Collector', 'B'),
(95, 10, 'Study of Earth’s surface and places is:', 'Geography', 'Biology', 'Chemistry', 'Physics', 'A'),
(96, 10, 'Indian Parliament includes Lok Sabha and:', 'Vidhan Sabha', 'Rajya Sabha', 'Gram Sabha', 'Zilla Parishad', 'B'),
(97, 10, 'Which is renewable?', 'Coal', 'Petroleum', 'Solar energy', 'Natural gas', 'C'),
(98, 10, 'A map showing mountains and rivers is a:', 'Physical map', 'Political map', 'Road map', 'Weather map', 'A'),
(99, 10, 'Capital of India?', 'Mumbai', 'New Delhi', 'Kolkata', 'Chennai', 'B'),
(100, 10, 'Village local self-government is commonly represented by:', 'Gram Panchayat', 'Rajya Sabha', 'High Court', 'Municipal Corporation', 'A'),
(101, 11, 'CPU stands for:', 'Central Processing Unit', 'Computer Primary Unit', 'Central Program Utility', 'Control Processing User', 'A'),
(102, 11, 'Device used mainly to type text?', 'Monitor', 'Keyboard', 'Speaker', 'Printer', 'B'),
(103, 11, 'Example of an operating system?', 'Windows', 'Google', 'YouTube', 'HTML', 'A'),
(104, 11, 'URL stands for:', 'Uniform Resource Locator', 'Universal Reading Link', 'User Resource List', 'Uniform Record Language', 'A'),
(105, 11, 'Device that displays visual output?', 'Keyboard', 'Mouse', 'Monitor', 'Microphone', 'C'),
(106, 11, '1 byte contains:', '4 bits', '8 bits', '16 bits', '32 bits', 'B'),
(107, 11, 'Used to store files permanently?', 'RAM', 'Hard drive/SSD', 'CPU', 'Monitor', 'B'),
(108, 11, 'WWW stands for:', 'World Wide Web', 'World Web Window', 'Wide World Word', 'Web World Work', 'A'),
(109, 11, 'Which is a web browser?', 'Chrome', 'Windows', 'Linux', 'Excel', 'A'),
(110, 11, 'A strong password should contain:', 'Only your name', 'Only 123456', 'A mix of letters, numbers and symbols', 'Only birth year', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `quiz_id` int(11) NOT NULL,
  `category` varchar(80) NOT NULL,
  `title` varchar(150) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`quiz_id`, `category`, `title`, `description`) VALUES
(1, '', 'UPSC General Studies', '10 practice questions covering history, geography, polity, economy and science.'),
(2, '', 'MPSC General Studies', '10 Maharashtra and general studies practice questions.'),
(3, '', 'SSC CGL General Awareness', '10 SSC CGL general awareness practice questions.'),
(4, '', 'General Knowledge', '10 general knowledge practice questions.'),
(5, '', 'Mathematics Test', '10 school mathematics practice questions.'),
(6, '', 'Science Test', '10 school science practice questions.'),
(7, '', 'English Test', '10 school English practice questions.'),
(8, '', 'Marathi Test', '10 Marathi language practice questions.'),
(9, '', 'Hindi Test', '10 Hindi language practice questions.'),
(10, '', 'Social Science', '10 social science practice questions.'),
(11, '', 'Computer Test', '10 computer practice questions.');

-- --------------------------------------------------------

--
-- Table structure for table `results`
--

CREATE TABLE `results` (
  `result_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quiz_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `percentage` decimal(5,2) NOT NULL,
  `taken_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `results`
--

INSERT INTO `results` (`result_id`, `user_id`, `quiz_id`, `score`, `total_questions`, `percentage`, `taken_at`) VALUES
(1, 1, 4, 5, 10, 50.00, '2026-09-29 14:43:35'),
(3, 2, 11, 7, 10, 70.00, '2026-10-03 09:01:19'),
(4, 2, 7, 1, 10, 10.00, '2026-10-03 09:15:10'),
(5, 1, 7, 3, 10, 30.00, '2026-10-04 16:37:05'),
(6, 2, 1, 2, 10, 20.00, '2026-10-05 09:01:13'),
(7, 2, 7, 7, 10, 70.00, '2026-10-05 09:36:57'),
(8, 2, 11, 0, 10, 0.00, '2026-10-05 14:40:20'),
(9, 1, 11, 0, 10, 0.00, '2026-10-05 15:33:12'),
(10, 1, 11, 0, 10, 0.00, '2026-10-05 15:33:35'),
(11, 2, 10, 0, 10, 0.00, '2026-10-05 15:35:12'),
(12, 2, 10, 0, 10, 0.00, '2026-10-05 15:35:20'),
(13, 1, 11, 0, 10, 0.00, '2026-10-05 15:35:53'),
(14, 1, 11, 0, 10, 0.00, '2026-10-05 15:40:36'),
(15, 1, 11, 0, 10, 0.00, '2026-10-05 17:26:51'),
(16, 2, 11, 0, 10, 0.00, '2026-10-06 03:55:54'),
(17, 2, 11, 0, 10, 0.00, '2026-10-06 04:58:02'),
(18, 2, 11, 1, 10, 10.00, '2026-10-06 05:10:46'),
(26, 2, 11, 1, 10, 10.00, '2026-10-06 05:23:47'),
(27, 3, 11, 0, 10, 0.00, '2026-10-06 05:26:24'),
(28, 3, 11, 4, 10, 40.00, '2026-10-06 05:26:51'),
(29, 2, 11, 1, 10, 10.00, '2026-10-06 05:27:09'),
(30, 2, 10, 4, 10, 40.00, '2026-10-06 05:27:38'),
(31, 2, 11, 4, 10, 40.00, '2026-10-06 05:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `result_answers`
--

CREATE TABLE `result_answers` (
  `result_answer_id` int(11) NOT NULL,
  `result_id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `selected_answer` char(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `result_answers`
--

INSERT INTO `result_answers` (`result_answer_id`, `result_id`, `question_id`, `selected_answer`, `created_at`) VALUES
(1, 3, 101, 'A', '2026-10-03 09:01:19'),
(2, 3, 102, 'B', '2026-10-03 09:01:19'),
(3, 3, 103, 'A', '2026-10-03 09:01:19'),
(4, 3, 104, 'B', '2026-10-03 09:01:19'),
(5, 3, 105, 'C', '2026-10-03 09:01:19'),
(6, 3, 106, 'C', '2026-10-03 09:01:19'),
(7, 3, 107, 'B', '2026-10-03 09:01:19'),
(8, 3, 108, 'B', '2026-10-03 09:01:19'),
(9, 3, 109, 'A', '2026-10-03 09:01:19'),
(10, 3, 110, 'C', '2026-10-03 09:01:19'),
(11, 4, 61, 'A', '2026-10-03 09:15:10'),
(12, 4, 62, 'B', '2026-10-03 09:15:10'),
(13, 4, 63, NULL, '2026-10-03 09:15:10'),
(14, 4, 64, 'C', '2026-10-03 09:15:10'),
(15, 4, 65, 'D', '2026-10-03 09:15:10'),
(16, 4, 66, 'C', '2026-10-03 09:15:10'),
(17, 4, 67, 'D', '2026-10-03 09:15:10'),
(18, 4, 68, 'D', '2026-10-03 09:15:10'),
(19, 4, 69, 'D', '2026-10-03 09:15:10'),
(20, 4, 70, 'C', '2026-10-03 09:15:10'),
(21, 5, 61, 'A', '2026-10-04 16:37:05'),
(22, 5, 62, 'D', '2026-10-04 16:37:05'),
(23, 5, 63, 'C', '2026-10-04 16:37:05'),
(24, 5, 64, 'C', '2026-10-04 16:37:05'),
(25, 5, 65, 'A', '2026-10-04 16:37:05'),
(26, 5, 66, 'C', '2026-10-04 16:37:05'),
(27, 5, 67, 'A', '2026-10-04 16:37:05'),
(28, 5, 68, 'D', '2026-10-04 16:37:05'),
(29, 5, 69, 'D', '2026-10-04 16:37:05'),
(30, 5, 70, 'D', '2026-10-04 16:37:05'),
(31, 6, 1, 'B', '2026-10-05 09:01:13'),
(32, 6, 2, 'B', '2026-10-05 09:01:13'),
(33, 6, 3, 'A', '2026-10-05 09:01:13'),
(34, 6, 4, 'B', '2026-10-05 09:01:13'),
(35, 6, 5, 'B', '2026-10-05 09:01:13'),
(36, 6, 6, 'C', '2026-10-05 09:01:13'),
(37, 6, 7, NULL, '2026-10-05 09:01:13'),
(38, 6, 8, 'C', '2026-10-05 09:01:13'),
(39, 6, 9, 'A', '2026-10-05 09:01:13'),
(40, 6, 10, 'A', '2026-10-05 09:01:13'),
(41, 7, 61, 'B', '2026-10-05 09:36:57'),
(42, 7, 62, 'A', '2026-10-05 09:36:57'),
(43, 7, 63, 'B', '2026-10-05 09:36:57'),
(44, 7, 64, 'B', '2026-10-05 09:36:57'),
(45, 7, 65, 'B', '2026-10-05 09:36:57'),
(46, 7, 66, 'B', '2026-10-05 09:36:57'),
(47, 7, 67, 'B', '2026-10-05 09:36:57'),
(48, 7, 68, 'B', '2026-10-05 09:36:57'),
(49, 7, 69, 'C', '2026-10-05 09:36:57'),
(50, 7, 70, 'D', '2026-10-05 09:36:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'harsgh12', 'palavharsh0@gmail.com', '$2y$10$QK8GxRjQi1WAD3uh4mihreu9byuQs2LVcHasb1QRDQW3dGqNg5Csi', 'student', '2026-09-29 14:41:05'),
(2, 'harsh11', 'palavdattaram8@gmail.com', '$2y$10$dpEOMEmTIsVsjQTKzIeApe4xtOPmcWOJhIHG/Afd3wFuI11jEWHNe', 'student', '2026-10-03 08:13:17'),
(3, 'admin', 'dattarampalav91@gmail.com', '$2y$12$XjmKBWFGzbKGN1eLGeR6EeLhy04Ph4QZ0FyFtDQjiodR2eGBsCTl.', 'admin', '2026-10-05 15:49:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`quiz_id`);

--
-- Indexes for table `results`
--
ALTER TABLE `results`
  ADD PRIMARY KEY (`result_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `result_answers`
--
ALTER TABLE `result_answers`
  ADD PRIMARY KEY (`result_answer_id`),
  ADD UNIQUE KEY `uq_result_question` (`result_id`,`question_id`),
  ADD KEY `fk_result_answers_question` (`question_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `quiz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `results`
--
ALTER TABLE `results`
  MODIFY `result_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `result_answers`
--
ALTER TABLE `result_answers`
  MODIFY `result_answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `results`
--
ALTER TABLE `results`
  ADD CONSTRAINT `results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `results_ibfk_2` FOREIGN KEY (`quiz_id`) REFERENCES `quizzes` (`quiz_id`) ON DELETE CASCADE;

--
-- Constraints for table `result_answers`
--
ALTER TABLE `result_answers`
  ADD CONSTRAINT `fk_result_answers_question` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_result_answers_result` FOREIGN KEY (`result_id`) REFERENCES `results` (`result_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
