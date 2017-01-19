-- Populate test database with dummy data

INSERT INTO `users` (`id`, `name`, `password`, `email`, `role`) VALUES (1, 'test', MD5('test'), 'test@gmail.com', 'user');
INSERT INTO `users` (`id`, `name`, `password`, `email`, `role`) VALUES (2, 'admin', MD5('admin'), 'admin@gmail.com', 'admin');
INSERT INTO `users` (`id`, `name`, `password`, `email`, `role`) VALUES (3, 'superAdmin', MD5('superAdmin'), 'superAdmin@gmail.com', 'superAdmin');