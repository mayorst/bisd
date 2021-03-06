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
course_abbr VARCHAR(20),
category INT(5), 
description TEXT,
course_schedule TEXT,
tuition_fee DOUBLE(8,2),
img_path VARCHAR(300),
stat VARCHAR(15),

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


CREATE TABLE IF NOT EXISTS tbl_venue(

venue_id BIGINT(15) AUTO_INCREMENT,
venue_name VARCHAR(30) NOT NULL,
address VARCHAR(150) NOT NULL,
venue_description VARCHAR(1024),

PRIMARY KEY(venue_id)
);

CREATE TABLE IF NOT EXISTS tbl_venue_img(
	venue_id BIGINT(15),
	img_path VARCHAR(300),

	PRIMARY KEY(venue_id),
	FOREIGN KEY(venue_id) REFERENCES tbl_venue(venue_id)
);

CREATE TABLE IF NOT EXISTS tbl_events(
	event_id BIGINT(20) AUTO_INCREMENT,
	name VARCHAR(50) NOT NULL,
	time_start DATETIME,
	time_end DATETIME,
	address VARCHAR(150) DEFAULT '',
	venue BIGINT(15),
	custom_venue BOOLEAN DEFAULT 0,
	description TEXT,
	ev_img_path VARCHAR(300),
	stat VARCHAR(15),

	PRIMARY KEY(event_id)
);

CREATE TABLE IF NOT EXISTS tbl_public_message(
	pmess_id BIGINT(7) AUTO_INCREMENT,
	date_publish DATETIME DEFAULT NOW(),
	title VARCHAR(200) DEFAULT 'MESSAGE OF PRRM',
	from_ TEXT,
	message TEXT,
	external_link TEXT,
	
	PRIMARY KEY(pmess_id)
);


CREATE TABLE IF NOT EXISTS tbl_enrollee(
	enrollee_id BIGINT(10) AUTO_INCREMENT,
	first_name VARCHAR(30),
	middle_name VARCHAR(20),
	last_name VARCHAR(20),
	birthdate DATETIME,
	gender VARCHAR(20),
	organization VARCHAR(200),
	occupation VARCHAR(50),
	phone_number VARCHAR(15),
	email VARCHAR(50),
	address1 VARCHAR(200),
	address2 VARCHAR(200),
	city VARCHAR(30),
	state VARCHAR(30),
	postal VARCHAR(6),
	country VARCHAR(20),
	date_applied DATETIME DEFAULT NOW(),

	PRIMARY KEY (enrollee_id)
);

CREATE TABLE IF NOT EXISTS 	tbl_enrollee_courses(
	enrollee_id BIGINT(10),
	course_id INT(10),

	PRIMARY KEY (enrollee_id,course_id),
	FOREIGN KEY (enrollee_id) REFERENCES tbl_enrollee(enrollee_id),
	FOREIGN KEY (course_id) REFERENCES tbl_course(course_id)
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
acc_verification VARCHAR(35),

PRIMARY KEY(temp_member_id)
);

-- =============== ALTERS ==========
ALTER TABLE tbl_events AUTO_INCREMENT=1001;
ALTER TABLE tbl_venue AUTO_INCREMENT=1001;
ALTER TABLE tbl_course AUTO_INCREMENT=1001;

ALTER TABLE tbl_course_category AUTO_INCREMENT=101;

ALTER TABLE tbl_member AUTO_INCREMENT=1001;




-- ==================== VIEWS =============

CREATE VIEW IF NOT EXISTS course_prereq AS

Select cp.course_id "req_by",c.*

from tbl_course_prereq cp
INNER JOIN tbl_course c ON cp.prereq_id = c.course_id;

