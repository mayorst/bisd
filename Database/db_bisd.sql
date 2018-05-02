DROP DATABASE IF EXISTS db_bisd;

CREATE DATABASE IF NOT EXISTS db_bisd;

USE db_bisd;


CREATE TABLE IF NOT EXISTS tbl_member(

member_id VARCHAR(15) NOT NULL,
last_name VARCHAR(15) NOT NULL,
first_name VARCHAR(30) NOT NULL,
middle_name VARCHAR(15),
street VARCHAR(30),
barangay VARCHAR(25),
municipality VARCHAR(30),
province VARCHAR(30),
birthdate DATE,
gender VARCHAR(10),
contact_number VARCHAR(20),
email VARCHAR(50),
username VARCHAR(10),
_password VARCHAR(255),
date_added DATETIME DEFAULT NOW(),
_position VARCHAR(20),
_status VARCHAR(15),
prof_pic VARCHAR(300),

PRIMARY KEY(member_id)
);


CREATE TABLE IF NOT EXISTS tbl_course_category(

categ_id INT(5) AUTO_INCREMENT NOT NULL,
categ_name VARCHAR(100),

PRIMARY KEY(categ_id)

);


CREATE TABLE IF NOT EXISTS tbl_course(

course_id INT(10) AUTO_INCREMENT  NOT NULL,
course_name VARCHAR(100) NOT NULL,
category INT(5), 
description VARCHAR(16384), -- description maybe in a .json file so thet the db is not bulky for just a description.

PRIMARY KEY(course_id),
FOREIGN KEY(category) REFERENCES tbl_course_category(categ_id)
);


CREATE TABLE IF NOT EXISTS tbl_course_prereq(

course_id INT(10),
prereq_id INT(10),

PRIMARY KEY(course_id,prereq_id),
FOREIGN KEY(course_id) REFERENCES tbl_course(course_id),
FOREIGN KEY(prereq_id) REFERENCES tbl_course(course_id)

);


-- ================= tempTables ===============
CREATE TABLE IF NOT EXISTS tbl_temp_member(

temp_member_id INT AUTO_INCREMENT NOT NULL,
last_name VARCHAR(15) NOT NULL,
first_name VARCHAR(30) NOT NULL,
middle_name VARCHAR(15),
street VARCHAR(30),
barangay VARCHAR(25),
municipality VARCHAR(30),
province VARCHAR(30),
birthdate DATE,
gender VARCHAR(10),
contact_number VARCHAR(20),
email VARCHAR(50),
username VARCHAR(10),
_password VARCHAR(255),
date_added DATETIME DEFAULT NOW(),
_position VARCHAR(20),
_status VARCHAR(15),
prof_pic VARCHAR(300),

PRIMARY KEY(temp_member_id)
);

-- =============== ALTERS ==========
ALTER TABLE tbl_course AUTO_INCREMENT=1001;

ALTER TABLE tbl_course_category AUTO_INCREMENT=101;

ALTER TABLE tbl_member AUTO_INCREMENT=1001;




-- ==================== VIEWS =============

CREATE VIEW IF NOT EXISTS course_prereq AS

Select cp.course_id "req_by",c.*

from tbl_course_prereq cp
INNER JOIN tbl_course c ON cp.prereq_id = c.course_id;



-- ================= INSERTS ===========
INSERT INTO tbl_member(member_id, last_name, first_name, middle_name, street, barangay, municipality, province, birthdate, gender, contact_number, email, username,_password, _position, _status, prof_pic) 
VALUES(
'2018-1001'
,'Geronimo'
,'Alvin John'
,'Duldulao'
,'098 hoho St.'
,'Munoz'
,'Sta. Clara'
,'Bulacan'
,'1995-12-12'
,'Male'
,'09267829192'
,'ddum101010@gmail.com'
,'mayor'
,'$2y$10$lQWYA0HgahSJu4McRPKjTu93/HyXp5nqqzeI3OkOXHccGGgF4YH46'
,'Admin'
,'Active'
,'/img/1.jpg'
); 


INSERT INTO tbl_course_category( categ_name)
VALUES(
'Foundation Courses'
),(
'Standard Courses'
),(
'Specialized Courses'
);

