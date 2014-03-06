DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Permissions;
DROP TABLE IF EXISTS Meetings;
DROP TABLE IF EXISTS Courses;
DROP TABLE IF

CREATE TABLE Users (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  Name varchar(50) NOT NULL,
  Password char(40) NOT NULL,
  Email varchar(50) NOT NULL,
  DeptId int(8) NOT NULL,
  FOREIGN KEY (DeptId) REFERENCES Departments(Id)
) engine=InnoDB;

CREATE TABLE Role (
  UserId int(8) NOT NULL,
  Role ENUM('student', 'faculty', 'staff', 'executive')
) engine=InnoDB;

CREATE TABLE Permissions (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  GiveGrade bool DEFAULT 0 NOT NULL,
  ViewAllGrades bool DEFAULT 0 NOT NULL,
  ChangeAllGrades bool DEFAULT 0 NOT NULL,
  AddCourses bool DEFAULT 0 NOT NULL
) engine=InnoDB;

CREATE TABLE Meetings (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  CourseInstanceId int(8) NOT NULL,
  BeginTime TIMESTAMP CURRENT_TIMESTAMP NOT NULL,
  EndTime TIMESTAMP CURRENT_TIMESTAMP NOT NULL,
  Location varchar(20)
) engine=InnoDB;

CREATE TABLE Courses (

) engine=InnoDB;

CREATE TABLE CourseInstances (
) engine=InnoDB;

CREATE TABLE GradeInfo (
) engine=InnoDB;

CREATE TABLE Registration (
) engine=InnoDB;

CREATE TABLE Departments (
) engine=InnoDB;