CREATE VIEW IF NOT EXISTS events AS 
SELECT  
	ev.event_id,
	ev.name ,
	ev.time_start,
	ev.time_end ,
	IF(ev.address = '' OR ev.address = NULL OR ev.custom_venue , 
	(SELECT CONCAT(venue_name,', ',address) from tbl_venue where venue_id  = ev.venue)
	,ev.address) as 'address',
	ev.venue ,
	ev.custom_venue,
	ev.description ,
	ev.stat,
	ev.ev_img_path,
	IF(ev.custom_venue, 
	(SELECT img_path from tbl_venue where venue_id  = ev.venue),0) as 'fallback_img_path'

from tbl_events ev
LEFT JOIN tbl_venue ven ON ev.venue = ven.venue_id
LEFT JOIN tbl_venue_img vimg ON ven.venue_id = vimg.venue_id
ORDER BY stat ASC, time_start DESC;

CREATE VIEW IF NOT EXISTS courses AS 
Select * from tbl_course crs 
INNER JOIN tbl_course_category ctg  ON crs.category = ctg.categ_id;

CREATE VIEW IF NOT EXISTS enrollees AS 
SELECT 
*,
TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) "age",
(
SELECT GROUP_CONCAT(crs.course_abbr SEPARATOR ', ')
FROM courses crs
INNER JOIN tbl_enrollee_courses ecrs ON ecrs.course_id = crs.course_id
WHERE ecrs.enrollee_id = e.enrollee_id
) AS 'applied_courses'
FROM tbl_enrollee e;

CREATE VIEW IF NOT EXISTS inquired_courses AS
SELECT  en.enrollee_id, ec.course_id, en.date_applied
FROM tbl_enrollee en 
RIGHT JOIN tbl_enrollee_courses ec ON en.enrollee_id = ec.enrollee_id;

-- ================= INSERTS ===========

INSERT INTO `tbl_member` (`member_id`, `last_name`, `first_name`, `middle_name`, `street`, `barangay`, `municipality`, `province`, `birthdate`, `gender`, `contact_number`, `email`, `username`, `_password`, `date_added`, `_position`, `_status`, `prof_pic`) VALUES
	('2018-1001', 'Geronimo', 'Alvin John', 'Duldulao', '098 hoho St.', 'Munoz', 'Sta. Clara', 'Bulacan', '1995-12-12', 'Male', '09267829192', 'ddum101010@gmail.com', 'mayor', '$2y$10$lQWYA0HgahSJu4McRPKjTu93/HyXp5nqqzeI3OkOXHccGGgF4YH46', '2018-06-04 23:42:18', 'Admin', 'Active', '/img/1.jpg');


INSERT INTO `tbl_course_category` (`categ_id`, `categ_name`) VALUES
	(101, 'Foundation Courses'),
	(102, 'Standard Courses'),
	(103, 'Specialized Courses');


