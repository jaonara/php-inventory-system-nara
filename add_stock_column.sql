-- Add stock column to products table
ALTER TABLE `products` ADD `stock` INT(11) NOT NULL DEFAULT 0 AFTER `price`;

-- Update existing products with default stock (optional - you can set your own values)
UPDATE `products` SET `stock` = 100 WHERE `stock` = 0;

