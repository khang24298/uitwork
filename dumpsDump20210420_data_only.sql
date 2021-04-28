-- MySQL dump 10.13  Distrib 8.0.23, for Win64 (x86_64)
--
-- Host: localhost    Database: uitwork
-- ------------------------------------------------------
-- Server version	8.0.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `departmentID`, `email`, `name`, `created_at`, `updated_at`) VALUES (1,'admin2','$2y$10$Cv1r3PtKTgCPdxdgS6Dvue2Ocg/SC9eaCdRueXruFrRjsCwTIqrKm',3,'fEKGsYy8G8@gmail.com','ciwYohBIWngBJJEeHa7V',NULL,NULL),(2,'khang2','$2y$10$70E7kNPxnqVesUwI2JY6eu..FVXfz.TNoUrTa47Wv5RjEa8g2blVS',9,'khangnguyen@gmail.com','Tien Khang',NULL,NULL);

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `user_id`, `task_id`, `parent_id`, `created_at`, `updated_at`) VALUES (1,'asd90yahsdbas9gdvh',1,4,NULL,'2021-03-19 00:15:18','2021-03-19 00:15:18'),(2,'ba9u90ahsud89wahsd',1,1,1,'2021-03-19 00:15:54','2021-03-19 00:15:54'),(3,'castc7asgucbas8h',1,8,1,'2021-03-19 00:16:17','2021-03-19 00:16:17'),(4,'ds65489w1daw1d51',1,3,NULL,'2021-03-19 00:17:00','2021-03-19 00:17:00'),(5,'e5asd8asd2asd',1,7,4,'2021-03-19 00:18:04','2021-03-19 00:18:04');

--
-- Dumping data for table `criteria`
--

INSERT INTO `criteria` (`id`, `user_id`, `task_id`, `max_score`, `criteria_name`, `criteria_type_id`, `description`, `created_at`, `updated_at`) VALUES (1,6,NULL,98,'Plating Machine Operator',1,'Jeweler','2021-04-07 05:58:33','2021-04-07 05:58:33'),(2,NULL,4,80,'Vending Machine Servicer',2,'Healthcare','2021-04-07 05:58:33','2021-04-07 05:58:33'),(3,NULL,11,86,'Coating Machine Operator',1,'Press Machine Setter, Operator','2021-04-07 05:58:33','2021-04-07 05:58:33'),(4,6,NULL,84,'Rolling Machine Setter',2,'Emergency Medical Technician and Paramedic','2021-04-07 05:58:33','2021-04-07 05:58:33'),(5,NULL,3,83,'Terrazzo Workes and Finisher',2,'Rehabilitation Counselor','2021-04-07 05:58:33','2021-04-07 05:58:33'),(6,NULL,3,92,'Forensic Investigator',1,'Director Of Marketing','2021-04-07 05:58:33','2021-04-07 05:58:33'),(7,1,NULL,95,'Bellhop',2,'Event Planner','2021-04-07 05:58:33','2021-04-07 05:58:33'),(8,NULL,17,95,'Military Officer',1,'Gaming Dealer','2021-04-07 05:58:33','2021-04-07 05:58:33'),(9,NULL,17,97,'Law Clerk',1,'Glass Blower','2021-04-07 05:58:33','2021-04-07 05:58:33'),(10,1,NULL,86,'Plasterer OR Stucco Mason',2,'University','2021-04-07 05:58:33','2021-04-07 05:58:33'),(11,NULL,15,90,'Archeologist',1,'Etcher','2021-04-07 05:58:33','2021-04-07 05:58:33'),(12,2,NULL,91,'Creative Writer',2,'Machinist','2021-04-07 05:58:33','2021-04-07 05:58:33'),(13,8,NULL,96,'Atmospheric and Space Scientist',1,'Segmental Paver','2021-04-07 05:58:33','2021-04-07 05:58:33'),(14,3,NULL,84,'Medical Scientists',2,'Agricultural Crop Farm Manager','2021-04-07 05:58:33','2021-04-07 05:58:33'),(15,5,NULL,95,'Baker',1,'Entertainer and Performer','2021-04-07 05:58:33','2021-04-07 05:58:33'),(16,8,NULL,95,'Transportation Worker',2,'Civil Engineering Technician','2021-04-07 05:58:33','2021-04-07 05:58:33'),(17,NULL,12,97,'Mathematician',1,'Solderer','2021-04-07 05:58:33','2021-04-07 05:58:33'),(18,NULL,11,91,'Space Sciences Teacher',1,'Manager of Food Preparation','2021-04-07 05:58:33','2021-04-07 05:58:33'),(19,NULL,3,97,'Bindery Machine Operator',2,'Occupational Therapist Aide','2021-04-07 05:58:33','2021-04-07 05:58:33'),(20,NULL,6,91,'Loading Machine Operator',1,'Philosophy and Religion Teacher','2021-04-07 05:58:33','2021-04-07 05:58:33');

