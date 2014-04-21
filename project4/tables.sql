CREATE TABLE Airports(
  Code int(5) PRIMARY KEY,
  City varchar(60),
  LocationAbbrev varchar(60),
  Name varchar(100)
) engine=InnoDB;

CREATE TABLE CancelationCodes(
  Code char(1) PRIMARY KEY,
  Description varchar(25)
) engine=InnoDB;

CREATE TABLE Carriers(
  Code varchar(4) PRIMARY KEY,
  Name varchar(100)
) engine=InnoDB;

CREATE TABLE Locations(
) engine=InnoDB;