# To view grades
select Abbreviation, CourseNumber, Title, GradeGPA, CreditValue from Courses
join Departments on Departments.Id = Courses.DeptId
join CourseInstance on CourseInstance.CourseId = Courses.Id
join Registration on Registration.CourseInstanceId = CourseInstance.Id
where UserId = ?