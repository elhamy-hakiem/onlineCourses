-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2022 at 03:37 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_courses`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) UNSIGNED NOT NULL,
  `course_title` varchar(150) CHARACTER SET utf8 NOT NULL,
  `course_description` text CHARACTER SET utf8 NOT NULL,
  `course_cover` varchar(200) CHARACTER SET utf8 NOT NULL,
  `course_instructor` int(11) UNSIGNED NOT NULL,
  `course_category` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_title`, `course_description`, `course_cover`, `course_instructor`, `course_category`) VALUES
(12, 'Java', 'Ex veniam dolor dol Ex veniam dolor dol Ex veniam dolor dolv Ex veniam dolor dol', '38815cf7be6802a3fefc2efa8ff7d8fe.jpeg', 22, 7);

-- --------------------------------------------------------

--
-- Table structure for table `courses_lessons`
--

CREATE TABLE `courses_lessons` (
  `lesson_id` int(11) UNSIGNED NOT NULL,
  `lesson_title` varchar(150) CHARACTER SET utf8 NOT NULL,
  `lesson_description` text CHARACTER SET utf8 NOT NULL,
  `lesson_cover` varchar(200) CHARACTER SET utf8 NOT NULL,
  `lesson_video` varchar(200) CHARACTER SET utf8 NOT NULL,
  `lesson_instructor` int(11) UNSIGNED NOT NULL,
  `lesson_course` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses_lessons`
--

INSERT INTO `courses_lessons` (`lesson_id`, `lesson_title`, `lesson_description`, `lesson_cover`, `lesson_video`, `lesson_instructor`, `lesson_course`) VALUES
(10, 'Id eum aut iure ad s', 'Reprehenderit in ar Reprehenderit in ar Reprehenderit in ar Reprehenderit in ar Reprehenderit in ar Reprehenderit in ar', '37ce04e0943bcfdc61948b44d5502bba.jpeg', '35d1e22e0856613c6b8e786946253460.mp4', 22, 12),
(11, 'Hic libero eum volup', 'Nam anim omnis qui o Nam anim omnis qui o Nam anim omnis qui o Nam anim omnis qui o Nam anim omnis qui o', 'e44a211def7905dcba2618bed7373949.jpeg', '0b0199a1da23d144bf1250167c63b541.mp4', 22, 12),
(12, 'Sunt incididunt dele', 'Ipsum vero id aliqui Ipsum vero id aliqui Ipsum vero id aliqui Ipsum vero id aliqui', '011c238fb7e3e2be5cd29efcf7a71658.jpeg', '616e77f69fb81e5f8a5e661b923eb20a.mp4', 22, 12);

-- --------------------------------------------------------

--
-- Table structure for table `courses_lessons_comments`
--

CREATE TABLE `courses_lessons_comments` (
  `comment_id` int(11) UNSIGNED NOT NULL,
  `comment_title` varchar(200) CHARACTER SET utf8 NOT NULL,
  `comment_content` text CHARACTER SET utf8 NOT NULL,
  `comment_lesson` int(11) UNSIGNED NOT NULL,
  `comment_user` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses_lessons_comments`
--

INSERT INTO `courses_lessons_comments` (`comment_id`, `comment_title`, `comment_content`, `comment_lesson`, `comment_user`) VALUES
(1, 'my opinion', 'Thanks ', 11, 9),
(2, 'thank you', 'Mo Salah', 11, 22);

-- --------------------------------------------------------

--
-- Table structure for table `courses_students`
--

CREATE TABLE `courses_students` (
  `course_id` int(11) UNSIGNED NOT NULL,
  `student_id` int(11) UNSIGNED NOT NULL,
  `approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses_students`
--

INSERT INTO `courses_students` (`course_id`, `student_id`, `approved`) VALUES
(12, 23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `category_id` int(11) UNSIGNED NOT NULL,
  `category_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `created_by` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `course_categories`
--

INSERT INTO `course_categories` (`category_id`, `category_name`, `created_by`) VALUES
(6, 'Cs', 12),
(7, 'IS', 12),
(8, 'Database', 12);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `email` varchar(150) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `user_image` varchar(200) CHARACTER SET utf8 NOT NULL,
  `user_group` tinyint(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `email`, `password`, `user_image`, `user_group`) VALUES
(9, 'mosalah', 'elhamy@gmail.com', '$2y$10$npSTnxwYFr/P9MHLx49XF.sX4LEoQJEOC96XotbXL0er4.LssY9ua', '4c6e2453f1d6ec19edecf43c51fa19ef_IMG_2915.jpg', 3),
(12, 'elhamy_hakiem', 'elhamy155@gmail.com', '$2y$10$fF2Ypj3BqQKD.4pOSbjQcO9VMeyYipbB3pHu.xnpDClv6qUnJk2y.', '3e43aed847e33f07154fc445d9e1ef8f.jpeg', 1),
(18, 'ralisy', 'xeqy@mailinator.com', '$2y$10$5NCah6OemHIzyBa9gH5Gq.AreIkrOhG0NYr.pCGt5XTxHvsxBta8K', '303b25def05b0743d01453a7b164d227.jpeg', 4),
(19, 'pyxess', 'tomol@mailinator.com', '$2y$10$.uHmD8zv9SmponHFi3YtD.xunXqZPNNLx7ndDfIT92mFU7iCwxcsy', 'cff6174cf007b6fd42486a152ad35cda.jpeg', 2),
(20, 'Admin1', 'admin@gmail.com', '$2y$10$Z8Vc8lVEMt8kBtrmR4YEYunh.ru4Mt6wmkqE/4ChRANFZT77nLtue', '7b5b021b4c66178ad9a51ed1fb205fa9.jpeg', 2),
(21, 'qipudabor', 'dadybyce@mailinator.com', '$2y$10$Cual5xJdwb/0JkP.mrfO8OMj6SphNTobNA.JOJ2hLSk6YpaMHGBXi', '58f8c80cf19e5abdb1f5b19627fd25b3.jpeg', 4),
(22, 'instructor2', 'instructor@gmail.com', '$2y$10$8R9MYWVstrA0ftfnSGKhoun8C/06ENESU.vQcGYv8AI7KCxGwhKH.', '3700b0615bd561af51408de7afeffa8c.jpeg', 3),
(23, 'xivuqopufa', 'fywukyvu@mailinator.com', '$2y$10$TAiArw6uJaohiuVsdc1i8ezX0P5ELGMkzcXrSMTkgCW4mWmLl6EZO', 'fc1871a32720f9570d4079c29592a476.jpeg', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `group_id` tinyint(11) UNSIGNED NOT NULL,
  `group_name` varchar(100) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`group_id`, `group_name`) VALUES
(1, 'superAdmin'),
(2, 'Admin'),
(3, 'Instructor'),
(4, 'Student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `coursesUsersId` (`course_instructor`),
  ADD KEY `coursesCoursesCategoriesId` (`course_category`);

--
-- Indexes for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  ADD PRIMARY KEY (`lesson_id`),
  ADD KEY `coursesLessonsCoursesId` (`lesson_course`),
  ADD KEY `coursesLessonsUsersId` (`lesson_instructor`);

--
-- Indexes for table `courses_lessons_comments`
--
ALTER TABLE `courses_lessons_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `lessonsCommentsLessonsId` (`comment_lesson`),
  ADD KEY `lessonsCommentsUsersId` (`comment_user`);

--
-- Indexes for table `courses_students`
--
ALTER TABLE `courses_students`
  ADD KEY `courseStudentsCourseId` (`course_id`),
  ADD KEY `coursesStudentsUsersId` (`student_id`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `coursesCategoriesUsersId` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `usersUserGroupsId` (`user_group`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `course_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  MODIFY `lesson_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `courses_lessons_comments`
--
ALTER TABLE `courses_lessons_comments`
  MODIFY `comment_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `course_categories`
--
ALTER TABLE `course_categories`
  MODIFY `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `group_id` tinyint(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `coursesCoursesCategoriesId` FOREIGN KEY (`course_category`) REFERENCES `course_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coursesUsersId` FOREIGN KEY (`course_instructor`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_lessons`
--
ALTER TABLE `courses_lessons`
  ADD CONSTRAINT `coursesLessonsCoursesId` FOREIGN KEY (`lesson_course`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coursesLessonsUsersId` FOREIGN KEY (`lesson_instructor`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_lessons_comments`
--
ALTER TABLE `courses_lessons_comments`
  ADD CONSTRAINT `lessonsCommentsLessonsId` FOREIGN KEY (`comment_lesson`) REFERENCES `courses_lessons` (`lesson_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lessonsCommentsUsersId` FOREIGN KEY (`comment_user`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses_students`
--
ALTER TABLE `courses_students`
  ADD CONSTRAINT `courseStudentsCourseId` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coursesStudentsUsersId` FOREIGN KEY (`student_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD CONSTRAINT `coursesCategoriesUsersId` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `usersUserGroupsId` FOREIGN KEY (`user_group`) REFERENCES `users_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
