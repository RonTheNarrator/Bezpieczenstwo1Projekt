-- Create the client table
CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    email TEXT
);

-- Create the product table
CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL,
    price REAL NOT NULL
);

-- Create the order table
CREATE TABLE IF NOT EXISTS orders (
    id INTEGER PRIMARY KEY,
    client_id INTEGER,
    product_id INTEGER,
    quantity INTEGER,
    order_date DATE,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert new clients
INSERT INTO clients (name, email) VALUES
    ('Crazy Alice', 'Alice@InWonderland.com'),
    ('Nebu Chadnezzar', 'NebuChadnezzar@OldKing.edu'),
    ('Jo Raimontilinekergrobelar', 'ShortName@badmail.com'),
    ('Web Killer', 'WebMurder@killer.ever.com'),
    ('Don Quixote', 'windmill@mail.spain'),
    ('Crazy priest', 'Exorcist@hotmail.com'),
    ('Jasson Killer', 'Friday13@JasonLives.com'),
    ('Everything All', 'AllweSaid@mail.com'),
    ('Thiseas Sparrow', 'Pirates@mail.gr');

-- Insert silly and mildly illegal products
INSERT INTO products (name, price) VALUES
    ('Invisible Ink Pen', 15.99),
    ('Mind-Controlled Pizza Delivery Drone', 99.99),
    ('Ultimate Water Gun - Shoots Chocolate Syrup', 29.95),
    ('Noise-Canceling Dog Bark Translator', 49.99),
    ('DIY Invisible Cloak Kit', 79.99),
    ('Holy Water Gun (for Crazy Priests)', 39.99),
    ('Haunted Hockey Mask (signed by Jasson)', 69.99),
    ('Everything Spray (literally does everything)', 199.99),
    ('Sparrow-Operated Pirate Ship Remote Control', 149.99);

-- Insert orders for the clients
INSERT INTO orders (client_id, product_id, quantity, order_date) VALUES
    (1, 3, 2, '2024-01-15'),
    (2, 4, 1, '2024-01-16'),
    (3, 1, 5, '2024-01-17'),
    (4, 2, 1, '2024-01-18'),
    (5, 5, 1, '2024-01-19'),
    (6, 6, 1, '2024-01-20'),
    (7, 7, 1, '2024-01-21'),
    (8, 8, 1,  '2024-01-22'),
    (9, 9, 1,  '2024-01-23');