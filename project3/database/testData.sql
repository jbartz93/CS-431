INSERT INTO Departments(Abbreviation, FullName) VALUES('MATH', 'Mathematical Science');

# come back and add users that have each individual role
INSERT INTO Users(Name, Password, Email, DeptId) VALUES('John Doe', sha1('password'), 'jd@431.edu', 1);
INSERT INTO Roles(UserId, Role) VALUES(1, 'student'),(1, 'faculty'), (1, 'staff'), (1, 'executive');
INSERT INTO Permissions(UserId, GiveGrade, ViewAllGrades, ChangeAllGrades, AddCourses) VALUES(1, true, true, true, true);

INSERT INTO Courses(Title, DeptId, CourseNumber, Description) VALUES('CALCULUS I', 1, 111, 'The first of many calculus courses');

INSERT INTO CourseInstances(CourseId, ProfessorId, NumberSeats, SectionNumber, Semester) VALUES(1, 1, 10, '001', 'F2014');

# add meeting times for the course

INSERT INTO Registration(UserId, CourseInstanceId, GradeGPA) VALUES(1, 1, 4.0);