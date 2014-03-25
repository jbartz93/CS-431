# Get Departments
SELECT Id, FullName, Abbreviation FROM Departments;

# Create a course
CREATE PROCEDURE createCourse(newTitle varchar(50), newDeptId int(8), newCourseNum int(5), newDescription text, newCreditValue int(3))
BEGIN
  INSERT INTO Courses(Title, DeptId, CourseNumber, Description, CreditValue) VALUES (newTitle, newDeptId, newDescription, newCreditValue);
END//

# Get courses in a specifie department
SELECT Abbreviation, CourseNumber, DeptId FROM Courses, Departments WHERE Courses.DeptId=Departments.Id AND Courses.Id=? LIMIT 1;

# Get the users who are faculty in a certain department
SELECT Id, Name FROM Users, Roles WHERE Users.Id=Roles.UserId AND Role='faculty' AND DeptId=? LIMIT 1

# Get the current semester id
SELECT Id FROM Semesters WHERE Current=true LIMIT 1;

# Create a new course section
INSERT INTO CourseInstances(CourseId, ProfessorId, NumberSeats, SectionNumber, SemesterId) VALUES(?, ?, ?, ?, ?);

# Create a new meeting for a section
INSERT INTO Meetings(CourseInstanceId, DayOfWeek, BeginTime, EndTime, Location) VALUES(?, ?, ?, ?, ?);

# get the sections of a course in a past semester
SELECT CourseInstances.Id AS Id, Title, Abbreviation, CourseNumber, Description, NumberSeats, Name, SectionNumber, GROUP_CONCAT(DISTINCT CONCAT(DayOfWeek, ': ', TIME_FORMAT(BeginTime, '%l:%i %p'), ' - ', TIME_FORMAT(EndTime, '%l:%i %p')) SEPARATOR '</br>') AS DayOfWeek FROM Courses
JOIN Departments ON Departments.Id = DeptId
JOIN CourseInstances ON Courses.Id = CourseInstances.CourseId
JOIN Semesters ON Semesters.Id = SemesterId
JOIN Users On ProfessorId = Users.Id
JOIN Meetings ON Meetings.CourseInstanceId = CourseInstances.Id
WHERE Courses.Id = ? AND Semesters.Id = ? GROUP BY CourseInstances.Id ORDER BY SectionNumber;

# Get the sections of a course in the current semester
SELECT CourseInstances.Id AS Id, Title, Abbreviation, CourseNumber, Description, NumberSeats, Name, SectionNumber, GROUP_CONCAT(DISTINCT CONCAT(DayOfWeek, ': ', TIME_FORMAT(BeginTime, '%l:%i %p'), ' - ', TIME_FORMAT(EndTime, '%l:%i %p')) SEPARATOR '</br>') AS DayOfWeek FROM Courses
JOIN Departments ON Departments.Id = DeptId
JOIN CourseInstances ON Courses.Id = CourseInstances.CourseId
JOIN Semesters ON Semesters.Id = SemesterId
JOIN Users On ProfessorId = Users.Id
JOIN Meetings ON Meetings.CourseInstanceId = CourseInstances.Id
WHERE Courses.Id = ? AND Current = true GROUP BY CourseInstances.Id ORDER BY SectionNumber

# Get every semester
SELECT Id, Season, Year, Current FROM Semesters;

# Search all courses in a specified department with a certain keyword
SELECT Courses.Id, Title, Abbreviation, CourseNumber, Description FROM Courses JOIN Departments ON Departments.Id = DeptId WHERE DeptId = ? AND (Title LIKE ? OR CourseNumber LIKE ?) ORDER BY CourseNumber;

# Drops a student from a class
DELETE FROM Registration WHERE UserId=? AND CourseInstanceId=?

# Get the name of a specified user
SELECT Name FROM Users WHERE Id=? LIMIT 1;

# Get the id and name of a user with a specified email and password
SELECT Id, Name FROM Users WHERE Email=? AND Password=SHA1(?) LIMIT 1;

# Find out what permissions a specified user has
SELECT * FROM Permissions WHERE UserId=? LIMIT 1;

# Get the courses that a certain user is registered in
SELECT CourseInstances.Id AS Id, Abbreviation, CourseNumber, SectionNumber, Title, CreditValue FROM Courses
JOIN Registration ON Registration.CourseInstanceId = CourseInstances.Id
JOIN CourseInstances ON CourseInstances.CourseId = Courses.Id
JOIN Departments ON Departments.Id = Courses.DeptId
WHERE UserId = ? ORDER BY (SELECT Year FROM Semesters WHERE Id=SemesterId), Abbreviation, CourseNumber;

# Register a user in a class
INSERT INTO Registration (UserId, CourseInstanceId) VALUES (?, ?);

# Find a user
SELECT Name, Email, FullName AS Department FROM Users JOIN Departments ON Departments.Id = DeptId WHERE Name LIKE ? OR Email LIKE ? OR FullName LIKE ?;

# Create a new user
INSERT INTO users (Name, Password, Email, DeptId) VALUES (?, sha1(?), ?, ?);

# Give a user permissions
INSERT INTO Permissions (UserId, GiveGrade, ViewAllGrades, ChangeAllGrades, AddCourses) VALUES (?, ?, ?, ?, ?);

# Get a specified user's grades
SELECT Abbreviation, CourseNumber, Title, GradeGPA, CreditValue FROM Courses
JOIN Departments ON Departments.Id = Courses.DeptId
JOIN CourseInstances ON CourseInstances.CourseId = Courses.Id
JOIN Registration ON Registration.CourseInstanceId = CourseInstances.Id
WHERE UserId = ? ORDER BY (SELECT Year FROM Semesters WHERE Id=SemesterId), Abbreviation, CourseNumber;

#
