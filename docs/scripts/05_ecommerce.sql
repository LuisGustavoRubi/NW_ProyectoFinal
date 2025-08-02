CREATE TABLE
    `sales` (
        `saleId` int(11) NOT NULL AUTO_INCREMENT,
        `userId` bigint(10) NOT NULL,
        `productId` int(11) NOT NULL,
        `salePrice` decimal(10, 2) NOT NULL,
        `saleStart` datetime NOT NULL,
        `saleEnd` datetime NOT NULL,
        PRIMARY KEY (`saleId`),
        KEY `fk_sales_products_idx` (`productId`),
        CONSTRAINT `fk_sales_products` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4;

CREATE TABLE
    `highlights` (
        `highlightId` int(11) NOT NULL AUTO_INCREMENT,
        `productId` int(11) NOT NULL,
        `highlightStart` datetime NOT NULL,
        `highlightEnd` datetime NOT NULL,
        PRIMARY KEY (`highlightId`),
        KEY `fk_highlights_products_idx` (`productId`),
        CONSTRAINT `fk_highlights_products` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE
    ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4;

-- Inserts de productos imaginarios
INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    4,
    'Celestial Coffee Beans',
    'Premium cosmic roast with notes of vanilla and caramel',
    150.00,
    'https://placehold.co/290x250?text=Celestial-Coffee-Beans&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    5,
    'Quantum Sketchpad',
    'Ultra-responsive digital drawing tablet with stylus',
    299.99,
    'https://placehold.co/290x250?text=Quantum-Sketchpad&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    6,
    'Orion Smart Thermostat',
    'AI-driven home climate control with smartphone app',
    129.50,
    'https://placehold.co/290x250?text=Orion-Smart-Thermostat&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    7,
    'EchoFlow Water Bottle',
    'Insulated stainless steel bottle with self-clean UV cap',
    19.95,
    'https://placehold.co/290x250?text=EchoFlow-Water-Bottle&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    8,
    'Lumen LED Desk Lamp',
    'Adjustable color-temperature lamp with wireless charging',
    49.99,
    'https://placehold.co/290x250?text=Lumen-LED-Desk-Lamp&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    9,
    'AeroTech Drone',
    'Foldable 4K drone with 30-minute flight time',
    899.00,
    'https://placehold.co/290x250?text=AeroTech-Drone&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    10,
    'TerraSound Earbuds',
    'Noise-cancelling true wireless earbuds with mic',
    129.99,
    'https://placehold.co/290x250?text=TerraSound-Earbuds&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    11,
    'Nimbus Portable Projector',
    'Compact HD projector with built-in speaker',
    249.90,
    'https://placehold.co/290x250?text=Nimbus-Portable-Projector&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    12,
    'Pulse Fitness Tracker',
    'Waterproof wristband with heart-rate and sleep monitoring',
    179.00,
    'https://placehold.co/290x250?text=Pulse-Fitness-Tracker&font=roboto',
    'ACT'
);

INSERT INTO `products` (
    `productId`,
    `productName`,
    `productDescription`,
    `productPrice`,
    `productImgUrl`,
    `productStatus`
)
VALUES (
    13,
    'Solace Sleep Mask',
    'Bluetooth eye mask with built-in speakers and soothing lights',
    29.90,
    'https://placehold.co/290x250?text=Solace-Sleep-Mask&font=roboto',
    'ACT'
);