INSERT INTO `tbl_course` (`course_id`, `course_name`, `course_abbr`, `category`, `description`, `course_schedule`, `tuition_fee`, `img_path`, `stat`) VALUES
	(1001, 'Basic Course on Sustainability(BCS)', 'BCS', 101, 'The Philippines and the world are  moving towards crisis - the crisis of unsustainable development. This idea contrasts with the view that life has been getting better, and the future is even brighter. The BCS is a basic course on sustainable development. The course will enable learners to understand the basic concept, discourses and practical implications of sustainable development. It has six modules, logically sequenced, building from descriptive to analytical, covering topics such as the crisis of unsustainable development; the roots of the problem – causes, effects and systemic problems; perspectives and analytical tools – critiques of mainstream development; building blocks and tools for a sustainable world; strategies and approaches for sustainability; and individual action. The learners will construct webs of problems and webs of solutions, examine different perspectives, strategies and indicators of sustainability, and make individual and collective commitments. They will develop their own pathways to sustainability, whilst understanding the challenges they will face during implementation and build in appropriate strategies and approaches to overcome these barriers.', 'Monday - Friday: 1:00 pm to 5:30 pm', 400.00, 'uploads/img/1/6ad6f73ef144fb89649edd64ba05e88b.jpg', NULL),
	(1002, 'Climate Change and Disaster Risk Reduction', 'CCDRR', 101, 'The occurrence of natural disasters and the losses associated with extreme climatic events have increased significantly in recent years. In the aftermath of these natural disasters, the affected households and communities are now more impoverished than they used to be, making them even more vulnerable to natural disasters in the future. Reducing the vulnerability of these affected households and communities to the adverse impacts of natural disasters is the most appropriate strategy of building adaptive capacity of these communities to cope with the future impacts of global climate change. This course helps to systematically facilitate the integration of disaster risk reduction and climate change into local development planning. This integration will facilitate transformation of communities from their current state of vulnerability into disasterresilient and sustainable communities in the long term.', 'Monday-Friday: 8:00 am-12:00 pm', 1000.00, 'uploads/img/1/69b9ade714bbe68cb53e495669644be3.jpg', NULL),
	(1003, 'Governance for Sustainability', 'GS', 103, 'This course is about the kind of governance needed to shift development to a sustainable path. It will introduce learners to principles that make for good governance, enable them to critique governance practices from the perspective of sustainable development, and explore effective advocacy strategies. Special emphasis is given to local governance and its role in (re) building sustainable communities.', 'Monday - Friday: 2:00 pm to 4:30 pm', 600.00, 'uploads/img/1/993e05e692594d1c40decf9b4ca6da21.png', NULL),
	(1004, 'Managing Development for Sustainability', 'MDS', 102, 'This course is about managing development to become sustainable. It will introduce learners to the cycles and processes of strategic, program and project planning. The participants of development projects will explore participatory approaches as a means to enhance stakeholdership and ownership. An important part of the management of the project systems environment is an organized process to identify and manage the probable stakeholders in that environment, and determine how they will react to the project decisions. The stakeholder dimension of sustainability is mainly to determine the social aspects of sustainability, in combination with the economical, ecological and cultural aspects. The social aspects of the project must be fully considered and integrated into decision-making.\r\n To effectively manage stakeholder interests it is not enough to just identify their demands and needs. Project management must also identify the relative power/influence and commitment different stakeholders have on the implementation of the project. Participants will learn how to do this through stakeholder mapping, an approach, which is adapted from the concept of environmental scanning. \r\nAt the end, learners should be able to conduct stakeholder mapping, analyze the needs and capacities of stakeholders, set goals, define purposes and objectives, explore strategic options, and set performance indicators for effective monitoring and evaluation of sustainable development.', 'Monday-Friday: 3:00 pm to 6:00 pm', 2000.00, 'uploads/img/1/c8d5df8b402d96ae1ccb1e6b7bf70720.jpg', NULL),
	(1005, 'Gender and Development', 'GenDev', 102, 'This course combines theoretical and life-based inputs that broadens and refocuses one’s perspectives to accommodate and see women’s points of view, situations, capacities and aspirations in relation to men. Learners will discuss the realities men and women face in the context of day-to-day engagements, establishing and improving local production, livelihood, community development, governance, and education. They will explore how men and women can contribute to sustainable development on a personal level, within the family, organizations, working environment and the community. The course emphasizes participation, empowerment, sharing and respect within the framework of balanced gender relations.', 'Monday - Friday: 2:00 pm to 4:30 pm', 300.00, 'uploads/img/1/0ce54de46b249430602be3b4551e3c0b.png', NULL),
	(1006, 'Organizing for Community Development', 'OCDev', 102, 'One big downside of modernization is the destruction of local communities. In this course learners will explore the various perspectives, strategies and approaches to (re) building sustainable communities. The course will introduce learners to the basic steps of the community organizing process, help them analyze the different strategies in building local mass movements and apply instruments for evaluating the strengths and weaknesses of organizations and movements.', 'Monday - Friday: 1:00 pm to 4:15 pm', 3000.00, 'uploads/img/1/d6662ef2f9f3621bb230b53c1ecaa68d.jpg', NULL),
	(1007, 'Local Economy and Microfinance', 'LEM', 102, 'This course focuses on the role of local (i.e., community-level) economies in ensuring national sustainability. It examines the elements that comprise a sustainable local economy. Specific cases will also be discussed, to give participants a realistic picture of the problems involved and options available in making local economies sustainable, including the principles of micro-finance and risk transfer mechanisms.', 'Monday - Friday: 7:00 am to 4:30 pm', 2500.00, 'uploads/img/1/cec76bc457f8d888e08616c861cc9bb2.jpg', NULL),
	(1008, 'Sustainable Coastal Resource Management', 'SCRM', 102, 'This course is a community-based, holistic and integrated approach to managing coastal resources. It focuses on enhancing local capacity in developing and implementing projects to ensure the sustainability of coastal resources and livelihood for the local community. The course also equips participants with necessary knowledge, attitude and skills in mainstreaming CBCRM into current development policy and practice.', 'Monday - Friday: 2:00 pm to 4:30 pm', 500.00, 'uploads/img/1/bff7a1598bb05b11c7f6ac025e0f855d.jpg', NULL),
	(1009, 'Sustainable Agriculture', 'SA', 102, 'This course will familiarize participants with the concepts of sustainable agriculture. Participants will become familiar with the factors of sustainable agriculture (food security, cash crops for higher income, organic farming, and the preservation of biodiversity) and develop understanding on how to make a farm sustainable. General principles and specific practices such as diversified integrated farming systems (DIFS), system of rice intensification (SRI), nature farming, and permaculture will be covered.', 'Monday - Friday: 2:00 pm to 4:30 pm', 750.00, 'uploads/img/1/fc611b5991125e3075023bcb1264074e.jpg', NULL);

