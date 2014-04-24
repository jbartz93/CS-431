--search for flights from point a to point b
--search for flights on a particular day
--get total canceled flights by airline
--get total time in air
--check the status of a flight
--figure out the relationship between cities and markets
--get info on a specific flight
--average number of flights cancelled/delayed
--the average delay duration per airline
--cancelled/delayed flights based on cities/markets
--we only need 2 or 3 actually written
delimiter //
create procedure SearchAirports(a int(5), b int(5))
begin
	select Month, DayOfMonth, DayOfWeek, Carriers.Name as CarrierName, FlNum as FlightNumber, OriginAirportId, OriginAirport.Name as OriginAirportName, OriginAirport.City as OriginAirportCity, OriginMarket.City as OriginMarketCity, OriginLocation.Location as OriginAirportLocation, DestAirportId, DestAirport.Name as DestAirportName, DestAirport.City as DestAirportCity, DestMarket.City as DestAirportCity, DestLocation.Location as DestAirportLocation, TaxiOut as DepartureTime, TaxiIn as ArrivalTime
	from Flights
	join Airports as OriginAirport on OriginAirport.Code = OriginAirportId
	join Airports as DestAirport on DestAirport.Code = DestAirportId
	join Markets as OriginMarket on OriginMarket.Code = OriginMarketId
	join Markets as DestMarket on DestMarket.Code = DestMarketId
	join Locations as OriginLocation on OriginLocation.Abbreviation = OriginAirport.Location
	join Locations as DestLocation on DestLocation.Abbreviation = DestAirport.Location
	where OriginAirportId = a and DestAirportId = b;
end//

CREATE PROCEDURE FlightsOnDay(day int(1))
BEGIN
  SELECT * FROM Flights WHERE DayOfWeek = day;
END//

create procedure SearchAirportsWithoutJoin(a int(5), b int(5))
begin
	select Month, DayOfMonth, DayOfWeek, Carriers.Name as CarrierName, FlNum as FlightNumber, @origin := OriginAirportId, @dest := DestAirportId, TaxiOut as DepartureTime, TaxiIn as ArrivalTime
	from Flights
	where OriginAirportId = a and DestAirportId = b;
	select Name, City, Locations.Location from Airports
	join Locations on Abbreviation = Airports.Location
	where Code = @origin;
	select Name, City, Locations.Location from Airports
	join Locations on Abbreviation = Airports.Location
	where Code = @dest;
end//
