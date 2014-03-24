INSERT INTO Departments(Abbreviation, FullName) VALUES('MATH', 'Mathematical Science');
INSERT INTO Departments(Abbreviation, FullName) VALUES('CS', 'Computer Science');
INSERT INTO Departments(Abbreviation, FullName) VALUES('IT', 'Information Technology');
INSERT INTO Departments(Abbreviation, FullName) VALUES('HUM', 'Humanities');
INSERT INTO Departments(Abbreviation, FullName) VALUES('STS', 'Science and Technology');

# come back and add users that have each individual role
INSERT INTO Users(Name, Password, Email, DeptId) VALUES('John Doe', sha1('password'), 'jd@431.edu', 1);
INSERT INTO Users(Name, Password, Email, DeptId) VALUES('George Rookie', sha1('george'), 'george@431.edu', 11);
INSERT INTO Users(Name, Password, Email, DeptId) VALUES('Jeremy Bartz', sha1('jeremy'), 'jb@431.edu', 21);
INSERT INTO Users(Name, Password, Email, DeptId) VALUES('Jacob Moorman', sha1('jacob'), 'jm@431.edu', 31);
INSERT INTO Users(Name, Password, Email, DeptId) VALUES('Stephen Morrison', sha1('stephen'), 'sm@431.edu', 41);

INSERT INTO Roles(UserId, Role) VALUES(1, 'student'), (11, 'faculty'), (21, 'faculty'), (31, 'staff'), (41, 'executive');

INSERT INTO Permissions(UserId, GiveGrade, ViewAllGrades, ChangeAllGrades, AddCourses) VALUES(1, true, true, true, true), (11, true, false, false, false), (21, false, true, false, false), (31, false, false, true, false), (41, false, false, false, true);

INSERT INTO Semesters(Year, Season, StartDate, EndDate, Current) VALUES('2014', 'WINTER', '2014-1-1 00:00:01', '2014-1-18 00:00:01', false);
INSERT INTO Semesters(Year, Season, StartDate, EndDate, Current) VALUES('2014', 'SPRING', '2014-01-20 00:00:01', '2014-05-15 00:00:01', true);