INSERT INTO `tbl_course_prereq` (`course_id`, `prereq_id`) VALUES
	(1003, 1001),
	(1003, 1002),
	(1004, 1001),
	(1004, 1002),
	(1005, 1001),
	(1005, 1002),
	(1006, 1001),
	(1006, 1002),
	(1007, 1001),
	(1007, 1002),
	(1008, 1001),
	(1008, 1002),
	(1009, 1001),
	(1009, 1002);


INSERT INTO `tbl_venue` (`venue_id`, `venue_name`, `address`, `venue_description`) VALUES
	(1001, 'Avogadro Hall', 'PRRM Mother Ignacia, Quezon City', 'Good Place for Meeting.'),
	(1002, 'Valencia Hall', 'Bulacan State University, Malolos Bulacan', '3000 Audience Capacity.');

INSERT INTO `tbl_venue_img` (`venue_id`, `img_path`) VALUES
	(1001, 'uploads/img/1/ad31b57e1db091a4e2bccaf27436601b.jpg'),
	(1002, 'uploads/img/1/4d249031a4c362b892f1e39ba90daa61.jpg');


INSERT INTO `tbl_events` (`event_id`, `name`, `time_start`, `time_end`, `address`, `venue`, `custom_venue`, `description`, `ev_img_path`, `stat`) VALUES
	(1001, 'Earth Day 2018', '2018-05-09 09:00:00', '2018-05-09 22:00:00', 'Philippine Arena, Bocaue, Bulacan', 1001, 0, 'Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing Elit, Sed Do Eiusmod\r\nTempor Incididunt Ut Labore Et Dolore Magna Aliqua. Ut Enim Ad Minim Veniam,\r\nQuis Nostrud Exercitation Ullamco Laboris Nisi Ut Aliquip Ex Ea Commodo\r\nConsequat. Duis Aute Irure Dolor In Reprehenderit In Voluptate Velit Esse\r\nCillum Dolore Eu Fugiat Nulla Pariatur. Excepteur Sint Occaecat Cupidatat Non\r\nProident, Sunt In Culpa Qui Officia Deserunt Mollit Anim Id Est Laborum.', 'uploads/img/1/9ada481e62e41536687dde57ee04d18b.jpg', 'Active'),
	(1002, 'Youth Camp 2018', '2018-05-09 10:00:00', '2018-05-16 10:00:00', 'Tagaytay City, Cavite', 1001, 0, 'Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing Elit, Sed Do Eiusmod\r\nTempor Incididunt Ut Labore Et Dolore Magna Aliqua. Ut Enim Ad Minim Veniam,\r\nQuis Nostrud Exercitation Ullamco Laboris Nisi Ut Aliquip Ex Ea Commodo\r\nConsequat. Duis Aute Irure Dolor In Reprehenderit In Voluptate Velit Esse\r\nCillum Dolore Eu Fugiat Nulla Pariatur. Excepteur Sint Occaecat Cupidatat Non\r\nProident, Sunt In Culpa Qui Officia Deserunt Mollit Anim Id Est Laborum.', 'uploads/img/1/8718de51e125e4a2c267dd9583be7473.jpg', 'Active');


