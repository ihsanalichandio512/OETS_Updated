-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2024 at 10:42 AM
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
-- Database: `oets`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_sessions`
--

CREATE TABLE `active_sessions` (
  `session_id` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `answer_text` text DEFAULT NULL,
  `selected_option` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`answer_id`, `question_id`, `user_id`, `semester_id`, `exam_id`, `answer_text`, `selected_option`) VALUES
(44, 10, 4, 6, 3, 'jkhjk', NULL),
(45, 10, 4, 6, 3, 'jkhjk', NULL),
(46, 8, 4, 6, 3, 'hjkhk', NULL),
(47, 17, 4, 6, 3, 'khkj', NULL),
(48, 20, 4, 6, 3, 'jhjk', NULL),
(49, 2, 4, 6, 3, 'hjkh', NULL),
(50, 15, 4, 6, 3, 'hkjk', NULL),
(51, 11, 4, 6, 3, 'hjkh', NULL),
(52, 18, 4, 6, 3, 'hjkhk', NULL),
(53, 5, 4, 6, 3, 'hjkhjk', NULL),
(54, 13, 4, 6, 3, 'hjkhk', NULL),
(55, 4, 4, 6, 3, 'hjkhjk', NULL),
(56, 21, 4, 6, 3, 'hjkh', NULL),
(57, 9, 4, 6, 3, 'jkh', NULL),
(58, 22, 4, 6, 3, 'jkh', NULL),
(59, 14, 4, 6, 3, 'jkh', NULL),
(60, 16, 4, 6, 3, 'jkhjk', NULL),
(61, 6, 4, 6, 3, 'hjk', NULL),
(62, 12, 4, 6, 3, 'hkj', NULL),
(63, 3, 4, 6, 3, 'hkj', NULL),
(64, 7, 4, 6, 3, 'kjh', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `batches`
--

CREATE TABLE `batches` (
  `batch_id` int(11) NOT NULL,
  `batch_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `batches`
--

INSERT INTO `batches` (`batch_id`, `batch_name`) VALUES
(1, '2020'),
(2, '2021');

-- --------------------------------------------------------

--
-- Table structure for table `exams`
--

