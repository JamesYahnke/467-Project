-- David Soh Z1922762
-- 2003May20
DROP TABLE IF EXISTS `HAS`, `parts_main`, `ORDERS`, `WEIGHT`;

CREATE TABLE `parts_main` (
  `number` INT(11) NOT NULL,
  `description` VARCHAR(50) DEFAULT NULL,
  `price` FLOAT(8,2) DEFAULT NULL,
  `weight` FLOAT(4,2) NOT NULL DEFAULT 2.00,
  `pictureURL` VARCHAR(50) NOT NULL DEFAULT 'http://blitz.cs.niu.edu/pics/any.jpg',
  `qty` INT(6),
  `quantity` smallint(6)
 );
-- Indexes for table `parts`
--
ALTER TABLE `parts_main`
  ADD PRIMARY KEY (`number`);

--
-- AUTO_INCREMENT for table `parts`
--
ALTER TABLE `parts_main`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;
COMMIT;

CREATE TABLE `ORDERS`(
    `ORDER_NUM`    INT    AUTO_INCREMENT,
    `ORDER_DATE`   DATE,
    `CUS_NAME`     VARCHAR(64)  NOT NULL,
    `CUS_EMAIL`    VARCHAR(254) NOT NULL,    
    `CUS_ADDRESS`  VARCHAR(96)  NOT NULL,
    `TOTAL`        VARCHAR(96)  NOT NULL,
    `ORDER_WEIGHT` VARCHAR(96),    
    `STATUS`       VARCHAR(32)  NOT NULL,
    `TRACKING`     VARCHAR(32),

    PRIMARY KEY (`ORDER_NUM`)
);

CREATE TABLE `WEIGHT`(
    `MIN`         REAL   NOT NULL,
    `MAX`         REAL   NOT NULL,
    `COST`        REAL   NOT NULL,

    PRIMARY KEY (`MIN`,`MAX`)
);

CREATE TABLE `HAS`(
    `ORDER_NUM`  INT,
    `NUM`        INT(11) NOT NULL,
    `DESC`       VARCHAR(50) DEFAULT NULL,
    `WEIGHT`     FLOAT(100,2 )NOT NULL DEFAULT 2.00,
    `QTY`        INT(6),

    PRIMARY KEY (`ORDER_NUM`, `NUM`),
    FOREIGN KEY (`ORDER_NUM`) REFERENCES `ORDERS`(`ORDER_NUM`),
    FOREIGN KEY (`NUM`) REFERENCES `parts_main`(`number`)
);
