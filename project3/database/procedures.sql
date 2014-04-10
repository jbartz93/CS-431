DROP PROCEDURE IF EXISTS searchCourses;
DROP PROCEDURE IF EXISTS dropClass;
DROP PROCEDURE IF EXISTS getUsername;
DROP PROCEDURE IF EXISTS loginUser;
DROP PROCEDURE IF EXISTS getUserPermissions;
DROP PROCEDURE IF EXISTS getUserCourses;
DROP PROCEDURE IF EXISTS registerUser;
DROP PROCEDURE IF EXISTS searchUsers;
DROP PROCEDURE IF EXISTS createUser;
DROP PROCEDURE IF EXISTS getUserGrades;
DROP PROCEDURE IF EXISTS createCourse;
DROP PROCEDURE IF EXISTS getDepartmentCourses;
DROP PROCEDURE IF EXISTS getDepartmentFaculty;
DROP PROCEDURE IF EXISTS getCurrentSemester;
DROP PROCEDURE IF EXISTS createCourseSection;
DROP PROCEDURE IF EXISTS createSectionMeeting;
DROP PROCEDURE IF EXISTS getPastSemesterCourseSections;
DROP PROCEDURE IF EXISTS getCurrentCourseSections;

delimiter //

# Get Departments
SELECT Id, FullName, Abbreviation FROM Departments;

# Create a course
CREATE PROCEDURE createCourse(newTitle varchar(50), newDeptId int(8), newCourseNum int(5), newDescription text, newCreditValue int(3))
BEGIN
  INSERT INTO Courses(Title, DeptId, CourseNumber, Description, CreditValue)
VALUES (newTitle, newDeptId, newCourseNum, newDescription, newCreditValue);
END//

# Get courses in a specific department
CREATE PROCEDURE getDepartmentCourses(newDeptId int(8))
BEGIN
  SELECT DISTINCT Courses.Id AS Id, Abbreviation, CourseNumber, DeptId
  FROM Courses, Departments
  WHERE Courses.DeptId=newDeptId
  GROUP BY Courses.Id;
END//

# Get the users who are faculty in a certain department
CREATE PROCEDURE getDepartmentFaculty(departmentId int(8))
BEGIN
  SELECT Id, Name
  FROM Users
  WHERE Role='faculty' AND DeptId=departmentId;
END//

# Get the current semester
CREATE PROCEDURE getCurrentSemester()
BEGIN
  SELECT Id, Year, Season, StartDate, EndDate
  FROM Semesters
  WHERE Current=true
  LIMIT 1;
END//

# Create a new course section
CREATE PROCEDURE createCourseSection(newCourseId int(8), newProfessorId int(8), seatNumber int(8), newSectionNumber char(3), newSemesterId int(8))
BEGIN
  INSERT INTO CourseInstances(CourseId, ProfessorId, NumberSeats, SectionNumber, SemesterId)
VALUES(newCourseId, newProfessorId, seatNumber, newSectionNumber, newSemesterId);
END//

# Create a new meeting for a section
CREATE PROCEDURE createSectionMeeting(newCourseInstanceId int(8), newDayOfWeek ENUM('M', 'T', 'W', 'R', 'F'), newBeginTime TIME, newEndTime TIME, newLocation varchar(20))
BEGIN
  INSERT INTO Meetings(CourseInstanceId, DayOfWeek, BeginTime, EndTime, Location) VALUES(newCourseInstanceId, newDayOfWeek, newBeginTime, newEndTime, newLocation);
END//

# get the sections of a course in a past semester
CREATE PROCEDURE getPastSemesterCourseSections(newCourseId int(8), newSemesterId int(8))
BEGIN
  SELECT CourseInstances.Id AS Id, Title, Abbreviation, CourseNumber, Description, NumberSeats, Name, SectionNumber, GROUP_CONCAT(DISTINCT CONCAT(DayOfWeek, ': ', TIME_FORMAT(BeginTime, '%l:%i %p'), ' - ', TIME_FORMAT(EndTime, '%l:%i %p')) SEPARATOR ' ') AS DayOfWeek FROM Courses
  JOIN Departments ON Departments.Id = DeptId
  JOIN CourseInstances ON Courses.Id = CourseInstances.CourseId
  JOIN Semesters ON Semesters.Id = SemesterId
  JOIN Users On ProfessorId = Users.Id
  JOIN Meetings ON Meetings.CourseInstanceId = CourseInstances.Id
  WHERE Courses.Id = newCourseId AND Semesters.Id = newSemesterId
  GROUP BY CourseInstances.Id
  ORDER BY SectionNumber;
END//

