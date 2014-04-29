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

drop procedure if exists SearchAirports;
delimiter //
create procedure SearchAirports(a int(5), b int(5))
begin
	select Month, DayOfMonth, DayOfWeek, Carriers.Name as CarrierName, FlNum as FlightNumber, OriginAirportId, OriginAirport.Name as OriginAirportName, OriginAirport.City as OriginAirportCity, OriginMarket.City as OriginMarketCity, OriginAirport.Location as OriginAirportLocation, DestAirportId, DestAirport.Name as DestAirportName, DestAirport.City as DestAirportCity, DestMarket.City as DestMarketCity, DestAirport.Location as DestAirportLocation, TaxiOut as DepartureTime, TaxiIn as ArrivalTime
	from Flights
	join Airports as OriginAirport on OriginAirport.Code = OriginAirportId
	join Airports as DestAirport on DestAirport.Code = DestAirportId
	join Markets as OriginMarket on OriginMarket.Code = OriginCityMarketId
	join Markets as DestMarket on DestMarket.Code = DestCityMarketId
	join Carriers on Carriers.Code = UniqueCarrier
	where OriginAirportId = a and DestAirportId = b;
end//
call SearchAirports(14831, 13891)//

CREATE PROCEDURE FlightsOnDay(day int(1))
BEGIN
  SELECT * FROM Flights WHERE DayOfWeek = day;
END//
drop procedure if exists SearchAirportsWithoutJoin//
create procedure SearchAirportsWithoutJoin(a int(5), b int(5))
begin
	select Month, DayOfMonth, DayOfWeek, Carriers.Name as CarrierName, FlNum as FlightNumber, OriginAirportId, DestAirportId, TaxiOut as DepartureTime, TaxiIn as ArrivalTime
	from Flights
	join Carriers on Carriers.Code = UniqueCarrier
	where OriginAirportId = a and DestAirportId = b;
	select Name, City, Location from Airports
	where Code = a;
	select Name, City, Location from Airports
	where Code = b;
end//

CREATE PROCEDURE CarrierAggregation()
BEGIN
  SELECT UniqueCarrier, AVG(DepDelay) AS AverageDepartureDelay, 
  AVG(ArrDelay) AS AverageArrivalDelay, AVG(AirTime) AS AverageTimeInAir
  FROM Flights GROUP BY UniqueCarrier;
END//
