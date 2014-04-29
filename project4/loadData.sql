load data local infile 'airports.csv' into table Airports columns terminated by ',' optionally enclosed by '"' ignore 1 lines;
load data local infile 'cancelation_codes.csv' into table CancelationCodes columns terminated by ',' optionally enclosed by '"' ignore 1 lines;
load data local infile 'carriers.csv' into table Carriers columns terminated by ',' optionally enclosed by '"' ignore 1 lines;
load data local infile 'city_markets.csv' into table Markets columns terminated by ',' optionally enclosed by '"' ignore 1 lines;
load data local infile 'feb2014.csv' into table Flights columns terminated by ',' optionally enclosed by '"' ignore 1 lines;
load data local infile 'jan2014.csv' into table Flights columns terminated by ',' optionally enclosed by '"' ignore 1 lines;
load data local infile 'locations.csv' into table Locations columns terminated by ',' optionally enclosed by '"' ignore 1 lines;