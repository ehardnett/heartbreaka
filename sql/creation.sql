DROP DATABASE IF EXISTS aka;
CREATE DATABASE aka;
USE aka;

-- Admins
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
	adminId SMALLINT UNSIGNED AUTO_INCREMENT,
    email VARCHAR(155),
    firstName VARCHAR(40),
    lastName VARCHAR(40),
    CONSTRAINT pk_adminId PRIMARY KEY(adminId)
);

-- Bachelors
DROP TABLE IF EXISTS bachelors;
CREATE TABLE bachelors (
	bachelorId SMALLINT UNSIGNED AUTO_INCREMENT,
    firstName VARCHAR(40),
    lastName VARCHAR(40),
    age SMALLINT UNSIGNED,
    major VARCHAR(100),
    biography TEXT,
    photoUrl VARCHAR(100),
    maxBid DECIMAL(20,2) UNSIGNED,
    auctionStatus BOOLEAN,
    addedBy SMALLINT UNSIGNED,
    CONSTRAINT pk_bachelorId PRIMARY KEY(bachelorId),
    CONSTRAINT fk_bachelorAdminId FOREIGN KEY(addedBy)
		REFERENCES admins(adminId)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- Attendees
DROP TABLE IF EXISTS attendees;
CREATE TABLE attendees (
	attendeeId SMALLINT UNSIGNED AUTO_INCREMENT,
    email VARCHAR(155),
    firstName VARCHAR(40),
    lastName VARCHAR(40),
	accountBalance DECIMAL(20,2) UNSIGNED,
    totalDonations DECIMAL(20,2) UNSIGNED,
    auctionWon BOOLEAN,
    CONSTRAINT pk_attendeeId PRIMARY KEY(attendeeId)
);

-- Bids
DROP TABLE IF EXISTS bids;
CREATE TABLE bids (
	bidId SMALLINT UNSIGNED AUTO_INCREMENT,
    attendeeId SMALLINT UNSIGNED,
    bachelorId SMALLINT UNSIGNED,
    bidAmount DECIMAL(20,2) UNSIGNED,
    CONSTRAINT pk_bidId PRIMARY KEY(bidId),
    CONSTRAINT fk_bidAttendeeId FOREIGN KEY(attendeeId)
		REFERENCES attendees(attendeeId)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
	CONSTRAINT fk_bidBachelorId FOREIGN KEY(bachelorId)
		REFERENCES bachelors(bachelorId)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
);

-- Auctions
DROP TABLE IF EXISTS auctions;
CREATE TABLE auctions (
	auctionId SMALLINT UNSIGNED AUTO_INCREMENT,
    bachelorId SMALLINT UNSIGNED NOT NULL,
    winningAttendeeId SMALLINT UNSIGNED,
    winningBidId SMALLINT UNSIGNED,
    winningBid DECIMAL(20,2) UNSIGNED,
    timeStart INT UNSIGNED,
    timeComplete INT UNSIGNED,
    CONSTRAINT pk_auctionId PRIMARY KEY(auctionId),
    CONSTRAINT fk_auctionBachelorId FOREIGN KEY(bachelorId)
		REFERENCES bachelors(bachelorId)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT fk_auctionBidId FOREIGN KEY(winningBidId)
		REFERENCES bids(bidId)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);