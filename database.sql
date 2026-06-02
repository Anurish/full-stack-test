CREATE DATABASE IF NOT EXISTS wpoets_full_stack_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE wpoets_full_stack_test;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS slides;
DROP TABLE IF EXISTS tabs;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE tabs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    icon VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `slides` (
  `id` int(11) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `badge_text` varchar(150) NOT NULL,
  `title` varchar(255) NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `button_link` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO tabs (id, title, icon, sort_order, status) VALUES
(1, 'Learning', 'assets/images/DL-learning.svg', 1, 1, '2026-05-31 20:25:54'),
(2, 'Technology', 'assets/images/DL-technology.svg', 2, 1, '2026-05-31 20:25:54'),
(3, 'Communication', 'assets/images/DL-communication.svg', 3, 1, '2026-05-31 20:25:54');

INSERT INTO `slides` (`id`, `tab_id`, `badge_text`, `title`, `button_text`, `button_link`, `image`, `sort_order`, `status`, `created_at`) VALUES
(1, 1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Usability enhancement and Training for Transaction Portal for Customers', 'Learn More', '#', 'assets/images/DL-Learning-1.jpg', 1, 1, '2026-05-31 20:25:54'),
(2, 1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Interactive LMS rollout for onboarding and field enablement', 'Learn More', '#', 'assets/images/DL-Learning-1.jpg', 2, 1, '2026-05-31 20:25:54'),
(3, 1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Training portal modernization with better engagement flows', 'Learn More', '#', 'assets/images/DL-Learning-1.jpg', 3, 1, '2026-05-31 20:25:54'),
(4, 2, 'CONNECTED TECHNOLOGY PLATFORM', 'Cloud-first architecture for resilient operations and growth', 'Discover', '#', 'assets/images/DL-Technology.jpg', 1, 1, '2026-05-31 20:25:54'),
(5, 2, 'CONNECTED TECHNOLOGY PLATFORM', 'Automation systems that reduce friction and speed up delivery', 'Discover', '#', 'assets/images/DL-Technology.jpg', 2, 1, '2026-05-31 20:25:54'),
(6, 2, 'CONNECTED TECHNOLOGY PLATFORM', 'Modern dashboards that keep every team aligned in real time', 'Discover', '#', 'assets/images/DL-Technology.jpg', 3, 1, '2026-05-31 20:25:54'),
(7, 3, 'SMART COMMUNICATION HUB', 'Unified communication that keeps customers informed at every step', 'Explore', '#', 'assets/images/DL-Communication.jpg', 1, 1, '2026-05-31 20:25:54'),
(8, 3, 'SMART COMMUNICATION HUB', 'Campaign messaging and alerts with a clear content hierarchy', 'Explore', '#', 'assets/images/DL-Communication.jpg', 2, 1, '2026-05-31 20:25:54'),
(9, 3, 'SMART COMMUNICATION HUB', 'Omnichannel communication experiences with measurable impact', 'Explore', '#', 'assets/images/DL-Communication.jpg', 3, 1, '2026-05-31 20:25:54');
