# To view grades
SELECT Abbreviation, CourseNumber, Title, GradeGPA, CreditValue FROM Courses
JOIN Departments ON Departments.Id = Courses.DeptId
JOIN CourseInstance ON CourseInstance.CourseId = Courses.Id
JOIN Registration ON Registration.CourseInstanceId = CourseInstance.Id
WHERE UserId = ? ORDER BY Semester, Abbreviation