--
-- Dumping data for table `criteria_types`
--

INSERT INTO `criteria_types` (`id`, `type_id`, `type_name`, `description`, `created_at`, `updated_at`) VALUES (1,1,'forTask','aisdashdashd9ashdasd','2021-03-17 21:16:46','2021-03-17 21:16:46'),(2,2,'forUser','69r8tvkhbluhtfbty','2021-03-17 21:17:57','2021-03-17 21:17:57'),(3,2,'forUser','0pneh45rytf2g0dwqh0sgb','2021-03-17 21:18:39','2021-03-17 21:18:39');

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `address`, `phone`, `created_at`, `updated_at`) VALUES (1,'Biological Scientist','906 Gustave Prairie Apt. 462','+1-414-507-5866','2021-03-20 22:06:07','2021-03-20 22:06:07'),(2,'Urban Planner','278 Gulgowski Neck Suite 487','+1 (816) 834-3993','2021-03-20 22:06:07','2021-03-20 22:06:07'),(3,'Freight Inspector','599 Onie Heights Apt. 166','+1.289.715.8232','2021-03-20 22:06:07','2021-03-20 22:06:07'),(4,'Visual Designer','35049 Amya Terrace Apt. 242','(529) 949-1431','2021-03-20 22:06:07','2021-03-20 22:06:07'),(5,'Dietetic Technician','708 Dena Forks Apt. 548','(615) 526-5289','2021-03-20 22:06:07','2021-03-20 22:06:07');

--
-- Dumping data for table `documents`
--


--
-- Dumping data for table `education_levels`
--

INSERT INTO `education_levels` (`id`, `name`, `expertise`, `created_at`, `updated_at`) VALUES (1,'Master','Computer Systems Administrator','2021-03-21 00:08:15','2021-03-21 00:08:15'),(2,'Doctor','HR Specialist','2021-03-21 00:09:01','2021-03-21 00:09:01'),(3,'Associate Professor','Computer Hardware Engineer','2021-03-21 00:10:09','2021-03-21 00:10:09'),(4,'Professor','Software Developer','2021-03-21 00:10:59','2021-03-21 00:10:59');

--
-- Dumping data for table `evaluation`
--

