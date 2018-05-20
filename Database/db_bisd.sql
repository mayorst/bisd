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
description TEXT,
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
	
	PRIMARY KEY(pmess_id)
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
	IF(ev.address = '' OR ev.address = NULL , 
	(SELECT CONCAT(venue_name,', ',address) from tbl_venue where venue_id  = ev.venue)
	,ev.address) as 'address',
	ev.venue ,
	ev.description ,
	ev.stat,
	IF(ev.ev_img_path = '' OR ev.ev_img_path = NULL , 
	(SELECT img_path from tbl_venue where venue_id  = ev.venue)
	,ev.ev_img_path) as 'ev_img_path'

from tbl_events ev
LEFT JOIN tbl_venue ven ON ev.venue = ven.venue_id
LEFT JOIN tbl_venue_img vimg ON ven.venue_id = vimg.venue_id
ORDER BY stat ASC, time_start DESC;

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

INSERT INTO `tbl_venue` (`venue_id`, `venue_name`, `address`, `venue_description`) VALUES
	(1001, 'Avogadro Hall', 'PRRM Mother Ignacia, Quezon City', 'Good Place for Meeting.'),
	(1002, 'Valencia Hall', 'Bulacan State University, Malolos Bulacan', '3000 Audience Capacity.');

INSERT INTO `tbl_venue_img` (`venue_id`, `img_path`) VALUES
	(1001, 'uploads/img/1/ad31b57e1db091a4e2bccaf27436601b.jpg'),
	(1002, 'uploads/img/1/4d249031a4c362b892f1e39ba90daa61.jpg');

INSERT INTO `tbl_events` (`event_id`, `name`, `time_start`, `time_end`, `address`, `venue`, `description`, `ev_img_path`, `stat`) VALUES
	(1001, 'Earth Day 2018', '2018-05-09 09:00:00', '2018-05-09 22:00:00', 'Philippine Arena, Bocaue, Bulacan', 0, 'Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing Elit, Sed Do Eiusmod\r\nTempor Incididunt Ut Labore Et Dolore Magna Aliqua. Ut Enim Ad Minim Veniam,\r\nQuis Nostrud Exercitation Ullamco Laboris Nisi Ut Aliquip Ex Ea Commodo\r\nConsequat. Duis Aute Irure Dolor In Reprehenderit In Voluptate Velit Esse\r\nCillum Dolore Eu Fugiat Nulla Pariatur. Excepteur Sint Occaecat Cupidatat Non\r\nProident, Sunt In Culpa Qui Officia Deserunt Mollit Anim Id Est Laborum.', 'uploads/img/1/e294f6ddb564b9215bba5bf42ea8501c.jpg', 'Active'),
	(1002, 'Youth Camp 2018', '2018-05-09 10:00:00', '2018-05-16 10:00:00', 'Tagaytay City, Cavite', 0, 'Lorem Ipsum Dolor Sit Amet, Consectetur Adipisicing Elit, Sed Do Eiusmod\r\nTempor Incididunt Ut Labore Et Dolore Magna Aliqua. Ut Enim Ad Minim Veniam,\r\nQuis Nostrud Exercitation Ullamco Laboris Nisi Ut Aliquip Ex Ea Commodo\r\nConsequat. Duis Aute Irure Dolor In Reprehenderit In Voluptate Velit Esse\r\nCillum Dolore Eu Fugiat Nulla Pariatur. Excepteur Sint Occaecat Cupidatat Non\r\nProident, Sunt In Culpa Qui Officia Deserunt Mollit Anim Id Est Laborum.', 'uploads/img/1/0ac584f6571167cb76ed1c1168d3034b.jpg', 'Active');

INSERT INTO `tbl_public_message` (`pmess_id`, `date_publish`, `title`, `from_`, `message`) VALUES
	(1, '2018-05-20 22:45:25', 'EARTH DAY 2018 MESSAGE', 'Isagani R. Serrano\r\nPresident, Earth Day Network Philippines\r\nPresident, Philippine Rural Reconstruction Movement', 'Our theme for this year’s Earth Day celebration “Green the Cities, Green the Oceans” is a response to the urgent call of the UN to clean up our oceans. It is also about the interconnectedness of things on this planet, among other ecological principles. \r\n\r\nWe say ‘Green the cities’ first because cities are the source of wastes that eventually end up in the ocean. Unless action happens in the cities and communities where we live, work and enjoy our lives, efforts at cleaning the ocean sink, also read cesspool, may not count for much. \r\n\r\nThere’s about a trillion single-use plastic bags used annually across our home planet. That amounts to millions every minute of every day. And single-use plastic is just one among dozens of plastic products that we use and eventually throw away. Yet we know there’s really no away to throw to. \r\n\r\nIf you’re not worried yet, let’s consider this scenario: in not so distant future there would be more plastic than fish in our oceans. And today so much plastic has already ended up in the body of the fish we eat. \r\nWe could resign in the fact that nature, with or without us, can very well take care of itself. It can clean up any shit we throw at it. As for plastic which may live for a hundred years or more, we could rest in the hope that anyway everything dissolves in water sooner or later. What’s 150 million tons of accumulated plastics in the oceans and eight million tons more dumped there each year. We can even turn the entire land area of the planet into a garbage pit and all of it, including us, can be accommodated in the ocean, no sweat. So why worry over a few waste patches here and there floating on our mighty oceans. \r\n\r\nWe do have good reason to worry, and not only for later, but here and now. There’s enough to cause us sleepless nights about the way things are, even without invoking some doomsday scenario of malfunctioning ocean ecosystem.\r\n\r\nWe know that ocean pollution impacts our health. Health is first and foremost what we eat and we eat a lot of fish that eat the plastic we dispose into the oceans. We know all too well that when health is on the line, nothing else matters.\r\n\r\nOceans provide scope for our diminishing terrestrial space. The state of land degradation now threatens our long-term food security. Our supply of fresh water resources is likewise at risk.\r\n\r\nOceans moderate the weather that affects us all, regardless of where we live, along the shore or deep into the continents. Oceans are crucial to the stability of the climate system. Well-functioning oceans can help avert catastrophic climate change. \r\n\r\nHappiness is a green blue ocean. Let’s help clean it up so it will stay that way.\r\n\r\nA world without waste is possible. Let’s help build it.  And let’s begin at home. ');



