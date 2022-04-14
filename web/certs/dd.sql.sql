/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE IF NOT EXISTS `activeconn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `radcheck_id` int(11) NOT NULL,
  `ipsec_conn` int(11) DEFAULT 0,
  `opvn_conn` int(11) DEFAULT 0,
  `wg_conn` int(11) DEFAULT 0,
  `serv_ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=123971 DEFAULT CHARSET=utf8mb4;

DELETE FROM `activeconn`;
/*!40000 ALTER TABLE `activeconn` DISABLE KEYS */;
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(48405, 71, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(49209, 71, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119164, 66, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119165, 78, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119166, 29, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119167, 73, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119168, 67, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119169, 79, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119170, 31, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119171, 74, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119182, 80, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119183, 68, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119197, 32, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119198, 75, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119199, 1, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119200, 69, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119201, 81, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119202, 63, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119203, 76, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119204, 70, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119205, 15, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119206, 64, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119207, 77, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119208, 25, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(119209, 72, 0, 0, 0, '45.137.152.70');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123948, 1, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123949, 15, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123950, 25, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123951, 29, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123952, 31, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123953, 32, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123954, 63, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123955, 64, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123956, 66, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123957, 67, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123958, 68, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123959, 69, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123960, 70, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123961, 72, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123962, 73, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123963, 74, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123964, 75, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123965, 76, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123966, 77, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123967, 78, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123968, 79, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123969, 80, 0, 0, 0, '45.135.164.160');
INSERT INTO `activeconn` (`id`, `radcheck_id`, `ipsec_conn`, `opvn_conn`, `wg_conn`, `serv_ip`) VALUES
	(123970, 81, 0, 0, 0, '45.135.164.160');
/*!40000 ALTER TABLE `activeconn` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