INSERT INTO `evaluation` (`id`, `task_id`, `user_id`, `score`, `note`, `created_at`, `updated_at`) VALUES (1,4,NULL,4,'Board Of Directors','2021-03-31 21:25:46','2021-03-31 21:25:46'),(2,NULL,6,1,'Electrical Parts Reconditioner','2021-03-31 21:25:46','2021-03-31 21:25:46'),(3,13,NULL,18,'Craft Artist','2021-03-31 21:25:46','2021-03-31 21:25:46'),(4,6,NULL,3,'Agricultural Manager','2021-03-31 21:25:46','2021-03-31 21:25:46'),(5,1,NULL,8,'Writer OR Author','2021-03-31 21:25:46','2021-03-31 21:25:46'),(6,4,NULL,1,'Appliance Repairer','2021-03-31 21:25:46','2021-03-31 21:25:46'),(7,8,NULL,21,'Electronics Engineering Technician','2021-03-31 21:25:46','2021-03-31 21:25:46'),(8,7,NULL,26,'Sales Manager','2021-03-31 21:25:46','2021-03-31 21:25:46'),(9,NULL,2,27,'Baker','2021-03-31 21:25:46','2021-03-31 21:25:46'),(10,16,NULL,14,'House Cleaner','2021-03-31 21:25:46','2021-03-31 21:25:46'),(11,NULL,9,8,'Postal Clerk','2021-03-31 21:25:46','2021-03-31 21:25:46'),(12,20,NULL,24,'Electrician','2021-03-31 21:25:46','2021-03-31 21:25:46'),(13,18,NULL,8,'Traffic Technician','2021-03-31 21:25:46','2021-03-31 21:25:46'),(14,NULL,7,10,'Customer Service Representative','2021-03-31 21:25:46','2021-03-31 21:25:46'),(15,NULL,10,30,'Orthodontist','2021-03-31 21:25:46','2021-03-31 21:25:46'),(16,6,NULL,25,'Real Estate Association Manager','2021-03-31 21:25:46','2021-03-31 21:25:46'),(17,14,NULL,6,'Forming Machine Operator','2021-03-31 21:25:46','2021-03-31 21:25:46'),(18,2,NULL,26,'Mathematical Science Teacher','2021-03-31 21:25:46','2021-03-31 21:25:46'),(19,NULL,8,20,'Optical Instrument Assembler','2021-03-31 21:25:46','2021-03-31 21:25:46'),(20,3,NULL,21,'Bulldozer Operator','2021-03-31 21:25:46','2021-03-31 21:25:46'),(21,NULL,1,18,'Park Naturalist','2021-03-31 21:25:50','2021-03-31 21:25:50'),(22,9,NULL,21,'Hand Trimmer','2021-03-31 21:25:50','2021-03-31 21:25:50'),(23,13,NULL,15,'Safety Engineer','2021-03-31 21:25:50','2021-03-31 21:25:50'),(24,NULL,5,4,'Textile Knitting Machine Operator','2021-03-31 21:25:50','2021-03-31 21:25:50'),(25,NULL,3,4,'Respiratory Therapy Technician','2021-03-31 21:25:50','2021-03-31 21:25:50'),(26,NULL,4,17,'Paving Equipment Operator','2021-03-31 21:25:50','2021-03-31 21:25:50'),(27,5,NULL,11,'Transportation Manager','2021-03-31 21:25:50','2021-03-31 21:25:50'),(28,NULL,1,6,'Fishing OR Forestry Supervisor','2021-03-31 21:25:50','2021-03-31 21:25:50'),(29,3,NULL,9,'Sound Engineering Technician','2021-03-31 21:25:50','2021-03-31 21:25:50'),(30,19,NULL,6,'Infantry Officer','2021-03-31 21:25:50','2021-03-31 21:25:50'),(31,NULL,8,12,'Caption Writer','2021-03-31 21:25:50','2021-03-31 21:25:50'),(32,5,NULL,8,'Psychology Teacher','2021-03-31 21:25:50','2021-03-31 21:25:50'),(33,17,NULL,18,'First-Line Supervisor-Manager of Landscaping, Lawn Service, and Groundskeeping Worker','2021-03-31 21:25:50','2021-03-31 21:25:50'),(34,10,NULL,22,'Automatic Teller Machine Servicer','2021-03-31 21:25:50','2021-03-31 21:25:50'),(35,1,NULL,18,'Exhibit Designer','2021-03-31 21:25:50','2021-03-31 21:25:50'),(36,3,NULL,27,'Railroad Yard Worker','2021-03-31 21:25:50','2021-03-31 21:25:50'),(37,15,NULL,4,'Purchasing Manager','2021-03-31 21:25:50','2021-03-31 21:25:50'),(38,NULL,7,29,'Radio Mechanic','2021-03-31 21:25:50','2021-03-31 21:25:50'),(39,11,NULL,14,'Art Director','2021-03-31 21:25:50','2021-03-31 21:25:50'),(40,12,NULL,25,'Claims Taker','2021-03-31 21:25:50','2021-03-31 21:25:50');

--
-- Dumping data for table `failed_jobs`
--


