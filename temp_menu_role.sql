INSERT INTO menu_role (menu_id, role_id) VALUES
(5, 1), (5, 2),
(6, 1), (6, 2),
(11, 1), (11, 2),
(12, 1), (12, 2)
ON DUPLICATE KEY UPDATE menu_id=menu_id;
