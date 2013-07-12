CREATE TABLE IF NOT EXISTS `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=Innodb  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`first_name`, `last_name`, `phone`, `email`) VALUES
('Martin', 'Weaver', '870-481-7683', 'martin@evanscorporation.net'),
('Manuel', 'Gardner', '870-403-7325', 'manuel@chavezcompany.com'),
('Sarah', 'Perez', '501-118-9366', 'sarah@barnessales.com'),
('Randall', 'Freeman', '757-878-7998', 'randall@ramosplumbing.us'),
('Judy', 'Ross', '812-482-2054', 'judy@mendozafurniture.us'),
('Martha', 'Jackson', '918-576-4385', 'martha@kingcompany.net'),
('Lee', 'Owens', '870-972-0921', 'lee@simmonsgroup.com'),
('Adam', 'Cook', '515-972-6209', 'adam@austingroup.net'),
('Lois', 'Mills', '765-186-7028', 'lois@harperplumbing.com'),
('Vera', 'Ryan', '559-764-0111', 'vera@perrygroup.net'),
('Derrick', 'King', '870-444-4707', 'derrick@jordanplumbing.com'),
('Amy', 'Armstrong', '717-905-7181', 'amy@greeneincorporated.net'),
('April', 'Hanson', '870-726-5976', 'april@hartauto.us'),
('Joel', 'Thomas', '501-820-7226', 'joel@ryancompany.com'),
('Rose', 'Fowler', '956-122-0342', 'rose@fowlerfurniture.us'),
('Jamie', 'Gonzales', '212-341-0036', 'jamie@bryantauto.us'),
('Suzanne', 'Barnes', '816-609-0785', 'suzanne@hendersonflowers.com'),
('Sharon', 'Sanders', '315-816-3208', 'sharon@mitchellbooks.com'),
('Doris', 'Evans', '870-891-3198', 'doris@evanssales.us'),
('Adam', 'Diaz', '479-330-6147', 'adam@andrewsplumbing.net'),
('Erica', 'Shaw', '812-571-0047', 'erica@greenefurniture.us'),
('Gene', 'Richards', '870-435-2294', 'gene@snyderincorporated.com'),
('Thelma', 'Morrison', '501-276-1724', 'thelma@bryantsales.com'),
('Vera', 'Marshall', '870-689-1208', 'vera@phillipsfurniture.us'),
('Leon', 'Hudson', '323-682-8453', 'leon@harperfoods.com'),
('Alicia', 'Ellis', '501-294-8680', 'alicia@schmidtroofing.us'),
('Alexander', 'Hart', '870-153-8606', 'alexander@edwardsgroup.com'),
('Jean', 'Pierce', '410-783-6577', 'jean@washingtongroup.net'),
('Joanne', 'Hart', '940-239-7752', 'joanne@cunninghamfurniture.us'),
('Judith', 'Hart', '843-974-5505', 'judith@burnssales.com'),
('Rachel', 'Hanson', '845-353-9384', 'rachel@perezincorporated.com'),
('Sara', 'Martinez', '870-547-4973', 'sara@myersandsons.net'),
('Sarah', 'Elliott', '910-175-2367', 'sarah@evansfurniture.us'),
('Ana', 'Johnston', '870-105-4077', 'ana@jonesandsons.net'),
('Teresa', 'Dunn', '870-415-6089', 'teresa@fowlerandsons.net'),
('Ethel', 'Payne', '504-979-4563', 'ethel@nguyenroofing.com'),
('David', 'Taylor', '501-809-0150', 'david@taylorfoods.us'),
('Debra', 'Palmer', '510-366-3574', 'debra@brownfoods.net'),
('Bryan', 'Harrison', '870-330-5885', 'bryan@reynoldsflowers.com'),
('Lynn', 'George', '317-484-6522', 'lynn@hicksfoods.us'),
('Bessie', 'Moore', '518-749-5754', 'bessie@kelleyfurniture.net'),
('Kevin', 'Cole', '000-690-8010', 'kevin@gardnersales.us'),
('Agnes', 'Green', '479-996-7329', 'agnes@reedplumbing.net'),
('Sean', 'Long', '505-721-5162', 'sean@whitefurniture.net'),
('Doris', 'Evans', '870-249-8534', 'doris@cookroofing.com'),
('Dennis', 'Day', '870-206-2280', 'dennis@morrisonplumbing.us'),
('Oscar', 'Morrison', '870-382-5340', 'oscar@hudsonroofing.us'),
('Elaine', 'Howell', '501-875-3723', 'elaine@foxgroup.net'),
('Steve', 'Daniels', '501-330-2460', 'steve@henrygroup.net'),
('Megan', 'Lopez', '479-911-5670', 'megan@leeandsons.net'),
('Darryl', 'Nichols', '717-203-0369', 'darryl@berrybooks.us'),
('Katherine', 'Black', '585-596-0239', 'katherine@colemanauto.com'),
('Esther', 'Jenkins', '479-958-2345', 'esther@lawsonsales.us'),
('Mildred', 'George', '870-478-3945', 'mildred@evansgroup.us'),
('Mark', 'George', '915-754-1518', 'mark@rossauto.us'),
('Ruth', 'Greene', '870-615-6031', 'ruth@stephensauto.com'),
('Sandra', 'Gibson', '859-164-4746', 'sandra@schmidtfoods.us'),
('Brian', 'Taylor', '513-500-8664', 'brian@petersonfoods.com'),
('Bryan', 'Shaw', '479-498-7538', 'bryan@chavezroofing.com'),
('Herman', 'Ross', '787-682-1498', 'herman@lewissales.us'),
('Darryl', 'Burke', '501-838-7955', 'darryl@gibsoncompany.com'),
('Sean', 'Lawrence', '870-628-0432', 'sean@martinsales.com'),
('Troy', 'Burke', '870-735-1443', 'troy@johnstonauto.us'),
('Matthew', 'Jacobs', '518-412-9841', 'matthew@coxandsons.net'),
('Fred', 'Little', '318-301-1758', 'fred@littleflowers.net'),
('Jeremy', 'Ward', '317-531-1457', 'jeremy@spencerandsons.net'),
('Lynn', 'Robertson', '707-243-7160', 'lynn@millerandsons.net'),
('Elaine', 'Knight', '501-339-8571', 'elaine@knightfurniture.com'),
('Brenda', 'Austin', '815-569-5241', 'brenda@johnstongroup.us'),
('Wayne', 'Payne', '501-235-6188', 'wayne@colemansales.com'),
('Russell', 'Warren', '870-133-6422', 'russell@warrengroup.us'),
('Jim', 'Jones', '478-538-0411', 'jim@hernandezroofing.com'),
('Katie', 'Parker', '501-614-2681', 'katie@moorebooks.us'),
('Stephen', 'Austin', '870-788-8511', 'stephen@kelleysales.net'),
('Annie', 'Jones', '916-304-9881', 'annie@burtonsales.us'),
('Juanita', 'Gilbert', '501-191-1323', 'juanita@brooksplumbing.us'),
('Vivian', 'Snyder', '714-866-8098', 'vivian@oliverbooks.us'),
('Janice', 'Rice', '207-395-5674', 'janice@reynoldsfurniture.com'),
('Anna', 'Wilson', '870-770-0210', 'anna@lawsonincorporated.us'),
('Pamela', 'Lewis', '870-696-6462', 'pamela@fullergroup.com'),
('Mike', 'Shaw', '870-914-9280', 'mike@jacobssales.com'),
('Maria', 'Wells', '870-583-0604', 'maria@bowmanandsons.us'),
('Gail', 'Bradley', '231-395-7398', 'gail@hicksplumbing.net'),
('Tiffany', 'Johnston', '201-229-4232', 'tiffany@holmessales.net'),
('Jose', 'Hayes', '785-949-2354', 'jose@grantplumbing.us'),
('Edith', 'Jones', '318-997-2917', 'edith@rogersplumbing.net'),
('Alma', 'Bishop', '952-615-7131', 'alma@bishopcompany.us'),
('Denise', 'Moreno', '870-933-6816', 'denise@williamsoncorporation.us'),
('Lorraine', 'Anderson', '203-406-7845', 'lorraine@alexandercorporation.net'),
('Alvin', 'White', '501-986-0550', 'alvin@welchgroup.com'),
('Amber', 'Ferguson', '315-895-6643', 'amber@burtonfoods.com'),
('Jimmy', 'Carr', '336-379-5786', 'jimmy@millercompany.us'),
('George', 'Reynolds', '501-112-4014', 'george@campbellauto.com'),
('Marion', 'Freeman', '915-768-6587', 'marion@gordonsales.com'),
('Ramon', 'Nguyen', '409-383-0823', 'ramon@thompsongroup.us'),
('Amy', 'Elliott', '479-515-1704', 'amy@kennedyroofing.net'),
('Frances', 'Baker', '870-331-8951', 'frances@bakerflowers.net'),
('Dolores', 'Freeman', '479-653-9306', 'dolores@warrenfurniture.net'),
('Jeremy', 'Morrison', '870-941-2301', 'jeremy@reidplumbing.us'),
('Cecil', 'Boyd', '509-515-5985', 'cecil@willisgroup.us');