--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2014_10_12_000000_create_users_table',1),(19,'2014_10_12_100000_create_password_resets_table',1),(20,'2019_08_19_000000_create_failed_jobs_table',1),(21,'2021_03_05_043128_create_tasks_table',1),(22,'2021_03_07_112941_create_admin_table',1),(23,'2021_03_08_102237_create_projects_table',1),(24,'2021_03_10_192412_add_role_column_to_users_table',2),(25,'2021_03_15_032522_create_criterias_table',3),(26,'2021_03_15_083119_create_reports_table',4),(27,'2021_03_16_073643_create_type_of_report_table',5),(28,'2021_03_16_075549_create_report_types_table',6),(29,'2021_03_16_081115_create_report_types_table',7),(30,'2021_03_16_081955_create_report_types_table',8),(31,'2021_03_17_023550_create_report_types_table',9),(32,'2021_03_17_033027_create_report_types_table',10),(33,'2021_03_17_033049_create_report_types_table',11),(34,'2021_03_17_084832_create_tasks_table',12),(35,'2021_03_17_104245_create_criteria_table',13),(36,'2021_03_18_032325_create_reports_table',14),(37,'2021_03_18_034705_create_criteria_types_table',15),(38,'2021_03_18_074708_create_comments_table',16),(39,'2021_03_19_034208_create_status_table',17),(40,'2021_03_19_070910_create_comments_table',18),(41,'2021_03_19_021038_create_documents_table',19),(42,'2021_03_19_064137_create_work_processes_table',20),(43,'2021_03_21_021955_create_departments_table',20),(44,'2021_03_21_025106_create_positions_table',20),(45,'2021_03_21_030552_create_salaries_table',20),(46,'2021_03_21_034129_create_education_levels_table',20),(47,'2021_03_21_073951_create_salaries_table',21),(48,'2021_03_22_022638_alter_users_table',22),(49,'2021_03_22_030948_create_work_processes_table',22),(50,'2021_03_29_071915_create_sessions_table',23),(51,'2021_03_29_081428_create_evaluation_table',23),(52,'2021_03_30_014125_create_rankings_table',24),(53,'2021_03_31_040654_create_rankings_table',25),(54,'2021_03_31_041222_create_evaluation_table',25),(55,'2021_03_31_080826_create_work_processes_table',26),(56,'2021_03_31_152540_create_rankings_table',27),(57,'2021_04_02_103349_alter_tasks_table',28),(58,'2021_04_07_125750_create_criteria_table',29);

--
-- Dumping data for table `password_resets`
--


