CREATE TABLE IF NOT EXISTS `#__jf_accessroles` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `system_access` tinyint(4) NOT NULL,
  `can_see_private_objects` tinyint(4) NOT NULL,
  `can_assign` tinyint(4) NOT NULL,
  `can_be_assigned_leads` tinyint(4) NOT NULL,
  `can_be_assigned_tickets` tinyint(4) NOT NULL,
  `can_access_messages` tinyint(4) NOT NULL,
  `can_view_reports` tinyint(4) NOT NULL,
  `project` tinyint(4) NOT NULL,
  `lead` tinyint(4) NOT NULL,
  `person` tinyint(4) NOT NULL,
  `company` tinyint(4) NOT NULL,
  `campaign` tinyint(4) NOT NULL,
  `potential` tinyint(4) NOT NULL,
  `global_quote` tinyint(4) NOT NULL,
  `global_invoice` tinyint(4) NOT NULL,
  `global_ticket` tinyint(4) NOT NULL,
  `milestone` tinyint(4) NOT NULL,
  `checklist` tinyint(4) NOT NULL,
  `timetracker` tinyint(4) NOT NULL,
  `document` tinyint(4) NOT NULL,
  `ticket` tinyint(4) NOT NULL,
  `discussion` tinyint(4) NOT NULL,
  `quote` tinyint(4) NOT NULL,
  `invoice` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_campaigns` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `status` varchar(255) default NULL,
  `expectedclose` datetime default NULL,
  `type` varchar(255) default NULL,
  `audience` varchar(255) default NULL,
  `sponsor` varchar(255) default NULL,
  `reach` varchar(255) default NULL,
  `ecost` varchar(255) default NULL,
  `acost` varchar(255) default NULL,
  `eresponse` varchar(255) default NULL,
  `aresponse` varchar(255) default NULL,
  `erevenue` varchar(255) default NULL,
  `arevenue` varchar(255) default NULL,
  `eroi` varchar(255) default NULL,
  `aroi` varchar(255) default NULL,
  `description` text,
  `tags` varchar(255) default NULL,
  `published` tinyint(2) default NULL,
  `visibility` tinyint(2) default NULL,
  `author` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `attachments` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_checklists` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `description` text,
  `visibility` tinyint(2) NOT NULL,
  `milestone` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `completed` tinyint(4) default NULL,
  `reopened` tinyint(4) NOT NULL,
  `datecompleted` datetime NOT NULL,
  `datereopened` datetime NOT NULL,
  `completedby` int(11) NOT NULL,
  `reopenedby` int(11) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` int(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_comments` (
  `id` int(11) NOT NULL auto_increment,
  `discussion` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `quote` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `campaign` int(11) NOT NULL,
  `potential` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `message` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_companies` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `fax` varchar(100) NOT NULL,
  `homepage` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `enabled` tinyint(2) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `admin` tinyint(2) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_configuration` (
  `id` int(11) NOT NULL auto_increment,
  `status` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `supportcategories` varchar(255) NOT NULL,
  `quotetemplate` text NOT NULL,
  `tax` varchar(255) NOT NULL,
  `tax_enabled` tinyint(4) NOT NULL,
  `currency` varchar(10) NOT NULL,
  `emailsubject` text NOT NULL,
  `emailbody` text NOT NULL,
  `generalcategories` varchar(255) NOT NULL,
  `invoicetemplate` text NOT NULL,
  `showhelp` tinyint(2) NOT NULL,
  `sales_stages` varchar(255) default NULL,
  `lead_status` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_customfields` (
  `id` int(11) NOT NULL auto_increment,
  `field` varchar(255) NOT NULL,
  `fieldtype` varchar(255) NOT NULL,
  `values` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `required` tinyint(4) NOT NULL,
  `public` tinyint(2) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_customfields_cf` (
  `id` int(11) NOT NULL auto_increment,
  `fid` int(11) NOT NULL,
  `cfid` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_discussions` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `message` text,
  `visibility` tinyint(2) NOT NULL,
  `category` varchar(255) NOT NULL,
  `milestone` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `attachments` int(11) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_documents` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `visibility` tinyint(4) NOT NULL,
  `category` varchar(255) NOT NULL,
  `milestone` int(11) NOT NULL,
  `discussion` int(11) NOT NULL,
  `comment` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `attachment` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_files` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `filelocation` varchar(255) NOT NULL,
  `filetype` varchar(255) NOT NULL,
  `image` tinyint(4) NOT NULL,
  `filesize` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_invoices` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `milestone` int(11) NOT NULL,
  `checklist` int(11) NOT NULL,
  `quote` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `validtill` date default NULL,
  `publishdate` date NOT NULL,
  `published` tinyint(2) NOT NULL,
  `payment_method` int(255) NOT NULL,
  `paid` tinyint(2) NOT NULL,
  `subtotal` float NOT NULL,
  `tax` float NOT NULL,
  `total` float NOT NULL,
  `viewed` tinyint(2) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `discount` float default NULL,
  `tags` varchar(255) NOT NULL,
  `visibility` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_leads` (
  `id` int(11) NOT NULL auto_increment,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `office_phone` varchar(255) NOT NULL,
  `home_phone` varchar(255) NOT NULL,
  `cell_phone` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `source` int(11) NOT NULL,
  `do_not_contact` tinyint(2) NOT NULL,
  `converted` tinyint(2) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(4) NOT NULL,
  `manager` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_messages` (
  `id` int(11) NOT NULL auto_increment,
  `to` int(11) NOT NULL,
  `from` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text,
  `created` datetime default NULL,
  `read` int(11) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_milestones` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `startdate` date default NULL,
  `duedate` date default NULL,
  `notes` text,
  `summary` text,
  `completed` tinyint(2) NOT NULL,
  `reopened` tinyint(2) NOT NULL,
  `datereopened` datetime default NULL,
  `datecompleted` datetime default NULL,
  `completedby` int(11) NOT NULL,
  `reopenedby` int(11) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_notes` (
  `id` int(11) NOT NULL auto_increment,
  `lead` int(11) NOT NULL,
  `note` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_objectviews` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `object` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_persons` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `systemrole` int(11) NOT NULL,
  `projectrole` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `auto_add` varchar(100) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `lead` tinyint(4) NOT NULL,
  `lead_company` varchar(255) NOT NULL,
  `converted` tinyint(4) NOT NULL,
  `published` tinyint(2) NOT NULL,
  `key` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `author` varchar(255) default NULL,
  `authoremail` varchar(255) NOT NULL,
  `published` int(11) default NULL,
  `default` tinyint(4) default NULL,
  `folder` varchar(255) default NULL,
  `link` tinyint(4) NOT NULL,
  `params` text,
  `type` varchar(255) NOT NULL,
  `ordering` int(11) NOT NULL,
  `authorurl` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `copyright` varchar(255) NOT NULL,
  `license` varchar(255) NOT NULL,
  `creationdate` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_potentials` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` text,
  `lead` int(11) default NULL,
  `company` int(11) default NULL,
  `campaign` int(11) default NULL,
  `closedate` datetime default NULL,
  `nextstep` varchar(255) default NULL,
  `salesstage` varchar(255) default NULL,
  `probability` varchar(255) default NULL,
  `amount` varchar(255) default NULL,
  `tags` varchar(255) default NULL,
  `published` tinyint(2) default NULL,
  `visibility` tinyint(2) default NULL,
  `author` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_projectroles` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `milestone` tinyint(2) NOT NULL,
  `checklist` tinyint(2) NOT NULL,
  `timetracker` tinyint(2) NOT NULL,
  `document` tinyint(2) NOT NULL,
  `ticket` tinyint(2) NOT NULL,
  `discussion` tinyint(2) NOT NULL,
  `quote` tinyint(4) NOT NULL,
  `invoice` tinyint(4) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_projectroles_cf` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `milestone` tinyint(2) NOT NULL,
  `checklist` tinyint(2) NOT NULL,
  `timetracker` tinyint(2) NOT NULL,
  `document` tinyint(2) NOT NULL,
  `ticket` tinyint(2) NOT NULL,
  `discussion` tinyint(2) NOT NULL,
  `quote` tinyint(4) NOT NULL,
  `invoice` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_projects` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  `author` int(11) NOT NULL,
  `leader` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `imagethumb` varchar(255) NOT NULL,
  `created` datetime default NULL,
  `startson` date NOT NULL,
  `modified` datetime default NULL,
  `alertmessage` varchar(255) NOT NULL,
  `published` tinyint(2) NOT NULL,
  `key` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_projecttemplates` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) default NULL,
  `description` text,
  `data` text,
  `published` tinyint(2) default NULL,
  `author` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_quotes` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `milestone` int(11) NOT NULL,
  `checklist` int(11) NOT NULL,
  `company` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `validtill` date default NULL,
  `published` tinyint(2) NOT NULL,
  `publishdate` date NOT NULL,
  `accepted` tinyint(2) NOT NULL,
  `subtotal` float NOT NULL,
  `discount` float NOT NULL,
  `tax` float NOT NULL,
  `total` float NOT NULL,
  `viewed` tinyint(2) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `interval` int(11) NOT NULL,
  `numinvoices` int(11) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `visibility` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_reports` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `search` text,
  `created` datetime default NULL,
  `lastrun` datetime default NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_services` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` varchar(100) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_services_cf` (
  `id` int(11) NOT NULL auto_increment,
  `service` int(11) NOT NULL,
  `quote` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `subtotal` float NOT NULL,
  `tax` float NOT NULL,
  `total` float NOT NULL,
  `discount` int(11) NOT NULL,
  `discount_type` varchar(255) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_subscriptions` (
  `id` int(11) NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `project` int(11) NOT NULL,
  `milestone` int(11) NOT NULL,
  `discussion` int(11) NOT NULL,
  `document` int(11) NOT NULL,
  `ticket` int(11) NOT NULL,
  `task` int(11) NOT NULL,
  `checklist` int(11) NOT NULL,
  `quote` int(11) NOT NULL,
  `invoice` int(11) NOT NULL,
  `assignment` tinyint(1) NOT NULL,
  `primary` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_systemroles` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `system_access` tinyint(2) NOT NULL,
  `can_see_private_objects` tinyint(2) NOT NULL,
  `can_assign` tinyint(2) NOT NULL,
  `can_be_assigned_leads` tinyint(2) NOT NULL,
  `can_be_assigned_tickets` tinyint(2) NOT NULL,
  `can_access_messages` tinyint(4) NOT NULL,
  `can_view_reports` tinyint(4) NOT NULL,
  `project` tinyint(4) NOT NULL,
  `lead` tinyint(4) NOT NULL,
  `person` tinyint(4) NOT NULL,
  `company` tinyint(4) NOT NULL,
  `campaign` tinyint(4) NOT NULL,
  `potential` tinyint(4) NOT NULL,
  `quote` tinyint(4) NOT NULL,
  `invoice` tinyint(4) NOT NULL,
  `ticket` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_tasks` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `duedate` date default NULL,
  `notify` tinyint(2) NOT NULL,
  `completed` tinyint(4) NOT NULL,
  `reopened` tinyint(4) NOT NULL,
  `completedby` int(11) NOT NULL,
  `reopenedby` int(11) NOT NULL,
  `datecompleted` datetime default NULL,
  `datereopened` datetime NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_tickets` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `description` text,
  `attachment` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `milestone` int(11) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `duedate` datetime default NULL,
  `resolved` tinyint(2) NOT NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  `author` int(11) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

CREATE TABLE IF NOT EXISTS `#__jf_timetracker` (
  `id` int(11) NOT NULL auto_increment,
  `pid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `date` datetime default NULL,
  `hours` varchar(100) NOT NULL,
  `summary` text,
  `billable` tinyint(2) NOT NULL,
  `billed` tinyint(2) NOT NULL,
  `task` int(11) NOT NULL,
  `published` tinyint(2) NOT NULL,
  PRIMARY KEY  (`id`)
);