CREATE TABLE `exams` (
  `exam_id` int(11) NOT NULL,
  `exam_type` enum('class_test','entry_test','internal_exam','external_exam') NOT NULL,
  `exam_duration_minutes` int(11) DEFAULT NULL,
  `start_datetime` date NOT NULL DEFAULT curdate(),
  `exam_status` enum('active','inactive') DEFAULT 'inactive',
  `semester_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `batch_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exams`
--

INSERT INTO `exams` (`exam_id`, `exam_type`, `exam_duration_minutes`, `start_datetime`, `exam_status`, `semester_id`, `subject_id`, `teacher_id`, `batch_id`) VALUES
(3, 'external_exam', 2, '2024-05-01', 'active', 6, 9, 16, 0),
(5, 'entry_test', 2, '2024-04-10', 'inactive', 6, 9, 16, 0),
(6, '', 2, '2024-05-02', 'inactive', 6, 9, 16, 0),
(8, 'internal_exam', 2, '2024-04-25', 'inactive', 6, 10, 16, 0),
(9, 'internal_exam', 1, '2024-04-29', 'inactive', 6, 9, 16, 0),
(10, 'class_test', 1, '2024-05-01', 'inactive', 6, 9, 16, 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_results`
--

CREATE TABLE `exam_results` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `long_answer_score` int(11) NOT NULL,
  `mcq_score` int(11) NOT NULL,
  `true_false_score` int(11) NOT NULL,
  `fill_in_the_blanks_score` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `total_questions` int(11) NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_completed` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fill_in_the_blanks`
--

CREATE TABLE `fill_in_the_blanks` (
  `question_id` int(6) UNSIGNED NOT NULL,
  `question_text` text NOT NULL,
  `correct_answer` text NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_mark` int(11) NOT NULL,
  `is_completed` enum('completed','not_completed') NOT NULL DEFAULT 'not_completed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fill_in_the_blanks`
--

INSERT INTO `fill_in_the_blanks` (`question_id`, `question_text`, `correct_answer`, `exam_id`, `question_mark`, `is_completed`) VALUES
(1, 'ihsan ali is_____________ at aptech', 'teacher', 3, 10, 'completed'),
(2, '_________________ is the father of comuter', 'Charles Babage', 5, 10, 'not_completed'),
(3, 'The capital of France is ________', 'Paris', 3, 2, 'completed'),
(4, 'The largest planet in our solar system is ________', 'Jupiter', 3, 2, 'completed'),
(5, 'The chemical symbol for water is ________', 'H2O', 3, 2, 'completed'),
(6, 'The number of continents on Earth is ________', '7', 3, 2, 'completed'),
(7, 'The formula for calculating the area of a rectangle is length × ________', 'width', 5, 2, 'not_completed'),
(8, 'The chemical symbol for oxygen is ________', 'O', 3, 2, 'completed'),
(9, 'The first president of the United States was ________', 'George Washington', 5, 2, 'not_completed'),
(10, 'The largest ocean on Earth is the ________ Ocean', 'Pacific', 5, 2, 'not_completed'),
(11, 'The process of plants turning sunlight into energy is called ________', 'photosynthesis', 3, 2, 'completed'),
(12, 'The smallest prime number is ________', '2', 3, 2, 'completed'),
(13, 'The study of living organisms is called ________', 'biology', 5, 2, 'not_completed'),
(14, 'The formula for calculating the circumference of a circle is ________', '2πr', 5, 2, 'not_completed'),
(15, 'The chemical symbol for carbon is ________', 'C', 5, 2, 'not_completed'),
(16, 'The primary colors are red, blue, and ________', 'yellow', 3, 2, 'completed'),
(17, 'The distance around a circle is called the ________', 'circumference', 5, 2, 'not_completed'),
(18, 'The human body has ________ bones', '206', 3, 3, 'completed'),
(19, 'The study of the Earth\'s physical structure and substance is called ________', 'geology', 3, 2, 'completed'),
(20, 'The formula for the Pythagorean theorem is a² + b² = ________', 'c²', 5, 2, 'not_completed'),
(21, 'The largest desert in the world is the ________ Desert', 'Sahara', 3, 2, 'completed'),
(22, 'The chemical symbol for gold is ________', 'Au', 3, 2, 'completed');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_password`
--

CREATE TABLE `forgot_password` (
  `reset_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `multiple_choice_questions`
--

CREATE TABLE `multiple_choice_questions` (
  `question_id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `option_a` varchar(100) NOT NULL,
  `option_b` varchar(100) NOT NULL,
  `option_c` varchar(100) NOT NULL,
  `option_d` varchar(100) NOT NULL,
  `correct_option` enum('A','B','C','D') NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_mark` int(11) NOT NULL,
  `is_completed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `multiple_choice_questions`
--

INSERT INTO `multiple_choice_questions` (`question_id`, `question_text`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `exam_id`, `question_mark`, `is_completed`) VALUES
(23, 'What is the output of the following C code?', 'Hello', 'World', 'Hello World', 'No output', 'C', 3, 1, 0),
(24, 'What is the default return type of a function in C?', 'int', 'void', 'float', 'char', 'B', 3, 1, 0),
(25, 'How do you define a constant in C?', '#define', 'const', 'constant', 'final', 'A', 3, 1, 0),
(26, 'Which operator is used to allocate memory dynamically in C?', 'malloc()', 'calloc()', 'alloc()', 'allocmem()', 'A', 3, 1, 0),
(27, 'What will be the output of the following code snippet?', 'Syntax error', 'Garbage value', '10', '0', 'C', 3, 1, 0),
(28, 'What is the size of int in C?', '2 bytes', '4 bytes', '8 bytes', 'Depends on the compiler', 'B', 3, 1, 0),
(29, 'What is the correct way to declare an array in C?', 'int array[10];', 'array<int> arr;', 'array arr[10];', 'int arr[];', 'A', 3, 1, 0),
(30, 'What is the result of the expression 5 + 2 * 3 in C?', '21', '11', '17', '13', 'D', 3, 1, 0),
(31, 'What is the syntax to declare a pointer in C?', 'int *ptr;', 'int ptr;', 'ptr int;', 'int &ptr;', 'A', 3, 1, 0),
(32, 'Which of the following is an escape sequence in C?', '\\n', '\\e', '\\t', '\\a', 'A', 3, 1, 0),
(33, 'What is the purpose of #include<stdio.h> in C?', 'To include the I/O functions', 'To include the math functions', 'To include the string functions', 'To include the file handling functions', 'A', 3, 1, 0),
(34, 'What will be the output of printf(\"%d\", 5 / 2); in C?', '2', '2.5', '2.0', '2.25', 'A', 3, 1, 0),
(35, 'What is the correct syntax for a do-while loop in C?', 'do { // code } while (condition);', 'do (condition) { // code } while;', 'while (condition) { // code } do;', 'do (condition) { // code } while;', 'A', 3, 1, 0),
(36, 'What is the function of the modulus operator in C?', 'To perform division', 'To find remainder', 'To find quotient', 'To perform multiplication', 'B', 3, 1, 0),
(37, 'Which header file is used for dynamic memory allocation in C?', '<stdlib.h>', '<stdio.h>', '<string.h>', '<math.h>', 'A', 3, 1, 0),
(38, 'What is the output of the following C++ code?', 'C++ is a High Level Language', 'C++ is a compiler', 'C++ is a library', 'C++ is an Object Oriented Programming Language', 'D', 3, 1, 0),
(39, 'What is the correct syntax for inheritance in C++?', 'class SubClass : public SuperClass', 'class SubClass -> public SuperClass', 'class SubClass :: public SuperClass', 'class SubClass extends SuperClass', 'A', 3, 1, 0),
(40, 'Which header file should be included to use cout in C++?', '<iostream>', '<stdio.h>', '<conio.h>', '<iostream.h>', 'A', 3, 1, 0),
(41, 'Which operator is used to dereference a pointer in C++?', '*', '->', '&', '::', 'A', 3, 1, 0),
(42, 'What is the size of an integer data type in C++?', '2 bytes', '4 bytes', '8 bytes', 'Depends on the compiler', 'B', 3, 1, 0),
(43, 'What is the output of the following C++ code?', 'No output', 'Syntax error', 'Hello', 'World', 'C', 3, 1, 0),
(44, 'Which keyword is used to define a function in C++?', 'function', 'define', 'method', 'void', 'D', 3, 1, 0),
(45, '0', 'Bitwise AND', 'Bitwise OR', 'Right shift', 'Left shift', 'D', 3, 1, 0),
(46, 'Which data type is used to store single characters in C++?', 'char', 'string', 'int', 'float', 'A', 3, 1, 0),
(47, 'What is the correct way to initialize an array in C++?', 'int arr[] = {1, 2, 3};', 'array<int> arr = {1, 2, 3};', 'arr[3] = {1, 2, 3};', 'arr<int> = {1, 2, 3};', 'A', 3, 1, 0),
(48, 'What is the output of cout << 5 / 2; in C++?', '2.5', '2', '2.0', '2.25', 'B', 3, 1, 0),
(49, 'Which type of loop is used to execute a block of code repeatedly until a specified condition is false in C++?', 'for loop', 'while loop', 'do-while loop', 'if-else loop', 'B', 3, 1, 0),
(50, 'What is the function of the modulus operator in C++?', 'To perform division', 'To find remainder', 'To find quotient', 'To perform multiplication', 'B', 3, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `question_id` int(11) NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_text` text DEFAULT NULL,
  `question_mark` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`question_id`, `exam_id`, `question_text`, `question_mark`) VALUES
(1, 5, 'who is the father of computer', 10),
(2, 5, 'what is the full form of html', 10),
(3, 5, 'What is the capital of France?', 1),
(4, 3, 'Who wrote the famous novel \"To Kill a Mockingbird\"?', 1),
(5, 8, 'What is the chemical symbol for water?', 1),
(6, 9, 'Which planet is known as the Red Planet?', 1),
(7, 5, 'What is the tallest mountain in the world?', 1),
(8, 3, 'Who painted the Mona Lisa?', 1),
(9, 8, 'What is the largest organ in the human body?', 1),
(10, 9, 'Which country is known as the Land of the Rising Sun?', 1),
(11, 5, 'What year did the Titanic sink?', 1),
(12, 3, 'Who invented the telephone?', 1),
(13, 8, 'What is the chemical symbol for gold?', 1),
(14, 9, 'Which ocean is the largest?', 1),
(15, 5, 'Who is known as the father of modern physics?', 1),
(16, 3, 'What is the capital of Japan?', 1),
(17, 8, 'Who wrote the play \"Romeo and Juliet\"?', 1),
(18, 9, 'What is the hardest natural substance on Earth?', 1),
(19, 5, 'What is the tallest mammal?', 1),
(20, 3, 'What is the smallest country in the world?', 1),
(21, 8, 'Who painted the ceiling of the Sistine Chapel?', 1),
(22, 9, 'What is the capital of Brazil?', 1),
(23, NULL, 'HWLO LFJ;LAJ;L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'student'),
(3, 'teacher'),
(4, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `semester_id` int(11) NOT NULL,
  `semester_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`semester_id`, `semester_name`) VALUES
(6, '1st'),
(7, '2nd');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `exam_id` int(11) NOT NULL,
  `subject_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `user_id`, `batch_id`, `semester_id`, `exam_id`, `subject_Id`) VALUES
(1, 4, 1, 6, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `subject_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `semester_id` int(11) DEFAULT NULL,
  `teacher_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`subject_id`, `subject_name`, `semester_id`, `teacher_Id`) VALUES
(9, 'english', 6, 6),
(10, 'Math', 6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `teacher_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`teacher_id`, `user_id`) VALUES
(16, 1);

-- --------------------------------------------------------

--
-- Table structure for table `true_false_question`
--

CREATE TABLE `true_false_question` (
  `ques_id` int(11) NOT NULL,
  `question_text` varchar(255) NOT NULL,
  `correct_answer` enum('True','False') NOT NULL,
  `exam_id` int(11) DEFAULT NULL,
  `question_mark` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `true_false_question`
--

INSERT INTO `true_false_question` (`ques_id`, `question_text`, `correct_answer`, `exam_id`, `question_mark`) VALUES
(1, 'is html a programing language?', 'False', 3, 10),
(2, 'is the css is programming language?', 'False', 3, 10),
(3, 'The Earth is flat.', 'False', 5, 1),
(4, 'Water boils at 100 degrees Celsius.', 'True', 3, 1),
(5, 'The moon orbits the Earth.', 'True', 8, 1),
(6, 'Mars is the largest planet in the solar system.', 'False', 9, 1),
(7, 'The Great Wall of China is visible from space.', 'False', 5, 1),
(8, 'Albert Einstein invented the lightbulb.', 'False', 3, 1),
(9, 'Gold is a chemical element.', 'True', 8, 1),
(10, 'Mount Everest is located in Europe.', 'False', 9, 1),
(11, 'The Nile River is the longest river in the world.', 'True', 5, 1),
(12, 'The speed of light is approximately 300,000 km/s.', 'True', 3, 1),
(13, 'Oxygen is the most abundant element in the Earth\'s atmosphere.', 'False', 8, 1),
(14, 'The Sahara Desert is the largest desert in the world.', 'True', 9, 1),
(15, 'The human body has four lungs.', 'False', 5, 1),
(16, 'The Eiffel Tower is located in London.', 'False', 3, 1),
(17, 'Diamonds are formed from coal.', 'False', 8, 1),
(18, 'The Pacific Ocean is the smallest ocean on Earth.', 'False', 9, 1),
(19, 'A triangle has four sides.', 'False', 5, 1),
(20, 'Venus is the closest planet to the Sun.', 'False', 3, 1),
(21, 'The Amazon River flows through Africa.', 'False', 8, 1),
(22, 'Sharks are mammals.', 'False', 9, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_cheated` enum('yes','no') NOT NULL DEFAULT 'no',
  `is_completed` enum('completed','not_completed') DEFAULT 'not_completed',
  `role_id` int(11) DEFAULT 1,
  `user_photo` blob DEFAULT NULL,
  `exam_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `username`, `password`, `is_cheated`, `is_completed`, `role_id`, `user_photo`, `exam_id`) VALUES
(1, 'abuzar abbasi', 'abuzarhussaini512@gmail.com', 'abuzar110', '$2y$10$Ya18M.yTl/SPkDi0C2.CvuB2HAelKlmM9DyVO/DLv2fWi9/oXxO1W', 'no', 'not_completed', 3, 0x2e2f696d67363631363730663338633539325f494d472d32303232313130332d5741303031332e6a7067, 0),
(2, 'ihsan ali ', 'ihsanalichandio02@gmail.com', 'ihsanali512', '$2y$10$YZvgWsWSWx8AH1uqtWAHoOtdCAAdLtuORQkETSzLWCnenbh0S5Xt.', 'no', 'not_completed', 4, 0x2e2f696d672f363631636363336462366366305f322e6a7067, 0),
(3, 'aakash ameer abro', 'aakash@gmail.com', 'aakash111', '$2y$10$HX3V9cB4whbN4QN9CM6RQeEBdj9iPQ0ncA52VRJiL0fBs/kkEoom2', 'no', 'not_completed', 3, 0x2e2f696d672f363632306262643865336465395f494d472d32303233303330362d5741303038362e6a7067, 0),
(4, 'abraiz ali', 'abraizali@gmail.com', 'abraiz111', '$2y$10$VA1Q66v9vO3JlPjmM0mUueC0dHgRmUAlz4iJH9coduNNB5XFVY6wu', 'no', 'not_completed', 1, 0x2e2f696d672f363632363163363436336462645f494d472d32303233303330362d5741303330342e6a7067, 0),
(8, 'ihsan ali chandio', 'ahsanali@gmail.com', 'ihsan110', '$2y$10$/7DL5IeRzfVy0TkpSGhDmu/i.fdiJsuH.GFtAiCt3x/EbqmudOOL.', 'no', 'not_completed', 4, 0x2e2f696d672f363632653335366634653639665f70726f66696c652e6a7067, 0),
(11, 'Abuzar Al Hussaini', 'abuzaralabbasi@gmail.com', 'abuzar786', '$2y$10$JdF2t3cvN/gD48mYHWfsH.teSZtVtpp/bzBqk8tWjUWnEVLYGnzHW', 'no', 'not_completed', 4, 0x2e2f696d672f363632653338353462643430615f494d472d32303232313130332d5741303031332e6a7067, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_sessions`
--
ALTER TABLE `active_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `answers_ibfk_1` (`question_id`),
  ADD KEY `exam_id` (`exam_id`),
  ADD KEY `semester_id` (`semester_id`),
  ADD KEY `answers_ibfk_4` (`user_id`);

--
-- Indexes for table `batches`
--
ALTER TABLE `batches`
  ADD PRIMARY KEY (`batch_id`);

--
-- Indexes for table `exams`
--
ALTER TABLE `exams`
  ADD PRIMARY KEY (`exam_id`),
  ADD KEY `exams_ibfk_1` (`semester_id`),
  ADD KEY `exams_ibfk_2` (`subject_id`),
  ADD KEY `exams_ibfk_3` (`teacher_id`);

--
-- Indexes for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `exam_results_ibfk_1` (`user_id`),
  ADD KEY `exam_results_ibfk_2` (`exam_id`),
  ADD KEY `exam_results_ibfk_3` (`semester_id`),
  ADD KEY `exam_results_ibfk_4` (`batch_id`);

--
-- Indexes for table `fill_in_the_blanks`
--
ALTER TABLE `fill_in_the_blanks`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `fill_in_the_blanks_ibfk_1` (`exam_id`);

--
-- Indexes for table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD PRIMARY KEY (`reset_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `multiple_choice_questions`
--
ALTER TABLE `multiple_choice_questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `multiple_choice_questions_ibfk_1` (`exam_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `questions_ibfk_1` (`exam_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`semester_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `students_ibfk_1` (`user_id`),
  ADD KEY `students_ibfk_2` (`batch_id`),
  ADD KEY `students_ibfk_3` (`semester_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`subject_id`),
  ADD KEY `subjects_ibfk_1` (`semester_id`),
  ADD KEY `subjects_ibfk_2` (`teacher_Id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`teacher_id`),
  ADD KEY `teachers_ibfk_1` (`user_id`);

--
-- Indexes for table `true_false_question`
--
ALTER TABLE `true_false_question`
  ADD PRIMARY KEY (`ques_id`),
  ADD KEY `true_false_question_ibfk_1` (`exam_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `users_ibfk_1` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `answer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `batches`
--
ALTER TABLE `batches`
  MODIFY `batch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `exams`
--
ALTER TABLE `exams`
  MODIFY `exam_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `exam_results`
--
ALTER TABLE `exam_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fill_in_the_blanks`
--
ALTER TABLE `fill_in_the_blanks`
  MODIFY `question_id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `forgot_password`
--
ALTER TABLE `forgot_password`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `multiple_choice_questions`
--
ALTER TABLE `multiple_choice_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `semester_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `subject_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `teacher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `true_false_question`
--
ALTER TABLE `true_false_question`
  MODIFY `ques_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`question_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `answers_ibfk_4` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`subject_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exams_ibfk_3` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exam_results`
--
ALTER TABLE `exam_results`
  ADD CONSTRAINT `exam_results_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_results_ibfk_2` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_results_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `exam_results_ibfk_4` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `fill_in_the_blanks`
--
ALTER TABLE `fill_in_the_blanks`
  ADD CONSTRAINT `fill_in_the_blanks_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `forgot_password`
--
ALTER TABLE `forgot_password`
  ADD CONSTRAINT `forgot_password_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `multiple_choice_questions`
--
ALTER TABLE `multiple_choice_questions`
  ADD CONSTRAINT `multiple_choice_questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`batch_id`) REFERENCES `batches` (`batch_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`semester_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subjects_ibfk_2` FOREIGN KEY (`teacher_Id`) REFERENCES `teachers` (`teacher_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teachers`
--
ALTER TABLE `teachers`
  ADD CONSTRAINT `teachers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `true_false_question`
--
ALTER TABLE `true_false_question`
  ADD CONSTRAINT `true_false_question_ibfk_1` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`exam_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
