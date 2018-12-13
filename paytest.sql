DROP TABLE person;
CREATE TABLE person
(
	id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	document VARCHAR(12) NOT NULL, documentType VARCHAR(3) NOT NULL,
	firstName VARCHAR(60) NOT NULL, lastName VARCHAR(60) NOT NULL,
	company VARCHAR(60) NULL, emailAddress VARCHAR(80) NULL,
	address VARCHAR(100) NULL, city VARCHAR(50) NULL, 
	province VARCHAR(50) NULL, country VARCHAR(2) NULL,
	phone VARCHAR(30) NULL, mobile VARCHAR(30) NULL,
	created_at DATETIME, updated_at DATETIME
);

DROP TABLE payment;
CREATE TABLE payment
(
	id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transaction_id INT(3) NULL,
	bankCode VARCHAR(4) NOT NULL, bankInterface VARCHAR(1) NOT NULL,
	reference VARCHAR(32) NOT NULL, description VARCHAR(255) NOT NULL,
	totalAmount DOUBLE NOT NULL,
	payer_id INT(3) NOT NULL, buyer_id INT(3),
	ipAddress VARCHAR(15) NOT NULL, userAgent VARCHAR(255) NOT NULL,
	created_at DATETIME, updated_at DATETIME,
	FOREIGN KEY (payer_id) REFERENCES person(id),
	FOREIGN KEY (buyer_id) REFERENCES person(id)
);

DROP TABLE transaction;
CREATE TABLE transaction
(
	id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	state VARCHAR(10) NOT NULL DEFAULT 'CREATED', -- PROCESSED
	transactionID INT(11) NOT NULL,
	sessionID VARCHAR(32) NOT NULL, returnCode VARCHAR(30) NOT NULL,
	trazabilityCode VARCHAR(40) NOT NULL, transactionCycle INT(3) NOT NULL,
	bankCurrency VARCHAR(3) NOT NULL, bankFactor INT(3) NOT NULL,
	bankURL VARCHAR(255) NULL, responseCode INT(3) NOT NULL,
	responseReasonCode VARCHAR(3) NULL, responseReasonText VARCHAR(255) NULL,
	created_at DATETIME, updated_at DATETIME
);

DROP TABLE transaction_result;
CREATE TABLE transaction_result
(
	id INT(3) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	transaction_id INT(11) NOT NULL,
	transactionID INT(11) NOT NULL,
	sessionID VARCHAR(32) NOT NULL, reference VARCHAR(32) NOT NULL,
	requestDate VARCHAR(30) NOT NULL, bankProcessDate VARCHAR(30) NOT NULL,
	onTest CHAR(1) NOT NULL, returnCode VARCHAR(30) NOT NULL,
	trazabilityCode VARCHAR(40) NOT NULL, transactionCycle INT(3) NOT NULL,
	transactionState VARCHAR(20) NULL, responseCode INT(3) NOT NULL,
	responseReasonCode VARCHAR(3) NULL, responseReasonText VARCHAR(255) NULL, 
	created_at DATETIME, updated_at DATETIME,
	FOREIGN KEY (transaction_id) REFERENCES transaction(id)
);