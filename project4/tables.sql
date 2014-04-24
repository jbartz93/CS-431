CREATE TABLE Airports(
  Code int(5) PRIMARY KEY,
  City varchar(60),
  Location varchar(60),
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
  Abbreviation varchar(60) PRIMARY KEY,
  Location varchar(60)
) engine=InnoDB;

CREATE TABLE Markets(
  Code int(5) PRIMARY KEY,
  City varchar(60),
  Location varchar(60)
) engine=InnoDB;

CREATE TABLE Flights(
  Month int(2),
  DayOfMonth int(2),
  DayOfWeek int(1),
  UniqueCarrier varchar(4) REFERENCES Carriers(Code),
  FlNum int(4),
  OriginAirportId int(5),
  OriginCityMarketId int(5),
  DestAirportId int(5),
  DestCityMarketId int(5),
  DepDelay decimal(5,2),
  TaxiOut decimal(5,2),
  TaxiIn decimal(5,2),
  ArrDelay,
  Cancelled,
  CancellationCode,
  Diverted,
  AirTime,
  Flights,
  Distance,
  CarrierDelay,
  WeatherDelay,
  NasDelay,
  SecurityDelay,
  LateAircraftDelay,
) engine=InnoDB;