INSERT INTO `tbl_public_message` (`pmess_id`, `date_publish`, `title`, `from_`, `message`, `external_link`) VALUES
	(1, '2018-05-20 22:45:25', 'EARTH DAY 2018 MESSAGE', 'Isagani R. Serrano\r\nPresident, Earth Day Network Philippines\r\nPresident, Philippine Rural Reconstruction Movement', 'Our theme for this year’s Earth Day celebration “Green the Cities, Green the Oceans” is a response to the urgent call of the UN to clean up our oceans. It is also about the interconnectedness of things on this planet, among other ecological principles. \r\n\r\nWe say ‘Green the cities’ first because cities are the source of wastes that eventually end up in the ocean. Unless action happens in the cities and communities where we live, work and enjoy our lives, efforts at cleaning the ocean sink, also read cesspool, may not count for much. \r\n\r\nThere’s about a trillion single-use plastic bags used annually across our home planet. That amounts to millions every minute of every day. And single-use plastic is just one among dozens of plastic products that we use and eventually throw away. Yet we know there’s really no away to throw to. \r\n\r\nIf you’re not worried yet, let’s consider this scenario: in not so distant future there would be more plastic than fish in our oceans. And today so much plastic has already ended up in the body of the fish we eat. \r\nWe could resign in the fact that nature, with or without us, can very well take care of itself. It can clean up any shit we throw at it. As for plastic which may live for a hundred years or more, we could rest in the hope that anyway everything dissolves in water sooner or later. What’s 150 million tons of accumulated plastics in the oceans and eight million tons more dumped there each year. We can even turn the entire land area of the planet into a garbage pit and all of it, including us, can be accommodated in the ocean, no sweat. So why worry over a few waste patches here and there floating on our mighty oceans. \r\n\r\nWe do have good reason to worry, and not only for later, but here and now. There’s enough to cause us sleepless nights about the way things are, even without invoking some doomsday scenario of malfunctioning ocean ecosystem.\r\n\r\nWe know that ocean pollution impacts our health. Health is first and foremost what we eat and we eat a lot of fish that eat the plastic we dispose into the oceans. We know all too well that when health is on the line, nothing else matters.\r\n\r\nOceans provide scope for our diminishing terrestrial space. The state of land degradation now threatens our long-term food security. Our supply of fresh water resources is likewise at risk.\r\n\r\nOceans moderate the weather that affects us all, regardless of where we live, along the shore or deep into the continents. Oceans are crucial to the stability of the climate system. Well-functioning oceans can help avert catastrophic climate change. \r\n\r\nHappiness is a green blue ocean. Let’s help clean it up so it will stay that way.\r\n\r\nA world without waste is possible. Let’s help build it.  And let’s begin at home. ', 'http://www.prrm.org/news-archive/earth-day-2018-message'),
	(2, '2018-05-20 22:45:25', 'Water project benefits Brgy. Gen. Luna in Carranglan, Nueva Ecija ', 'By Nappy R. Manegdeg', 'At least 800 households of Brgy. General Luna, Carranglan municipality in northern Nueva Ecija are now benefiting from a new water system installed in the area.\r\n\r\nNestled at the foot of the Sierra Madre mountain range, Brgy. General Luna, considered an upland barangay, is surrounded by mountains. Its rice fields are irrigated by a number of communal irrigation systems, whose source are the watersheds around it. Privately-owned artesian wells and a few communal pitcher pumps are the main sources of potable water for the residents of General Luna. However, water for domestic use is difficult during the summer months.\r\n\r\nPartnership for water\r\n\r\nPRRM, in partnership with the Coca-Cola Foundation Philippines, Inc. (CCFI), installed the Level 2 water system composed of an intake dam, a 2.5 x 2.5 x 2.5 cubic meter distribution tank, a three-kilometer pipeline from the intake dam to the distribution tank, and five kilometers of distribution pipeline from the distribution tank to the household clusters. This was turned over to the community residents through the General Luna Water Spring Association [GLUWASA] on 28 November 2014 in simple handover rites.\r\n\r\nIn the turnover ceremonies, PRRM President, Gani Serrano, emphasized that access to water, as a basic right, should be enjoyed by rural communities. Ms. Cecile Alcantara, CCFI President, explained that supporting the project was a way to “safely return to nature and to communities an amount of water equal to what is used in Coca Cola beverages and their production”.\r\n\r\nOfficials of the municipal and barangay local government units were present in the turnover program. They expressed that they will continue to support the project by helping GLUWASA in the maintenance of the water system.\r\n\r\nBenefits to women and children\r\n\r\n?Margarita Gabriel, a longtime resident of General Luna, said that households like hers can do more today than in the past because of the water project. Mothers and grandmothers like her can do their laundry in shorter time, making more time for other livelihood or recreational activities. Also, their children and grandchildren do not have to walk far to fetch water as water tap stands are strategically located within household clusters.', 'http://www.prrm.org/news-archive/water-project-benefits-brgy-gen-luna-in-carranglan-nueva-ecija'),
	(3, '2018-05-20 22:45:25', 'PRRM facilitates CSO conference in Upper Sierra Madre ', '', 'From 27-28 October 2016, PRRM facilitated a CSO conference in Upper Sierra Madre. The conference provided a venue for stocktaking and surfacing of emerging lessons by grantees of the UNDP Global Environment Facility (GEF) – Small Grants Programme Phase 5 (SGP5).', 'http://www.prrm.org/news-archive/prrm-facilitates-cso-conference-in-upper-sierra-madre');


