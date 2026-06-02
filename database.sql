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

CREATE TABLE slides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tab_id INT NOT NULL,
    badge_text VARCHAR(150) NOT NULL,
    title VARCHAR(255) NOT NULL,
    button_text VARCHAR(100) NOT NULL,
    button_link VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    status TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_slides_tabs FOREIGN KEY (tab_id) REFERENCES tabs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO tabs (id, title, icon, sort_order, status) VALUES
(1, 'Learning', 'assets/images/icon-learning.svg', 1, 1),
(2, 'Technology', 'assets/images/icon-technology.svg', 2, 1),
(3, 'Communication', 'assets/images/icon-communication.svg', 3, 1);

INSERT INTO slides (tab_id, badge_text, title, button_text, button_link, image, sort_order, status) VALUES
(1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Usability enhancement and Training for Transaction Portal for Customers', 'Learn More', '#', 'assets/images/learning-1.svg', 1, 1),
(1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Interactive LMS rollout for onboarding and field enablement', 'Learn More', '#', 'assets/images/learning-2.svg', 2, 1),
(1, 'DIGITAL LEARNING INFRASTRUCTURE', 'Training portal modernization with better engagement flows', 'Learn More', '#', 'assets/images/learning-3.svg', 3, 1),

(2, 'CONNECTED TECHNOLOGY PLATFORM', 'Cloud-first architecture for resilient operations and growth', 'Discover', '#', 'assets/images/technology-1.svg', 1, 1),
(2, 'CONNECTED TECHNOLOGY PLATFORM', 'Automation systems that reduce friction and speed up delivery', 'Discover', '#', 'assets/images/technology-2.svg', 2, 1),
(2, 'CONNECTED TECHNOLOGY PLATFORM', 'Modern dashboards that keep every team aligned in real time', 'Discover', '#', 'assets/images/technology-3.svg', 3, 1),

(3, 'SMART COMMUNICATION HUB', 'Unified communication that keeps customers informed at every step', 'Explore', '#', 'assets/images/communication-1.svg', 1, 1),
(3, 'SMART COMMUNICATION HUB', 'Campaign messaging and alerts with a clear content hierarchy', 'Explore', '#', 'assets/images/communication-2.svg', 2, 1),
(3, 'SMART COMMUNICATION HUB', 'Omnichannel communication experiences with measurable impact', 'Explore', '#', 'assets/images/communication-3.svg', 3, 1);