INSERT INTO `tbl_course` (`course_id`, `course_name`, `category`, `description`) VALUES
	(1001, 'Basic Course on Sustainability(BCS)', 101, 'The Philippines and the world are  moving towards crisis - the crisis of unsustainable development. This idea contrasts with the view that life has been getting better, and the future is even brighter. The BCS is a basic course on sustainable development. The course will enable learners to understand the basic concept, discourses and practical implications of sustainable development. It has six modules, logically sequenced, building from descriptive to analytical, covering topics such as the crisis of unsustainable development; the roots of the problem – causes, effects and systemic problems; perspectives and analytical tools – critiques of mainstream development; building blocks and tools for a sustainable world; strategies and approaches for sustainability; and individual action. The learners will construct webs of problems and webs of solutions, examine different perspectives, strategies and indicators of sustainability, and make individual and collective commitments. They will develop their own pathways to sustainability, whilst understanding the challenges they will face during implementation and build in appropriate strategies and approaches to overcome these barriers.'),
	(1002, 'Climate Change and Disaster Risk Reduction', 101, 'The occurrence of natural disasters and the losses associated with extreme climatic events have increased significantly in recent years. In the aftermath of these natural disasters, the affected households and communities are now more impoverished than they used to be, making them even more vulnerable to natural disasters in the future. Reducing the vulnerability of these affected households and communities to the adverse impacts of natural disasters is the most appropriate strategy of building adaptive capacity of these communities to cope with the future impacts of global climate change. This course helps to systematically facilitate the integration of disaster risk reduction and climate change into local development planning. This integration will facilitate transformation of communities from their current state of vulnerability into disasterresilient and sustainable communities in the long term.'),
	(1003, 'Governance for Sustainability', 103, 'This course is about the kind of governance needed to shift development to a sustainable path. It will introduce learners to principles that make for good governance, enable them to critique governance practices from the perspective of sustainable development, and explore effective advocacy strategies. Special emphasis is given to local governance and its role in (re) building sustainable communities.'),
	(1004, 'Managing Development for Sustainability', 102, 'This course is about managing development to become sustainable. It will introduce learners to the cycles and processes of strategic, program and project planning. The participants of development projects will explore participatory approaches as a means to enhance stakeholdership and ownership. An important part of the management of the project systems environment is an organized process to identify and manage the probable stakeholders in that environment, and determine how they will react to the project decisions. The stakeholder dimension of sustainability is mainly to determine the social aspects of sustainability, in combination with the economical, ecological and cultural aspects. The social aspects of the project must be fully considered and integrated into decision-making.\r\n To effectively manage stakeholder interests it is not enough to just identify their demands and needs. Project management must also identify the relative power/influence and commitment different stakeholders have on the implementation of the project. Participants will learn how to do this through stakeholder mapping, an approach, which is adapted from the concept of environmental scanning. \r\nAt the end, learners should be able to conduct stakeholder mapping, analyze the needs and capacities of stakeholders, set goals, define purposes and objectives, explore strategic options, and set performance indicators for effective monitoring and evaluation of sustainable development.'),
	(1005, 'Gender and Development', 102, 'This course combines theoretical and life-based inputs that broadens and refocuses one’s perspectives to accommodate and see women’s points of view, situations, capacities and aspirations in relation to men. Learners will discuss the realities men and women face in the context of day-to-day engagements, establishing and improving local production, livelihood, community development, governance, and education. They will explore how men and women can contribute to sustainable development on a personal level, within the family, organizations, working environment and the community. The course emphasizes participation, empowerment, sharing and respect within the framework of balanced gender relations.'),
	(1006, 'Organizing for Community Development', 102, 'One big downside of modernization is the destruction of local communities. In this course learners will explore the various perspectives, strategies and approaches to (re) building sustainable communities. The course will introduce learners to the basic steps of the community organizing process, help them analyze the different strategies in building local mass movements and apply instruments for evaluating the strengths and weaknesses of organizations and movements.'),
	(1007, 'Local Economy and Microfinance', 102, 'This course focuses on the role of local (i.e., community-level) economies in ensuring national sustainability. It examines the elements that comprise a sustainable local economy. Specific cases will also be discussed, to give participants a realistic picture of the problems involved and options available in making local economies sustainable, including the principles of micro-finance and risk transfer mechanisms.'),
	(1008, 'Sustainable Coastal Resource Management', 102, 'This course is a community-based, holistic and integrated approach to managing coastal resources. It focuses on enhancing local capacity in developing and implementing projects to ensure the sustainability of coastal resources and livelihood for the local community. The course also equips participants with necessary knowledge, attitude and skills in mainstreaming CBCRM into current development policy and practice.'),
	(1009, 'Sustainable Agriculture', 102, 'This course will familiarize participants with the concepts of sustainable agriculture. Participants will become familiar with the factors of sustainable agriculture (food security, cash crops for higher income, organic farming, and the preservation of biodiversity) and develop understanding on how to make a farm sustainable. General principles and specific practices such as diversified integrated farming systems (DIFS), system of rice intensification (SRI), nature farming, and permaculture will be covered.');