INSERT INTO `tbl_enrollee` (`enrollee_id`, `first_name`, `middle_name`, `last_name`, `birthdate`, `gender`, `organization`, `occupation`, `phone_number`, `email`, `address1`, `address2`, `city`, `state`, `postal`, `country`, `date_applied`) VALUES
	(1, 'John Simon', 'F.', 'Dela Cruz', '2000-06-18 00:00:00', 'Male', 'BulSu', 'none', '09653242157', 'webdevBh7@gmail.com', 'Hernandez', 'San Simon', 'Manila', 'Ncr', '3001', 'Philppines', '2018-06-05 00:13:10'),
	(2, 'Bennett', '', 'Sanchez', '2000-06-18 00:00:00', 'Male', 'Laco', 'Driver', '09563215487', '2dcute@gmail.com', 'Sta Rita', 'Negros', 'Panay', 'Negros', '4056', 'Philippines', '2018-06-05 00:13:10'),
	(3, 'Sonya', 'D.', 'Benitez', '2000-06-18 00:00:00', 'Female', 'Nasxa', 'Technician', '09653242157', 'keukeu@gmail.com', 'Jacak', 'Pienco', 'Batanes', 'Regioin 1', '3200', 'Philiippines', '2018-06-05 00:13:10');


INSERT INTO `tbl_enrollee_courses` (`enrollee_id`, `course_id`) VALUES
	(1, 1001),
	(1, 1002),
	(2, 1001),
	(2, 1002),
	(2, 1006),
	(3, 1001),
	(3, 1002),
	(3, 1003),
	(3, 1008);