--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `position_name`, `description`, `salary_id`, `created_at`, `updated_at`) VALUES (1,'pos1','q7hd9q9qwdhndk3',1,'2021-03-21 00:24:42','2021-03-21 00:24:42'),(2,'pos2','4as4d8asdas4d12das12d',3,'2021-03-21 00:25:01','2021-03-21 00:25:01'),(3,'pos3','qwe15311wq1sa3',2,'2021-03-21 00:25:26','2021-03-21 00:25:26'),(4,'pos4','98ehfnsqxefqnec',4,'2021-03-21 00:25:46','2021-03-21 00:25:46');

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `project_name`, `description`, `created_at`, `updated_at`) VALUES (1,8,'Dr.','Molestiae quae et est in eius ab. Quos rem recusandae eos aliquam dolores. Doloremque iste quae ex excepturi. Ut est ullam esse harum deleniti.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(2,9,'Dr.','In ratione recusandae et aliquam eaque consequatur est quia. Quo consectetur commodi unde labore. Perferendis debitis voluptatum laboriosam ipsam sed exercitationem. Provident doloremque ipsam adipisci mollitia magni eum accusamus. Quia aspernatur aut dolorem.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(3,5,'Miss','Tempore et et debitis ea. Aliquam autem voluptatem qui qui architecto ut aut inventore. Est recusandae quam iste sed pariatur perspiciatis sapiente.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(4,2,'Mr.','Deserunt atque cupiditate numquam autem. Doloribus dolorum occaecati quidem corporis a natus corrupti culpa. Et impedit perferendis autem iusto harum animi sit.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(5,6,'Ms.','Exercitationem porro ut doloremque ab in molestiae illo. Placeat similique voluptas unde et minus. Similique culpa atque nisi ut pariatur. Dolore alias eius quas dolor ea. Repudiandae recusandae beatae in numquam.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(6,7,'Prof.','Culpa officiis quibusdam nemo omnis ut qui rerum voluptatem. Praesentium est sit est non sit cupiditate.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(7,10,'Mrs.','Nam ut rerum cumque qui quia qui qui. Et sint voluptatem voluptates dolorem nostrum. Consectetur quia expedita perferendis sed.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(8,4,'Dr.','Suscipit aut tempore sunt iste est id. Assumenda architecto ducimus distinctio voluptatem eum fuga. Voluptas deleniti porro quia enim est.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(9,9,'Prof.','Molestiae adipisci sit quisquam aut ut libero dolorum deleniti. Molestiae eius ut eos sed ut. Atque aliquid perferendis ex qui provident debitis quis. Et consequatur dolores unde quasi ut qui. Exercitationem ut praesentium cupiditate ut enim temporibus.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(10,2,'Prof.','Molestiae sint in pariatur occaecati esse et. Culpa quibusdam quisquam neque molestias. Sed omnis ipsam sunt nemo aut et.','2021-03-15 00:37:21','2021-03-15 00:37:21'),(11,1,'asdnsd','alshdioashdiasdhsaoid','2021-03-15 00:56:37','2021-03-15 00:56:37');

--
-- Dumping data for table `rankings`
--

INSERT INTO `rankings` (`id`, `user_id`, `rank_by_task_criteria_score`, `rank_by_user_criteria_score`, `total_rank`, `created_at`, `updated_at`) VALUES (1,10,6,3,5,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(2,1,1,5,1,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(3,8,9,2,6,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(4,3,4,9,8,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(5,6,8,10,9,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(6,5,10,8,10,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(7,9,2,7,3,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(8,2,3,4,2,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(9,4,5,6,7,'2021-04-06 01:32:34','2021-04-06 01:32:34'),(10,7,7,1,4,'2021-04-06 01:32:34','2021-04-06 01:32:34');

--
-- Dumping data for table `report_types`
--

INSERT INTO `report_types` (`id`, `type_id`, `type_name`, `content`, `created_at`, `updated_at`) VALUES (1,1,'Project','test project report','2021-03-16 20:31:57','2021-03-16 20:31:57'),(2,2,'Task','test task report','2021-03-16 20:32:03','2021-03-16 20:32:03');

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `title`, `content`, `type_id`, `user_id`, `task_id`, `project_id`, `created_at`, `updated_at`) VALUES (1,'f4a894fsasas488','v4Asv56asd18asd4asd5',2,1,NULL,3,'2021-03-17 20:34:01','2021-03-17 20:34:01'),(2,'78gwibsdocgdqyvshasb','9ea4194sdas4dasdasd',2,1,1,1,'2021-03-17 20:36:39','2021-03-17 20:36:39'),(3,'nas9dg9qwguibsniob','87agdvashdvyasd',1,1,5,4,'2021-03-17 20:37:17','2021-03-17 20:37:17'),(4,'e5dcughibu9ct8','m9uy7f68tvh',2,1,8,NULL,'2021-03-17 20:37:47','2021-03-17 20:37:47'),(5,'3a49s4fasf','23wfdsghteh',1,1,4,2,'2021-03-17 20:38:35','2021-03-17 20:38:35');

--
-- Dumping data for table `salaries`
--

INSERT INTO `salaries` (`id`, `salary_scale`, `basic_salary`, `allowance_coefficient`, `created_at`, `updated_at`) VALUES (1,1,10000000,0.1,'2021-03-21 00:43:15','2021-03-21 00:43:15'),(2,1,15000000,0.2,'2021-03-21 00:43:46','2021-03-21 00:43:46'),(3,1,30000000,0.5,'2021-03-21 00:44:21','2021-03-21 00:44:21'),(4,1,20000000,0.3,'2021-03-21 00:44:52','2021-03-21 00:44:52');

--
-- Dumping data for table `sessions`
--


--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `name`, `type_id`, `created_at`, `updated_at`) VALUES (1,'ToDo',1,'2021-03-18 23:18:41','2021-03-18 23:18:41'),(2,'Doing',2,'2021-03-18 23:18:53','2021-03-18 23:18:53'),(3,'Done',3,'2021-03-18 23:19:03','2021-03-18 23:19:03');

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `task_name`, `description`, `user_id`, `project_id`, `assignee_id`, `start_date`, `end_date`, `status_id`, `qa_id`, `priority`, `created_at`, `updated_at`) VALUES (1,'Mckenna Predovic','Psychology Teacher',4,4,1,'2024-09-15','2025-03-18',1,38,'Normal','2021-04-02 03:40:04','2021-04-02 03:40:04'),(2,'Felipe Mosciski','Foundry Mold and Coremaker',9,3,10,'2024-04-08','2024-05-16',1,25,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(3,'Rhiannon Flatley','Counselor',1,3,8,'2022-01-01','2023-01-11',3,23,'Low','2021-04-02 03:40:04','2021-04-02 03:40:04'),(4,'Mr. Jules Goodwin III','Electrical Power-Line Installer',5,9,1,'2022-05-19','2024-11-03',1,35,'Low','2021-04-02 03:40:04','2021-04-02 03:40:04'),(5,'Miss Ora Davis DDS','Plumber',10,4,7,'2023-01-03','2024-03-28',2,50,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(6,'Jade Mohr','Animal Trainer',2,9,10,'2022-09-08','2024-01-30',3,29,'Normal','2021-04-02 03:40:04','2021-04-02 03:40:04'),(7,'Edyth Borer','Medical Appliance Technician',2,10,6,'2024-09-17','2025-03-20',1,5,'Low','2021-04-02 03:40:04','2021-04-02 03:40:04'),(8,'Jannie Brakus','Civil Drafter',1,8,2,'2023-08-14','2024-08-31',2,38,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(9,'Garnet Cremin','Nursing Aide',9,7,9,'2023-03-14','2023-08-06',3,45,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(10,'Tess Ferry','Wellhead Pumper',7,10,6,'2023-02-16','2025-01-06',1,16,'Low','2021-04-02 03:40:04','2021-04-02 03:40:04'),(11,'Mrs. Candice Streich III','Irradiated-Fuel Handler',6,3,10,'2024-03-24','2025-02-05',2,49,'Normal','2021-04-02 03:40:04','2021-04-02 03:40:04'),(12,'Scot O\'Kon','Data Entry Operator',9,9,7,'2022-09-20','2024-08-07',3,8,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(13,'Prof. Jerod Johns III','Payroll Clerk',1,6,8,'2024-03-27','2024-09-04',3,47,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(14,'Leanna Medhurst','Forest and Conservation Technician',10,6,4,'2023-02-02','2023-08-09',1,10,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(15,'Clemens Schuster','Fishery Worker',3,3,8,'2023-06-09','2024-12-18',3,18,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(16,'Dr. Amos Watsica PhD','Computer Systems Analyst',8,1,5,'2022-07-14','2022-12-17',2,44,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(17,'Fausto Glover','Night Security Guard',1,10,7,'2022-03-31','2023-07-16',3,23,'Normal','2021-04-02 03:40:04','2021-04-02 03:40:04'),(18,'Ms. Jessika Fahey','Industrial-Organizational Psychologist',6,2,2,'2022-11-09','2024-06-18',3,11,'High','2021-04-02 03:40:04','2021-04-02 03:40:04'),(19,'Deangelo Prohaska','Transportation Manager',2,1,2,'2023-06-27','2024-09-25',2,9,'Normal','2021-04-02 03:40:04','2021-04-02 03:40:04'),(20,'Merritt Schimmel','General Practitioner',3,6,8,'2021-05-21','2023-12-04',1,32,'Normal','2021-04-02 03:40:04','2021-04-02 03:40:04');

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `phone`, `gender`, `dob`, `position_id`, `education_level_id`, `department_id`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES (1,'Jessy Jast III','cecile73@example.org','2021-03-09 04:30:16','916-612-9537','female','1964-07-03',2,1,3,'$2y$10$uLg1cVBhcxTa0YWu0NNN3OlfKJuX0zeiEdQDNSqs9IWnTPAMdVKWC',4,'0YUULCY73PDrhCPN1W3oTAygJNrciUX5bpZxFTBWzE7vyjtWMFnSNqkiha4c','2021-03-09 04:30:16','2021-03-09 04:30:16'),(2,'Prof. Dewitt Rutherford V','qaufderhar@example.net','2021-03-09 04:30:16','704-902-9852','male','1965-01-02',1,1,2,'$2y$10$G5LPbPUyHryLK1gy58YdQOBAW0iuijZuzv6aUKldPUAnWc9/Ej98q',0,'Zdu2fI4vJr','2021-03-09 04:30:16','2021-03-09 04:30:16'),(3,'Orion McKenzie','ckoelpin@example.org','2021-03-09 04:30:16','863-913-6344','male','1970-04-21',4,4,4,'$2y$10$rOOGNbde6EryzgeUamlH0ePGpLWnMoOjr/tab.eTYW/iTt2igbz6C',0,'1ktGFwqrXp','2021-03-09 04:30:16','2021-03-09 04:30:16'),(4,'Angelita Senger','tyson.mante@example.org','2021-03-14 06:10:25','443-800-1706','female','1974-04-01',3,2,1,'$2y$10$wrDgoigVIC6Z7PQeuPwE2eDZhJHIlqi4PkflDqB0mb/fWn9ZbxVhi',1,'o0j2s9kcUf','2021-03-14 06:10:25','2021-03-14 06:10:25'),(5,'Rahsaan Hackett III','mcdermott.natalia@example.net','2021-03-14 06:10:25','402-677-2469','male','1974-04-24',1,3,5,'$2y$10$55bZEnljDIrvTZ7uXbsWvueWCkfoxGbaQ5y6luU9CdDp9fISjVOZG',3,'JC3vACvhUM','2021-03-14 06:10:25','2021-03-14 06:10:25'),(6,'Rhiannon Wolff','jessika.huel@example.net','2021-03-14 06:10:25','785-432-7159','female','1974-06-21',1,2,2,'$2y$10$qtXfbdclwuJnrdNpAYavROY.7X2LKkDO80Ytf9AZdxqvgZZMcrtCW',4,'6pYMvbGT58','2021-03-14 06:10:25','2021-03-14 06:10:25'),(7,'Horacio Funk III','zabshire@example.org','2021-03-14 06:10:25','904-718-3342','male','1978-12-13',4,1,3,'$2y$10$AVFkyuBo1gOgGUsHdV.GQeB8Rt7n33WHMzBfsrO4KZ6GBmK2eDy1.',3,'bWllop7aAR','2021-03-14 06:10:25','2021-03-14 06:10:25'),(8,'Alison Huels PhD','celia.senger@example.org','2021-03-14 06:10:25','317-489-5444','male','1981-12-26',2,4,1,'$2y$10$0i.TQ8QfCqoJmcpS3nhPCe5Nl3Sf2XketLBNy5jPL7qj8CGqDf5Ye',1,'9FuOsolR2I','2021-03-14 06:10:25','2021-03-14 06:10:25'),(9,'Wallace Beer','mrutherford@example.net','2021-03-14 06:10:25','469-441-9729','male','1985-10-21',3,3,5,'$2y$10$YNZwS7812QCYlPttH5MRpu6KayBYMU2PNetP6i.E1RglXDceqtEuu',2,'IQH2OAaAjw','2021-03-14 06:10:25','2021-03-14 06:10:25'),(10,'Tony Ferguson','asiyowbas@example.org','2021-04-01 02:33:25','951-025-147','male','1990-08-03',2,2,4,'$2y$10$YNZwS7812QCYlPttH5MRpu6KayBYMU2PNetP6i.E1RglXDceqtEuu',1,'8finoiONSNLb','2021-04-01 02:33:25','2021-04-01 02:33:25');

--
-- Dumping data for table `work_processes`
--

INSERT INTO `work_processes` (`process_name`, `process_id`, `status_id`, `next_status_id`, `prev_status_id`, `department_id`, `created_at`, `updated_at`) VALUES ('asdasd',1,2,3,1,1,NULL,NULL),('2ewrfv',2,5,6,4,3,NULL,NULL),('bvfcd',3,8,9,7,2,NULL,NULL),('sdh796',4,2,7,1,4,NULL,NULL),('loikujh',5,4,9,3,8,NULL,NULL);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-20 14:20:49
