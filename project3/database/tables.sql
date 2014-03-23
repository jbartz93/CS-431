DROP TABLE IF EXISTS Registration;
DROP TABLE IF EXISTS Meetings;
DROP TABLE IF EXISTS CourseInstances;
DROP TABLE IF EXISTS Semesters;
DROP TABLE IF EXISTS Courses;
DROP TABLE IF EXISTS Permissions;
DROP TABLE IF EXISTS Roles;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Departments;

CREATE TABLE Departments (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  Abbreviation varchar(4) NOT NULL,
  FullName varchar(30) NOT NULL
) engine=InnoDB;

CREATE TABLE Users (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  Name varchar(50) NOT NULL,
  Password char(40) NOT NULL,
  Email varchar(50) NOT NULL,
  DeptId int(8) NOT NULL,
  FOREIGN KEY (DeptId) REFERENCES Departments(Id)
) engine=InnoDB;

CREATE TABLE Roles (
  UserId int(8) NOT NULL,
  Role ENUM('student', 'faculty', 'staff', 'executive') NOT NULL,
  FOREIGN KEY (UserId) REFERENCES Users(Id)
) engine=InnoDB;

CREATE TABLE Permissions (
  UserId int(8) PRIMARY KEY AUTO_INCREMENT,
  GiveGrade bool DEFAULT 0 NOT NULL,
  ViewAllGrades bool DEFAULT 0 NOT NULL,
  ChangeAllGrades bool DEFAULT 0 NOT NULL,
  AddCourses bool DEFAULT 0 NOT NULL,
  FOREIGN KEY (UserId) REFERENCES Users(Id)
) engine=InnoDB;

CREATE TABLE Courses (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  Title varchar(50) NOT NULL,
  DeptId int(8) NOT NULL,
  CourseNumber int(5) NOT NULL,
  Description text,
  CreditValue int(3) NOT NULL
) engine=InnoDB;

CREATE TABLE Semesters (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  Year char(4) NOT NULL,
  Season ENUM('WINTER', 'SPRING', 'SUMMER', 'FALL') NOT NULL,
  StartDate TIMESTAMP NOT NULL,
  EndDate TIMESTAMP NOT NULL
) engine=InnoDB;

CREATE TABLE CourseInstances (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  CourseId int(8) NOT NULL,
  ProfessorId int(8),
  NumberSeats int(8) NOT NULL,
  SectionNumber char(3) NOT NULL,
  SemesterId int(8) NOT NULL,
  FOREIGN KEY (SemesterId) REFERENCES Semesters(Id),
  FOREIGN KEY (CourseId) REFERENCES Courses(Id),
  FOREIGN KEY (ProfessorId) REFERENCES Users(Id)
) engine=InnoDB;

CREATE TABLE Meetings (
  Id int(8) PRIMARY KEY AUTO_INCREMENT,
  CourseInstanceId int(8) NOT NULL,
  BeginTime TIMESTAMP NOT NULL,
  EndTime TIMESTAMP NOT NULL,
  Location varchar(20),
  FOREIGN KEY (CourseInstanceId) REFERENCES CourseInstances(Id)
) engine=InnoDB;

CREATE TABLE Registration (
  UserId int(8) NOT NULL,
  CourseInstanceId int(8) NOT NULL,
  GradeGPA decimal(1, 1) DEFAULT 0.0 NOT NULL,
  FOREIGN KEY (UserId) REFERENCES Users(Id),
  FOREIGN KEY (CourseInstanceId) REFERENCES CourseInstances(Id)
) engine=InnoDB;