# Get the sections of a course in the current semester
CREATE PROCEDURE getCurrentCourseSections(newCourseId int(8))
BEGIN
  SELECT CourseInstances.Id AS Id, Title, Abbreviation, CourseNumber, Description, NumberSeats, Name, SectionNumber, GROUP_CONCAT(DISTINCT CONCAT(DayOfWeek, ': ', TIME_FORMAT(BeginTime, '%l:%i %p'), ' - ', TIME_FORMAT(EndTime, '%l:%i %p')) SEPARATOR ' ') AS DayOfWeek FROM Courses
  JOIN Departments ON Departments.Id = DeptId
  JOIN CourseInstances ON Courses.Id = CourseInstances.CourseId
  JOIN Semesters ON Semesters.Id = SemesterId
  JOIN Users On ProfessorId = Users.Id
  JOIN Meetings ON Meetings.CourseInstanceId = CourseInstances.Id
  WHERE Courses.Id = newCourseId AND Current = true
  GROUP BY CourseInstances.Id
  ORDER BY SectionNumber;
END//

# Get every semester
SELECT Id, Season, Year, Current FROM Semesters;

# Search all courses in a specified department with a certain keyword
CREATE PROCEDURE searchCourses(query varchar(50), departmentId int(8))
BEGIN
  SELECT Courses.Id, Title, Abbreviation, CourseNumber, Description
  FROM Courses
  JOIN Departments ON Departments.Id = DeptId
  WHERE DeptId = departmentId AND (Title LIKE query OR CourseNumber LIKE query)
  ORDER BY CourseNumber;
END//

# Drops a student from a class
CREATE PROCEDURE dropClass(studentId int(8), newCourseInstanceId int(8))
BEGIN
  START TRANSACTION;
  DELETE FROM Registration
  WHERE UserId=studentId AND CourseInstanceId=newCourseInstanceId;
  UPDATE CourseInstances SET NumberSeats = NumberSeats + 1 WHERE Id = newCourseInstanceId;
  COMMIT;
END//

# Get the name of a specified user
CREATE PROCEDURE getUserName(userId int(8))
BEGIN
  SELECT Name FROM Users WHERE Id=userId LIMIT 1;
END//

# Get the id and name of a user with a specified email and password
CREATE PROCEDURE loginUser(userEmail varchar(50), userPassword char(40))
BEGIN
  SELECT Id, Name FROM Users WHERE Email=userEmail AND Password=SHA1(userPassword) LIMIT 1;
END//

# Find out what permissions a specified user has
CREATE PROCEDURE getUserPermissions(newUserId int(8))
BEGIN
  SELECT * FROM Permissions WHERE UserId=newUserId LIMIT 1;
END//

# Get the courses that a certain user is registered in
CREATE PROCEDURE getUserCourses(newUserId int(8))
BEGIN
  SELECT CourseInstances.Id AS Id, Abbreviation, CourseNumber, SectionNumber, Title, CreditValue FROM Courses
  JOIN Registration ON Registration.CourseInstanceId = CourseInstances.Id
  JOIN CourseInstances ON CourseInstances.CourseId = Courses.Id
  JOIN Departments ON Departments.Id = Courses.DeptId
  WHERE UserId = newUserId
  ORDER BY (SELECT Year FROM Semesters WHERE Id=SemesterId), Abbreviation, CourseNumber;
END//

# Register a user in a class
CREATE PROCEDURE registerUser(newUserId int(8), courseInstanceId int(8))
BEGIN
  START TRANSACTION;
  INSERT INTO Registration (UserId, CourseInstanceId) VALUES (newUserId, CourseInstanceId);
  UPDATE CourseInstances SET NumberSeats = NumberSeats - 1 WHERE Id = CourseInstanceId;
  COMMIT;
END//

# Find a user
CREATE PROCEDURE searchUsers(query varchar(50))
BEGIN
  SELECT Name, Email, FullName AS Department
  FROM Users
  JOIN Departments ON Departments.Id = DeptId
  WHERE Name LIKE query OR Email LIKE query OR FullName LIKE query;
END//

# Create a new user
CREATE PROCEDURE createUser(userName varchar(50), userPassword char(40), userEmail varchar(50), userDeptId int(8), userRole ENUM('student', 'faculty', 'staff', 'executive'), userCanGiveGrade bool, userCanViewAllGrades bool, userCanChangeAllGrades bool, userCanAddCourses bool)
BEGIN
  START TRANSACTION;
    INSERT INTO users (Name, Password, Email, DeptId, Role)
    VALUES (userName, SHA1(userPassword), userEmail, userDeptId, userRole);

    SELECT @userId := LAST_INSERT_ID;

    INSERT INTO Permissions (UserId, GiveGrade, ViewAllGrades, ChangeAllGrades, AddCourses)
    VALUES (@userId, userCanGiveGrade, userCanViewAllGrades, userCanChangeAllGrades, userCanAddCourses);
  COMMIT;
END//

# Get a specified user's grades
CREATE PROCEDURE getUserGrades(newUserId int(8))
BEGIN
  SELECT Abbreviation, CourseNumber, Title, GradeGPA, CreditValue
  FROM Courses
  JOIN Departments ON Departments.Id = Courses.DeptId
  JOIN CourseInstances ON CourseInstances.CourseId = Courses.Id
  JOIN Registration ON Registration.CourseInstanceId = CourseInstances.Id
WHERE UserId = newUserId AND GradeGPA IS NOT NULL ORDER BY (SELECT Year FROM Semesters WHERE Id=SemesterId), Abbreviation, CourseNumber;
END//

delimiter ;