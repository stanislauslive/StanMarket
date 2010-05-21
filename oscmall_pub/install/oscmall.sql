DROP TABLE IF EXISTS address_book;
CREATE TABLE address_book (
  address_book_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  entry_gender char(1) NOT NULL default '',
  entry_company varchar(32) default NULL,
  entry_firstname varchar(32) NOT NULL default '',
  entry_lastname varchar(32) NOT NULL default '',
  entry_street_address varchar(64) NOT NULL default '',
  entry_postcode varchar(10) NOT NULL default '',
  entry_city varchar(32) NOT NULL default '',
  entry_state varchar(32) default NULL,
  entry_country_id int(11) NOT NULL default '0',
  entry_suburb varchar(32) NOT NULL default '',
  entry_zone_id int(11) NOT NULL default '0',
  PRIMARY KEY  (address_book_id),
  KEY idx_address_book_customers_id (customers_id)
) ENGINE=MyISAM;



INSERT INTO address_book (address_book_id, customers_id, entry_gender, entry_company, entry_firstname, entry_lastname, entry_street_address, entry_postcode, entry_city, entry_state, entry_country_id, entry_zone_id) VALUES (1, 1, 'M', 'SystemsManager Technologies', 'Peter', 'McGrath', '123 Here St.', '123456', 'Napanee', 'Ontario', 38, 74);


DROP TABLE IF EXISTS address_format;
CREATE TABLE address_format (
  address_format_id int(11) NOT NULL auto_increment,
  address_format varchar(128) NOT NULL default '',
  address_summary varchar(48) NOT NULL default '',
  PRIMARY KEY  (address_format_id)
) ENGINE=MyISAM;



INSERT INTO address_format (address_format_id, address_format, address_summary) VALUES (1, '$firstname $lastname$cr$streets$cr$city, $postcode$cr$statecomma$country', '$city / $country');
INSERT INTO address_format (address_format_id, address_format, address_summary) VALUES (2, '$firstname $lastname$cr$streets$cr$city, $state    $postcode$cr$country', '$city, $state / $country');
INSERT INTO address_format (address_format_id, address_format, address_summary) VALUES (3, '$firstname $lastname$cr$streets$cr$city$cr$postcode - $statecomma$country', '$state / $country');
INSERT INTO address_format (address_format_id, address_format, address_summary) VALUES (4, '$firstname $lastname$cr$streets$cr$city ($postcode)$cr$country', '$postcode / $country');
INSERT INTO address_format (address_format_id, address_format, address_summary) VALUES (5, '$firstname $lastname$cr$streets$cr$postcode $city$cr$country', '$city / $country');


DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
  admin_id int(11) NOT NULL auto_increment,
  admin_groups_id int(11) default NULL,
  store_id int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '1',
  admin_firstname varchar(32) NOT NULL default '',
  admin_lastname varchar(32) default NULL,
  admin_email_address varchar(96) NOT NULL default '',
  admin_password varchar(40) NOT NULL default '',
  admin_created datetime default NULL,
  admin_modified datetime NOT NULL default '0000-00-00 00:00:00',
  admin_logdate datetime default NULL,
  admin_lognum int(11) NOT NULL default '0',
  PRIMARY KEY  (admin_id),
  UNIQUE KEY admin_email_address (admin_email_address)
) ENGINE=MyISAM;



INSERT INTO admin (admin_id, admin_groups_id, store_id, customer_id, admin_firstname, admin_lastname, admin_email_address, admin_password, admin_created, admin_modified, admin_logdate, admin_lognum) VALUES (1, 1, 1, 1, 'AdminFirstname', 'AdminLastname', 'admin@localhost', '351683ea4e19efe34874b501fdbf9792:9b', '2003-07-30 00:45:42', '0000-00-00 00:00:00', '2006-03-09 20:41:06', 206);



DROP TABLE IF EXISTS admin_files;
CREATE TABLE admin_files (
  admin_files_id int(11) NOT NULL auto_increment,
  admin_files_name varchar(64) NOT NULL default '',
  admin_files_is_boxes tinyint(5) NOT NULL default '0',
  admin_files_is_tab tinyint(2) NOT NULL default '0',
  admin_tabs_to_files int(11) NOT NULL default '0',
  admin_files_to_boxes int(11) NOT NULL default '0',
  admin_groups_id set('1','2','3','4') NOT NULL default '1',
  PRIMARY KEY  (admin_files_id)
) ENGINE=MyISAM;

 

INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (1, 'administrator.php', 1, 0, 0, 0, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (2, 'configuration.php', 1, 0, 0, 0, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (3, 'catalog.php', 1, 0, 0, 0, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (4, 'modules.php', 1, 0, 0, 0, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (5, 'customers_info.php', 1, 0, 0, 0, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (6, 'taxes.php', 1, 0, 0, 0, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (7, 'localization.php', 1, 0, 0, 0, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (8, 'reports.php', 1, 0, 0, 0, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (9, 'tools.php', 1, 0, 0, 0, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (12, 'configuration.php', 0, 0, 0, 2, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (13, 'categories.php', 0, 0, 0, 3, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (14, 'products_attributes.php', 0, 0, 0, 3, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (15, 'manufacturers.php', 0, 0, 0, 3, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (16, 'reviews.php', 0, 0, 0, 3, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (17, 'specials.php', 0, 0, 0, 3, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (18, 'products_expected.php', 0, 0, 0, 3, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (19, 'modules.php', 0, 0, 0, 4, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (20, 'customers.php', 0, 0, 0, 5, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (21, 'orders.php', 0, 0, 0, 5, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (22, 'countries.php', 0, 0, 0, 6, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (23, 'zones.php', 0, 0, 0, 6, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (24, 'geo_zones.php', 0, 0, 0, 6, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (25, 'tax_classes.php', 0, 0, 0, 6, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (26, 'tax_rates.php', 0, 0, 0, 6, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (27, 'currencies.php', 0, 0, 0, 7, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (28, 'languages.php', 0, 0, 0, 7, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (29, 'orders_status.php', 0, 0, 0, 7, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (30, 'stats_products_viewed.php', 0, 0, 0, 8, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (31, 'stats_products_purchased.php', 0, 0, 0, 8, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (32, 'stats_customers.php', 0, 0, 0, 8, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (33, 'backup.php', 0, 0, 0, 9, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (34, 'banner_manager.php', 0, 0, 0, 9, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (35, 'cache.php', 0, 0, 0, 9, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (36, 'define_language.php', 0, 0, 0, 9, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (38, 'mail.php', 0, 0, 0, 9, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (39, 'newsletters.php', 0, 0, 0, 9, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (41, 'whos_online.php', 0, 0, 0, 9, '1,2');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (42, 'banner_statistics.php', 0, 0, 0, 9, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (43, 'layout.php', 1, 0, 0, 0, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (44, 'management.php', 0, 0, 0, 43, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (45, 'template.php', 0, 0, 0, 43, '1,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (46, 'text_editor.php', 0, 0, 0, 43, '1,2,3');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (47, 'affiliate.php', 1, 0, 0, 0, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (49, 'affiliate_affiliates.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (50, 'affiliate_banners.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (51, 'affiliate_clicks.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (52, 'affiliate_contact.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (53, 'affiliate_invoice.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (54, 'affiliate_news.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (55, 'affiliate_newsletters.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (56, 'affiliate_payment.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (57, 'affiliate_sales.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (58, 'affiliate_popup_image.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (59, 'affiliate_statistics.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (60, 'affiliate_statistics.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (61, 'affiliate_summary.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (62, 'affiliate_summary.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (63, 'affiliate_validproducts.php', 0, 0, 0, 47, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (64, 'gv_admin.php', 1, 0, 0, 0, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (65, 'coupon_admin.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (66, 'gv_mail.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (67, 'gv_queue.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (68, 'gv_sent.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (69, 'listcategories.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (70, 'listproducts.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (71, 'treeview.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (72, 'validcategories.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (73, 'validproducts.php', 0, 0, 0, 64, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (202, 'admin_members.php', 0, 0, 0, 1, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (214, 'tab_members.php', 0, 1, 211, 1, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (215, 'tab_groups.php', 0, 1, 211, 1, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (212, 'tab_files.php', 0, 1, 211, 1, '1');
INSERT INTO admin_files (admin_files_id, admin_files_name, admin_files_is_boxes, admin_files_is_tab, admin_tabs_to_files, admin_files_to_boxes, admin_groups_id) VALUES (211, 'admin.php', 0, 0, 0, 1, '1');



DROP TABLE IF EXISTS admin_groups;
CREATE TABLE admin_groups (
  admin_groups_id int(11) NOT NULL auto_increment,
  admin_groups_name varchar(64) default NULL,
  admin_groups_max_products smallint(6) NOT NULL default '0',
  admin_sales_cost decimal(15,4) NOT NULL default '0.0000',
  admin_groups_store_type tinyint(4) NOT NULL default '1',
  admin_groups_products_id smallint(6) NOT NULL default '0',
  PRIMARY KEY  (admin_groups_id),
  UNIQUE KEY admin_groups_name (admin_groups_name)
) ENGINE=MyISAM;



INSERT INTO admin_groups (admin_groups_id, admin_groups_name, admin_groups_max_products, admin_sales_cost, admin_groups_store_type, admin_groups_products_id) VALUES (1, 'Top Administrator', 0, 0.0000, 1, 0);
INSERT INTO admin_groups (admin_groups_id, admin_groups_name, admin_groups_max_products, admin_sales_cost, admin_groups_store_type, admin_groups_products_id) VALUES (2, 'Retail', 4, 5.0000, 2, 1);



DROP TABLE IF EXISTS affiliate_affiliate;
CREATE TABLE affiliate_affiliate (
  affiliate_id int(11) NOT NULL auto_increment,
  affiliate_customer_id int(11) NOT NULL default '0',
  affiliate_homepage varchar(96) NOT NULL default '',
  affiliate_agb tinyint(4) NOT NULL default '0',
  affiliate_company_taxid varchar(64) NOT NULL default '',
  affiliate_commission_percent decimal(4,2) NOT NULL default '0.00',
  affiliate_payment_check varchar(100) NOT NULL default '',
  affiliate_payment_paypal varchar(64) NOT NULL default '',
  affiliate_payment_bank_name varchar(64) NOT NULL default '',
  affiliate_payment_bank_branch_number varchar(64) NOT NULL default '',
  affiliate_payment_bank_swift_code varchar(64) NOT NULL default '',
  affiliate_payment_bank_account_name varchar(64) NOT NULL default '',
  affiliate_payment_bank_account_number varchar(64) NOT NULL default '',
  affiliate_lft int(11) NOT NULL default '0',
  affiliate_rgt int(11) NOT NULL default '0',
  affiliate_root int(11) NOT NULL default '0',
  affiliate_newsletter char(1) default NULL,
  PRIMARY KEY  (affiliate_id),
  KEY affiliate_customer_id (affiliate_customer_id)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS affiliate_banners;
CREATE TABLE affiliate_banners (
  affiliate_banners_id int(11) NOT NULL auto_increment,
  affiliate_banners_title varchar(64) NOT NULL default '',
  affiliate_products_id int(11) NOT NULL default '0',
  affiliate_banners_image varchar(64) NOT NULL default '',
  affiliate_banners_group varchar(10) NOT NULL default '',
  affiliate_category_id int(11) NOT NULL default '0',
  affiliate_banners_html_text text,
  affiliate_expires_impressions int(7) default '0',
  affiliate_expires_date datetime default NULL,
  affiliate_date_scheduled datetime default NULL,
  affiliate_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_date_status_change datetime default NULL,
  affiliate_status int(1) NOT NULL default '1',
  PRIMARY KEY  (affiliate_banners_id)
) ENGINE=MyISAM;

 

DROP TABLE IF EXISTS affiliate_banners_history;
CREATE TABLE affiliate_banners_history (
  affiliate_banners_history_id int(11) NOT NULL auto_increment,
  affiliate_banners_products_id int(11) NOT NULL default '0',
  affiliate_banners_id int(11) NOT NULL default '0',
  affiliate_banners_affiliate_id int(11) NOT NULL default '0',
  affiliate_banners_shown int(11) NOT NULL default '0',
  affiliate_banners_clicks tinyint(4) NOT NULL default '0',
  affiliate_banners_history_date date NOT NULL default '0000-00-00',
  PRIMARY KEY  (affiliate_banners_history_id,affiliate_banners_products_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS affiliate_clickthroughs;
CREATE TABLE affiliate_clickthroughs (
  affiliate_clickthrough_id int(11) NOT NULL auto_increment,
  affiliate_id int(11) NOT NULL default '0',
  affiliate_clientdate datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_clientbrowser varchar(200) default 'Could Not Find This Data',
  affiliate_clientip varchar(50) default 'Could Not Find This Data',
  affiliate_clientreferer varchar(200) default 'none detected (maybe a direct link)',
  affiliate_products_id int(11) default '0',
  affiliate_banner_id int(11) NOT NULL default '0',
  PRIMARY KEY  (affiliate_clickthrough_id),
  KEY refid (affiliate_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS affiliate_news;
CREATE TABLE affiliate_news (
  news_id int(11) NOT NULL auto_increment,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  news_status tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (news_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS affiliate_news_contents;
CREATE TABLE affiliate_news_contents (
  affiliate_news_contents_id int(11) NOT NULL auto_increment,
  affiliate_news_id int(11) NOT NULL default '0',
  affiliate_news_languages_id int(11) NOT NULL default '0',
  affiliate_news_headlines varchar(255) NOT NULL default '',
  affiliate_news_contents text NOT NULL,
  PRIMARY KEY  (affiliate_news_contents_id),
  KEY affiliate_news_id (affiliate_news_id),
  KEY affiliate_news_languages_id (affiliate_news_languages_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS affiliate_newsletters;
CREATE TABLE affiliate_newsletters (
  affiliate_newsletters_id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  content text NOT NULL,
  module varchar(255) NOT NULL default '',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  date_sent datetime default NULL,
  status int(1) default NULL,
  locked int(1) default '0',
  PRIMARY KEY  (affiliate_newsletters_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS affiliate_payment;
CREATE TABLE affiliate_payment (
  affiliate_payment_id int(11) NOT NULL auto_increment,
  affiliate_id int(11) NOT NULL default '0',
  affiliate_payment decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_tax decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_total decimal(15,2) NOT NULL default '0.00',
  affiliate_payment_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_status int(5) NOT NULL default '0',
  affiliate_firstname varchar(32) NOT NULL default '',
  affiliate_lastname varchar(32) NOT NULL default '',
  affiliate_street_address varchar(64) NOT NULL default '',
  affiliate_suburb varchar(64) NOT NULL default '',
  affiliate_city varchar(32) NOT NULL default '',
  affiliate_postcode varchar(10) NOT NULL default '',
  affiliate_country varchar(32) NOT NULL default '0',
  affiliate_company varchar(60) NOT NULL default '',
  affiliate_state varchar(32) NOT NULL default '0',
  affiliate_address_format_id int(5) NOT NULL default '0',
  affiliate_last_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (affiliate_payment_id)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS affiliate_payment_status;
CREATE TABLE affiliate_payment_status (
  affiliate_payment_status_id int(11) NOT NULL default '0',
  affiliate_language_id int(11) NOT NULL default '1',
  affiliate_payment_status_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (affiliate_payment_status_id,affiliate_language_id),
  KEY idx_affiliate_payment_status_name (affiliate_payment_status_name)
) ENGINE=MyISAM;



INSERT INTO affiliate_payment_status (affiliate_payment_status_id, affiliate_language_id, affiliate_payment_status_name) VALUES (0, 1, 'Pending');
INSERT INTO affiliate_payment_status (affiliate_payment_status_id, affiliate_language_id, affiliate_payment_status_name) VALUES (1, 1, 'Paid');



DROP TABLE IF EXISTS affiliate_payment_status_history;
CREATE TABLE affiliate_payment_status_history (
  affiliate_status_history_id int(11) NOT NULL auto_increment,
  affiliate_payment_id int(11) NOT NULL default '0',
  affiliate_new_value int(5) NOT NULL default '0',
  affiliate_old_value int(5) default NULL,
  affiliate_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_notified int(1) default '0',
  PRIMARY KEY  (affiliate_status_history_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS affiliate_sales;
CREATE TABLE affiliate_sales (
  affiliate_id int(11) NOT NULL default '0',
  affiliate_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_browser varchar(100) NOT NULL default '',
  affiliate_ipaddress varchar(20) NOT NULL default '',
  affiliate_orders_id int(11) NOT NULL default '0',
  affiliate_value decimal(15,2) NOT NULL default '0.00',
  affiliate_payment decimal(15,2) NOT NULL default '0.00',
  affiliate_clickthroughs_id int(11) NOT NULL default '0',
  affiliate_billing_status int(5) NOT NULL default '0',
  affiliate_payment_date datetime NOT NULL default '0000-00-00 00:00:00',
  affiliate_payment_id int(11) NOT NULL default '0',
  affiliate_percent decimal(4,2) NOT NULL default '0.00',
  affiliate_salesman int(11) NOT NULL default '0',
  PRIMARY KEY  (affiliate_orders_id,affiliate_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS articles;
CREATE TABLE articles (
  store_id int(11) NOT NULL default '1',
  page_id int(11) NOT NULL default '0',
  language_id tinyint(4) NOT NULL default '1',
  page_title varchar(150) default NULL,
  text_content longtext,
  date_modified date default NULL,
  PRIMARY KEY  (page_id,store_id,language_id)
) ENGINE=MyISAM;


INSERT INTO articles (store_id, page_id, language_id, page_title, text_content, date_modified) VALUES (1, 1, 1, 'Mall Conditions', 'Enter Your Mall Conditions here........', '2003-08-25');


DROP TABLE IF EXISTS banners;
CREATE TABLE banners (
  banners_id int(11) NOT NULL auto_increment,
  banners_title varchar(64) NOT NULL default '',
  banners_url varchar(255) NOT NULL default '',
  banners_image varchar(64) NOT NULL default '',
  banners_group varchar(10) NOT NULL default '',
  banners_html_text text,
  expires_impressions int(7) default '0',
  expires_date datetime default NULL,
  date_scheduled datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  date_status_change datetime default NULL,
  status int(1) NOT NULL default '1',
  categories_id int(11) NOT NULL default '0',
  PRIMARY KEY  (banners_id),
  KEY idx_banners_group (banners_group)
) ENGINE=MyISAM;



INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status, categories_id) VALUES (1, 'SystemsManager Technologies', 'http://www.systemsmanager.net', 'banners/smn_banner.jpg', '468x50', '', 0, NULL, NULL, '2003-09-23 19:10:16', NULL, 1, 0);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status, categories_id) VALUES (2, 'Google Ads', '', '', '468x50', '<script type="text/javascript">\r\n<!--\r\ngoogle_ad_client = "pub-0129397780797697";\r\ngoogle_alternate_ad_url = "http://www.systemsmanager.net/images/banners/smn_banner.jpg";\r\ngoogle_ad_width = 468;\r\ngoogle_ad_height = 60;\r\ngoogle_ad_format = "468x60_as";\r\ngoogle_ad_channel ="2370881250";\r\ngoogle_ad_type = "text";\r\ngoogle_color_border = "2D5893";\r\ngoogle_color_bg = "99AACC";\r\ngoogle_color_link = "000000";\r\ngoogle_color_url = "000099";\r\ngoogle_color_text = "003366";\r\n//--></script>\r\n<script type="text/javascript"\r\n src="http://pagead2.googlesyndication.com/pagead/show_ads.js">\r\n</script>', 0, NULL, NULL, '2003-09-23 22:55:12', NULL, 1, 0);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status, categories_id) VALUES (3, 'The Template Shop', '', '', '468x50', '<a href="http://www.websitetemplatedesign.com/index.php?ref=45&affiliate_banner_id=46" target="_blank"><img src="http://www.websitetemplatedesign.com/affiliate_show_banner.php?ref=45&affiliate_banner_id=46" border="0" alt="Affordable, Quality osCommerce Templates at the Template Shop"></a>', 0, NULL, NULL, '2003-09-23 22:55:12', NULL, 1, 0);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status, categories_id) VALUES (4, 'Google Referral Ads', '', '', '468x50', '<script type="text/javascript">\r\n<!--\r\ngoogle_ad_client = "pub-0129397780797697";\r\ngoogle_ad_width = 468;\r\ngoogle_ad_height = 60;\r\ngoogle_ad_format = "468x60_as_rimg";\r\ngoogle_cpa_choice = "CAAQq8WdzgEaCCQIMpsWzihvKNvD93M";\r\n//--></script>\r\n<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">\r\n</script>\r\n', 0, NULL, NULL, '2003-09-23 22:55:12', NULL, 1, 0);
INSERT INTO banners (banners_id, banners_title, banners_url, banners_image, banners_group, banners_html_text, expires_impressions, expires_date, date_scheduled, date_added, date_status_change, status, categories_id) VALUES (5, 'Payment Processors', 'http://www.systemsmanager.net/payment_processors.php', 'banners/authorizeCC.gif', '468x50', '', 0, NULL, NULL, '2003-09-23 19:10:16', NULL, 1, 0);


DROP TABLE IF EXISTS banners_history;
CREATE TABLE banners_history (
  banners_history_id int(11) NOT NULL auto_increment,
  banners_id int(11) NOT NULL default '0',
  banners_shown int(5) NOT NULL default '0',
  banners_clicked int(5) NOT NULL default '0',
  banners_history_date datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (banners_history_id),
  KEY idx_banners_history_banners_id (banners_id)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS cache;
CREATE TABLE cache (
  cache_id varchar(32) NOT NULL default '',
  cache_language_id tinyint(1) NOT NULL default '0',
  cache_name varchar(255) NOT NULL default '',
  cache_data mediumtext NOT NULL,
  cache_global tinyint(1) NOT NULL default '1',
  cache_gzip tinyint(1) NOT NULL default '1',
  cache_method varchar(20) NOT NULL default 'RETURN',
  cache_date datetime NOT NULL default '0000-00-00 00:00:00',
  cache_expires datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (cache_id,cache_language_id),
  KEY cache_id (cache_id),
  KEY cache_language_id (cache_language_id),
  KEY cache_global (cache_global)
) ENGINE=MyISAM;

INSERT INTO cache (cache_id, cache_language_id, cache_name, cache_data, cache_global, cache_gzip, cache_method, cache_date, cache_expires) VALUES ('ca34fbe5f9a075091ad59abf02c259a7', 1, 'seo_urls_v2_products', 'AwA=', 1, 1, 'EVAL', '2008-03-14 21:11:20', '2008-04-13 21:11:20');
INSERT INTO cache (cache_id, cache_language_id, cache_name, cache_data, cache_global, cache_gzip, cache_method, cache_date, cache_expires) VALUES ('a93b9170a03ff54d81e95917742ea01b', 1, 'seo_urls_v2_categories', 'AwA=', 1, 1, 'EVAL', '2008-03-14 21:11:20', '2008-04-13 21:11:20');
INSERT INTO cache (cache_id, cache_language_id, cache_name, cache_data, cache_global, cache_gzip, cache_method, cache_date, cache_expires) VALUES ('4404c1df54fdb1291c8dd9bb259f32a9', 1, 'seo_urls_v2_manufacturers', 'AwA=', 1, 1, 'EVAL', '2008-03-14 21:11:20', '2008-04-13 21:11:20');


DROP TABLE IF EXISTS categories;
CREATE TABLE categories (
  store_id int(11) NOT NULL default '1',
  categories_id int(11) NOT NULL auto_increment,
  categories_image varchar(64) default NULL,
  parent_id int(11) NOT NULL default '0',
  category_head_title_tag varchar(80) default NULL,
  category_head_desc_tag longtext,
  category_head_keywords_tag longtext,
  sort_order int(3) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (categories_id,store_id),
  KEY idx_categories_parent_id (parent_id)
) ENGINE=MyISAM;


INSERT INTO categories (store_id, categories_id, categories_image, parent_id, category_head_title_tag, category_head_desc_tag, category_head_keywords_tag, sort_order, date_added, last_modified) VALUES (1, 1, 'bas.gif', 0, 'Gift Vouchers', 'Gift Vouchers', 'Gift Vouchers', 1, '2006-02-16 16:49:09', NULL);



DROP TABLE IF EXISTS categories_description;
CREATE TABLE categories_description (
  store_id int(11) NOT NULL default '1',
  categories_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  categories_name varchar(32) NOT NULL default '',
  categories_description text,
  categories_heading_title varchar(64) default NULL,
  categories_head_title_tag varchar(80) default NULL,
  categories_head_desc_tag longtext,
  categories_head_keywords_tag longtext,
  PRIMARY KEY  (categories_id,language_id),
  KEY idx_categories_name (categories_name)
) ENGINE=MyISAM;



INSERT INTO categories_description (store_id, categories_id, language_id, categories_name, categories_description, categories_heading_title, categories_head_title_tag, categories_head_desc_tag, categories_head_keywords_tag) VALUES (1, 1, 1, 'Gift Vouchers', 'Gift vouchers', NULL, NULL, '', '');


DROP TABLE IF EXISTS configuration;
CREATE TABLE configuration (
  store_id int(11) NOT NULL default '1',
  configuration_id int(11) NOT NULL auto_increment,
  configuration_title varchar(64) NOT NULL default '',
  configuration_key varchar(64) NOT NULL default '',
  configuration_value varchar(255) NOT NULL default '',
  configuration_description varchar(255) NOT NULL default '',
  configuration_group_id int(11) NOT NULL default '0',
  sort_order int(5) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  use_function varchar(255) default NULL,
  set_function varchar(255) default NULL,
  PRIMARY KEY  (configuration_id)
) ENGINE=MyISAM;



INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 1, 'Mall Name', 'MALL_NAME', 'oscMall', 'The name of this Mall', 16, 1, '2005-11-02 02:38:28', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 2, 'E-Mail Address', 'MALL_EMAIL_ADDRESS', 'info@localhost.com', 'The e-mail address of mall owner', 16, 2, '2005-11-02 02:38:51', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 3, 'E-Mail From', 'MALL_EMAIL_FROM', 'oscMall<info@localhost.com>', 'The e-mail address used in (sent) e-mails for new customers', 16, 3, '2005-11-02 02:39:40', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 4, 'Store Types', 'STORE_TYPES', '2', 'The types of stores installed', 16, 4, '2004-04-21 02:11:15', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 5, 'Turn shop rental system on', 'DISPLAY_STORE_IMMEDIATELY', 'true', 'Display store in catalog after creation without rental payment', 16, 4, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 6, 'Allow shops send newsletters to customers', 'ALLOW_STORE_NEWSLETTER', 'true', 'Allow Shop to Send Newsletters', 16, 6, '2005-11-18 08:46:34', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 7, 'Allow shops to have own Site Text', 'ALLOW_STORE_SITE_TEXT', 'false', 'Allow Shop to Edit Site Text', 16, 7, '2005-11-28 13:29:52', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 8, 'Allow shops to change layouts', 'ALLOW_STORE_TEMPLATE', 'false', 'Allow Shop to Change Layouts', 16, 8, '2005-11-16 09:15:04', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 9, 'Address Book Entries', 'MAX_ADDRESS_BOOK_ENTRIES', '5', 'Maximum address book entries a customer is allowed to have', 3, 1, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 10, 'First Name', 'ENTRY_FIRST_NAME_MIN_LENGTH', '2', 'Minimum length of first name', 2, 1, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 11, 'Last Name', 'ENTRY_LAST_NAME_MIN_LENGTH', '2', 'Minimum length of last name', 2, 2, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 12, 'Date of Birth', 'ENTRY_DOB_MIN_LENGTH', '10', 'Minimum length of date of birth', 2, 3, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 13, 'E-Mail Address', 'ENTRY_EMAIL_ADDRESS_MIN_LENGTH', '6', 'Minimum length of e-mail address', 2, 4, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 14, 'Street Address', 'ENTRY_STREET_ADDRESS_MIN_LENGTH', '5', 'Minimum length of street address', 2, 5, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 15, 'Company', 'ENTRY_COMPANY_MIN_LENGTH', '2', 'Minimum length of company name', 2, 6, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 16, 'Post Code', 'ENTRY_POSTCODE_MIN_LENGTH', '4', 'Minimum length of post code', 2, 7, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 17, 'City', 'ENTRY_CITY_MIN_LENGTH', '3', 'Minimum length of city', 2, 8, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 18, 'State', 'ENTRY_STATE_MIN_LENGTH', '2', 'Minimum length of state', 2, 9, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 19, 'Telephone Number', 'ENTRY_TELEPHONE_MIN_LENGTH', '0', 'Minimum length of telephone number', 2, 10, '2005-12-15 10:46:30', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 20, 'Password', 'ENTRY_PASSWORD_MIN_LENGTH', '5', 'Minimum length of password', 2, 11, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 21, 'Order History', 'MAX_DISPLAY_ORDER_HISTORY', '10', 'Maximum number of orders to display in the order history page', 3, 18, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 22, 'Store Page Parse Time', 'STORE_PAGE_PARSE_TIME', 'false', 'Store the time it takes to parse a page', 10, 1, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 23, 'Log Destination', 'STORE_PAGE_PARSE_TIME_LOG', '/var/log/www/smn/page_parse_time.log', 'Directory and filename of the page parse time log', 10, 2, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 24, 'Log Date Format', 'STORE_PARSE_DATE_TIME_FORMAT', '%d/%m/%Y %H:%M:%S', 'The date format', 10, 3, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 25, 'Display The Page Parse Time', 'DISPLAY_PAGE_PARSE_TIME', 'true', 'Display the page parse time (store page parse time must be enabled)', 10, 4, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 26, 'Store Database Queries', 'STORE_DB_TRANSACTIONS', 'false', 'Store the database queries in the page parse time log (PHP4 only)', 10, 5, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 27, 'Use Cache', 'USE_CACHE', 'false', 'Use caching features', 11, 1, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 28, 'Cache Directory', 'DIR_FS_CACHE', '/tmp/', 'The directory where the cached files are saved', 11, 2, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 29, 'E-Mail Transport Method', 'EMAIL_TRANSPORT', 'sendmail', 'Defines if this server uses a local connection to sendmail or uses an SMTP connection via TCP/IP. Servers running on Windows and MacOS should change this setting to SMTP.', 12, 1, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'sendmail\', \'smtp\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 30, 'E-Mail Linefeeds', 'EMAIL_LINEFEED', 'LF', 'Defines the character sequence used to separate mail headers.', 12, 2, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'LF\', \'CRLF\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 31, 'Use MIME HTML When Sending Emails', 'EMAIL_USE_HTML', 'true', 'Send e-mails in HTML format', 12, 3, '2005-11-02 20:18:00', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 32, 'Verify E-Mail Addresses Through DNS', 'ENTRY_EMAIL_ADDRESS_CHECK', 'true', 'Verify e-mail address through a DNS server', 12, 4, '2005-11-02 20:18:48', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 33, 'Send E-Mails', 'SEND_EMAILS', 'true', 'Send out e-mails', 12, 5, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 34, 'Enable download', 'DOWNLOAD_ENABLED', 'false', 'Enable the products download functions.', 13, 1, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 35, 'Download by redirect', 'DOWNLOAD_BY_REDIRECT', 'false', 'Use browser redirection for download. Disable on non-Unix systems.', 13, 2, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 36, 'Expiry delay (days)', 'DOWNLOAD_MAX_DAYS', '7', 'Set number of days before the download link expires. 0 means no limit.', 13, 3, NULL, '2003-08-14 18:07:14', NULL, '');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 37, 'Maximum number of downloads', 'DOWNLOAD_MAX_COUNT', '5', 'Set the maximum number of downloads. 0 means no download authorized.', 13, 4, NULL, '2003-08-14 18:07:14', NULL, '');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 38, 'Enable GZip Compression', 'GZIP_COMPRESSION', 'false', 'Enable HTTP GZip compression.', 14, 1, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 39, 'Compression Level', 'GZIP_LEVEL', '5', 'Use this compression level 0-9 (0 = minimum, 9 = maximum).', 14, 2, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 40, 'Session Directory', 'SESSION_WRITE_DIRECTORY', '/tmp', 'If sessions are file based, store them in this directory.', 15, 1, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 41, 'Force Cookie Use', 'SESSION_FORCE_COOKIE_USE', 'False', 'Force the use of sessions when cookies are only enabled.', 15, 2, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 42, 'Check SSL Session ID', 'SESSION_CHECK_SSL_SESSION_ID', 'False', 'Validate the SSL_SESSION_ID on every secure HTTPS page request.', 15, 3, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 43, 'Check User Agent', 'SESSION_CHECK_USER_AGENT', 'False', 'Validate the clients browser user agent on every page request.', 15, 4, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 44, 'Check IP Address', 'SESSION_CHECK_IP_ADDRESS', 'False', 'Validate the clients IP address on every page request.', 15, 5, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 45, 'Prevent Spider Sessions', 'SESSION_BLOCK_SPIDERS', 'False', 'Prevent known spiders from starting a session.', 15, 6, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 46, 'Recreate Session', 'SESSION_RECREATE', 'False', 'Recreate the session to generate a new session ID when the customer logs on or creates an account (PHP >=4.1 needed).', 15, 7, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 47, 'Minimim Store Name Length', 'ENTRY_STORE_NAME_MIN_LENGTH', '2', 'Minimum length of store name', 2, 1, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 48, 'Bank name min length', 'ENTRY_BANK_FIRST_NAME_MIN_LENGTH', '3', 'Minimum length of bank name', 2, 12, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 49, 'Bank account number min length', 'ENTRY_BANK_ACCOUNT_MIN_LENGTH', '3', 'Minimum length of bank account number', 2, 12, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 50, 'Bank routing code min length', 'ENTRY_BANK_ROUTING_CODE_MIN_LENGTH', '3', 'Minimum length of bank routing code', 2, 12, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 51, 'E-Mail Address', 'AFFILIATE_EMAIL_ADDRESS', '<affiliate@localhost.com>', 'The E Mail Address for the Affiliate Program', 900, 1, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 52, 'Affiliate Pay Per Sale Payment % Rate', 'AFFILIATE_PERCENT', '10.0000', 'Percentage Rate for the Affiliate Program', 900, 2, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 53, 'Payment Threshold', 'AFFILIATE_THRESHOLD', '50.00', 'Payment Threshold for paying affiliates', 900, 3, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 54, 'Cookie Lifetime', 'AFFILIATE_COOKIE_LIFETIME', '7200', 'How long does the click count (seconds) if customer comes back', 900, 4, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 55, 'Billing Time', 'AFFILIATE_BILLING_TIME', '30', 'Orders billed must be at least 30 days old.<br>This is needed if a order is refunded', 900, 5, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 56, 'Order Min Status', 'AFFILIATE_PAYMENT_ORDER_MIN_STATUS', '3', 'The status an order must have at least, to be billed', 900, 6, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 57, 'Pay Affiliates with check', 'AFFILIATE_USE_CHECK', 'true', 'Pay Affiliates with check', 900, 7, NULL, '2006-09-25 10:19:57', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 58, 'Pay Affiliates with PayPal', 'AFFILIATE_USE_PAYPAL', 'true', 'Pay Affiliates with PayPal', 900, 8, NULL, '2006-09-25 10:19:57', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 59, 'Pay Affiliates by Bank', 'AFFILIATE_USE_BANK', 'true', 'Pay Affiliates by Bank', 900, 9, NULL, '2006-09-25 10:19:57', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 60, 'Individual Affiliate Percentage', 'AFFILATE_INDIVIDUAL_PERCENTAGE', 'true', 'Allow per Affiliate provision', 900, 10, NULL, '2006-09-25 10:19:57', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 61, 'Use Affiliate-tier', 'AFFILATE_USE_TIER', 'false', 'Multilevel Affiliate provisions', 900, 11, NULL, '2006-09-25 10:19:57', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 62, 'Number of Tierlevels', 'AFFILIATE_TIER_LEVELS', '0', 'Number of Tierlevels', 900, 12, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 63, 'Percentage Rate for the Tierlevels', 'AFFILIATE_TIER_PERCENTAGE', '8.00;5.00;1.00', 'Percent Rates for the tier levels<br>Example: 8.00;5.00;1.00', 900, 13, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 64, 'Affiliate News', 'MAX_DISPLAY_AFFILIATE_NEWS', '3', 'Maximum number of items to display on the Affiliate News page', 900, 14, NULL, '2006-09-25 10:19:57', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 70, 'Default Currency', 'DEFAULT_CURRENCY', 'USD', 'Default Currency', 6, 0, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 71, 'Default Language', 'DEFAULT_LANGUAGE', 'en', 'Default Language', 6, 0, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 72, 'Gender', 'ACCOUNT_GENDER', 'true', 'Display gender in the customers account', 5, 1, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 73, 'Date of Birth', 'ACCOUNT_DOB', 'true', 'Display date of birth in the customers account', 5, 2, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 74, 'Company', 'ACCOUNT_COMPANY', 'true', 'Display company in the customers account', 5, 3, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 76, 'State', 'ACCOUNT_STATE', 'true', 'Display state in the customers account', 5, 5, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 77, 'Credit Card Required', 'ACCOUNT_CC', 'true', 'Require credit card information in the financial account', 5, 2, '2003-09-24 15:33:26', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 78, 'Bank Address Required', 'ACCOUNT_BANK_ADDRESS', 'true', 'Require bank address information in the financial account', 5, 2, '2003-09-24 15:33:44', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 79, 'Default Template ID for layout used for all shops', 'DEFAULT_TEMPLATE_ID', '1', 'Use Template id as default for all stores/vendors', 16, 4, '2005-11-28 13:29:36', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 80, 'Max Image File Size (bytes)', 'MAX_IMAGE_FILE_SIZE', '1048576', 'This is the max allowable size for a image file', 16, 100, '2005-12-14 15:28:37', '2005-12-09 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 81, 'To offer a gift voucher', 'NEW_SIGNUP_GIFT_VOUCHER_AMOUNT', '0', 'Please indicate the amount of the gift voucher which you want to offer a new customer.<br><br>Put 0 if you do not want to offer gift voucher.<br>', 1, 31, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 82, 'To offer a discount coupon', 'NEW_SIGNUP_DISCOUNT_COUPON', '', 'To offer a discount coupon to a new customer, enter the code of the coupon.<br><br>Leave empty if you do not want to offer discount coupon.<BR>', 1, 32, NULL, '2003-12-05 05:01:41', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 86, 'Expected Sort Order', 'EXPECTED_PRODUCTS_SORT', 'desc', 'This is the sort order used in the expected products box.', 1, 8, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'asc\', \'desc\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 87, 'Expected Sort Field', 'EXPECTED_PRODUCTS_FIELD', 'date_expected', 'The column to sort by in the expected products box.', 1, 9, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'products_name\', \'date_expected\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 88, 'Switch To Default Language Currency', 'USE_DEFAULT_LANGUAGE_CURRENCY', 'false', 'Automatically switch to the language\'s currency when it is changed', 1, 10, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 90, 'Use Search-Engine Safe URLs (still in development)', 'SEARCH_ENGINE_FRIENDLY_URLS', 'false', 'Use search-engine safe urls for all site links', 1, 12, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 91, 'Display Cart After Adding Product', 'DISPLAY_CART', 'true', 'Display the shopping cart after adding a product (or return back to their origin)', 1, 14, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 92, 'Allow Guest To Tell A Friend', 'ALLOW_GUEST_TO_TELL_A_FRIEND', 'true', 'Allow guests to tell a friend about a product', 1, 15, '2005-11-02 20:21:27', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 93, 'Default Search Operator', 'ADVANCED_SEARCH_DEFAULT_OPERATOR', 'and', 'Default search operators', 1, 17, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'and\', \'or\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 95, 'Show Category Counts', 'SHOW_COUNTS', 'false', 'Count recursively how many products are in each category', 1, 19, '2003-08-25 23:11:39', '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 96, 'Tax Decimal Places', 'TAX_DECIMAL_PLACES', '0', 'Pad the tax value this amount of decimal places', 1, 20, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 97, 'Display Prices with Tax', 'DISPLAY_PRICE_WITH_TAX', 'false', 'Display prices with tax included (true) or add the tax at the end (false)', 1, 21, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 98, 'Credit Card Owner Name', 'CC_OWNER_MIN_LENGTH', '3', 'Minimum length of credit card owner name', 2, 12, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 99, 'Credit Card Number', 'CC_NUMBER_MIN_LENGTH', '10', 'Minimum length of credit card number', 2, 13, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 100, 'Review Text', 'REVIEW_TEXT_MIN_LENGTH', '50', 'Minimum length of review text', 2, 14, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 101, 'Best Sellers', 'MIN_DISPLAY_BESTSELLERS', '1', 'Minimum number of best sellers to display', 2, 15, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 102, 'Also Purchased', 'MIN_DISPLAY_ALSO_PURCHASED', '1', 'Minimum number of products to display in the \'This Customer Also Purchased\' box', 2, 16, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 103, 'Search Results', 'MAX_DISPLAY_SEARCH_RESULTS', '20', 'Amount of products to list', 3, 2, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 104, 'Page Links', 'MAX_DISPLAY_PAGE_LINKS', '5', 'Number of \'number\' links use for page-sets', 3, 3, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 105, 'Special Products', 'MAX_DISPLAY_SPECIAL_PRODUCTS', '9', 'Maximum number of products on special to display', 3, 4, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 106, 'New Products Module', 'MAX_DISPLAY_NEW_PRODUCTS', '9', 'Maximum number of new products to display in a category', 3, 5, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 107, 'Products Expected', 'MAX_DISPLAY_UPCOMING_PRODUCTS', '10', 'Maximum number of products expected to display', 3, 6, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 108, 'Manufacturers List', 'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST', '0', 'Used in manufacturers box; when the number of manufacturers exceeds this number, a drop-down list will be displayed instead of the default list', 3, 7, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 109, 'Manufacturers Select Size', 'MAX_MANUFACTURERS_LIST', '1', 'Used in manufacturers box; when this value is \'1\' the classic drop-down list will be used for the manufacturers box. Otherwise, a list-box with the specified number of rows will be displayed.', 3, 7, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 110, 'Length of Manufacturers Name', 'MAX_DISPLAY_MANUFACTURER_NAME_LEN', '15', 'Used in manufacturers box; maximum length of manufacturers name to display', 3, 8, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 111, 'New Reviews', 'MAX_DISPLAY_NEW_REVIEWS', '6', 'Maximum number of new reviews to display', 3, 9, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 112, 'Selection of Random Reviews', 'MAX_RANDOM_SELECT_REVIEWS', '10', 'How many records to select from to choose one random product review', 3, 10, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 113, 'Selection of Random New Products', 'MAX_RANDOM_SELECT_NEW', '10', 'How many records to select from to choose one random new product to display', 3, 11, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 114, 'Selection of Products on Special', 'MAX_RANDOM_SELECT_SPECIALS', '10', 'How many records to select from to choose one random product special to display', 3, 12, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 115, 'Categories To List Per Row', 'MAX_DISPLAY_CATEGORIES_PER_ROW', '3', 'How many categories to list per row', 3, 13, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 116, 'New Products Listing', 'MAX_DISPLAY_PRODUCTS_NEW', '10', 'Maximum number of new products to display in new products page', 3, 14, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 117, 'Best Sellers', 'MAX_DISPLAY_BESTSELLERS', '10', 'Maximum number of best sellers to display', 3, 15, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 118, 'Also Purchased', 'MAX_DISPLAY_ALSO_PURCHASED', '6', 'Maximum number of products to display in the \'This Customer Also Purchased\' box', 3, 16, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 119, 'Customer Order History Box', 'MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX', '6', 'Maximum number of products to display in the customer order history box', 3, 17, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 120, 'Small Image Width', 'SMALL_IMAGE_WIDTH', '104', 'The pixel width of small images', 4, 1, '2005-12-16 18:05:51', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 121, 'Small Image Height', 'SMALL_IMAGE_HEIGHT', '102', 'The pixel height of small images', 4, 2, '2005-12-16 18:06:04', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 122, 'Heading Image Width', 'HEADING_IMAGE_WIDTH', '57', 'The pixel width of heading images', 4, 3, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 123, 'Heading Image Height', 'HEADING_IMAGE_HEIGHT', '40', 'The pixel height of heading images', 4, 4, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 124, 'Subcategory Image Width', 'SUBCATEGORY_IMAGE_WIDTH', '100', 'The pixel width of subcategory images', 4, 5, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 125, 'Subcategory Image Height', 'SUBCATEGORY_IMAGE_HEIGHT', '57', 'The pixel height of subcategory images', 4, 6, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 126, 'Calculate Image Size', 'CONFIG_CALCULATE_IMAGE_SIZE', 'true', 'Calculate the size of images?', 4, 7, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 127, 'Image Required', 'IMAGE_REQUIRED', 'true', 'Enable to display broken images. Good for development.', 4, 8, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 129, 'Installed Modules', 'MODULE_ORDER_TOTAL_INSTALLED', 'ot_subtotal.php;ot_coupon.php;ot_gv.php;ot_total.php', 'List of order_total module filenames separated by a semi-colon. This is automatically updated. No need to edit. (Example: ot_subtotal.php;ot_tax.php;ot_shipping.php;ot_total.php)', 6, 0, '2006-02-16 16:48:13', '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 131, 'Default Order Status For New Orders', 'DEFAULT_ORDERS_STATUS_ID', '1', 'When a new order is created, this order status will be assigned to it.', 6, 0, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 133, 'Handling Fee', 'SHIPPING_HANDLING', '5.00', 'Enter the handling fee you may charge.', 7, 6, NULL, '2005-11-02 02:24:36', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 135, 'Enter the Maximum Package Weight you will ship', 'SHIPPING_MAX_WEIGHT', '50', 'Carriers have a max weight limit for a single package. This is a common one for all.', 7, 3, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 136, 'Package Tare weight.', 'SHIPPING_BOX_WEIGHT', '3', 'What is the weight of typical packaging of small to medium packages?', 7, 4, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 137, 'Larger packages - percentage increase.', 'SHIPPING_BOX_PADDING', '10', 'For 10% enter 10', 7, 5, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 138, 'Display Product Image', 'PRODUCT_LIST_IMAGE', '1', 'Do you want to display the Product Image?', 8, 1, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 139, 'Display Product Manufaturer Name', 'PRODUCT_LIST_MANUFACTURER', '0', 'Do you want to display the Product Manufacturer Name?', 8, 2, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 140, 'Display Product Model', 'PRODUCT_LIST_MODEL', '0', 'Do you want to display the Product Model?', 8, 3, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 141, 'Display Product Name', 'PRODUCT_LIST_NAME', '2', 'Do you want to display the Product Name?', 8, 4, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 142, 'Display Product Price', 'PRODUCT_LIST_PRICE', '3', 'Do you want to display the Product Price', 8, 5, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 143, 'Display Product Quantity', 'PRODUCT_LIST_QUANTITY', '0', 'Do you want to display the Product Quantity?', 8, 6, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 144, 'Display Product Weight', 'PRODUCT_LIST_WEIGHT', '0', 'Do you want to display the Product Weight?', 8, 7, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 145, 'Display Buy Now column', 'PRODUCT_LIST_BUY_NOW', '4', 'Do you want to display the Buy Now column?', 8, 8, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 146, 'Display Category/Manufacturer Filter (0=disable; 1=enable)', 'PRODUCT_LIST_FILTER', '1', 'Do you want to display the Category/Manufacturer Filter?', 8, 9, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 147, 'Location of Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', 'PREV_NEXT_BAR_LOCATION', '2', 'Sets the location of the Prev/Next Navigation Bar (1-top, 2-bottom, 3-both)', 8, 10, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 148, 'Check stock level', 'STOCK_CHECK', 'true', 'Check to see if sufficent stock is available', 9, 1, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 149, 'Subtract stock', 'STOCK_LIMITED', 'true', 'Subtract product in stock by product orders', 9, 2, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 150, 'Allow Checkout', 'STOCK_ALLOW_CHECKOUT', 'true', 'Allow customer to checkout even if there is insufficient stock', 9, 3, NULL, '2003-08-14 18:07:14', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 151, 'Mark product out of stock', 'STOCK_MARK_PRODUCT_OUT_OF_STOCK', '***', 'Display something on screen so customer can see which product has insufficient stock', 9, 4, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 152, 'Stock Re-order level', 'STOCK_REORDER_LEVEL', '5', 'Define when stock needs to be re-ordered', 9, 5, NULL, '2003-08-14 18:07:14', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 153, 'Downloads Controller Update Status Value', 'DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE', '4', 'What orders_status resets the Download days and Max Downloads - Default is 4', 13, 90, '2003-02-18 13:22:32', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 154, 'Downloads Controller Download on hold message', 'DOWNLOADS_CONTROLLER_ON_HOLD_MSG', '<BR><font color=FF0000>NOTE: Downloads are not available until payment has been confirmed</font>', 'Downloads Controller Download on hold message', 13, 91, '2003-02-18 13:22:32', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 155, 'Downloads Controller Order Status Value', 'DOWNLOADS_CONTROLLER_ORDERS_STATUS', '2', 'Downloads Controller Order Status Value - Default=2', 13, 92, '2003-02-18 13:22:32', '0000-00-00 00:00:00', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 156, 'Installed Modules', 'MODULE_PAYMENT_INSTALLED', 'paypal.php', 'This is automatically updated. No need to edit.', 6, 0, '2006-02-16 16:46:02', '2006-02-16 16:44:59', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 157, 'Enable PayPal Module', 'MODULE_PAYMENT_PAYPAL_STATUS', 'True', 'Do you want to accept PayPal payments?', 6, 3, NULL, '2006-02-16 16:45:07', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 158, 'PayPal E-Mail Address', 'MODULE_PAYMENT_PAYPAL_ID', 'you@yourbusiness.com', 'The e-mail address to use for the PayPal service', 6, 4, NULL, '2006-02-16 16:45:07', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 159, 'PayPal Transaction Currency', 'MODULE_PAYMENT_PAYPAL_CURRENCY', 'Only USD', 'The currency to use for credit card transactions', 6, 6, NULL, '2006-02-16 16:45:07', NULL, 'smn_cfg_select_option(array(\'Selected Currency\',\'Only USD\',\'Only CAD\',\'Only EUR\',\'Only GBP\',\'Only JPY\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 160, 'PayPal Sort order of display.', 'MODULE_PAYMENT_PAYPAL_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', 6, 0, NULL, '2006-02-16 16:45:07', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 161, 'PayPal Payment Zone', 'MODULE_PAYMENT_PAYPAL_ZONE', '0', 'If a zone is selected, only enable this payment method for that zone.', 6, 2, NULL, '2006-02-16 16:45:07', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 162, 'PayPal Set Order Status', 'MODULE_PAYMENT_PAYPAL_ORDER_STATUS_ID', '0', 'Set the status of orders made with this payment module to this value', 6, 0, NULL, '2006-02-16 16:45:07', 'smn_get_order_status_name', 'smn_cfg_pull_down_order_statuses(');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 587, "For Single Checkout?", "MODULE_PAYMENT_PAYPAL_SINGLE_CHECKOUT", "True", "Use this payment for single checkout?", "6", "2", NULL, "2007-07-24 22:03:06", NULL, "smn_cfg_select_option(array(\'True\', \'False\'),");
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 168, 'Enable Free Shipping', 'MODULE_SHIPPING_FREESHIPPER_STATUS', '1', 'Do you want to offer Free shipping?', 6, 5, NULL, '2006-02-16 16:46:16', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 169, 'Free Shipping Cost', 'MODULE_SHIPPING_FREESHIPPER_COST', '0.00', 'What is the Shipping cost? The Handling fee will also be added.', 6, 6, NULL, '2006-02-16 16:46:16', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 170, 'Tax Class', 'MODULE_SHIPPING_FREESHIPPER_TAX_CLASS', '0', 'Use the following tax class on the shipping fee.', 6, 0, NULL, '2006-02-16 16:46:16', 'smn_get_tax_class_title', 'smn_cfg_pull_down_tax_classes(');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 171, 'Shipping Zone', 'MODULE_SHIPPING_FREESHIPPER_ZONE', '0', 'If a zone is selected, only enable this shipping method for that zone.', 6, 0, NULL, '2006-02-16 16:46:16', 'smn_get_zone_class_title', 'smn_cfg_pull_down_zone_classes(');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 167, 'Installed Modules', 'MODULE_SHIPPING_INSTALLED', 'freeshipper.php', 'This is automatically updated. No need to edit.', 6, 0, '2006-02-16 16:46:16', '2006-02-16 16:46:08', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 172, 'Sort Order', 'MODULE_SHIPPING_FREESHIPPER_SORT_ORDER', '0', 'Sort order of display.', 6, 0, NULL, '2006-02-16 16:46:16', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 173, 'Display Sub-Total', 'MODULE_ORDER_TOTAL_SUBTOTAL_STATUS', 'true', 'Do you want to display the order sub-total cost?', 6, 1, NULL, '2006-02-16 16:46:42', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 174, 'Sort Order', 'MODULE_ORDER_TOTAL_SUBTOTAL_SORT_ORDER', '1', 'Sort order of display.', 6, 2, NULL, '2006-02-16 16:46:42', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 175, 'Display Total', 'MODULE_ORDER_TOTAL_COUPON_STATUS', 'true', 'Do you want to display the Discount Coupon value?', 6, 1, NULL, '2006-02-16 16:46:59', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 176, 'Sort Order', 'MODULE_ORDER_TOTAL_COUPON_SORT_ORDER', '5', 'Sort order of display.', 6, 2, NULL, '2006-02-16 16:46:59', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 177, 'Include Shipping', 'MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING', 'true', 'Include Shipping in calculation', 6, 5, NULL, '2006-02-16 16:46:59', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 178, 'Include Tax', 'MODULE_ORDER_TOTAL_COUPON_INC_TAX', 'true', 'Include Tax in calculation.', 6, 6, NULL, '2006-02-16 16:46:59', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 179, 'Re-calculate Tax', 'MODULE_ORDER_TOTAL_COUPON_CALC_TAX', 'None', 'Re-Calculate Tax', 6, 7, NULL, '2006-02-16 16:46:59', NULL, 'smn_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 180, 'Tax Class', 'MODULE_ORDER_TOTAL_COUPON_TAX_CLASS', '0', 'Use the following tax class when treating Discount Coupon as Credit Note.', 6, 0, NULL, '2006-02-16 16:46:59', 'smn_get_tax_class_title', 'smn_cfg_pull_down_tax_classes(');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 181, 'Display Total', 'MODULE_ORDER_TOTAL_GV_STATUS', 'true', 'Do you want to display the Gift Voucher value?', 6, 1, NULL, '2006-02-16 16:47:24', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 182, 'Sort Order', 'MODULE_ORDER_TOTAL_GV_SORT_ORDER', '6', 'Sort order of display.', 6, 2, NULL, '2006-02-16 16:47:24', NULL, NULL);
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 183, 'Queue Purchases', 'MODULE_ORDER_TOTAL_GV_QUEUE', 'true', 'Do you want to queue purchases of the Gift Voucher?', 6, 3, NULL, '2006-02-16 16:47:24', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 184, 'Include Shipping', 'MODULE_ORDER_TOTAL_GV_INC_SHIPPING', 'true', 'Include Shipping in calculation', 6, 5, NULL, '2006-02-16 16:47:24', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 185, 'Include Tax', 'MODULE_ORDER_TOTAL_GV_INC_TAX', 'true', 'Include Tax in calculation.', 6, 6, NULL, '2006-02-16 16:47:24', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 186, 'Re-calculate Tax', 'MODULE_ORDER_TOTAL_GV_CALC_TAX', 'None', 'Re-Calculate Tax', 6, 7, NULL, '2006-02-16 16:47:24', NULL, 'smn_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 187, 'Tax Class', 'MODULE_ORDER_TOTAL_GV_TAX_CLASS', '0', 'Use the following tax class when treating Gift Voucher as Credit Note.', 6, 0, NULL, '2006-02-16 16:47:24', 'smn_get_tax_class_title', 'smn_cfg_pull_down_tax_classes(');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 188, 'Credit including Tax', 'MODULE_ORDER_TOTAL_GV_CREDIT_TAX', 'false', 'Add tax to purchased Gift Voucher when crediting to Account', 6, 8, NULL, '2006-02-16 16:47:24', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 189, 'Display Total', 'MODULE_ORDER_TOTAL_TOTAL_STATUS', 'true', 'Do you want to display the total order value?', 6, 1, NULL, '2006-02-16 16:48:03', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 190, 'Sort Order', 'MODULE_ORDER_TOTAL_TOTAL_SORT_ORDER', '10', 'Sort order of display.', 6, 2, NULL, '2006-02-16 16:48:03', NULL, NULL);
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (1, 'Commission Percentage', 'COMMISSION_PERCENTAGE', '3', 'This is the percentage of the sales sales amount the mall retains as commission', 1, 23, '2007-06-27 00:00:00', '2007-06-27 00:00:00', NULL, NULL);
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable SEO URLs?', 'SEO_ENABLED', 'true', 'Enable the SEO URLs?  This is a global setting and will turn them off completely.', 901, 0, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Allow shops to have independant management of payment modules', 'ALLOW_STORE_PAYMENT', 'true', 'Allow shops to have independant management of payment modules', '16', '9', '2007-06-18 19:45:05', '2007-06-18 00:00:00', NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Add cPath to product URLs?', 'SEO_ADD_CPATH_TO_PRODUCT_URLS', 'false', 'This setting will append the cPath to the end of product URLs (i.e. - some-product-p-1.html?cPath=xx).', 901, 1, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Add category parent to begining of URLs?', 'SEO_ADD_CAT_PARENT', 'true', 'This setting will add the category parent name to the beginning of the category URLs (i.e. - parent-category-c-1.html).', 901, 101, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Filter Short Words', 'SEO_URLS_FILTER_SHORT_WORDS', '3', 'This setting will filter words less than or equal to the value from the URL.', 901, 2, NULL, now(), NULL, NULL);
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Output W3C valid URLs (parameter string)?', 'SEO_URLS_USE_W3C_VALID', 'true', 'This setting will output W3C valid URLs.', 901, 3, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable SEO cache to save queries?', 'USE_SEO_CACHE_GLOBAL', 'true', 'This is a global setting and will turn off caching completely.', 901, 4, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable product cache?', 'USE_SEO_CACHE_PRODUCTS', 'true', 'This will turn off caching for the products.', 901, 5, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable categories cache?', 'USE_SEO_CACHE_CATEGORIES', 'true', 'This will turn off caching for the categories.', 901, 6, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable manufacturers cache?', 'USE_SEO_CACHE_MANUFACTURERS', 'true', 'This will turn off caching for the manufacturers.', 901, 7, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable articles cache?', 'USE_SEO_CACHE_ARTICLES', 'true', 'This will turn off caching for the articles.', 901, 8, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable topics cache?', 'USE_SEO_CACHE_TOPICS', 'true', 'This will turn off caching for the article topics.', 901, 9, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable information cache?', 'USE_SEO_CACHE_INFO_PAGES', 'true', 'This will turn off caching for the information pages.', 901, 10, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enable automatic redirects?', 'USE_SEO_REDIRECT', 'true', 'This will activate the automatic redirect code and send 301 headers for old to new URLs.', 901, 101, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Choose URL Rewrite Type', 'SEO_REWRITE_TYPE', 'Rewrite', 'Choose which SEO URL format to use.', 901, 11, NULL, now(), NULL, 'smn_cfg_select_option(array(\'Rewrite\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Enter special character conversions', 'SEO_CHAR_CONVERT_SET', '', 'This setting will convert characters.<br><br>The format <b>MUST</b> be in the form: <b>char=>conv,char2=>conv2</b>', 901, 12, NULL, now(), NULL, NULL);
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Remove all non-alphanumeric characters?', 'SEO_REMOVE_ALL_SPEC_CHARS', 'false', 'This will remove all non-letters and non-numbers.  This should be handy to remove all special characters with 1 setting.', 901, 13, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');
INSERT INTO configuration (store_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES (0, 'Reset SEO URLs Cache', 'SEO_URLS_CACHE_RESET', 'false', 'This will reset the cache data for SEO', 901, 14, NULL, now(), NULL, 'smn_cfg_select_option(array(\'true\', \'false\'),');


DROP TABLE IF EXISTS configuration_group;
CREATE TABLE configuration_group (
  configuration_group_id int(11) NOT NULL auto_increment,
  group_owner varchar(32) NOT NULL default 'mall',
  configuration_group_title varchar(64) NOT NULL default '',
  configuration_group_description varchar(255) NOT NULL default '',
  sort_order int(5) default NULL,
  visible int(1) default '1',
  PRIMARY KEY  (configuration_group_id)
) ENGINE=MyISAM;



INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (1, 'store', 'My Store', 'General information about my store', 1, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (2, 'store', 'Minimum Values', 'The minimum values for functions / data', 2, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (3, 'store', 'Maximum Values', 'The maximum values for functions / data', 3, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (4, 'store', 'Images', 'Image parameters', 4, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (5, 'mall', 'Customer Details', 'Customer account configuration', 5, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (6, 'store', 'Module Options', 'Hidden from configuration', 6, 0);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (7, 'store', 'Shipping/Packaging', 'Shipping options available at my store', 7, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (8, 'store', 'Product Listing', 'Product Listing    configuration options', 8, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (9, 'store', 'Stock', 'Stock configuration options', 9, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (10, 'mall', 'Logging', 'Logging configuration options', 10, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (11, 'mall', 'Cache', 'Caching configuration options', 11, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (12, 'mall', 'E-Mail Options', 'General setting for E-Mail transport and HTML E-Mails', 12, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (13, 'mall', 'Download', 'Downloadable products options', 13, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (14, 'mall', 'GZip Compression', 'GZip compression options', 14, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (15, 'mall', 'Sessions', 'Session options', 15, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (16, 'mall', 'Mall Set-Up', 'Mall options', 16, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (900, 'mall', 'Affiliate Program', 'Options for the Affiliate Program', 50, 1);
INSERT INTO configuration_group (configuration_group_id, group_owner, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (901, 'mall', 'SEO URLs ', 'Options for Ultimate SEO URLs by Chemo', 51, 1);


DROP TABLE IF EXISTS countries;
CREATE TABLE countries (
  countries_id int(11) NOT NULL auto_increment,
  countries_name varchar(64) NOT NULL default '',
  countries_iso_code_2 char(2) NOT NULL default '',
  countries_iso_code_3 char(3) NOT NULL default '',
  address_format_id int(11) NOT NULL default '0',
  PRIMARY KEY  (countries_id),
  KEY IDX_COUNTRIES_NAME (countries_name)
) ENGINE=MyISAM;



INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (1, 'Afghanistan', 'AF', 'AFG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (2, 'Albania', 'AL', 'ALB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (3, 'Algeria', 'DZ', 'DZA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (4, 'American Samoa', 'AS', 'ASM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (5, 'Andorra', 'AD', 'AND', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (6, 'Angola', 'AO', 'AGO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (7, 'Anguilla', 'AI', 'AIA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (8, 'Antarctica', 'AQ', 'ATA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (9, 'Antigua and Barbuda', 'AG', 'ATG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (10, 'Argentina', 'AR', 'ARG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (11, 'Armenia', 'AM', 'ARM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (12, 'Aruba', 'AW', 'ABW', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (13, 'Australia', 'AU', 'AUS', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (14, 'Austria', 'AT', 'AUT', 5);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (15, 'Azerbaijan', 'AZ', 'AZE', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (16, 'Bahamas', 'BS', 'BHS', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (17, 'Bahrain', 'BH', 'BHR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (18, 'Bangladesh', 'BD', 'BGD', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (19, 'Barbados', 'BB', 'BRB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (20, 'Belarus', 'BY', 'BLR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (21, 'Belgium', 'BE', 'BEL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (22, 'Belize', 'BZ', 'BLZ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (23, 'Benin', 'BJ', 'BEN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (24, 'Bermuda', 'BM', 'BMU', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (25, 'Bhutan', 'BT', 'BTN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (26, 'Bolivia', 'BO', 'BOL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (27, 'Bosnia and Herzegowina', 'BA', 'BIH', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (28, 'Botswana', 'BW', 'BWA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (29, 'Bouvet Island', 'BV', 'BVT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (30, 'Brazil', 'BR', 'BRA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (31, 'British Indian Ocean Territory', 'IO', 'IOT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (32, 'Brunei Darussalam', 'BN', 'BRN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (33, 'Bulgaria', 'BG', 'BGR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (34, 'Burkina Faso', 'BF', 'BFA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (35, 'Burundi', 'BI', 'BDI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (36, 'Cambodia', 'KH', 'KHM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (37, 'Cameroon', 'CM', 'CMR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (38, 'Canada', 'CA', 'CAN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (39, 'Cape Verde', 'CV', 'CPV', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (40, 'Cayman Islands', 'KY', 'CYM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (41, 'Central African Republic', 'CF', 'CAF', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (42, 'Chad', 'TD', 'TCD', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (43, 'Chile', 'CL', 'CHL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (44, 'China', 'CN', 'CHN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (45, 'Christmas Island', 'CX', 'CXR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (46, 'Cocos (Keeling) Islands', 'CC', 'CCK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (47, 'Colombia', 'CO', 'COL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (48, 'Comoros', 'KM', 'COM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (49, 'Congo', 'CG', 'COG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (50, 'Cook Islands', 'CK', 'COK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (51, 'Costa Rica', 'CR', 'CRI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (52, 'Cote D\'Ivoire', 'CI', 'CIV', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (53, 'Croatia', 'HR', 'HRV', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (54, 'Cuba', 'CU', 'CUB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (55, 'Cyprus', 'CY', 'CYP', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (56, 'Czech Republic', 'CZ', 'CZE', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (57, 'Denmark', 'DK', 'DNK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (58, 'Djibouti', 'DJ', 'DJI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (59, 'Dominica', 'DM', 'DMA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (60, 'Dominican Republic', 'DO', 'DOM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (61, 'East Timor', 'TP', 'TMP', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (62, 'Ecuador', 'EC', 'ECU', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (63, 'Egypt', 'EG', 'EGY', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (64, 'El Salvador', 'SV', 'SLV', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (65, 'Equatorial Guinea', 'GQ', 'GNQ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (66, 'Eritrea', 'ER', 'ERI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (67, 'Estonia', 'EE', 'EST', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (68, 'Ethiopia', 'ET', 'ETH', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (70, 'Faroe Islands', 'FO', 'FRO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (71, 'Fiji', 'FJ', 'FJI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (72, 'Finland', 'FI', 'FIN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (73, 'France', 'FR', 'FRA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (74, 'France, Metropolitan', 'FX', 'FXX', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (75, 'French Guiana', 'GF', 'GUF', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (76, 'French Polynesia', 'PF', 'PYF', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (77, 'French Southern Territories', 'TF', 'ATF', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (78, 'Gabon', 'GA', 'GAB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (79, 'Gambia', 'GM', 'GMB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (80, 'Georgia', 'GE', 'GEO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (81, 'Germany', 'DE', 'DEU', 5);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (82, 'Ghana', 'GH', 'GHA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (83, 'Gibraltar', 'GI', 'GIB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (84, 'Greece', 'GR', 'GRC', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (85, 'Greenland', 'GL', 'GRL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (86, 'Grenada', 'GD', 'GRD', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (87, 'Guadeloupe', 'GP', 'GLP', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (88, 'Guam', 'GU', 'GUM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (89, 'Guatemala', 'GT', 'GTM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (90, 'Guinea', 'GN', 'GIN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (91, 'Guinea-bissau', 'GW', 'GNB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (92, 'Guyana', 'GY', 'GUY', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (93, 'Haiti', 'HT', 'HTI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (94, 'Heard and Mc Donald Islands', 'HM', 'HMD', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (95, 'Honduras', 'HN', 'HND', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (96, 'Hong Kong', 'HK', 'HKG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (97, 'Hungary', 'HU', 'HUN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (98, 'Iceland', 'IS', 'ISL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (99, 'India', 'IN', 'IND', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (100, 'Indonesia', 'ID', 'IDN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (101, 'Iran (Islamic Republic of)', 'IR', 'IRN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (102, 'Iraq', 'IQ', 'IRQ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (103, 'Ireland', 'IE', 'IRL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (104, 'Israel', 'IL', 'ISR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (105, 'Italy', 'IT', 'ITA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (106, 'Jamaica', 'JM', 'JAM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (107, 'Japan', 'JP', 'JPN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (108, 'Jordan', 'JO', 'JOR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (109, 'Kazakhstan', 'KZ', 'KAZ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (110, 'Kenya', 'KE', 'KEN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (111, 'Kiribati', 'KI', 'KIR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (112, 'Korea, Democratic People\'s Republic of', 'KP', 'PRK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (113, 'Korea, Republic of', 'KR', 'KOR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (114, 'Kuwait', 'KW', 'KWT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (115, 'Kyrgyzstan', 'KG', 'KGZ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (116, 'Lao People\'s Democratic Republic', 'LA', 'LAO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (117, 'Latvia', 'LV', 'LVA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (118, 'Lebanon', 'LB', 'LBN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (119, 'Lesotho', 'LS', 'LSO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (120, 'Liberia', 'LR', 'LBR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (122, 'Liechtenstein', 'LI', 'LIE', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (123, 'Lithuania', 'LT', 'LTU', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (124, 'Luxembourg', 'LU', 'LUX', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (125, 'Macau', 'MO', 'MAC', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (127, 'Madagascar', 'MG', 'MDG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (128, 'Malawi', 'MW', 'MWI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (129, 'Malaysia', 'MY', 'MYS', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (130, 'Maldives', 'MV', 'MDV', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (131, 'Mali', 'ML', 'MLI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (132, 'Malta', 'MT', 'MLT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (133, 'Marshall Islands', 'MH', 'MHL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (134, 'Martinique', 'MQ', 'MTQ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (135, 'Mauritania', 'MR', 'MRT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (136, 'Mauritius', 'MU', 'MUS', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (137, 'Mayotte', 'YT', 'MYT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (138, 'Mexico', 'MX', 'MEX', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (139, 'Micronesia, Federated States of', 'FM', 'FSM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (140, 'Moldova, Republic of', 'MD', 'MDA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (141, 'Monaco', 'MC', 'MCO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (142, 'Mongolia', 'MN', 'MNG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (143, 'Montserrat', 'MS', 'MSR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (144, 'Morocco', 'MA', 'MAR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (145, 'Mozambique', 'MZ', 'MOZ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (146, 'Myanmar', 'MM', 'MMR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (147, 'Namibia', 'NA', 'NAM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (148, 'Nauru', 'NR', 'NRU', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (149, 'Nepal', 'NP', 'NPL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (150, 'Netherlands', 'NL', 'NLD', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (151, 'Netherlands Antilles', 'AN', 'ANT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (152, 'New Caledonia', 'NC', 'NCL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (153, 'New Zealand', 'NZ', 'NZL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (154, 'Nicaragua', 'NI', 'NIC', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (155, 'Niger', 'NE', 'NER', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (156, 'Nigeria', 'NG', 'NGA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (157, 'Niue', 'NU', 'NIU', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (158, 'Norfolk Island', 'NF', 'NFK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (159, 'Northern Mariana Islands', 'MP', 'MNP', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (160, 'Norway', 'NO', 'NOR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (161, 'Oman', 'OM', 'OMN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (162, 'Pakistan', 'PK', 'PAK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (163, 'Palau', 'PW', 'PLW', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (164, 'Panama', 'PA', 'PAN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (165, 'Papua New Guinea', 'PG', 'PNG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (166, 'Paraguay', 'PY', 'PRY', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (167, 'Peru', 'PE', 'PER', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (168, 'Philippines', 'PH', 'PHL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (169, 'Pitcairn', 'PN', 'PCN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (170, 'Poland', 'PL', 'POL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (171, 'Portugal', 'PT', 'PRT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (172, 'Puerto Rico', 'PR', 'PRI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (173, 'Qatar', 'QA', 'QAT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (174, 'Reunion', 'RE', 'REU', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (175, 'Romania', 'RO', 'ROM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (176, 'Russian Federation', 'RU', 'RUS', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (177, 'Rwanda', 'RW', 'RWA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (178, 'Saint Kitts and Nevis', 'KN', 'KNA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (179, 'Saint Lucia', 'LC', 'LCA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (181, 'Samoa', 'WS', 'WSM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (182, 'San Marino', 'SM', 'SMR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (183, 'Sao Tome and Principe', 'ST', 'STP', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (184, 'Saudi Arabia', 'SA', 'SAU', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (185, 'Senegal', 'SN', 'SEN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (186, 'Seychelles', 'SC', 'SYC', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (187, 'Sierra Leone', 'SL', 'SLE', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (188, 'Singapore', 'SG', 'SGP', 4);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (190, 'Slovenia', 'SI', 'SVN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (191, 'Solomon Islands', 'SB', 'SLB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (192, 'Somalia', 'SO', 'SOM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (193, 'South Africa', 'ZA', 'ZAF', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (195, 'Spain', 'ES', 'ESP', 3);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (196, 'Sri Lanka', 'LK', 'LKA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (197, 'St. Helena', 'SH', 'SHN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (198, 'St. Pierre and Miquelon', 'PM', 'SPM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (199, 'Sudan', 'SD', 'SDN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (200, 'Suriname', 'SR', 'SUR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (202, 'Swaziland', 'SZ', 'SWZ', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (203, 'Sweden', 'SE', 'SWE', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (204, 'Switzerland', 'CH', 'CHE', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (205, 'Syrian Arab Republic', 'SY', 'SYR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (206, 'Taiwan', 'TW', 'TWN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (207, 'Tajikistan', 'TJ', 'TJK', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (208, 'Tanzania, United Republic of', 'TZ', 'TZA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (209, 'Thailand', 'TH', 'THA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (210, 'Togo', 'TG', 'TGO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (211, 'Tokelau', 'TK', 'TKL', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (212, 'Tonga', 'TO', 'TON', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (213, 'Trinidad and Tobago', 'TT', 'TTO', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (214, 'Tunisia', 'TN', 'TUN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (215, 'Turkey', 'TR', 'TUR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (216, 'Turkmenistan', 'TM', 'TKM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (217, 'Turks and Caicos Islands', 'TC', 'TCA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (218, 'Tuvalu', 'TV', 'TUV', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (219, 'Uganda', 'UG', 'UGA', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (220, 'Ukraine', 'UA', 'UKR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (221, 'United Arab Emirates', 'AE', 'ARE', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (222, 'United Kingdom', 'GB', 'GBR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (223, 'United States', 'US', 'USA', 2);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (224, 'United States Minor Outlying Islands', 'UM', 'UMI', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (225, 'Uruguay', 'UY', 'URY', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (226, 'Uzbekistan', 'UZ', 'UZB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (227, 'Vanuatu', 'VU', 'VUT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (228, 'Vatican City State (Holy See)', 'VA', 'VAT', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (229, 'Venezuela', 'VE', 'VEN', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (230, 'Viet Nam', 'VN', 'VNM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (231, 'Virgin Islands (British)', 'VG', 'VGB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (232, 'Virgin Islands (U.S.)', 'VI', 'VIR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (233, 'Wallis and Futuna Islands', 'WF', 'WLF', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (234, 'Western Sahara', 'EH', 'ESH', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (235, 'Yemen', 'YE', 'YEM', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (236, 'Yugoslavia', 'YU', 'YUG', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (237, 'Zaire', 'ZR', 'ZAR', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (238, 'Zambia', 'ZM', 'ZMB', 1);
INSERT INTO countries (countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id) VALUES (239, 'Zimbabwe', 'ZW', 'ZWE', 1);



DROP TABLE IF EXISTS coupon_email_track;
CREATE TABLE coupon_email_track (
  unique_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  coupon_id int(11) NOT NULL default '0',
  customer_id_sent int(11) NOT NULL default '0',
  sent_firstname varchar(32) default NULL,
  sent_lastname varchar(32) default NULL,
  emailed_to varchar(32) default NULL,
  date_sent datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (unique_id)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS coupon_gv_customer;
CREATE TABLE coupon_gv_customer (
  customer_id int(5) NOT NULL default '0',
  store_id int(11) NOT NULL default '1',
  amount decimal(8,4) NOT NULL default '0.0000',
  PRIMARY KEY  (customer_id),
  KEY customer_id (customer_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS coupon_gv_queue;
CREATE TABLE coupon_gv_queue (
  unique_id int(5) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  customer_id int(5) NOT NULL default '0',
  order_id int(5) NOT NULL default '0',
  amount decimal(8,4) NOT NULL default '0.0000',
  date_created datetime NOT NULL default '0000-00-00 00:00:00',
  ipaddr varchar(32) NOT NULL default '',
  release_flag char(1) NOT NULL default 'N',
  PRIMARY KEY  (unique_id),
  KEY uid (unique_id,customer_id,order_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS coupon_redeem_track;
CREATE TABLE coupon_redeem_track (
  unique_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  coupon_id int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '0',
  redeem_date datetime NOT NULL default '0000-00-00 00:00:00',
  redeem_ip varchar(32) NOT NULL default '',
  order_id int(11) NOT NULL default '0',
  PRIMARY KEY  (unique_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS coupons;
CREATE TABLE coupons (
  coupon_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  coupon_type char(1) NOT NULL default 'F',
  coupon_code varchar(32) NOT NULL default '',
  coupon_amount decimal(8,4) NOT NULL default '0.0000',
  coupon_minimum_order decimal(8,4) NOT NULL default '0.0000',
  coupon_start_date datetime NOT NULL default '0000-00-00 00:00:00',
  coupon_expire_date datetime NOT NULL default '0000-00-00 00:00:00',
  uses_per_coupon int(5) NOT NULL default '1',
  uses_per_user int(5) NOT NULL default '0',
  restrict_to_products varchar(255) default NULL,
  restrict_to_categories varchar(255) default NULL,
  restrict_to_customers text,
  coupon_active char(1) NOT NULL default 'Y',
  date_created datetime NOT NULL default '0000-00-00 00:00:00',
  date_modified datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (coupon_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS coupons_description;
CREATE TABLE coupons_description (
  coupon_id int(11) NOT NULL default '0',
  store_id int(11) NOT NULL default '1',
  language_id int(11) NOT NULL default '0',
  coupon_name varchar(32) NOT NULL default '',
  coupon_description text,
  KEY coupon_id (coupon_id)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS currencies;
CREATE TABLE currencies (
  currencies_id int(11) NOT NULL auto_increment,
  title varchar(32) NOT NULL default '',
  code char(3) NOT NULL default '',
  symbol_left varchar(12) default NULL,
  symbol_right varchar(12) default NULL,
  decimal_point char(1) default NULL,
  thousands_point char(1) default NULL,
  decimal_places char(1) default NULL,
  value float(13,8) default NULL,
  last_updated datetime default NULL,
  PRIMARY KEY  (currencies_id),
  KEY idx_currencies_code (`code`)
) ENGINE=MyISAM;



INSERT INTO currencies (currencies_id, title, code, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, value, last_updated) VALUES (1, 'US Dollar', 'USD', '$', '', '.', ',', '2', 1.00000000, '2003-08-14 18:07:14');



DROP TABLE IF EXISTS customers;
CREATE TABLE customers (
  customers_id int(11) NOT NULL auto_increment,
  customers_gender char(1) NOT NULL default '',
  customers_firstname varchar(32) NOT NULL default '',
  customers_lastname varchar(32) NOT NULL default '',
  customers_dob varchar(32) NOT NULL default '',
  customers_email_address varchar(96) NOT NULL default '',
  customers_default_address_id int(11) NOT NULL default '0',
  customers_telephone varchar(32) NOT NULL default '',
  customers_fax varchar(32) default NULL,
  customers_password varchar(40) NOT NULL default '',
  customers_newsletter char(1) default NULL,
  PRIMARY KEY  (customers_id),
  KEY idx_customers_email_address (customers_email_address)
) ENGINE=MyISAM;



INSERT INTO customers (customers_id, customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_default_address_id, customers_telephone, customers_fax, customers_password, customers_newsletter) VALUES (1, '', 'Peter', 'McGrath', '01-01-1970', 'pmcgrath@systemsmanager.net', 1, '5555555555', '', '696fae97f68ba0286c66aec623412b83:a9', '');


DROP TABLE IF EXISTS customers_basket;
CREATE TABLE customers_basket (
  customers_basket_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  customers_basket_quantity int(2) NOT NULL default '0',
  final_price decimal(15,4) NOT NULL default '0.0000',
  customers_basket_date_added varchar(8) default NULL,
  store_id int(11) NOT NULL default '1',
  PRIMARY KEY  (customers_basket_id),
  KEY idx_customers_basket_customers_id (customers_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS customers_basket_attributes;
CREATE TABLE customers_basket_attributes (
  customers_basket_attributes_id int(11) NOT NULL auto_increment,
  customers_id int(11) NOT NULL default '0',
  products_id tinytext NOT NULL,
  products_options_id int(11) NOT NULL default '0',
  products_options_value_id int(11) NOT NULL default '0',
  store_id int(11) NOT NULL default '1',
  PRIMARY KEY  (customers_basket_attributes_id),
  KEY idx_customers_basket_att_customers_id (customers_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS customers_info;
CREATE TABLE customers_info (
  customers_info_id int(11) NOT NULL default '0',
  customers_info_date_of_last_logon datetime default NULL,
  customers_info_number_of_logons int(5) default NULL,
  customers_info_date_account_created datetime default NULL,
  customers_info_date_account_last_modified datetime default NULL,
  global_product_notifications int(1) default '0',
  PRIMARY KEY  (customers_info_id)
) ENGINE=MyISAM;



INSERT INTO customers_info (customers_info_id, customers_info_date_of_last_logon, customers_info_number_of_logons, customers_info_date_account_created, customers_info_date_account_last_modified, global_product_notifications) VALUES (1, '2004-12-27 10:29:14', 30, '2004-11-24 20:34:51', NULL, 0);



DROP TABLE IF EXISTS dynamic_page_index;
CREATE TABLE dynamic_page_index (
  store_id int(11) NOT NULL default '1',
  page_id tinyint(4) NOT NULL auto_increment,
  page_name varchar(64) default NULL,
  page_type varchar(64) default NULL,
  PRIMARY KEY  (page_id,store_id)
) ENGINE=MyISAM;


INSERT INTO dynamic_page_index (store_id, page_id, page_name, page_type) VALUES (1, 1, 'Mall_Conditions', 'web_pages');


DROP TABLE IF EXISTS geo_zones;
CREATE TABLE geo_zones (
  store_id int(11) NOT NULL default '1',
  geo_zone_id int(11) NOT NULL auto_increment,
  geo_zone_name varchar(32) NOT NULL default '',
  geo_zone_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (geo_zone_id,store_id)
) ENGINE=MyISAM;


INSERT INTO geo_zones (store_id, geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added) VALUES (1, 1, 'Florida', 'Florida local sales tax zone', NULL, '2003-08-14 18:07:14');

DROP TABLE IF EXISTS help;
CREATE TABLE `help` (
  help_id int(11) NOT NULL auto_increment,
  help_file varchar(64) NOT NULL,
  help_file_tab varchar(64) NOT NULL default 'false',
  help_custom varchar(64) NOT NULL default 'false',
  KEY help_id (help_id)
) ENGINE=MyISAM AUTO_INCREMENT=1 ;
DROP TABLE IF EXISTS help_content;
CREATE TABLE help_content (
  help_id int(11) NOT NULL,
  help_content text NOT NULL,
  language_id int(11) NOT NULL,
  PRIMARY KEY  (help_id,language_id)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS languages;
CREATE TABLE languages (
  store_id int(11) NOT NULL default '1',
  languages_id int(11) NOT NULL auto_increment,
  name varchar(32) NOT NULL default '',
  code char(2) NOT NULL default '',
  image varchar(64) default NULL,
  directory varchar(32) default NULL,
  sort_order int(3) default NULL,
  PRIMARY KEY  (store_id,languages_id),
  KEY IDX_LANGUAGES_NAME (languages_id)
) ENGINE=MyISAM;



INSERT INTO languages (store_id, languages_id, name, code, image, directory, sort_order) VALUES (1, 1, 'english', 'en', 'english.gif', 'english', 1);



DROP TABLE IF EXISTS manufacturers;
CREATE TABLE manufacturers (
  store_id int(11) NOT NULL default '1',
  manufacturers_id int(11) NOT NULL auto_increment,
  manufacturers_name varchar(32) NOT NULL default '',
  manufacturers_image varchar(64) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (manufacturers_id),
  KEY IDX_MANUFACTURERS_NAME (manufacturers_name)
) ENGINE=MyISAM;




DROP TABLE IF EXISTS manufacturers_info;
CREATE TABLE manufacturers_info (
  manufacturers_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  manufacturers_url varchar(255) NOT NULL default '',
  url_clicked int(5) NOT NULL default '0',
  date_last_click datetime default NULL,
  PRIMARY KEY  (manufacturers_id,languages_id)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS member_orders;
CREATE TABLE member_orders (
  member_orders_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  store_id int(11) NOT NULL default '1',
  products_id int(11) NOT NULL default '0',
  customer_id int(11) NOT NULL default '0',
  products_end_date varchar(16) NOT NULL default '0000-00-00',
  PRIMARY KEY  (member_orders_id,store_id)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS newsletters;
CREATE TABLE newsletters (
  store_id int(11) NOT NULL default '1',
  newsletters_id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  content text NOT NULL,
  module varchar(255) NOT NULL default '',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  date_sent datetime default NULL,
  status int(1) default NULL,
  locked int(1) default '0',
  PRIMARY KEY  (newsletters_id,store_id)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS orders;
CREATE TABLE orders (
  orders_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  customers_id int(11) NOT NULL default '0',
  customers_name varchar(64) NOT NULL default '',
  customers_company varchar(32) default NULL,
  customers_street_address varchar(64) NOT NULL default '',
  customers_city varchar(32) NOT NULL default '',
  customers_postcode varchar(10) NOT NULL default '',
  customers_state varchar(32) default NULL,
  customers_country varchar(32) NOT NULL default '',
  customers_telephone varchar(32) NOT NULL default '',
  customers_email_address varchar(96) NOT NULL default '',
  customers_address_format_id int(5) NOT NULL default '0',
  delivery_name varchar(64) NOT NULL default '',
  delivery_company varchar(32) default NULL,
  delivery_street_address varchar(64) NOT NULL default '',
  delivery_city varchar(32) NOT NULL default '',
  delivery_postcode varchar(10) NOT NULL default '',
  delivery_state varchar(32) default NULL,
  delivery_country varchar(32) NOT NULL default '',
  delivery_address_format_id int(5) NOT NULL default '0',
  billing_name varchar(64) NOT NULL default '',
  billing_company varchar(32) default NULL,
  billing_street_address varchar(64) NOT NULL default '',
  billing_city varchar(32) NOT NULL default '',
  billing_postcode varchar(10) NOT NULL default '',
  billing_state varchar(32) default NULL,
  billing_country varchar(32) NOT NULL default '',
  billing_address_format_id int(5) NOT NULL default '0',
  payment_method varchar(255) NOT NULL,
  cc_type varchar(20) default NULL,
  cc_owner varchar(64) default NULL,
  cc_number varchar(32) default NULL,
  cc_expires varchar(4) default NULL,
  last_modified datetime default NULL,
  date_purchased datetime default NULL,
  orders_status int(5) NOT NULL default '0',
  orders_date_finished datetime default NULL,
  currency char(3) default NULL,
  currency_value decimal(14,6) default NULL,
  PRIMARY KEY  (orders_id),
  KEY idx_orders_customers_id (customers_id)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS orders_invoice;
CREATE TABLE orders_invoice (
  orders_invoice_id int(11) unsigned NOT NULL auto_increment,
  orders_id int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (orders_invoice_id,orders_id)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS orders_products;
CREATE TABLE orders_products (
  orders_products_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  products_id int(11) NOT NULL default '0',
  products_model varchar(12) default NULL,
  products_name varchar(64) NOT NULL default '',
  products_price decimal(15,4) NOT NULL default '0.0000',
  final_price decimal(15,4) NOT NULL default '0.0000',
  products_tax decimal(7,4) NOT NULL default '0.0000',
  products_quantity int(2) NOT NULL default '0',
  PRIMARY KEY  (orders_products_id),
  KEY idx_orders_products_orders_id (orders_id),
  KEY idx_orders_products_products_id (products_id)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS orders_products_attributes;
CREATE TABLE orders_products_attributes (
  orders_products_attributes_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_products_id int(11) NOT NULL default '0',
  products_options varchar(32) NOT NULL default '',
  products_options_values varchar(32) NOT NULL default '',
  options_values_price decimal(15,4) NOT NULL default '0.0000',
  price_prefix char(1) NOT NULL default '',
  PRIMARY KEY  (orders_products_attributes_id),
  KEY idx_orders_products_att_orders_id (orders_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS orders_products_download;
CREATE TABLE orders_products_download (
  orders_products_download_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_products_id int(11) NOT NULL default '0',
  orders_products_filename varchar(255) NOT NULL default '',
  download_maxdays int(2) NOT NULL default '0',
  download_count int(2) NOT NULL default '0',
  PRIMARY KEY  (orders_products_download_id),
  KEY idx_orders_products_download_orders_id (orders_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS orders_status;
CREATE TABLE orders_status (
  orders_status_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  orders_status_name varchar(32) NOT NULL default '',
  public_flag int(11) default '1',
  downloads_flag int(11) default '0',
  PRIMARY KEY  (orders_status_id,language_id),
  KEY idx_orders_status_name (orders_status_name)
) ENGINE=MyISAM;


INSERT INTO orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) VALUES (1, 1, 'Pending', 1, 0);
INSERT INTO orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) VALUES (2, 1, 'Processing', 1, 0);
INSERT INTO orders_status (orders_status_id, language_id, orders_status_name, public_flag, downloads_flag) VALUES (3, 1, 'Delivered', 1, 0);



DROP TABLE IF EXISTS orders_status_history;
CREATE TABLE orders_status_history (
  orders_status_history_id int(11) NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  orders_status_id int(5) NOT NULL default '0',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  customer_notified int(1) default '0',
  comments text,
  PRIMARY KEY  (orders_status_history_id),
  KEY idx_orders_status_history_orders_id (orders_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS orders_total;
CREATE TABLE orders_total (
  orders_total_id int(10) unsigned NOT NULL auto_increment,
  orders_id int(11) NOT NULL default '0',
  title varchar(255) NOT NULL default '',
  text varchar(255) NOT NULL default '',
  value decimal(15,4) NOT NULL default '0.0000',
  class varchar(32) NOT NULL default '',
  sort_order int(11) NOT NULL default '0',
  PRIMARY KEY  (orders_total_id),
  KEY idx_orders_total_orders_id (orders_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS orders_tracking;
CREATE TABLE orders_tracking (
  orders_tracking_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  orders_id int(11) NOT NULL default '1',
  value decimal(15,4) NOT NULL default '0.0000',
  date date NOT NULL default '0000-00-00',
  PRIMARY KEY  (orders_tracking_id,store_id)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS orders_vendor_amount;
CREATE TABLE orders_vendor_amount (
  orders_vendor_amount_id int(11) NOT NULL auto_increment,
  orders_id int(11) default '0',
  subtotal decimal(15,4) NOT NULL default '0.0000',
  shipping_method varchar(255) NOT NULL default '',
  shipping_charge decimal(15,4) NOT NULL default '0.0000',
  total decimal(15,4) NOT NULL default '0.0000',
  PRIMARY KEY  (orders_vendor_amount_id)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS products;
CREATE TABLE products (
  products_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  products_quantity int(4) NOT NULL default '0',
  products_model varchar(16) default NULL,
  products_image varchar(64) default NULL,
  products_price decimal(15,4) NOT NULL default '0.0000',
  products_date_added datetime NOT NULL default '0000-00-00 00:00:00',
  products_last_modified datetime default NULL,
  products_date_available datetime default NULL,
  products_weight decimal(5,2) NOT NULL default '0.00',
  products_status tinyint(1) NOT NULL default '0',
  products_tax_class_id int(11) NOT NULL default '0',
  manufacturers_id int(11) default NULL,
  products_ordered int(11) NOT NULL default '0',
  products_type int(11) NOT NULL default '0',
  PRIMARY KEY  (products_id,store_id),
  KEY idx_products_date_added (products_date_added),
  KEY idx_products_model (products_model)
) ENGINE=MyISAM;



INSERT INTO products (products_id, store_id, products_quantity, products_model, products_image, products_price, products_date_added, products_last_modified, products_date_available, products_weight, products_status, products_tax_class_id, manufacturers_id, products_ordered, products_type) VALUES (1, 1, 10000, 'mem_6_retail10', 'bas.gif', 10.9900, '2004-11-24 20:29:37', NULL, '0000-00-00 00:00:00', 0.00, 1, 1, 1, 0, 0);


DROP TABLE IF EXISTS products_attributes;
CREATE TABLE products_attributes (
  store_id int(11) NOT NULL default '1',
  products_attributes_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  options_id int(11) NOT NULL default '0',
  options_values_id int(11) NOT NULL default '0',
  options_values_price decimal(15,4) NOT NULL default '0.0000',
  price_prefix char(1) NOT NULL default '',
  sort_order int(11) NOT NULL default '0',
  PRIMARY KEY  (products_attributes_id,store_id),
  KEY idx_products_attributes_products_id (products_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS products_attributes_download;
CREATE TABLE products_attributes_download (
  store_id int(11) NOT NULL default '1',
  products_attributes_id int(11) NOT NULL default '0',
  products_attributes_filename varchar(255) NOT NULL default '',
  products_attributes_maxdays int(2) default '0',
  products_attributes_maxcount int(2) default '0',
  PRIMARY KEY  (products_attributes_id,store_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS products_description;
CREATE TABLE products_description (
  products_id int(11) NOT NULL auto_increment,
  language_id int(11) NOT NULL default '1',
  products_name varchar(64) NOT NULL default '',
  products_description text,
  products_head_title_tag varchar(80) default NULL,
  products_head_desc_tag longtext,
  products_head_keywords_tag longtext,
  products_url varchar(255) default NULL,
  products_viewed int(5) default '0',
  PRIMARY KEY  (products_id,language_id),
  KEY products_name (products_name)
) ENGINE=MyISAM;


INSERT INTO products_description (products_id, language_id, products_name, products_description, products_head_title_tag, products_head_desc_tag, products_head_keywords_tag, products_url, products_viewed) VALUES (1, 1, '10 Item Retail Shop', 'List up to ten items in this shop', NULL, NULL, NULL, 'www.systemsmanager.net', 15);



DROP TABLE IF EXISTS products_notifications;
CREATE TABLE products_notifications (
  store_id int(11) NOT NULL default '1',
  products_id int(11) NOT NULL default '0',
  customers_id int(11) NOT NULL default '0',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (products_id,customers_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS products_options;
CREATE TABLE products_options (
  store_id int(11) NOT NULL default '1',
  products_options_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  products_options_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (products_options_id,language_id,store_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS products_options_values;
CREATE TABLE products_options_values (
  store_id int(11) NOT NULL default '1',
  products_options_values_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  products_options_values_name varchar(64) NOT NULL default '',
  PRIMARY KEY  (products_options_values_id,language_id,store_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS products_options_values_to_products_options;
CREATE TABLE products_options_values_to_products_options (
  store_id int(11) NOT NULL default '1',
  products_options_values_to_products_options_id int(11) NOT NULL auto_increment,
  products_options_id int(11) NOT NULL default '0',
  products_options_values_id int(11) NOT NULL default '0',
  PRIMARY KEY  (products_options_values_to_products_options_id,store_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS products_to_categories;
CREATE TABLE products_to_categories (
  store_id int(11) NOT NULL default '1',
  products_id int(11) NOT NULL default '0',
  categories_id int(11) NOT NULL default '0',
  PRIMARY KEY  (store_id,products_id,categories_id)
) ENGINE=MyISAM;



INSERT INTO products_to_categories (store_id, products_id, categories_id) VALUES (1, 1, 1);


DROP TABLE IF EXISTS reviews;
CREATE TABLE reviews (
  store_id int(11) NOT NULL default '1',
  reviews_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  customers_id int(11) default NULL,
  customers_name varchar(64) NOT NULL default '',
  reviews_rating int(1) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  reviews_read int(5) NOT NULL default '0',
  PRIMARY KEY  (reviews_id,store_id),
  KEY idx_reviews_products_id (products_id),
  KEY idx_reviews_customers_id (customers_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS reviews_description;
CREATE TABLE reviews_description (
  store_id int(11) NOT NULL default '1',
  reviews_id int(11) NOT NULL default '0',
  languages_id int(11) NOT NULL default '0',
  reviews_text text NOT NULL,
  PRIMARY KEY  (reviews_id,languages_id,store_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS sessions;
CREATE TABLE sessions (
  sesskey varchar(32) NOT NULL default '',
  expiry int(11) unsigned NOT NULL default '0',
  value text NOT NULL,
  PRIMARY KEY  (sesskey)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS specials;
CREATE TABLE specials (
  store_id int(11) NOT NULL default '1',
  specials_id int(11) NOT NULL auto_increment,
  products_id int(11) NOT NULL default '0',
  specials_new_products_price decimal(15,4) NOT NULL default '0.0000',
  specials_date_added datetime default NULL,
  specials_last_modified datetime default NULL,
  expires_date datetime default NULL,
  date_status_change datetime default NULL,
  status int(1) NOT NULL default '1',
  PRIMARY KEY  (specials_id),
  KEY idx_specials_products_id (products_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS store_categories;
CREATE TABLE store_categories (
  store_categories_id int(11) NOT NULL auto_increment,
  store_categories_image varchar(64) default NULL,
  store_parent_id int(11) NOT NULL default '0',
  sort_order int(3) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  PRIMARY KEY  (store_categories_id),
  KEY idx_categories_parent_id (store_parent_id)
) ENGINE=MyISAM;



INSERT INTO store_categories (store_categories_id, store_categories_image, store_parent_id, sort_order, date_added, last_modified) VALUES (1, 'bas.gif', 0, 0, '2006-02-16 13:26:29', NULL);
INSERT INTO store_categories (store_categories_id, store_categories_image, store_parent_id, sort_order, date_added, last_modified) VALUES (2, 'bas.gif', 0, 0, '2006-02-16 13:26:42', NULL);


DROP TABLE IF EXISTS store_categories_description;
CREATE TABLE store_categories_description (
  store_categories_id int(11) NOT NULL default '0',
  language_id int(11) NOT NULL default '1',
  store_categories_name varchar(32) NOT NULL default '',
  store_categories_description text NOT NULL,
  PRIMARY KEY  (store_categories_id,language_id),
  KEY idx_categories_name (store_categories_name)
) ENGINE=MyISAM;


INSERT INTO store_categories_description (store_categories_id, language_id, store_categories_name, store_categories_description) VALUES (1, 1, 'Yard Sale', 'yard sale items');
INSERT INTO store_categories_description (store_categories_id, language_id, store_categories_name, store_categories_description) VALUES (2, 1, 'Art Work', 'Art work items');



DROP TABLE IF EXISTS store_costs;
CREATE TABLE store_costs (
  store_id int(11) NOT NULL default '1',
  monthly_costs float NOT NULL default '0',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  account_paid varchar(15) NOT NULL default 'false',
  PRIMARY KEY  (store_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS store_description;
CREATE TABLE store_description (
  store_id int(11) NOT NULL default '1',
  language_id int(11) NOT NULL default '1',
  store_name varchar(64) NOT NULL default '',
  store_description text,
  store_viewed int(5) default '0',
  PRIMARY KEY  (store_id,language_id),
  KEY products_name (store_name,store_id)
) ENGINE=MyISAM;


INSERT INTO store_description (store_id, language_id, store_name, store_description, store_viewed) VALUES (1, 1, 'oscMall Store', '<P align=center><FONT color=#0033ff size=4><U><STRONG>Welcome to the osCMall System</STRONG></U></FONT> </P>\r\n<TABLE cellSpacing=1 cellPadding=2 width=\\"100%\\" border=0>\r\n<TBODY>\r\n<TR>\r\n<TD class=main>\r\n<P>Maintained and developed by <STRONG>SystemsManager Technologies</STRONG>, with over five years of osCommerce development experience. Working with and customizing many clients software to provide the functionality they required, we deliver results! </P>\r\n<P>&nbsp;</P></TD></TR>\r\n<TR>\r\n<TD class=main>\r\n<P>This software is Licensed under the <a href="http://www.gnu.org/copyleft/gpl.html"><STRONG>GNU GPL</STRONG></a>, which gives you the freedom to use, modify and distribute the code as you wish to, as long as the GPL license requirements have been met. </P>\r\n<P>&nbsp;</P></TD></TR>\r\n<TR>\r\n<TD class=main>\r\n<P>If you need custom code development, we&nbsp;at SystemsManager Technologies are available for customization work, or if you perfer, you are welcome to post on our <STRONG>FREE Script Bid Site</STRONG> which caters to osCommerce/osCMall/CRE Loaded related projects. </P>\r\n<P>Some useful Links:</P>\r\n<P><A href=\\"http://www.systemsmanager.net/contact_us.php?ID=1\\">Contact SystemsManager Technologies </A></P>\r\n<P><A href=\\"http://forum.systemsmanager.net\\">Free online Support </A></P>\r\n<P><A href=\\"http://www.systemsmanager.net/product_info.php?ID=1&products_id=191\\">Purchase the osCMall Admin Users eBook </A></P>\r\n<P><A href=\\"http://www.oscdevshed.com\\">The osCDevShed Script Bid Site</A></P>\r\n<P>We hope that this system meets your needs being based on the <STRONG>World Class</STRONG> cart system osCommerce, we have extended the functionality to allow for multiple vendors to manage their own on-line shop within the mall system.&nbsp;</P></TD></TR></TBODY></TABLE>', 100);



DROP TABLE IF EXISTS store_main;
CREATE TABLE store_main (
  store_id int(11) NOT NULL auto_increment,
  customer_id int(11) NOT NULL default '1',
  store_type tinyint(4) NOT NULL default '1',
  store_image varchar(255) default NULL,
  store_status int(1) NOT NULL default '1',
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (store_id),
  KEY customer_id (customer_id)
) ENGINE=MyISAM;


INSERT INTO store_main (store_id, customer_id, store_type, store_image, store_status, date_added) VALUES (1, 1, 1, 'logo.gif', 1, '0000-00-00 00:00:00');



DROP TABLE IF EXISTS store_reviews;
CREATE TABLE store_reviews (
  store_id int(11) NOT NULL default '1',
  reviews_id int(11) NOT NULL auto_increment,
  customers_id int(11) default NULL,
  customers_name varchar(64) NOT NULL default '',
  reviews_rating int(1) default NULL,
  date_added datetime default NULL,
  last_modified datetime default NULL,
  reviews_read int(5) NOT NULL default '0',
  PRIMARY KEY  (reviews_id,store_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS store_to_categories;
CREATE TABLE store_to_categories (
  store_id int(11) NOT NULL default '1',
  store_categories_id int(11) NOT NULL default '0',
  PRIMARY KEY  (store_id,store_categories_id)
) ENGINE=MyISAM;



DROP TABLE IF EXISTS store_types;
CREATE TABLE store_types (
  store_types_id tinyint(4) NOT NULL auto_increment,
  store_types_name varchar(32) NOT NULL default 'mall',
  PRIMARY KEY  (store_types_id)
) ENGINE=MyISAM;


INSERT INTO store_types (store_types_id, store_types_name) VALUES (1, 'mall');
INSERT INTO store_types (store_types_id, store_types_name) VALUES (2, 'retail');



DROP TABLE IF EXISTS tax_class;
CREATE TABLE tax_class (
  store_id int(11) NOT NULL default '1',
  tax_class_id int(11) NOT NULL auto_increment,
  tax_class_title varchar(32) NOT NULL default '',
  tax_class_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (tax_class_id,store_id)
) ENGINE=MyISAM;


INSERT INTO tax_class (store_id, tax_class_id, tax_class_title, tax_class_description, last_modified, date_added) VALUES (1, 1, 'Taxable Goods', 'The following types of products are included non-food, services, etc', '2003-08-14 18:07:14', '2003-08-14 18:07:14');


DROP TABLE IF EXISTS tax_rates;
CREATE TABLE tax_rates (
  store_id int(11) NOT NULL default '1',
  tax_rates_id int(11) NOT NULL auto_increment,
  tax_zone_id int(11) NOT NULL default '0',
  tax_class_id int(11) NOT NULL default '0',
  tax_priority int(5) default '1',
  tax_rate decimal(7,4) NOT NULL default '0.0000',
  tax_description varchar(255) NOT NULL default '',
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (tax_rates_id,store_id)
) ENGINE=MyISAM;



INSERT INTO tax_rates (store_id, tax_rates_id, tax_zone_id, tax_class_id, tax_priority, tax_rate, tax_description, last_modified, date_added) VALUES (1, 1, 1, 1, 1, 7.0000, 'FL TAX 7.0%', '2003-08-14 18:07:14', '2003-08-14 18:07:14');


DROP TABLE IF EXISTS template;
CREATE TABLE template (
  template_id int(11) NOT NULL auto_increment,
  template_name varchar(32) default NULL,
  thema varchar(32) default NULL,
  PRIMARY KEY  (template_id)
) ENGINE=MyISAM;



INSERT INTO template (template_id, template_name, thema) VALUES (1, 'smn_original', 'blue');
INSERT INTO template (template_id, template_name, thema) VALUES (2, 'smn_original', 'light_blue');
INSERT INTO template (template_id, template_name, thema) VALUES (3, 'smn_original', 'light_brown');
INSERT INTO template (template_id, template_name, thema) VALUES (4, 'smn_original', 'gold');
INSERT INTO template (template_id, template_name, thema) VALUES (5, 'smn_original', 'gray');
INSERT INTO template (template_id, template_name, thema) VALUES (6, 'smn_original', 'red');



DROP TABLE IF EXISTS web_site_content;
CREATE TABLE web_site_content (
  store_id int(11) NOT NULL default '1',
  page_name varchar(32) NOT NULL default '',
  text_key varchar(64) NOT NULL default '',
  language_id tinyint(4) NOT NULL default '1',
  text_content longtext,
  date_modified date default '0000-00-00',
  KEY page_name (page_name),
  FULLTEXT KEY text_key (text_key)
) ENGINE=MyISAM;



INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'NAVBAR_TITLE', 1, 'All Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'HEADING_TITLE', 1, 'All Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_IMAGE', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_MODEL', 1, 'Destination', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_PRODUCTS', 1, 'Products Name', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_MANUFACTURER', 1, 'Wholesaler', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_QUANTITY', 1, 'Quantity', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_PRICE', 1, 'Price starting at', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_WEIGHT', 1, 'Weight', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'allprods', 'TABLE_HEADING_BUY_NOW', 1, ' ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'HEADING_TITLE', 1, 'Advanced Search', '2004-12-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'HEADING_TITLE', 1, 'Advanced Search', '2004-12-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_faq', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program FAQ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_faq', 'HEADING_TITLE', 1, 'Affiliate Agent Program - Frequently Asked Questions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_contact', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_contact', 'HEADING_TITLE', 1, 'Affiliate Agent Program - Contact Form', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_contact', 'TEXT_SUCCESS', 1, 'Your message has been successfully sent to the Affiliate Agent Program Team', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_contact', 'EMAIL_SUBJECT', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_contact', 'ENTRY_NAME', 1, 'Your Full Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_contact', 'ENTRY_EMAIL', 1, 'Your E-Mail:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_contact', 'ENTRY_ENQUIRY', 1, 'Your Message:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_text', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_text', 'HEADING_TITLE', 1, 'Affiliate Agent Program - Text Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_text', 'TEXT_AFFILIATE_NAME', 1, 'Link Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_text', 'TEXT_INFORMATION', 1, 'Choose the link you want to display on your website from the choices below:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_text', 'TEXT_AFFILIATE_INFO', 1, 'Copy the code shown below and paste into your website', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details', 'NAVBAR_TITLE_1', 1, 'The Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details', 'NAVBAR_TITLE_2', 1, 'Edit Affiliate Agent Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details', 'HEADING_TITLE', 1, 'The Affiliate Agent Program - Your Account Details<br><small>You may edit any information below:</small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details_ok', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details_ok', 'HEADING_TITLE', 1, 'Your Account Details were changed!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'HEADING_TITLE', 1, 'Affiliate Agent Program: Clickthroughs', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TABLE_HEADING_DATE', 1, 'Date', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TABLE_HEADING_REFFERED', 1, 'Referrer', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TABLE_HEADING_IP', 1, 'IP Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TABLE_HEADING_BROWSER', 1, 'Browser', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TABLE_HEADING_CLICKED_PRODUCT', 1, 'Tour, Package or Page', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_AFFILIATE_HEADER', 1, 'Total clickthroughs from your site:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_NO_CLICKS', 1, 'No clickthroughs have been recorded from your site.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_CLICKTHROUGH_HELP', 1, '<font color="#FFFFFF">[?]</font>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_CLICKS', 1, 'Click on [?] to see a description of each category.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'HEADING_CLICKTHROUGH_HELP', 1, 'Affiliate Agent Help', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_DATE_HELP', 1, '<i>Date</i> represents the date of the clickthrough from your site.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_CLICKED_PRODUCT_HELP', 1, '<i>Tour, Package or Page</i> represents the page, tour or package clicked through to', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_REFFERED_HELP', 1, '<i>Referrer</i> represents the url that the clickthrough came from.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_clicks', 'TEXT_CLOSE_WINDOW', 1, 'Close Window [x]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_newsletter', 'NAVBAR_TITLE_1', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_newsletter', 'NAVBAR_TITLE_2', 1, 'Newsletter Subscriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_newsletter', 'HEADING_TITLE', 1, 'Newsletter Subscriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_newsletter', 'MY_NEWSLETTERS_TITLE', 1, 'My Newsletter Subscriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_newsletter', 'MY_NEWSLETTERS_AFFILIATE_NEWSLETTER', 1, 'Travel Agent Newsletter', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_newsletter', 'MY_NEWSLETTERS_AFFILIATE_NEWSLETTER_DESCRIPTION', 1, 'Including Affiliate Agent news, new products, special offers, and other promotional announcements.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_newsletter', 'SUCCESS_NEWSLETTER_UPDATED', 1, 'Your newsletter subscriptions have been successfully updated.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_logout', 'NAVBAR_TITLE', 1, 'The Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_logout', 'HEADING_TITLE', 1, 'The Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_logout', 'TEXT_INFORMATION', 1, 'You were logged out successfully.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_logout', 'TEXT_INFORMATION_ERROR_1', 1, 'You could not be logged out.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_logout', 'TEXT_INFORMATION_ERROR_2', 1, 'You were not logged in and can therefore not be logged out.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'HEADING_TITLE', 1, 'Affiliate Agent News', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'TABLE_HEADING_AFFILIATE_NEWS', 1, 'Affiliate Agent News', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'TEXT_AFFILIATE_NAME', 1, 'Banner Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'TEXT_INFORMATION', 1, 'Choose the banner or link you want to display on your website from the choices below:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'TEXT_AFFILIATE_INFO', 1, 'Copy the code shown below and paste into your website', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'TEXT_AFFILIATE_INDIVIDUAL_BANNER', 1, 'BUILD-A-LINK', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'TEXT_AFFILIATE_INDIVIDUAL_BANNER_INFO', 1, 'Enter the product number you wish to link to.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'IMAGE_BUTTON_BUILD_A_LINK', 1, 'Build a Link for a Product Banner.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'EMPTY_CATEGORY', 1, 'Empty Category', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_news', 'TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS', 1, 'No Child Category or Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_info', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_info', 'HEADING_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_info', 'TEXT_INFORMATION', 1, 'Your Affiliate Agent Information Goes in Here', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'HEADING_TITLE', 1, 'Affiliate Agent Program: Sales', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TABLE_HEADING_DATE', 1, 'Date', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TABLE_HEADING_SALES', 1, 'Affiliate Agent Earnings (excl.)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TABLE_HEADING_VALUE', 1, 'Sale Value (excl.)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TABLE_HEADING_PERCENTAGE', 1, 'Commission Rate', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TABLE_HEADING_STATUS', 1, 'Sale Status', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_DELETED_ORDER_BY_ADMIN', 1, 'Deleted (Admin)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_INFORMATION_SALES_TOTAL', 1, 'Your current earnings amount (excl.) to:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_INFORMATION_SALES_TOTAL2', 1, '<br>Only delivered sales are counted!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_NO_SALES', 1, 'No sales have been recorded yet.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_AFFILIATE_HEADER', 1, 'Sales from your homepage:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_SALES_HELP', 1, '<font color="#FFFFFF">[?]</font>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_SALES', 1, 'Click on [?] to see a description of each category.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'HEADING_SALES_HELP', 1, 'Affiliate Agent Help', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_DATE_HELP', 1, '<i>Date</i> represents the date of the sale.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_TIME_HELP', 1, '<i>Time</i> represents the time of the sale.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_SALE_VALUE_HELP', 1, '<i>Sale Value</i> represents the value of the sale.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_COMMISSION_RATE_HELP', 1, '<i>Commission Rate</i> represents the commission rate paid on the sale.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_COMMISSION_VALUE_HELP', 1, '<i>Affiliate Agent Earnings</i> represents the commission due on the sale.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_STATUS_HELP', 1, '<i>Sale Status</i> represents the status the sale.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_sales', 'TEXT_CLOSE_WINDOW', 1, 'Close Window [x]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password_forgotten', 'NAVBAR_TITLE_1', 1, 'Login', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password_forgotten', 'NAVBAR_TITLE_2', 1, 'Affiliate Agent Password Forgotten', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password_forgotten', 'HEADING_TITLE', 1, 'I\'ve Forgotten My Affiliate Agent Password!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password_forgotten', 'TEXT_NO_EMAIL_ADDRESS_FOUND', 1, '<font color="#ff0000"><b>NOTE:</b></font> The E-Mail Address was not found in our records. Please try again.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password_forgotten', 'TEXT_PASSWORD_SENT', 1, 'A New Affiliate Agent Password Has Been Sent To Your Email Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'HEADING_TITLE', 1, 'Affiliate Agent Program: Payment', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_AFFILIATE_HEADER', 1, 'Your Payments:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TABLE_HEADING_DATE', 1, 'Payment Date', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TABLE_HEADING_PAYMENT', 1, 'Affiliate Agent Earnings', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TABLE_HEADING_STATUS', 1, 'Payment Status', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TABLE_HEADING_PAYMENT_ID', 1, 'Payment-ID', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_INFORMATION_PAYMENT_TOTAL', 1, 'Your current earnings amount to:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_NO_PAYMENTS', 1, 'No payments have been recorded yet.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_PAYMENT_HELP', 1, '<font color="#FFFFFF">[?]</font>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_PAYMENT', 1, 'Click on [?] to see a description of each category.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'HEADING_PAYMENT_HELP', 1, 'Affiliate Agent Help', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_DATE_HELP', 1, '<i>Date</i> represents the date of the payment made to the Affiliate Agent.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_PAYMENT_ID_HELP', 1, '<i>Payment-ID</i> represents the payment number associated to the payment.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_PAYMENT_HELP', 1, '<i>Affiliate Agent Earnings</i> represents the value of payment made to the Affiliate Agent.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_STATUS_HELP', 1, '<i>Payment Status</i> represents the status of the payment made to the Affiliate Agent', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_payment', 'TEXT_CLOSE_WINDOW', 1, 'Close Window [x]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'HEADING_TITLE', 1, 'Affiliate Agent Program: Affiliate Agent Reports', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'TEXT_INFORMATION', 1, 'Obtain Affiliate Agent links that you can display on your website.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'TEXT_AFFILIATE_CLICKS', 1, 'Clickthrough Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'TEXT_AFFILIATE_SALES', 1, 'Sales Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'TEXT_AFFILIATE_PAYMENT', 1, 'Payment Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'TEXT_INFORMATION_CLICKS', 1, 'View Clickthrough information from your website', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'TEXT_INFORMATION_SALES', 1, 'View your current and previous Affiliate Agent Sales', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'TEXT_INFORMATION_PAYMENT', 1, 'View all Affiliate Agent payments made to you', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'IMAGE_CLICKS', 1, 'Clickthrough Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'IMAGE_SALES', 1, 'Sales Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_reports', 'IMAGE_PAYMENT', 1, 'Payment Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password', 'NAVBAR_TITLE_1', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password', 'NAVBAR_TITLE_2', 1, 'Change Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password', 'HEADING_TITLE', 1, 'My Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password', 'MY_PASSWORD_TITLE', 1, 'My Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password', 'SUCCESS_PASSWORD_UPDATED', 1, 'Your password has been successfully updated.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_password', 'ERROR_CURRENT_PASSWORD_NOT_MATCHING', 1, 'Your Current Password did not match the password in our records. Please try again.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup_ok', 'NAVBAR_TITLE', 1, 'Affiliate Agent Signup', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup_ok', 'HEADING_TITLE', 1, 'Congratulations!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'HEADING_TITLE', 1, 'Affiliate Agent Program - Sign Up', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_ACCEPT_AGB', 1, 'Accept Our Affiliate Agreement', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_ACCEPT_AGB_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_NEWSLETTER_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_NEWSLETTER', 1, 'Recieve Our Newsletter', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_HOMEPAGE_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_HOMEPAGE', 1, 'Web Page', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_COMPANY_TAXID', 1, 'Company Tax ID', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_COMPANY_TAXID_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_COMPANY_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_AFFILIATE_COMPANY', 1, 'Company', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'NAVBAR_TITLE', 1, 'Your Summary', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'HEADING_TITLE', 1, 'The Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_CENTRE', 1, 'Affiliate Agent Centre', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_BANNER_CENTRE', 1, 'Affiliate Agent Banners', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_REPORT_CENTRE', 1, 'Affiliate Agent Reports', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_INFO', 1, 'Affiliate Agent Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_SUMMARY', 1, 'Affiliate Agent Summary', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_PASSWORD', 1, 'Change Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_NEWS', 1, 'Affiliate Agent News', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_NEWSLETTER', 1, 'Newsletter', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_ACCOUNT', 1, 'Edit Affiliate Agent Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_REPORTS', 1, 'Affiliate Agent Reports', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_CLICKRATE', 1, 'Clickthrough Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_PAYMENT', 1, 'Payment Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_SALES', 1, 'Sales Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_BANNERS', 1, 'Affiliate Agent Banners', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_BANNERS_BANNERS', 1, 'Banner Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_BANNERS_BUILD', 1, 'Build a Link', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_BANNERS_PRODUCT', 1, 'Product Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_BANNERS_TEXT', 1, 'Text Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_INFORMATION', 1, 'Your Affiliate Agent Information goes here', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_SUMMARY_TITLE', 1, 'Affiliate Agent Summary', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_IMPRESSIONS', 1, 'Impressions: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_VISITS', 1, 'Visits: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_TRANSACTIONS', 1, 'Transactions: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_CONVERSION', 1, 'Conversion: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AMOUNT', 1, 'Sales Amount: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AVERAGE', 1, 'Sales Average: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_COMMISSION_RATE', 1, 'Commission Rate: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_PAYPERSALE_RATE', 1, 'Pay Per Sale Rate: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_CLICKTHROUGH_RATE', 1, 'Clickthrough Rate: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_COMMISSION', 1, 'Commission: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'HEADING_SUMMARY_HELP', 1, 'Affiliate Agent Help', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_SUMMARY_HELP', 1, '[?]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_SUMMARY', 1, 'Click on [?] to see a description of each category.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_IMPRESSIONS_HELP', 1, '<b>Impressions:</b> displays the total number of times a banner or link has been displayed in the given time period.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_VISITS_HELP', 1, '<b>Visits:</b> represents the total number of click-throughs by visitors from your website.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_TRANSACTIONS_HELP', 1, '<b>Transactions:</b> represents the total number of successful transactions credited to your account.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_CONVERSION_HELP', 1, '<b>Conversions:</b> represents the percentage of visitors (click-throughs) completing a transaction.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AMOUNT_HELP', 1, '<b>Sales Amount:</b> represents the total sales value of delivered orders credited to your account.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AVERAGE_HELP', 1, '<b>Sales Average:</b> represents the average sales value credited to your account.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_COMMISSION_RATE_HELP', 1, '<b>Commission Rate:</b> represents the rate you are paid for sales as a percentage.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_CLICKTHROUGH_RATE_HELP', 1, '<b>Clickthrough Rate:</b> represents the rate you are paid for clickthroughs on a per click basis.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_PAY_PER_SALE_RATE_HELP', 1, '<b>Pay Per Sale Rate:</b> represents the rate you are paid for sales on a sale by sale basis.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_COMMISSION_HELP', 1, '<b>Commissions:</b> represents the total commission owed to you as "Info Dollars".', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_CLOSE_WINDOW', 1, 'Close Window [x]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_GREETING', 1, 'Welcome ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'TEXT_AFFILIATE_ID', 1, 'Your Affiliate Agent ID: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'IMAGE_BANNERS', 1, 'Banners', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'IMAGE_CLICKTHROUGHS', 1, 'Clickthrough Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_summary', 'IMAGE_SALES', 1, 'Sales Report', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_terms', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_terms', 'HEADING_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_terms', 'TEXT_INFORMATION', 1, 'Affiliate Agent Terms', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'HEADING_TITLE', 1, 'Affiliate Agent Program: Affiliate Agent Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_INFORMATION', 1, 'Obtain a range of Affiliate Agent links that you can display on your website.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_AFFILIATE_BANNERS', 1, 'Banner Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_AFFILIATE_BANNERS_BUILD', 1, 'Build a Link', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_AFFILIATE_BANNERS_PRODUCT', 1, 'Product Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_AFFILIATE_BANNERS_TEXT', 1, 'Text Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_INFORMATION_BANNERS_BANNERS', 1, 'Effective HIGHLY colorful graphical links in various shapes and sizes', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_INFORMATION_BANNERS_BUILD', 1, 'Create dynamic links to a particular product of your choice.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_INFORMATION_BANNERS_PRODUCT', 1, 'Recommend specific tours or packages to your visitors by linking directly to a particular tour or package.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'TEXT_INFORMATION_BANNERS_TEXT', 1, 'Get maximum sales from these proven to-be-effective and easy-to-use text based links.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'IMAGE_BANNERS', 1, 'Banners', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'IMAGE_PRODUCT', 1, 'Tours & Packages Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'IMAGE_BUILD', 1, 'Build a Link', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners', 'IMAGE_TEXT', 1, 'Text Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_banners', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_banners', 'HEADING_TITLE', 1, 'Affiliate Agent Program - Banners', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_banners', 'TEXT_AFFILIATE_NAME', 1, 'Banner Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_banners', 'TEXT_INFORMATION', 1, 'Choose the banner you want to display on your website from the choices below:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_banners', 'TEXT_AFFILIATE_INFO', 1, 'Copy the code shown below and paste into your website', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'HEADING_TITLE', 1, 'Affiliate Agent Program - Build a Link', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_AFFILIATE_NAME', 1, 'Banner Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_INFORMATION', 1, 'Enter the number of the products you wish to build a link for:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_AFFILIATE_INFO', 1, 'Copy the code shown below and paste into your website', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_AFFILIATE_INDIVIDUAL_BANNER', 1, 'BUILD-A-LINK', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_AFFILIATE_INDIVIDUAL_BANNER_INFO', 1, 'Enter the tour or package number you wish to link to and press the enter&nbsp;', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_AFFILIATE_VALIDPRODUCTS', 1, 'Click Here:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_AFFILIATE_INDIVIDUAL_BANNER_VIEW', 1, 'to view available tours & packages.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_AFFILIATE_INDIVIDUAL_BANNER_HELP', 1, 'Select the tour or package number from the popup window and enter the number in the Build A Link field.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_VALID_PRODUCTS_LIST', 1, 'Available Products List', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_VALID_PRODUCTS_ID', 1, 'Products #', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_VALID_PRODUCTS_NAME', 1, 'Products Name', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'TEXT_CLOSE_WINDOW', 1, '<u>Close Window</u> [x]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_build', 'IMAGE_BUTTON_BUILD_A_LINK', 1, 'BUILD-A-LINK', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_product', 'NAVBAR_TITLE', 1, 'Affiliate Agent Program', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_product', 'HEADING_TITLE', 1, 'Affiliate Agent Program - Product Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_product', 'TEXT_AFFILIATE_NAME', 1, 'Tours & Packages Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_product', 'TEXT_INFORMATION', 1, 'Choose the tour or package you want to display on your website from the choices below:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_banners_product', 'TEXT_AFFILIATE_INFO', 1, 'Copy the code shown below and paste into your website', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'NAVBAR_TITLE', 1, 'Affiliate Agent Login', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'HEADING_TITLE', 1, 'Affiliate Agent Login', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'HEADING_TITLE_ERROR', 1, 'Registration Error', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_INTRO', 1, 'Who can become an <b>Affiliate Agent</b> with Us?  <b>Webmasters, website owners</b> or <b>website operators</b> anywhere in the world as well. Actually, becoming <b>Affiliate Agent</b> for us is very simple - and moneywise. For each buying customer refered from a website - or for each sale made for a tier, you will get <b>5%</b> of the total before taxes paid to you as "Info Dollars", which are virtual dollars you can use foy buying any travel services sold by us, including offers from known tour operators. With enough "Info Dollars".', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_AFFILIATE_LOGOFF', 1, 'Log Out', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_AFFILIATE_ID', 1, 'Affiliate Agent Email:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_AFFILIATE_PASSWORD', 1, 'Password:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'HEADING_NEW_AFFILIATE', 1, 'New Affiliate Agent', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_NEW_AFFILIATE', 1, 'I am a new Affiliate Agent.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_NEW_AFFILIATE_TERMS', 1, 'Our Affiliate Agent Terms & Conditions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'HEADING_RETURNING_AFFILIATE', 1, 'Returning Affiliate Agent', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_RETURNING_AFFILIATE', 1, 'I am a returning Affiliate Agent.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_AFFILIATE_PASSWORD_FORGOTTEN', 1, 'Password forgotten? Click here.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_LOGIN_ERROR', 1, '<font color="#ff0000"><b>ERROR:</b></font> No match for \'Affiliate Agent ID\' and/or \'Password\'.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_affiliate', 'TEXT_NEW_AFFILIATE_INTRODUCTION', 1, 'Affiliate Agent Login', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'NAVBAR_TITLE', 1, 'My Account', '2008-01-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'HEADING_TITLE', 1, 'My Account Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'OVERVIEW_TITLE', 1, 'Overview', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'OVERVIEW_SHOW_ALL_ORDERS', 1, '(show all orders)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'OVERVIEW_PREVIOUS_ORDERS', 1, 'Previous Orders', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ACCOUNT_TITLE', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ACCOUNT_INFORMATION', 1, 'View or change my account information.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ACCOUNT_ADDRESS_BOOK', 1, 'View or change entries in my address book.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ACCOUNT_PASSWORD', 1, 'Change my account password.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ORDERS_TITLE', 1, 'My Orders', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ORDERS_VIEW', 1, 'View the orders I have made.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'EMAIL_NOTIFICATIONS_TITLE', 1, 'E-Mail Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'EMAIL_NOTIFICATIONS_NEWSLETTERS', 1, 'Subscribe or unsubscribe from newsletters.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'EMAIL_NOTIFICATIONS_PRODUCTS', 1, 'View or change my product notification list.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'NAVBAR_TITLE_2', 1, 'Edit Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'HEADING_TITLE', 1, 'My Account Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'MY_ACCOUNT_TITLE', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'SUCCESS_ACCOUNT_UPDATED', 1, 'Your account has been successfully updated.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'NAVBAR_TITLE_2', 1, 'History', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'HEADING_TITLE', 1, 'My Order History', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_ORDER_NUMBER', 1, 'Order Number:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_ORDER_STATUS', 1, 'Order Status:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_ORDER_DATE', 1, 'Order Date:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_ORDER_SHIPPED_TO', 1, 'Shipped To:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_ORDER_BILLED_TO', 1, 'Billed To:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_ORDER_PRODUCTS', 1, 'Products:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_ORDER_COST', 1, 'Order Cost:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_VIEW_ORDER', 1, 'View Order', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history', 'TEXT_NO_PURCHASES', 1, 'You have not yet made any purchases.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'NAVBAR_TITLE_2', 1, 'History', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_TITLE', 1, 'Order Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_ORDER_DATE', 1, 'Order Date:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_ORDER_TOTAL', 1, 'Order Total:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_DELIVERY_ADDRESS', 1, 'Delivery Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_SHIPPING_METHOD', 1, 'Shipping Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_PRODUCTS', 1, 'Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_TAX', 1, 'Tax', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_TOTAL', 1, 'Total', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_BILLING_INFORMATION', 1, 'Billing Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_BILLING_ADDRESS', 1, 'Billing Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_PAYMENT_METHOD', 1, 'Payment Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_ORDER_HISTORY', 1, 'Order History', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_COMMENT', 1, 'Comments', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'TEXT_NO_COMMENTS_AVAILABLE', 1, 'No comments available.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'TABLE_HEADING_DOWNLOAD_DATE', 1, 'Link expires: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'TABLE_HEADING_DOWNLOAD_COUNT', 1, ' downloads remaining', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_history_info', 'HEADING_DOWNLOAD', 1, 'Download links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_newsletters', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_newsletters', 'NAVBAR_TITLE_2', 1, 'Newsletter Subscriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_newsletters', 'HEADING_TITLE', 1, 'Newsletter Subscriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_newsletters', 'MY_NEWSLETTERS_TITLE', 1, 'My Newsletter Subscriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_newsletters', 'MY_NEWSLETTERS_GENERAL_NEWSLETTER', 1, 'General Newsletter', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_newsletters', 'MY_NEWSLETTERS_GENERAL_NEWSLETTER_DESCRIPTION', 1, 'Including store news, new products, special offers, and other promotional announcements.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_newsletters', 'SUCCESS_NEWSLETTER_UPDATED', 1, 'Your newsletter subscriptions have been successfully updated.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'NAVBAR_TITLE_2', 1, 'Product Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'HEADING_TITLE', 1, 'Product Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'MY_NOTIFICATIONS_TITLE', 1, 'My Product Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'MY_NOTIFICATIONS_DESCRIPTION', 1, 'The product notification list allows you to stay up to date on products you find of interest.<br><br>To be up to date on all product changes, select <b>Global Product Notifications</b>.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'GLOBAL_NOTIFICATIONS_TITLE', 1, 'Global Product Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'GLOBAL_NOTIFICATIONS_DESCRIPTION', 1, 'Recieve notifications on all available products.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'NOTIFICATIONS_TITLE', 1, 'Product Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'NOTIFICATIONS_DESCRIPTION', 1, 'To remove a product notification, clear the products checkbox and click on Continue.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'NOTIFICATIONS_NON_EXISTING', 1, 'There are currently no products marked to be notified on.<br><br>To add products to your product notification list, click on the notification link available on the detailed product information page.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_notifications', 'SUCCESS_NOTIFICATIONS_UPDATED', 1, 'Your product notifications have been successfully updated.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'NAVBAR_TITLE_2', 1, 'Change Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'HEADING_TITLE', 1, 'My Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'MY_PASSWORD_TITLE', 1, 'My Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'SUCCESS_PASSWORD_UPDATED', 1, 'Your password has been successfully updated.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'ERROR_CURRENT_PASSWORD_NOT_MATCHING', 1, 'Your Current Password did not match the password in our records. Please try again.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book', 'NAVBAR_TITLE_2', 1, 'Address Book', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book', 'HEADING_TITLE', 1, 'My Personal Address Book', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book', 'PRIMARY_ADDRESS_TITLE', 1, 'Primary Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book', 'PRIMARY_ADDRESS_DESCRIPTION', 1, 'This address is used as the pre-selected shipping and billing address for orders placed on this store.<br><br>This address is also used as the base for product and service tax calculations.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book', 'ADDRESS_BOOK_TITLE', 1, 'Address Book Entries', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book', 'PRIMARY_ADDRESS', 1, '(primary address)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'NAVBAR_TITLE_1', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'NAVBAR_TITLE_2', 1, 'Address Book', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'NAVBAR_TITLE_ADD_ENTRY', 1, 'New Entry', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'NAVBAR_TITLE_MODIFY_ENTRY', 1, 'Update Entry', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'NAVBAR_TITLE_DELETE_ENTRY', 1, 'Delete Entry', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'HEADING_TITLE_ADD_ENTRY', 1, 'New Address Book Entry', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'HEADING_TITLE_MODIFY_ENTRY', 1, 'Update Address Book Entry', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'HEADING_TITLE_DELETE_ENTRY', 1, 'Delete Address Book Entry', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'DELETE_ADDRESS_TITLE', 1, 'Delete Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'DELETE_ADDRESS_DESCRIPTION', 1, 'Are you sure you would like to delete the selected address from your address book?', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'NEW_ADDRESS_TITLE', 1, 'New Address Book Entry', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'SELECTED_ADDRESS', 1, 'Selected Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'SET_AS_PRIMARY', 1, 'Set as primary address.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 1, 'The selected address has been successfully removed from your address book.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 1, 'Your address book has been successfully updated.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'WARNING_PRIMARY_ADDRESS_DELETION', 1, 'The primary address cannot be deleted. Please set another address as the primary address and try again.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 1, 'The address book entry does not exist.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ERROR_ADDRESS_BOOK_FULL', 1, 'Your address book is full. Please delete an unneeded address to save a new one.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'NAVBAR_TITLE_1', 1, 'Advanced Search', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'NAVBAR_TITLE_2', 1, 'Search Results', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'HEADING_TITLE_1', 1, 'Advanced Search', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'HEADING_TITLE_2', 1, 'Products meeting the search criteria', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'HEADING_SEARCH_CRITERIA', 1, 'Search Criteria', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TEXT_SEARCH_IN_DESCRIPTION', 1, 'Search In Product Descriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ENTRY_CATEGORIES', 1, 'Categories:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ENTRY_INCLUDE_SUBCATEGORIES', 1, 'Include Subcategories', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ENTRY_MANUFACTURERS', 1, 'Manufacturers:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ENTRY_PRICE_FROM', 1, 'Price From:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ENTRY_PRICE_TO', 1, 'Price To:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ENTRY_DATE_FROM', 1, 'Date From:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ENTRY_DATE_TO', 1, 'Date To:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TEXT_SEARCH_HELP_LINK', 1, '<u>Search Help</u> [?]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TEXT_ALL_CATEGORIES', 1, 'All Categories', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TEXT_ALL_MANUFACTURERS', 1, 'All Manufacturers', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'HEADING_SEARCH_HELP', 1, 'Search Help', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TEXT_SEARCH_HELP', 1, 'Keywords may be separated by AND and/or OR statements for greater control of the search results.<br><br>For example, <u>Microsoft AND mouse</u> would generate a result set that contain both words. However, for <u>mouse OR keyboard</u>, the result set returned would contain both or either words.<br><br>Exact matches can be searched for by enclosing keywords in double-quotes.<br><br>For example, <u>"notebook computer"</u> would generate a result set which match the exact string.<br><br>Brackets can be used for further control on the result set.<br><br>For example, <u>Microsoft and (keyboard or mouse or "visual basic")</u>.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TEXT_CLOSE_WINDOW', 1, '<u>Close Window</u> [x]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_IMAGE', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_MODEL', 1, 'Model', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_PRODUCTS', 1, 'Product Name', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_MANUFACTURER', 1, 'Manufacturer', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_QUANTITY', 1, 'Quantity', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_PRICE', 1, 'Price', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_WEIGHT', 1, 'Weight', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TABLE_HEADING_BUY_NOW', 1, 'Buy Now', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'TEXT_NO_PRODUCTS', 1, 'There is no product that matches the search criteria.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_AT_LEAST_ONE_INPUT', 1, 'At least one of the fields in the search form must be entered.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_INVALID_FROM_DATE', 1, 'Invalid From Date.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_INVALID_TO_DATE', 1, 'Invalid To Date.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_TO_DATE_LESS_THAN_FROM_DATE', 1, 'To Date must be greater than or equal to From Date.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_PRICE_FROM_MUST_BE_NUM', 1, 'Price From must be a number.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_PRICE_TO_MUST_BE_NUM', 1, 'Price To must be a number.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', 1, 'Price To must be greater than or equal to Price From.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search', 'ERROR_INVALID_KEYWORDS', 1, 'Invalid keywords.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'NAVBAR_TITLE_1', 1, 'Advanced Search', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'NAVBAR_TITLE_2', 1, 'Search Results', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'HEADING_TITLE_1', 1, 'Advanced Search', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'HEADING_TITLE_2', 1, 'Products meeting the search criteria', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'HEADING_SEARCH_CRITERIA', 1, 'Search Criteria', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TEXT_SEARCH_IN_DESCRIPTION', 1, 'Search In Product Descriptions', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ENTRY_CATEGORIES', 1, 'Categories:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ENTRY_INCLUDE_SUBCATEGORIES', 1, 'Include Subcategories', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ENTRY_MANUFACTURERS', 1, 'Manufacturers:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ENTRY_PRICE_FROM', 1, 'Price From:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ENTRY_PRICE_TO', 1, 'Price To:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ENTRY_DATE_FROM', 1, 'Date From:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ENTRY_DATE_TO', 1, 'Date To:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TEXT_SEARCH_HELP_LINK', 1, '<u>Search Help</u> [?]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TEXT_ALL_CATEGORIES', 1, 'All Categories', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TEXT_ALL_MANUFACTURERS', 1, 'All Manufacturers', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'HEADING_SEARCH_HELP', 1, 'Search Help', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TEXT_SEARCH_HELP', 1, 'Keywords may be separated by AND and/or OR statements for greater control of the search results.<br><br>For example, <u>Microsoft AND mouse</u> would generate a result set that contain both words. However, for <u>mouse OR keyboard</u>, the result set returned would contain both or either words.<br><br>Exact matches can be searched for by enclosing keywords in double-quotes.<br><br>For example, <u>"notebook computer"</u> would generate a result set which match the exact string.<br><br>Brackets can be used for further control on the result set.<br><br>For example, <u>Microsoft and (keyboard or mouse or "visual basic")</u>.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TEXT_CLOSE_WINDOW', 1, '<u>Close Window</u> [x]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_IMAGE', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_MODEL', 1, 'Model', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_PRODUCTS', 1, 'Product Name', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_MANUFACTURER', 1, 'Manufacturer', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_QUANTITY', 1, 'Quantity', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_PRICE', 1, 'Price', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_WEIGHT', 1, 'Weight', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TABLE_HEADING_BUY_NOW', 1, 'Buy Now', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'TEXT_NO_PRODUCTS', 1, 'There is no product that matches the search criteria.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_AT_LEAST_ONE_INPUT', 1, 'At least one of the fields in the search form must be entered.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_INVALID_FROM_DATE', 1, 'Invalid From Date.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_INVALID_TO_DATE', 1, 'Invalid To Date.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_TO_DATE_LESS_THAN_FROM_DATE', 1, 'To Date must be greater than or equal to From Date.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_PRICE_FROM_MUST_BE_NUM', 1, 'Price From must be a number.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_PRICE_TO_MUST_BE_NUM', 1, 'Price To must be a number.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_PRICE_TO_LESS_THAN_PRICE_FROM', 1, 'Price To must be greater than or equal to Price From.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'advanced_search_result', 'ERROR_INVALID_KEYWORDS', 1, 'Invalid keywords.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'NAVBAR_TITLE_1', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'NAVBAR_TITLE_2', 1, 'Confirmation', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_TITLE', 1, 'Order Confirmation', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_DELIVERY_ADDRESS', 1, 'Delivery Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_SHIPPING_METHOD', 1, 'Shipping Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_PRODUCTS', 1, 'Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_TAX', 1, 'Tax', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_TOTAL', 1, 'Total', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_BILLING_INFORMATION', 1, 'Billing Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_BILLING_ADDRESS', 1, 'Billing Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_PAYMENT_METHOD', 1, 'Payment Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_PAYMENT_INFORMATION', 1, 'Payment Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'HEADING_ORDER_COMMENTS', 1, 'Comments About Your Order', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_confirmation', 'TEXT_EDIT', 1, 'Edit', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'NAVBAR_TITLE_1', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'NAVBAR_TITLE_2', 1, 'Payment Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'HEADING_TITLE', 1, 'Payment Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TABLE_HEADING_BILLING_ADDRESS', 1, 'Billing Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TEXT_SELECTED_BILLING_DESTINATION', 1, 'Please choose from your address book where you would like the invoice to be sent to.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TITLE_BILLING_ADDRESS', 1, 'Billing Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TABLE_HEADING_PAYMENT_METHOD', 1, 'Payment Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TEXT_SELECT_PAYMENT_METHOD', 1, 'Please select the preferred payment method to use on this order.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TITLE_PLEASE_SELECT', 1, 'Please Select', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TEXT_ENTER_PAYMENT_INFORMATION', 1, 'This is currently the only payment method available to use on this order.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TABLE_HEADING_COMMENTS', 1, 'Add Comments About Your Order', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TITLE_CONTINUE_CHECKOUT_PROCEDURE', 1, 'Continue Checkout Procedure', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TEXT_CONTINUE_CHECKOUT_PROCEDURE', 1, 'to confirm this order.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'NAVBAR_TITLE_1', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'NAVBAR_TITLE_2', 1, 'Change Billing Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'HEADING_TITLE', 1, 'Payment Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TABLE_HEADING_PAYMENT_ADDRESS', 1, 'Billing Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TEXT_SELECTED_PAYMENT_DESTINATION', 1, 'This is the currently selected billing address where the invoice to this order will be delivered to.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TITLE_PAYMENT_ADDRESS', 1, 'Billing Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TABLE_HEADING_ADDRESS_BOOK_ENTRIES', 1, 'Address Book Entries', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TEXT_SELECT_OTHER_PAYMENT_DESTINATION', 1, 'Please select the preferred billing address if the invoice to this order is to be delivered elsewhere.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TITLE_PLEASE_SELECT', 1, 'Please Select', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TABLE_HEADING_NEW_PAYMENT_ADDRESS', 1, 'New Billing Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TEXT_CREATE_NEW_PAYMENT_ADDRESS', 1, 'Please use the following form to create a new billing address to use for this order.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TITLE_CONTINUE_CHECKOUT_PROCEDURE', 1, 'Continue Checkout Procedure', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment_address', 'TEXT_CONTINUE_CHECKOUT_PROCEDURE', 1, 'to select the preferred payment method.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_SUBJECT', 1, 'Order Process', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_ORDER_NUMBER', 1, 'Order Number:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_INVOICE_URL', 1, 'Detailed Invoice:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_DATE_ORDERED', 1, 'Date Ordered:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_PRODUCTS', 1, 'Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_SUBTOTAL', 1, 'Sub-Total:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_TAX', 1, 'Tax:        ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_SHIPPING', 1, 'Shipping: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_TOTAL', 1, 'Total:    ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_DELIVERY_ADDRESS', 1, 'Delivery Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_BILLING_ADDRESS', 1, 'Billing Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_TEXT_PAYMENT_METHOD', 1, 'Payment Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'EMAIL_SEPARATOR', 1, '----------------------------------------', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_process', 'TEXT_EMAIL_VIA', 1, 'via', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'NAVBAR_TITLE_1', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'NAVBAR_TITLE_2', 1, 'Shipping Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'HEADING_TITLE', 1, 'Delivery Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TABLE_HEADING_SHIPPING_ADDRESS', 1, 'Shipping Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TEXT_CHOOSE_SHIPPING_DESTINATION', 1, 'Please choose from your address book where you would like the items to be delivered to.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TITLE_SHIPPING_ADDRESS', 1, 'Shipping Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TABLE_HEADING_SHIPPING_METHOD', 1, 'Shipping Method', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TEXT_CHOOSE_SHIPPING_METHOD', 1, 'Please select the preferred shipping method to use on this order.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TITLE_PLEASE_SELECT', 1, 'Please Select', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TEXT_ENTER_SHIPPING_INFORMATION', 1, 'This is currently the only shipping method available to use on this order.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TABLE_HEADING_COMMENTS', 1, 'Add Comments About Your Order', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TITLE_CONTINUE_CHECKOUT_PROCEDURE', 1, 'Continue Checkout Procedure', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping', 'TEXT_CONTINUE_CHECKOUT_PROCEDURE', 1, 'to select the preferred payment method.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'NAVBAR_TITLE_1', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'NAVBAR_TITLE_2', 1, 'Change Shipping Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'HEADING_TITLE', 1, 'Delivery Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TABLE_HEADING_SHIPPING_ADDRESS', 1, 'Shipping Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TEXT_SELECTED_SHIPPING_DESTINATION', 1, 'This is the currently selected shipping address where the items in this order will be delivered to.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TITLE_SHIPPING_ADDRESS', 1, 'Shipping Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TABLE_HEADING_ADDRESS_BOOK_ENTRIES', 1, 'Address Book Entries', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TEXT_SELECT_OTHER_SHIPPING_DESTINATION', 1, 'Please select the preferred shipping address if the items in this order are to be delivered elsewhere.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TITLE_PLEASE_SELECT', 1, 'Please Select', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TABLE_HEADING_NEW_SHIPPING_ADDRESS', 1, 'New Shipping Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TEXT_CREATE_NEW_SHIPPING_ADDRESS', 1, 'Please use the following form to create a new shipping address to use for this order.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TITLE_CONTINUE_CHECKOUT_PROCEDURE', 1, 'Continue Checkout Procedure', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_shipping_address', 'TEXT_CONTINUE_CHECKOUT_PROCEDURE', 1, 'to select the preferred shipping method.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'NAVBAR_TITLE_1', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'NAVBAR_TITLE_2', 1, 'Success', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'HEADING_TITLE', 1, 'Your Order Has Been Processed!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'TEXT_SUCCESS', 1, 'Your order has been successfully processed! Your products will arrive at their destination within 2-5 working days.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'TEXT_NOTIFY_PRODUCTS', 1, 'Please notify me of updates to the products I have selected below:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'TEXT_THANKS_FOR_SHOPPING', 1, 'Thanks for shopping with us online!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'TABLE_HEADING_COMMENTS', 1, 'Enter a comment for the order processed', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'TABLE_HEADING_DOWNLOAD_DATE', 1, 'Expiry date: ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'TABLE_HEADING_DOWNLOAD_COUNT', 1, ' downloads remaining', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'HEADING_DOWNLOAD', 1, 'Download your products here:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_success', 'TEXT_HEADING_CONTINUE_CHECKOUT', 1, 'You still have products from other vendors in your cart.&nbsp; Click here to \r\npurchase these items.', '2004-12-24');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'conditions', 'NAVBAR_TITLE', 1, 'Conditions of Use', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'conditions', 'HEADING_TITLE', 1, 'Conditions of Use', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'conditions', 'TEXT_INFORMATION', 1, 'Put here your Conditions of Use information.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'HEADING_TITLE', 1, 'Contact Us', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'NAVBAR_TITLE', 1, 'Contact Us', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'TEXT_SUCCESS', 1, 'Your enquiry has been successfully sent to the Store Owner.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'ENTRY_NAME', 1, 'Full Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'ENTRY_EMAIL', 1, 'E-Mail Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'ENTRY_ENQUIRY', 1, 'Enquiry:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'ENTRY_EMAIL_SUBJECT', 1, 'Email From oscMall', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'cookie_usage', 'NAVBAR_TITLE', 1, 'Cookie Usage', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'cookie_usage', 'HEADING_TITLE', 1, 'Cookie Usage', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'cookie_usage', 'TEXT_INFORMATION', 1, 'We have detected that your browser does not support cookies, or has set cookies to be disabled.<br><br>To continue shopping online, we encourage you to enable cookies on your browser.<br><br>For <b>Internet Explorer</b> browsers, please follow these instructions:<br><ol><li>Click on the Tools menubar, and select Internet Options</li><li>Select the Security tab, and reset the security level to Medium</li></ol>We have taken this measurement of security for your benefit, and apologize upfront if any inconveniences are caused.<br><br>Please contact the store owner if you have any questions relating to this requirement, or to continue purchasing products offline.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'cookie_usage', 'BOX_INFORMATION_HEADING', 1, 'Cookie Privacy and Security', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'cookie_usage', 'BOX_INFORMATION', 1, 'Cookies must be enabled to purchase online on this store to embrace privacy and security related issues regarding your visit to this site.<br><br>By enabling cookie support on your browser, the communication between you and this site is strengthened to be certain it is you who are making transactions on your own behalf, and to prevent leakage of your privacy information.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'NAVBAR_TITLE', 1, 'Create an Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'HEADING_TITLE', 1, 'My Account Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account_success', 'NAVBAR_TITLE_1', 1, 'Create an Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account_success', 'NAVBAR_TITLE_2', 1, 'Success', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account_success', 'HEADING_TITLE', 1, 'Your Account Has Been Created!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'HEADING_TITLE', 1, 'Welcome to Our Shop', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_UPCOMING_PRODUCTS', 1, 'Upcoming Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_DATE_EXPECTED', 1, 'Date Expected', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_IMAGE', 1, 'Image', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_BUY_NOW', 1, 'Buy Now', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_PRICE', 1, 'Price', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_PRODUCTS', 1, 'Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'HEADER_TITLE_BIG', 1, 'New At SystemsManager Technologies', '2004-03-31');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TEXT_PRICE', 1, 'Price', '2004-12-23');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TEXT_SHOW', 1, 'Filter: ', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TEXT_ALL_MANUFACTURERS', 1, 'All Manufacturers', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_MODEL', 1, 'Model', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TABLE_HEADING_QUANTITY', 1, 'Quantity', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'HEADING_TITLE', 1, 'Visitors Cart / Members Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'SUB_HEADING_TITLE_1', 1, 'Visitors Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'SUB_HEADING_TITLE_2', 1, 'Members Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'SUB_HEADING_TITLE_3', 1, 'Info', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'SUB_HEADING_TEXT_1', 1, 'Every visitor to our online shop will be given a <b>Visitors Cart</b>. This allows the visitor to store their products in a temporary shopping cart. Once the visitor leaves the online shop, so will the contents of their shopping cart.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'SUB_HEADING_TEXT_2', 1, 'Every member to our online shop that logs in is given a <b>Members Cart</b>. This allows the member to add products to their shopping cart, and come back at a later date to finalize their checkout. All products remain in their shopping cart until the member has  checked them out, or removed the products themselves.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'SUB_HEADING_TEXT_3', 1, 'If a member adds products to their <b>Visitors Cart</b> and decides to log in to the online shop to use their <b>Members Cart</b>, the contents of their <b>Visitors Cart</b> will merge with their <b>Members Cart</b> contents automatically.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'info_shopping_cart', 'TEXT_CLOSE_WINDOW', 1, '[ close window ]', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'NAVBAR_TITLE', 1, 'Login', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'HEADING_TITLE', 1, 'Welcome, Please Sign In', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'HEADING_NEW_CUSTOMER', 1, 'New Customer', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_NEW_CUSTOMER', 1, 'I am a new customer.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'HEADING_RETURNING_CUSTOMER', 1, 'Returning Customer', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_RETURNING_CUSTOMER', 1, 'I am a returning customer.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_PASSWORD_FORGOTTEN', 1, 'Password forgotten? Click here.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_LOGIN_ERROR', 1, 'Error: No match for E-Mail Address and/or Password.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'HEADING_NEW_AGENT', 1, 'New Sales Agent', '2006-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_NEW_AGENT', 1, 'Sales Agents Sign Up Here', '2006-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_NEW_AGENT_INTRODUCTION', 1, '<p>With our new system, continued growth in revenues from your referrals though marketing is possible. Our system works in the following way, refer vendors to us who list their services, all sales made using their services gives you a payment based on the total sale. This is recurring and will stay with you for as long as the vendors service remains with us. </p><p>This will allow you to gain a strong vendor base and to market their services, which will in turn give you more revenue. We are looking to build strong relationships with our agents and have several additional tips to increase your ability to generate an income which has the potential to continue growing as you gain more vendors. You put forth the effort and a strong revenue base is easily attainable, and the best part is that it is <strong><em>recurring</em></strong>.</p>', '2006-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'HEADING_NEW_STORE', 1, '<p>New Sevice Provider</p>', '2006-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_NEW_STORE', 1, 'Create Your Free Listings Account', '2006-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'TEXT_NEW_STORE_INTRODUCTION', 1, '<p>Want to gain a large exposure to your services? Do not have a budget or staff to deal with this on a large scale? List with us. We offer uniquely developed software which is designed to facilitate your management of online sales without the need to worry about all of the other tasks needed to run a successful online site.</p><p>We work on a simple system here:</p><ul><li>there are no up front costs to list with us </li><li>software specifically designed with small independant service operators in mind </li><li>support to help you in marketing </li><li>online help support in the setup and management of your product base </li><li>you deal with the customer after the initial purchase of the service from your firm </li><li>safety in knowing that your money is held in trust until all is confirmed </li><li>fair rates on services sold</li></ul><p>We want you to have the ability to offer your services to many potential customers, who may have difficulty finding your services if you just manage your own online site. Let us deal with the marketing, the promotion and software requirements, while you focus on your business.</p>', '2006-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'logoff', 'HEADING_TITLE', 1, 'Log Off', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'logoff', 'NAVBAR_TITLE', 1, 'Log Off', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'logoff', 'TEXT_MAIN', 1, 'You have been logged off your account. It is now safe to leave the computer.<br><br>Your shopping cart has been saved, the items inside it will be restored whenever you log back into your account.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'password_forgotten', 'NAVBAR_TITLE_1', 1, 'Login', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'password_forgotten', 'NAVBAR_TITLE_2', 1, 'Password Forgotten', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'password_forgotten', 'HEADING_TITLE', 1, 'Forgotten Your Password!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'password_forgotten', 'TEXT_MAIN', 1, 'If you have forgotten your password, enter your e-mail address below and we will send you an e-mail message containing your new password.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'password_forgotten', 'TEXT_NO_EMAIL_ADDRESS_FOUND', 1, 'Error: The E-Mail Address was not found in our records, please try again.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'password_forgotten', 'SUCCESS_PASSWORD_SENT', 1, 'Success: A new password has been sent to your e-mail address.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'privacy', 'NAVBAR_TITLE', 1, 'Privacy Notice', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'privacy', 'HEADING_TITLE', 1, 'Privacy Notice', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'privacy', 'TEXT_INFORMATION', 1, 'Put here your Privacy Notice information.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_PRODUCT_NOT_FOUND', 1, 'Product not found!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_CURRENT_REVIEWS', 1, 'Current Reviews:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_ALSO_PURCHASED_PRODUCTS', 1, 'Customers who bought this product also purchased', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_PRODUCT_OPTIONS', 1, 'Available Options:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_CLICK_TO_ENLARGE', 1, 'Click to enlarge', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_XSELL_PRODUCTS', 1, 'Recommended', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_NO_MOPICS', 1, 'Additional Images', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_SLAVE_PRODUCTS', 1, '<b>Tour or package categories</b>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_PRICE_SOLO', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_info', 'TEXT_PRICE_END', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews', 'NAVBAR_TITLE', 1, 'Reviews', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews', 'TEXT_CLICK_TO_ENLARGE', 1, 'Click to enlarge', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_info', 'NAVBAR_TITLE', 1, 'Reviews', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_info', 'SUB_TITLE_PRODUCT', 1, 'Product:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_info', 'SUB_TITLE_FROM', 1, 'From:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_info', 'SUB_TITLE_DATE', 1, 'Date:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_info', 'SUB_TITLE_REVIEW', 1, 'Review:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_info', 'SUB_TITLE_RATING', 1, 'Rating:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_info', 'TEXT_CLICK_TO_ENLARGE', 1, 'Click to enlarge', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'NAVBAR_TITLE', 1, 'Reviews', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'JS_REVIEW_TEXT', 1, 'The product review is too short.  Please add additional information or comments.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'JS_REVIEW_RATING', 1, 'Please select a review rating for this product first.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'SUB_TITLE_FROM', 1, 'From:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'SUB_TITLE_REVIEW', 1, 'Your Review:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'SUB_TITLE_RATING', 1, 'Rating:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'TEXT_NO_HTML', 1, '<small><font color="#ff0000"><b>NOTE:</b></font></small>&nbsp;HTML is not translated!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'TEXT_BAD', 1, '<small><font color="#ff0000"><b>BAD</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'TEXT_GOOD', 1, '<small><font color="#ff0000"><b>GOOD</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'product_reviews_write', 'TEXT_CLICK_TO_ENLARGE', 1, 'Click to enlarge', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'products_new', 'NAVBAR_TITLE', 1, 'New Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'products_new', 'HEADING_TITLE', 1, 'New Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'products_new', 'TEXT_DATE_ADDED', 1, 'Date Added:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'products_new', 'TEXT_MANUFACTURER', 1, 'Manufacturer:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'products_new', 'TEXT_PRICE', 1, 'Price:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'reviews', 'NAVBAR_TITLE', 1, 'Reviews', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'reviews', 'HEADING_TITLE', 1, 'Read What Others Are Saying', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shipping', 'NAVBAR_TITLE', 1, 'Shipping & Returns', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shipping', 'HEADING_TITLE', 1, 'Shipping & Returns', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shipping', 'TEXT_INFORMATION', 1, 'Put here your Shipping & Returns information.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'NAVBAR_TITLE', 1, 'Cart Contents', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'HEADING_TITLE', 1, 'My Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'TABLE_HEADING_REMOVE', 1, 'Remove', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'TABLE_HEADING_QUANTITY', 1, 'Qty.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'TABLE_HEADING_MODEL', 1, 'Model', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'TABLE_HEADING_PRODUCTS', 1, 'Product(s)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'TABLE_HEADING_TOTAL', 1, 'Total', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'TEXT_CART_EMPTY', 1, 'Your Shopping Cart is empty!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'SUB_TITLE_SUB_TOTAL', 1, 'Sub-Total:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'shopping_cart', 'SUB_TITLE_TOTAL', 1, 'Total:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'specials', 'NAVBAR_TITLE', 1, 'Specials', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'specials', 'HEADING_TITLE', 1, 'Get Them While They Are Hot!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ssl_check', 'NAVBAR_TITLE', 1, 'Security Check', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ssl_check', 'HEADING_TITLE', 1, 'Security Check', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ssl_check', 'TEXT_INFORMATION', 1, 'We have detected that your browser has generated a different SSL Session ID used throughout our secure pages.<br><br>For security measures you will need to logon to your account again to continue shopping online.<br><br>Some browsers such as Konqueror 3.1 does not have the capability of generating a secure SSL Session ID automatically which we require. If you use such a browser, we recommend switching to another browser such as <a href="http://www.microsoft.com/ie/" target="_blank">Microsoft Internet Explorer</a>, <a href="http://channels.netscape.com/ns/browsers/download_other.jsp" target="_blank">Netscape</a>, or <a href="http://www.mozilla.org/releases/" target="_blank">Mozilla</a>, to continue your online shopping experience.<br><br>We have taken this measurement of security for your benefit, and apologize upfront if any inconveniences are caused.<br><br>Please contact the store owner if you have any questions relating to this requirement, or to continue purchasing products offline.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ssl_check', 'BOX_INFORMATION_HEADING', 1, 'Privacy and Security', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ssl_check', 'BOX_INFORMATION', 1, 'We validate the SSL Session ID automatically generated by your browser on every secure page request made to this server.<br><br>This validation assures that it is you who is navigating on this site with your account and not somebody else.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'HEADING_TITLE', 1, 'Tell A Friend', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'NAVBAR_TITLE', 1, 'Tell A Friend', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'FORM_TITLE_CUSTOMER_DETAILS', 1, 'Your Details', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'FORM_TITLE_FRIEND_DETAILS', 1, 'Your Friends Details', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'FORM_TITLE_FRIEND_MESSAGE', 1, 'Your Message', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'FORM_FIELD_CUSTOMER_NAME', 1, 'Your Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'FORM_FIELD_CUSTOMER_EMAIL', 1, 'Your E-Mail Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'FORM_FIELD_FRIEND_NAME', 1, 'Your Friends Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'FORM_FIELD_FRIEND_EMAIL', 1, 'Your Friends E-Mail Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'ERROR_TO_NAME', 1, 'Error: Your friends name must not be empty.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'ERROR_TO_ADDRESS', 1, 'Error: Your friends e-mail address must be a valid e-mail address.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'ERROR_FROM_NAME', 1, 'Error: Your name must not be empty.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'tell_a_friend', 'ERROR_FROM_ADDRESS', 1, 'Error: Your e-mail address must be a valid e-mail address.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_INFORMATION_AFFILIATE', 1, 'Affiliate Agents', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_AFFILIATE', 1, 'Affiliate Agents', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_AFFILIATE_NEWS', 1, 'Affiliate Agent News', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_CENTRE', 1, 'Affiliate Agent Centre', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_BANNER_CENTRE', 1, 'Affiliate Agent Links', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_REPORT_CENTRE', 1, 'Affiliate Agent Reports', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_INFO', 1, 'Affiliate Agent Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_DETAILS', 1, 'Payable to:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_ACCEPT_AGB', 1, 'Check here to indicate that you have read and agree to the ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_AGB_ERROR', 1, ' &nbsp;<small><font color="yellow"><b>You must accept our Affiliate Agent Program Terms & Conditions</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_CHECK', 1, 'Check payable to:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_CHECK_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_CHECK_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_PAYPAL', 1, 'PayPal Account Email:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_PAYPAL_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_PAYPAL_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_NAME', 1, 'Bank Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_NAME_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_NAME_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME', 1, 'Account Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER', 1, 'Account Number:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER', 1, 'ABA/BSB number (branch number):', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE', 1, 'SWIFT Code:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_COMPANY', 1, 'Affiliate Agency', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_COMPANY_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_COMPANY_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_COMPANY_TAXID', 1, 'TAX ID.:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_COMPANY_TAXID_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_COMPANY_TAXID_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_HOMEPAGE', 1, 'Homepage', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_HOMEPAGE_TEXT', 1, '&nbsp;<small><font color="yellow"><b>required (http://)</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_HOMEPAGE_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required (http://)</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_NEWSLETTER', 1, 'Affiliate Agent Newsletter', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_NEWSLETTER_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AFFILIATE_NEWSLETTER_ERROR', 1, '&nbsp;<small><font color="yellow"><b>required</b></font></small>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CATEGORY_PAYMENT_DETAILS', 1, 'You get your money by:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_SUMMARY', 1, 'Affiliate Summary', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_ACCOUNT', 1, 'Affiliate Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_PASSWORD', 1, 'Affiliate Password', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_NEWSLETTER', 1, 'Affiliate Newsletter', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_NEWS', 1, 'Affiliate News', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_BANNERS', 1, 'Affiliate Banners', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_BANNERS_BANNERS', 1, 'Affiliate Banners Listed', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_BANNERS_BUILD', 1, 'Affiliate Build Banners', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_BANNERS_PRODUCT', 1, 'Affiliate Banner Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_BANNERS_TEXT', 1, 'Affiliate Banner Text', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_REPORTS', 1, 'Affiliate Reports', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_CLICKRATE', 1, 'Affiliate Click-Rate', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_SALES', 1, 'Affiliate Sales', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_PAYMENT', 1, 'Affiliate Payments', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_CONTACT', 1, 'Affiliate Contact Us', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_FAQ', 1, 'Affiliate FAC', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_LOGOUT', 1, 'Affiliate Logout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTML_PARAMS', 1, 'dir="LTR" lang="en"', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CHARSET', 1, 'iso-8859-1', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TITLE', 1, 'SystemsManager Technologies -- ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_CREATE_ACCOUNT', 1, 'Create an Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_MY_ACCOUNT', 1, 'My Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_CART_CONTENTS', 1, 'Cart Contents', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_CHECKOUT', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_TOP', 1, 'Top', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_CATALOG', 1, 'Catalog', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_LOGOFF', 1, 'Log Off', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_LOGIN', 1, 'Log In', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'FOOTER_TEXT_REQUESTS_SINCE', 1, 'requests since', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'MALE', 1, 'Male', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'FEMALE', 1, 'Female', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'MALE_ADDRESS', 1, 'Mr.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'FEMALE_ADDRESS', 1, 'Ms.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'DOB_FORMAT_STRING', 1, 'mm/dd/yyyy', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_CATEGORIES', 1, 'Mall Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_VENDOR_CATEGORIES', 1, 'Vendor Products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_CREATE_NEW_STORE', 1, 'Create a shop', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_MANUFACTURERS', 1, 'Manufacturers', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_ARTICLES', 1, 'Articles', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_WHATS_NEW', 1, 'New Here?', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_SEARCH', 1, 'Quick Find', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_SEARCH_TEXT', 1, 'Use keywords to find the product you are looking for.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_SEARCH_ADVANCED_SEARCH', 1, 'Advanced Search', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_SPECIALS', 1, 'Specials', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_REVIEWS', 1, 'Reviews', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_REVIEWS_WRITE_REVIEW', 1, 'Write a review on this product!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_REVIEWS_NO_REVIEWS', 1, 'There are currently no product reviews', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_SHOPPING_CART', 1, 'Your Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_SHOPPING_CART_EMPTY', 1, '0 items', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_CUSTOMER_ORDERS', 1, 'Order History', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_BESTSELLERS', 1, 'Bestsellers', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_BESTSELLERS_IN', 1, 'Bestsellers in<br>&nbsp;&nbsp;', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_NOTIFICATIONS', 1, 'Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_MANUFACTURER_INFO', 1, 'Manufacturer Info', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 1, 'Other products', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_LANGUAGES', 1, 'Languages', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_CURRENCIES', 1, 'Currencies', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_INFORMATION', 1, 'Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_INFORMATION_PRIVACY', 1, 'Privacy Notice', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_INFORMATION_CONDITIONS', 1, 'Conditions of Use', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_INFORMATION_SHIPPING', 1, 'Shipping & Returns', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_INFORMATION_CONTACT', 1, 'Contact Us', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_TELL_A_FRIEND', 1, 'Tell A Friend', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_TELL_A_FRIEND_TEXT', 1, 'Tell someone you know about this product.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CHECKOUT_BAR_DELIVERY', 1, 'Delivery Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CHECKOUT_BAR_PAYMENT', 1, 'Payment Information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CHECKOUT_BAR_CONFIRMATION', 1, 'Confirmation', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CHECKOUT_BAR_FINISHED', 1, 'Finished!', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'PULL_DOWN_DEFAULT', 1, 'Please Select', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TYPE_BELOW', 1, 'Type Below', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'FORM_REQUIRED_INFORMATION', 1, '* Required information', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'PREVNEXT_TITLE_FIRST_PAGE', 1, 'First Page', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'PREVNEXT_TITLE_PREVIOUS_PAGE', 1, 'Previous Page', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'PREVNEXT_TITLE_NEXT_PAGE', 1, 'Next Page', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'PREVNEXT_TITLE_LAST_PAGE', 1, 'Last Page', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_ADD_ADDRESS', 1, 'Add Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_ADDRESS_BOOK', 1, 'Address Book', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_BACK', 1, 'Back', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_BUY_NOW', 1, 'Buy Now', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_CHANGE_ADDRESS', 1, 'Change Address', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_CHECKOUT', 1, 'Checkout', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_CONFIRM_ORDER', 1, 'Confirm Order', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_CONTINUE', 1, 'Continue', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_CONTINUE_SHOPPING', 1, 'Continue Shopping', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_DELETE', 1, 'Delete', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_EDIT_ACCOUNT', 1, 'Edit Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_HISTORY', 1, 'Order History', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_LOGIN', 1, 'Sign In', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_IN_CART', 1, 'Add to Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_NOTIFICATIONS', 1, 'Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_QUICK_FIND', 1, 'Quick Find', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_REMOVE_NOTIFICATIONS', 1, 'Remove Notifications', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_REVIEWS', 1, 'Reviews', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_SEARCH', 1, 'Search', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_SHIPPING_OPTIONS', 1, 'Shipping Options', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_TELL_A_FRIEND', 1, 'Tell a Friend', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_UPDATE', 1, 'Update', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_UPDATE_CART', 1, 'Update Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_WRITE_REVIEW', 1, 'Write Review', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_CREATE_STORE', 1, 'Create Your Own Store', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_CREATE_CUSTOMER', 1, 'Create An Customer Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_CREATE_AGENT', 1, 'Create An Sales Agent Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'SMALL_IMAGE_BUTTON_DELETE', 1, 'Delete', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'SMALL_IMAGE_BUTTON_EDIT', 1, 'Edit', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'SMALL_IMAGE_BUTTON_VIEW', 1, 'View', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ICON_ARROW_RIGHT', 1, 'more', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ICON_CART', 1, 'In Cart', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ICON_ERROR', 1, 'Error', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ICON_SUCCESS', 1, 'Success', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ICON_WARNING', 1, 'Warning', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TEXT_SORT_PRODUCTS', 1, 'Sort products ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TEXT_DESCENDINGLY', 1, 'descendingly', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TEXT_ASCENDINGLY', 1, 'ascendingly', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TEXT_BY', 1, ' by ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'FOOTER_TEXT_BODY', 1, 'Copyright &copy; 2002 - 2006 <a href="http://www.systemsmanager.net" target="_blank">SystemsManager Technologies</a><br>Powered by <a href="http://www.systemsmanager.net" target="_blank">the oscMall System</a>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_STORE_CATEGORIES', 1, 'Mall Stores', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_LOGIN_BOX_MY_ACCOUNT', 1, 'Your Account', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_MY_ACCOUNT', 1, 'Account Details', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_ACCOUNT_EDIT', 1, 'Edit Your Account', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_ACCOUNT_HISTORY', 1, 'Account History', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_ADDRESS_BOOK', 1, 'Your Address Book', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_PRODUCT_NOTIFICATIONS', 1, 'Product Notifications', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_LOGOFF', 1, 'Log Out ', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_LOGINBOX_HEADING', 1, 'Login Here', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_LOGINBOX_EMAIL', 1, 'Your Email Address', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_LOGINBOX_PASSWORD', 1, 'Password', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_NEW_STORE', 1, 'Store Setup', '2003-09-17');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_STORE_OWNER', 1, 'Store Owner Login', '2003-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_FINANCIAL', 1, 'Financial Information', '2003-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_QUICK_PICK', 1, 'Your Quick Picks', '2003-10-02');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_MESSAGE', 1, 'Quick Links', '2004-03-18');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_PRIVACY', 1, 'Our Privacy&nbsp;Rules', '2004-03-18');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_CONDITIONS', 1, 'Conditions of Use', '2004-03-18');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEADER_TITLE_CONTACT', 1, 'Contact Us', '2004-03-18');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_FOOTER', 1, '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', '2004-04-01');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_AFFILIATE_LOGIN', 1, 'Affiliate Login', '2004-03-18');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_AFFILIATE', 1, 'Affiliates', '2004-04-01');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ARTICLE_DATE', 1, 'Date of Article', '2003-09-11');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_TITLE_TAG_ALL', 1, 'oscMall System :', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_DESC_TAG_ALL', 1, 'oscMall System : Complete eCommerce Services ', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_KEY_TAG_ALL', 1, ' Complete eCommerce Services ', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTTA_DEFAULT_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTKA_DEFAULT_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTDA_DEFAULT_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_TITLE_TAG_DEFAULT', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_DESC_TAG_DEFAULT', 1, 'oscMall System : Complete eCommerce Services ', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_KEY_TAG_DEFAULT', 1, ' Complete eCommerce Services ', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTTA_PRODUCT_INFO_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTKA_PRODUCT_INFO_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTDA_PRODUCT_INFO_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_TITLE_TAG_PRODUCT_INFO', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_DESC_TAG_PRODUCT_INFO', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_KEY_TAG_PRODUCT_INFO', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTTA_WHATS_NEW_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTKA_WHATS_NEW_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTDA_WHATS_NEW_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_TITLE_TAG_WHATS_NEW', 1, 'New Products', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_DESC_TAG_WHATS_NEW', 1, 'I am ON PRODUCTS_NEW as HEAD_DESC_TAG_WHATS_NEW and over ride the HEAD_DESC_TAG_ALL', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_KEY_TAG_WHATS_NEW', 1, 'I am on PRODUCTS_NEW as HEAD_KEY_TAG_WHATS_NEW and over ride HEAD_KEY_TAG_ALL', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTTA_SPECIALS_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTKA_SPECIALS_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTDA_SPECIALS_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_TITLE_TAG_SPECIALS', 1, 'Specials', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_DESC_TAG_SPECIALS', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_KEY_TAG_SPECIALS', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTTA_PRODUCT_REVIEWS_INFO_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTKA_PRODUCT_REVIEWS_INFO_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HTDA_PRODUCT_REVIEWS_INFO_ON', 1, '1', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_TITLE_TAG_PRODUCT_REVIEWS_INFO', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_DESC_TAG_PRODUCT_REVIEWS_INFO', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'HEAD_KEY_TAG_PRODUCT_REVIEWS_INFO', 1, '', '2005-01-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_POST_CODE', 1, 'Post Code', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_COMPANY_ERROR', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_COMPANY_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_CITY', 1, 'City', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_GENDER_ERROR', 1, 'Please select your Gender.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_GENDER_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_FIRST_NAME_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_STREET_ADDRESS', 1, 'Street Address', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_LAST_NAME_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_COMPANY', 1, 'Company', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_DATE_OF_BIRTH_ERROR', 1, 'Your Date of Birth must be in this format: MM/DD/YYYY (eg 05/21/1970)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_DATE_OF_BIRTH_TEXT', 1, '* (eg. 05/21/1970)', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_EMAIL_ADDRESS', 1, 'Email Address', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 1, 'Your E-Mail Address does not appear to be valid - please make any necessary corrections.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 1, 'Your E-Mail Address already exists in our records - please log in with the e-mail address or create an account with a different address.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_EMAIL_ADDRESS_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_STREET_ADDRESS_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_DATE_OF_BIRTH', 1, 'Date of birth', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_SUBURB_ERROR', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_SUBURB_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_POST_CODE_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_LAST_NAME', 1, 'Last Name', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_CITY_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_STATE_ERROR_SELECT', 1, 'Please select a state from the States pull down menu.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_STATE_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_FIRST_NAME', 1, 'First Name', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_COUNTRY_ERROR', 1, 'You must select a country from the Countries pull down menu.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_COUNTRY_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_GENDER', 1, 'Gender:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_TELEPHONE_NUMBER_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'ENTRY_PASSWORD_CONFIRMATION', 1, 'New Password Confirmation:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_FAX_NUMBER_ERROR', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_FAX_NUMBER_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_NEWSLETTER_TEXT', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_NEWSLETTER', 1, 'Newsletter', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_NEWSLETTER_ERROR', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_FAX_NUMBER', 1, 'Fax Number', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_PASSWORD_ERROR_NOT_MATCHING', 1, 'The Password Confirmation must match your Password.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_PASSWORD_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_TELEPHONE_NUMBER', 1, 'Telephone Number', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_PASSWORD_CONFIRMATION_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_STATE', 1, 'State', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_PASSWORD_CURRENT_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_COUNTRY', 1, 'Country', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_PASSWORD_NEW_TEXT', 1, '*', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 1, 'The Password Confirmation must match your new Password.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'PASSWORD_HIDDEN', 1, '#HIDDEN#', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ERROR_AT_LEAST_ONE_INPUT', 1, 'At Least One Input is Required', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_STORE_NAME_ERROR', 1, 'You must enter a store name it it must be Unique to our Mall.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'JS_ERROR', 1, 'Form Error', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_BANK_FIRST_NAME_ERROR', 1, 'You do not have enough characters in the bank name.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_BANK_ROUTING_CODE_ERROR', 1, 'You do not have enough characters in the bank account number.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'java', 'ENTRY_BANK_ACCOUNT_ERROR', 1, 'You do not have enough characters in the bank rounting number.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'TABLE_HEADING_QUANTITY', 1, 'Qty.', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'TABLE_HEADING_MODEL', 1, 'Model', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'TABLE_HEADING_PRODUCTS', 1, 'Product(s)', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'TABLE_HEADING_TOTAL', 1, 'Total', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'TABLE_HEADING_TAX', 1, 'Taxes', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'TEXT_CART_EMPTY', 1, 'Your Shopping Cart is empty!', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'SUB_TITLE_SUB_TOTAL', 1, 'Sub-Total:', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'SUB_TITLE_TOTAL', 1, 'Total:', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'TEXT_DROP_PRODUCTS_IN_CART', 1, 'Do you want to drop your shopping cart contents and proceed to the next store?', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'THANK_YOU_HEADING_TITLE', 1, 'Thank You for Coming In.....', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'NAVBAR_TITLE', 1, 'Thank You', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'thank_you', 'HEADER_TITLE', 1, 'My Cart?', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'TEXT_STORE_LISTING_INFORMATION', 1, 'Welcome to <b>Our Mall Stores</b>.  Here is a listing of stores currently on line with us.  All of our store owners are commited to above average service to <b>YOU</b>, a truely valued customer.  Browse though the stores, like something?  We have various payment systems in place to make your shopping experience both <b>rewarding and hassle free<b>.', '2002-10-13');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'HEADING_TITLE', 1, 'Stores in Our Mall', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'TABLE_HEADER_STORE_NAME', 1, 'Store Name', '2002-10-13');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'TABLE_HEADER_STORE_EMAIL', 1, 'Store Email Address', '2002-10-13');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'TEXT_STORE_LISTING_INFORMATION', 1, '', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'NAVBAR_TITLE', 1, 'Store Listing', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'CATAGORY_HEADING_TITLE', 1, 'Stores in this Catagory', '2003-10-06');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_listing', 'TEXT_NO_STORE_LISTING_INFORMATION', 1, 'There are no stores currently listed under this catagory.', '2003-10-06');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'TEXT_NEW_STORE_MESSAGE', 1, '<FONT color=#ff0000 size=2>\r\n<H4><B>Congradulations On Your Choice...</B></H4></FONT><FONT size=3>Here at SystemsManager Technologies, we specialize in offering<STRONG> multi-purpose </STRONG>store fronts and mall systems. We&nbsp;will supply your firm a fully functional store&nbsp;where you can set-up and sell your product or services. \r\n<P>In as little as time as it take to fill out our on line form, we will have a store ready for you to start your Internet E-commerce experience. </P>\r\n<P>With a large customer base, affiliate program and a completely customizable store, you are sure to impress your clients with this.</FONT>&nbsp; </FONT></P>\r\n<P align=center><FONT size=3><STRONG><FONT color=#0033cc>Get on-line and start selling to the World!</FONT></STRONG></FONT></P>', '2004-04-02');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'TEXT_ORIGIN_LOGIN', 1, '<font color=#FF0000><small><b>NOTE:</b></font></small> If you already have an account with us, please login at the <a href="%s"><u>login page</u></a>', '2002-10-24');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'HEADER_TITLE', 1, 'Choose Which Store Package<br>is Right for You', '2002-10-26');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'NAVBAR_TITLE', 1, 'Create Your Own Store', '2002-10-24');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'HEADING_TITLE', 1, 'Step One for Creation of a on line shop', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'TEXT_CONDITIONS_MESSAGE', 1, 'You must agreee to the mall conditions', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'VIEW_CONDITIONS_TEXT', 1, 'View Mall Conditions Here', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'AGREE_TO_CONDITIONS_CHECK_BOX', 1, 'Check here if you agree to our conditions', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'BASIC_STORE_PACKAGE_TEXT', 1, 'After agreeing to our conditions, you will need to fill out the required information for the operation of your on line store.', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'REGULAR_STORE_MAX_PRODUCTS', 1, 'enter up to', '2004-04-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store', 'REGULAR_STORE_COST', 1, 'products at a monthly cost of', '2004-04-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'TEXT_STORES_IMAGE', 1, 'Store Logo', '2003-10-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_LOGO_TEXT', 1, '<FONT color=#ff0000>(must be a gif, jpg or png graphic type)</FONT>', '2003-10-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'HEADING_TITLE', 1, 'Add Your Store to Our Mall', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'TEXT_STORES_TIME_AVAILABLE', 1, 'What are your stores operating hours?', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_CATAGORY', 1, 'What category do you want to be listed in?', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'TEXT_STORE_DESCRIPTION', 1, 'Description of your store', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'CATEGORY_PERSONAL', 1, 'Personal Information', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_STORE_NAME', 1, 'Your Store\'s Name', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_STORE_NAME_TEXT', 1, 'Must be Unique', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'CATEGORY_COMPANY', 1, 'Company Name', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'CATEGORY_ADDRESS', 1, 'Your Address', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'CATEGORY_CONTACT', 1, 'Your Contact Numbers', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'CATEGORY_OPTIONS', 1, 'Other Options', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'CATEGORY_PASSWORD', 1, 'Your Password', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'NAVBAR_TITLE', 1, 'Create an Account', '2002-10-24');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'TEXT_ORIGIN_LOGIN', 1, '<font color=#FF0000><small><b>NOTE:</b></font></small> If you already have an account with us, please login at the <a href="%s"><u>login page</u></a>', '2002-10-24');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'Mall_Conditions', 'NAVBAR_TITLE', 1, 'Mall Conditions', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'Mall_Conditions', 'HEADING_TITLE', 1, 'Mall Conditions', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'Mall_Conditions', 'HEADER_TITLE', 1, 'Mall Conditions', '2003-08-25');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'CATEGORY_PERSONAL', 1, 'Personal Information', '2003-08-26');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'CATEGORY_ADDRESS', 1, 'Your Address', '2003-08-26');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'CATEGORY_CONTACT', 1, 'Contact Information', '2003-08-26');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'CATEGORY_OPTIONS', 1, 'Options', '2003-08-26');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'CATEGORY_PASSWORD', 1, 'Your Password', '2003-08-26');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'CATEGORY_COMPANY', 1, 'Company Name', '2003-08-26');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'TEXT_GO_TO_NEW_STORE', 1, 'Continue on to <b>Your New Store</b>....', '2002-10-13');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'TEXT_ACCOUNT_CREATED', 1, 'Congradulations on your new shop in our mall.&nbsp; Your store is now set up and ready for you to set up with your products.', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'SUCCESS_HEADING_TITLE', 1, '<FONT color=#ff0033 size=3><STRONG>Success!!</STRONG></FONT>', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'NAVBAR_TITLE_2', 1, '<P>Success</P>', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'HEADING_TITLE', 1, 'Success on Store Creation', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'NAVBAR_TITLE_1', 1, 'Create a Store', '2003-08-28');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'TEXT_GO_TO_NEW_STORE_ADMIN', 1, 'Go to Your Store Administration....', '2003-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account_success', 'TEXT_FINANCIAL_STORE_INFORMATION', 1, 'You will need to add in the financial Information for your store prior to it being fully functional.&nbsp; Once your financial information has been entered and verified your shop will be turned on. Until you have done so <STRONG>YOUR SHOP WILL NOT BE LISTED.</STRONG>', '2003-09-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TABLE_HEADING_QUANTITY', 1, 'Qty.', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TABLE_HEADING_MODEL', 1, 'Model', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TABLE_HEADING_PRODUCTS', 1, 'Product(s)', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TABLE_HEADING_TOTAL', 1, 'Total', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TABLE_HEADING_TAX', 1, 'Taxes', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TEXT_CART_EMPTY', 1, 'Your Shopping Cart is empty!', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'SUB_TITLE_SUB_TOTAL', 1, 'Sub-Total:', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'SUB_TITLE_TOTAL', 1, 'Total:', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TEXT_DROP_PRODUCTS_IN_CART', 1, 'Do you want to drop your shopping cart contents and proceed to the next store?', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'NAVBAR_TITLE', 1, 'Checkout Selection', '2004-12-23');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'HEADER_TITLE', 1, 'My Cart?', '2002-10-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TEXT_THANK_YOU_FOR_SHOPPING_HERE', 1, 'Thank you for shopping with us.&nbsp; Currently your cart has the following \r\nitems from ', '2004-12-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'THANK_YOU_HEADING_TITLE', 1, 'Check out Selection Page', '2004-12-20');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TEXT_BUY_PRODUCTS_IN_STORE', 1, 'Checkout products&nbsp;from &nbsp;', '2004-12-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TEXT_RETURN_TO_SHOPPING_HERE', 1, 'Continue shopping', '2004-12-20');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TABLE_HEADING_REMOVE', 1, 'Remove Product', '2004-12-20');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'HEADING_TITLE', 1, 'Checkout Select Page', '2004-12-20');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_select', 'TEXT_UPDATE_SHOPPING_CART', 1, 'Update Items in Cart', '2004-12-23');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'NOT_REQUIRED_TEXT', 1, '(Not Required) ', '2005-12-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'TEXT_STORES_IMAGE', 1, 'Store Logo', '2003-10-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_LOGO_TEXT', 1, '<FONT color=#ff0000>(must be a gif, jpg or png graphic type, %s bytes max size)</FONT>', '2003-10-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_STORE_DESCRIPTION', 1, 'Store Description', '2006-01-10');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_STORE_NAME', 1, 'Store Name', '2006-01-10');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create account', 'EMAIL_GV_LINK', 1, 'or by following this link ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create account', 'EMAIL_COUPON_INCENTIVE_HEADER', 1, 'Congratulations, to make your first visit to our online shop a more rewarding experience we are sending you an e-Discount Coupon."\n\n" Below are details of the Discount Coupon created just for you"\n"', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create account', 'EMAIL_COUPON_REDEEM', 1, 'To use the coupon enter the redeem code which is %s during checkout while making a purchase', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_INFORMATION_GV', 1, 'Gift Voucher FAQ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'VOUCHER_BALANCE', 1, 'Voucher Balance', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_HEADING_GIFT_VOUCHER', 1, 'Gift Voucher Account', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'GV_FAQ', 1, 'Gift Voucher FAQ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ERROR_REDEEMED_AMOUNT', 1, 'The coupon has been successfully applied for ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ERROR_NO_REDEEM_CODE', 1, 'You did not enter a redeem code.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ERROR_NO_INVALID_REDEEM_GV', 1, 'Invalid Gift Voucher Code', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TABLE_HEADING_CREDIT', 1, 'Gift Vouchers &amp; Coupons', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'GV_HAS_VOUCHERA', 1, 'You have funds in your Gift Voucher Account. If you want <br> you can send those funds by <a class="pageResults" href="', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'GV_HAS_VOUCHERB', 1, '"><b>email</b></a> to someone', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ENTRY_AMOUNT_CHECK_ERROR', 1, 'You do not have enough funds to send this amount.', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'BOX_SEND_TO_FRIEND', 1, 'Send Gift Voucher', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'VOUCHER_REDEEMED', 1, 'Voucher Redeemed', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CART_COUPON', 1, 'Coupon :', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'CART_COUPON_INFO', 1, 'more info', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'MODULE_ORDER_TOTAL_COUPON_TEXT_ERROR', 1, 'Coupon Redemption', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'ERROR_REDEEMED_AMOUNT_ZERO', 1, '<BR>***HOWEVER:No reducion available, please see the coupon restrictions***', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'index', 'TEXT_STORE_OWNER_EMAIL_ADDRESS', 1, 'Contact Seller', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv_faq', 'NAVBAR_TITLE', 1, 'Gift Voucher FAQ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv_faq', 'HEADING_TITLE', 1, 'Gift Voucher FAQ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv redeem', 'NAVBAR_TITLE', 1, 'Redeem Gift Certificate', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv redeem', 'HEADING_TITLE', 1, 'Redeem Gift Certificate', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv redeem', 'TEXT_INVALID_GV', 1, 'The Gift Certificate number may be invalid or has already been redeemed. To contact the shop owner please use the Contact Page', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'EMAIL_GV_LINK', 1, 'To redeem please click ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'EMAIL_GV_VISIT', 1, ' or visit ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'EMAIL_GV_ENTER', 1, ' and enter the code ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'EMAIL_GV_FIXED_FOOTER', 1, 'If you are have problems redeeming the Gift Certificate using the automated link above,\nyou can also enter the Gift Certificate code during the checkout process at our store."\n\n"', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'EMAIL_GV_SHOP_FOOTER', 1, '', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'EMAIL_GV_MESSAGE', 1, 'With a message saying ', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'EMAIL_SEPARATOR', 1, '----------------------------------------------------------------------------------------', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'TEXT_SUCCESS', 1, 'Congratulations, your Gift Certificate has successfully been sent', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'ENTRY_NAME', 1, 'Recipients Name:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'ENTRY_EMAIL', 1, 'Recipients E-Mail Address:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'ENTRY_MESSAGE', 1, 'Message to Recipients:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'ENTRY_AMOUNT', 1, 'Amount of Gift Certificate:', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'ERROR_ENTRY_AMOUNT_CHECK', 1, '&nbsp;&nbsp;<span class="errorText">Invalid Amount</span>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'ERROR_ENTRY_EMAIL_ADDRESS_CHECK', 1, '&nbsp;&nbsp;<span class="errorText">Invalid Email Address</span>', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'HEADING_TITLE', 1, 'Send Gift Certificate', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'gv send', 'NAVBAR_TITLE', 1, 'Send Gift Certificate', '2003-08-14');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'NOT_REQUIRED_TEXT', 1, '(Not Required) ', '2005-12-19');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'paypal', 'MODULE_PAYMENT_PAYPAL_TEXT_TITLE', 1, 'PayPal', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'paypal', 'MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', 1, 'PayPal', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'freeshipper', 'MODULE_SHIPPING_FREESHIPPER_TEXT_WAY', 1, 'No Shipping Charges', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'freeshipper', 'MODULE_SHIPPING_FREESHIPPER_TEXT_DESCRIPTION', 1, 'No Shipping Charges', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'freeshipper', 'MODULE_SHIPPING_FREESHIPPER_TEXT_TITLE', 1, 'No Shipping Charges', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_subtotal', 'MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 1, 'Sub-Total', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_subtotal', 'MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 1, 'Order Sub-Total', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_TITLE', 1, 'Discount Coupons', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_HEADER', 1, 'Gift Vouchers/Discount Coupons', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_DESCRIPTION', 1, 'Discount Coupon', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'SHIPPING_NOT_INCLUDED', 1, ' [Shipping not included]', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'TAX_NOT_INCLUDED', 1, ' [Tax not included]', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_USER_PROMPT', 1, '', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'ERROR_NO_INVALID_REDEEM_COUPON', 1, 'Invalid Coupon Code', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'ERROR_REDEEMED_AMOUNT_ZERO', 1, 'a valid coupon number. HOWEVER: No reduction will be applied, please see the coupon restrictions that was sent within your offer email**', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'ERROR_INVALID_STARTDATE_COUPON', 1, 'This coupon is not available yet', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'ERROR_INVALID_FINISDATE_COUPON', 1, 'This coupon has expired', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'ERROR_INVALID_USES_COUPON', 1, 'This coupon could only be used ', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'TIMES', 1, ' times.', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'ERROR_INVALID_USES_USER_COUPON', 1, 'You have used the coupon the maximum number of times allowed per customer.', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'REDEEMED_COUPON', 1, 'a coupon worth ', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'REDEEMED_MIN_ORDER', 1, 'on orders over ', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'REDEEMED_RESTRICTIONS', 1, ' [Product-Category restrictions apply]', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'TEXT_ENTER_COUPON_CODE', 1, 'Enter Redeem Code&nbsp;&nbsp;', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_coupon', 'MODULE_ORDER_TOTAL_COUPON_TEXT_ERROR', 1, 'Discount Coupon Error', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'MODULE_ORDER_TOTAL_GV_TITLE', 1, 'Gift Vouchers (-) ', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'MODULE_ORDER_TOTAL_GV_HEADER', 1, 'Enter code below if you have any gift certificates or coupons you have not redeemed yet.', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'MODULE_ORDER_TOTAL_GV_DESCRIPTION', 1, 'Gift Vouchers', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'SHIPPING_NOT_INCLUDED', 1, ' [Shipping not included]', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'TAX_NOT_INCLUDED', 1, ' [Tax not included]', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'MODULE_ORDER_TOTAL_GV_USER_PROMPT', 1, ' <b>to be used from Gift Vouchers</td><td align=right>', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'TEXT_ENTER_GV_CODE', 1, 'Enter Redeem Code  ', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_gv', 'MODULE_ORDER_TOTAL_GV_TEXT_ERROR', 1, 'Gift Voucher/Discount coupon Error', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_total', 'MODULE_ORDER_TOTAL_TOTAL_TITLE', 1, 'Total', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'ot_total', 'MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 1, 'Order Total', '2006-02-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'contact_us', 'ENTRY_SUBJECT', 1, 'Subject : ', '2006-03-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create account', 'ENTRY_STORE_NAME_TEXT', 1, '* Store Name', '2006-01-10');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_COST', 1, 'Order Total', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_DATE', 1, 'Order Date', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_STATUS', 1, 'Status', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_NO_PURCHASES', 1, 'No Purchases', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'HEADING_TITLE', 1, 'Order Tool', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'NAVBAR_TITLE_1', 1, 'My Account', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'NAVBAR_TITLE_2', 1, 'Order Tool', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_SHIPPED_TO', 1, 'Shipped To', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_BILLED_TO', 1, 'Billed To', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'HEADING_EDIT_TITLE', 1, 'Edit Order', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'NAVBAR_TITLE_1', 1, 'My Account', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'NAVBAR_TITLE_2', 1, 'Order Tool', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'NAVBAR_TITLE_3', 1, 'Edit Order', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ENTRY_CUSTOMER', 1, 'Customer', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ENTRY_SHIPPING_ADDRESS', 1, 'Shipping Address', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ENTRY_BILLING_ADDRESS', 1, 'Billing Address', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ENTRY_PAYMENT_METHOD', 1, 'Payment Method', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_PRODUCTS', 1, 'Products', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_PRODUCTS_MODEL', 1, 'Model', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_TAX', 1, 'Tax', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_PRICE_EXCLUDING_TAX', 1, 'Price (ex)  	', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_PRICE_INCLUDING_TAX', 1, 'Price (inc)', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_TOTAL_EXCLUDING_TAX', 1, 'Total (ex)', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_TOTAL_INCLUDING_TAX', 1, 'Total (inc)', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_DATE_ADDED', 1, 'Date Added', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_CUSTOMER_NOTIFIED', 1, 'Customer Notified', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_STATUS', 1, 'Status', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TABLE_HEADING_COMMENTS', 1, 'Comments', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ENTRY_STATUS', 1, 'Status:', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ENTRY_NOTIFY_CUSTOMER', 1, 'Notify Customer:', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ENTRY_NOTIFY_COMMENTS', 1, 'Append Comments:', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ICON_TICK', 1, 'True', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ICON_CROSS', 1, 'False', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'IMAGE_UPDATE', 1, 'Update', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'IMAGE_BACK', 1, 'Back', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'IMAGE_ORDERS_INVOICE', 1, 'Invoice', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'IMAGE_ORDERS_PACKINGSLIP', 1, 'Packing Slip', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'ORDER_DELETE_DESCRIPTION', 1, 'Are you sure you would like to delete the selected order from your order list?', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'HEADING_DELETE_TITLE', 1, 'Delete Orders', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'TEXT_INFO_RESTOCK_PRODUCT_QUANTITY', 1, 'Restock product quantity', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_edit', 'IMAGE_DELETE', 1, 'Delete', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'ENTRY_SOLD_TO', 2, 'Sold To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'ENTRY_SOLD_TO', 2, 'Sold To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'ENTRY_SHIP_TO', 2, 'Ship To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'ENTRY_SOLD_TO', 1, 'Sold To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'ENTRY_SOLD_TO', 1, 'Sold To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'ENTRY_SHIP_TO', 1, 'Ship To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'ENTRY_PAYMENT_METHOD', 1, 'Payment Mathod', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_PRODUCTS', 1, 'Products', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_PRODUCTS_MODEL', 1, 'Model', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_TAX', 1, 'Tax', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_PRICE_EXCLUDING_TAX', 1, 'Price (ex)  	', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_PRICE_INCLUDING_TAX', 1, 'Price (inc)', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_TOTAL_EXCLUDING_TAX', 1, 'Total (ex)', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_TOTAL_INCLUDING_TAX', 1, 'Total (inc)', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'invoice', 'TABLE_HEADING_DATE_ADDED', 1, 'Date Added', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_NEWSLETTER', 1, 'Affiliate Newsletter', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'packingslip', 'ENTRY_SOLD_TO', 1, 'Sold To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'packingslip', 'ENTRY_SHIP_TO', 1, 'Ship To', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'packingslip', 'ENTRY_PAYMENT_METHOD', 1, 'Payment Method', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'packingslip', 'TABLE_HEADING_PRODUCTS', 1, 'Products', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'packingslip', 'TABLE_HEADING_PRODUCTS_MODEL', 1, 'Model', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_PRODUCT_TOOL', 1, 'Product Tool', '2007-07-31');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_product_categories', 'NAVBAR_TITLE', 1, 'Product Categories', '2007-07-30');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'HEADING_PRODUCTS', 1, 'Products', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'checkout_payment', 'TEXT_EDIT', 1, 'Edit', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'CATEGORY_PERSONAL', 1, 'Personal Information', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'CATEGORY_COMPANY', 1, 'Company Name', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'CATEGORY_ADDRESS', 1, 'CATEGORY_ADDRESS', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'CATEGORY_CONTACT', 1, 'Contact Information', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'CATEGORY_PASSWORD', 1, 'Password', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'CATEGORY_OPTIONS', 1, 'Options', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details', 'CATEGORY_PERSONAL', 1, 'Personal Information', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details', 'CATEGORY_COMPANY', 1, 'Company Name', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details', 'CATEGORY_ADDRESS', 1, 'Your address', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_details', 'CATEGORY_CONTACT', 1, 'Contact Information', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_NEWS', 1, 'Affiliate News', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_BANNERS', 1, 'Affiliate Agent Banners', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_BANNERS_BANNERS', 1, 'Banner Links', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_BANNERS_BUILD', 1, 'Build a Link', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_BANNERS_TEXT', 1, 'Text Links', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_BANNERS_PRODUCT', 1, 'Product Links', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_REPORTS', 1, 'Affiliate Agent Reports', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_CLICKRATE', 1, 'Clickthrough Report', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_PAYMENT', 1, 'Payment Report', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'TEXT_AFFILIATE_SALES', 1, 'Sales Report', '2007-08-08');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'LOGIN_BOX_STORE_TEXT_EDITOR', 1, 'Text Editor', '2007-08-16');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ORDERS_TOOL', 1, 'Order Tool', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'NAVBAR_TITLE_2', 1, 'Order Details', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'HEADING_TITLE', 1, 'Order Details', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'NAVBAR_TITLE_1', 1, 'My Account', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'TEXT_ORDER_NUMBER', 1, 'Order Number', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'TEXT_ORDER_STATUS', 1, 'Order Status', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'TEXT_ORDER_DATE', 1, 'Order Date', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'TEXT_ORDER_SHIPPED_TO', 1, 'Shipped To', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'TEXT_ORDER_PRODUCTS', 1, 'Products', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'TEXT_ORDER_COST', 1, 'Cost', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_details', 'TEXT_NO_PURCHASES', 1, 'No Orders', '2007-07-21');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'MY_ORDERS_FROM_ME_SINGLE_CHECKOUT', 1, 'View Order From My Store In Single Checkout', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_NUMBER', 1, 'Order Number', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_COST', 1, 'Order Total', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_DATE', 1, 'Order Date', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_STATUS', 1, 'Status', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_NO_PURCHASES', 1, 'No Purchases', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'HEADING_TITLE', 1, 'Order Tool', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'NAVBAR_TITLE_1', 1, 'My Account', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'NAVBAR_TITLE_2', 1, 'Order Tool', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_SHIPPED_TO', 1, 'Shipped To', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'store_order_tool', 'TEXT_ORDER_BILLED_TO', 1, 'Billed To', '2007-07-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (2, 'ot_total', 'MODULE_ORDER_TOTAL_TOTAL_TITLE', 0, 'Total', '2007-11-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (2, 'ot_total', 'MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 0, 'Order Total', '2007-11-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (2, 'ot_subtotal', 'MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 0, 'Sub-Total', '2007-11-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (2, 'ot_subtotal', 'MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 0, 'Order Sub-Total', '2007-11-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (2, 'paypal', 'MODULE_PAYMENT_PAYPAL_TEXT_TITLE', 0, 'PayPal', '2007-11-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (2, 'paypal', 'MODULE_PAYMENT_PAYPAL_TEXT_DESCRIPTION', 0, 'PayPal', '2007-11-27');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'CATEGORY_COMPANY', 1, 'Company', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'CATEGORY_PERSONAL', 1, 'Personal Info', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'CATEGORY_ADDRESS', 1, 'Address', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_TOLL_FREE_NUMBER', 1, 'Tollfree Number', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'CATEGORY_CONTACT', 1, 'Contact Info', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'CATEGORY_OPTIONS', 1, 'Other Options', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_CATEGORY', 1, 'Store Category', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'ENTRY_PASSWORD_NEW', 1, 'New Password:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_password', 'ENTRY_PASSWORD_CURRENT', 1, 'Current Password:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_FIRST_NAME', 1, 'First Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_LAST_NAME', 1, 'Last Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_COMPANY', 1, 'Company:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_STREET_ADDRESS', 1, 'Street Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_POST_CODE', 1, 'Post Code:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_CITY', 1, 'City:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_STATE', 1, 'State:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'address_book_process', 'ENTRY_COUNTRY', 1, 'Country:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_GENDER', 1, 'Gender:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'ENTRY_PASSWORD', 1, 'Password:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'login', 'ENTRY_EMAIL_ADDRESS', 1, 'Email Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'password_forgotten', 'ENTRY_EMAIL_ADDRESS', 1, 'Email Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_FIRST_NAME', 1, 'First Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_LAST_NAME', 1, 'Last Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_DATE_OF_BIRTH', 1, 'Date Of Birth:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_EMAIL_ADDRESS', 1, 'Email Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_COMPANY', 1, 'Company:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_STREET_ADDRESS', 1, 'Street Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_POST_CODE', 1, 'Post Code:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_CITY', 1, 'City:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_STATE', 1, 'State:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_COUNTRY', 1, 'Country:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_TELEPHONE_NUMBER', 1, 'Telephone Number:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_FAX_NUMBER', 1, 'Fax Number:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_NEWSLETTER', 1, 'Newsletter:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_PASSWORD', 1, 'Password:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_account', 'ENTRY_PASSWORD_CONFIRMATION', 1, 'Password Confirmation:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_GENDER', 1, 'Gender:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_FIRST_NAME', 1, 'First Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_LAST_NAME', 1, 'Last Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_DATE_OF_BIRTH', 1, 'Date Of Birth:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_EMAIL_ADDRESS', 1, 'Email Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_COMPANY', 1, 'Company:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_STREET_ADDRESS', 1, 'Street Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_POST_CODE', 1, 'Post Code:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_CITY', 1, 'City:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_STATE', 1, 'State:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_COUNTRY', 1, 'Country:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_TELEPHONE_NUMBER', 1, 'Telephone Number:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_FAX_NUMBER', 1, 'Fax Number:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_NEWSLETTER', 1, 'Newsletter:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_PASSWORD', 1, 'Password:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'ENTRY_PASSWORD_CONFIRMATION', 1, 'Password Confirmation:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'affiliate_signup', 'CATEGORY_ADDRESS', 1, 'Address', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_GENDER', 1, 'Gender:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_FIRST_NAME', 1, 'First Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_LAST_NAME', 1, 'Last Name:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_DATE_OF_BIRTH', 1, 'Date Of Birth:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_EMAIL_ADDRESS', 1, 'Email Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_COMPANY', 1, 'Company:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_STREET_ADDRESS', 1, 'Street Address:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_POST_CODE', 1, 'Post Code:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_CITY', 1, 'City:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_STATE', 1, 'State:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_COUNTRY', 1, 'Country:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_TELEPHONE_NUMBER', 1, 'Telephone Number:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_FAX_NUMBER', 1, 'Fax Number:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_NEWSLETTER', 1, 'Newsletter:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_PASSWORD', 1, 'Password:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'create_store_account', 'ENTRY_PASSWORD_CONFIRMATION', 1, 'Password Confirmation:', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'LOGIN_BOX_TAX_ZONES', 1, 'My Store Tax Zones', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'LOGIN_BOX_TAX_CLASSES', 1, 'My Store Tax Classes', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account', 'LOGIN_BOX_TAX_RATES', 1, 'My Store Tax Rates', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ACCOUNT_EDIT_TAB_CONTACT', 1, '<p>Contact</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ACCOUNT_EDIT_TAB_PERSONAL', 1, '<p>Personal</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ACCOUNT_EDIT_TAB_SETTINGS', 1, '<p>Settings</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'account_edit', 'ENTRY_CATAGORY', 1, '<p>Store Category:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_SAVE_CHANGES', 1, '<p>Save Changes</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_HELP', 1, '<p>Help</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'HEADING_TITLE', 1, 'My Stores Taxes', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_CLASS_TITLE', 1, '<p>Tax Class Title:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_CLASS_DESCRIPTION', 1, '<p>Tax Class Description:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_DELETE_INTRO', 1, '<p>Are you sure you want to delete this tax class?</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_ZONE_NAME', 1, '<p>Tax Zone Name:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_TAX_RATE', 1, '<p>Tax Rate:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_TAX_RATE_PRIORITY', 1, '<p>Tax Rate Priority:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_DELETE_TAX_RATE_INTRO', 1, '<p>Are you sure you want to delete this tax rate?</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_ZONE_DESCRIPTION', 1, '<p>Tax Zone Description:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_DELETE_ZONE_INTRO', 1, '<p>Are you sure you want to delete this tax zone?</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_COUNTRY', 1, '<p>Tax Country:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_COUNTRY_ZONE', 1, '<p>Tax Countries Zone:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_DELETE_SUB_ZONE_INTRO', 1, '<p>Are you sure you want to delete this tax country?</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TEXT_INFO_RATE_DESCRIPTION', 1, '<p>Tax Rate Description:</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_CLASS_TITLE', 1, 'Tax Class Title', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_CLASS_DESCRIPTION', 1, 'Tax Class Description', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TABLE_HEADING_LAST_MODIFIED', 1, 'Last Modified', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TABLE_HEADING_DATE_ADDED', 1, 'Date Added', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_EDIT_SELECTED', 1, 'Edit Selected', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_DELETE_SELECTED', 1, 'Delete Selected', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'IMAGE_BUTTON_INSERT_NEW', 1, 'Insert New', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_DELETE_TAX_CLASS', 1, 'Delete Tax Class', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_EDIT_TAX_CLASS', 1, 'Edit Tax Class', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_INSERT_TAX_CLASS', 1, 'Insert Tax Class', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_PRIORITY', 1, 'Tax Priority', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_GEO_ZONE_NAME', 1, 'Geo Zone Name', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_RATE', 1, 'Tax Rate', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_RATE_ID', 1, 'Tax Rate ID', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_ZONE_ID', 1, 'Tax Zone ID', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_CLASS_ID', 1, '<p>Tax Class ID</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_TAX_DESCRIPTION', 1, 'Description', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_EDIT_TAX_RATE', 1, 'Edit Tax Rate', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_INSERT_TAX_RATE', 1, 'Insert Tax Rate', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_DELETE_TAX_RATE', 1, 'Delete Tax Rate', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'IMAGE_BUTTON_VIEW_SUB_ZONES', 1, 'View Sub Zones', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'IMAGE_BUTTON_BACK_TO_ZONES', 1, 'Back To Zones', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_EDIT_TAX_ZONE', 1, 'Edit Tax Zone', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_INSERT_TAX_ZONE', 1, 'Insert Tax Zone', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_DELETE_TAX_ZONE', 1, 'Delete Tax Zone', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_GEO_ZONE_ID', 1, 'Geo Zone ID', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_GEO_ZONE_NAME', 1, 'Geo Zone Name', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_GEO_ZONE_DESCRIPTION', 1, 'Geo Zone Description', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_ZONE_ID', 1, 'Zone ID', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_ZONE_COUNTRY_ID', 1, 'Zone Country ID', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_ASSOCIATION_ID', 1, 'Association ID', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_EDIT_TAX_SUB_ZONE', 1, 'Edit Tax SubZone', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_INSERT_TAX_SUB_ZONE', 1, 'Insert Tax SubZone', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'WINDOW_HEADING_DELETE_TAX_SUB_ZONE', 1, 'Delete Tax SubZone', '0000-00-00');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_COUNTRY_NAME', 1, '<p>Country Name</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'taxes', 'TABLE_HEADING_ZONE_NAME', 1, '<p>Zone Name</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'all', 'TEXT_ALL_COUNTRIES', 1, '<p>All Countries</p>', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'My_Article', 'NAVBAR_TITLE', 1, 'My Article', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'My_Article', 'HEADING_TITLE', 1, 'My Article', '2008-04-09');
INSERT INTO web_site_content (store_id, page_name, text_key, language_id, text_content, date_modified) VALUES (1, 'My_Article', 'HEADER_TITLE', 1, 'My Article', '2008-04-09');

DROP TABLE IF EXISTS whos_online;
CREATE TABLE whos_online (
  customer_id int(11) default NULL,
  full_name varchar(64) NOT NULL default '',
  session_id varchar(128) NOT NULL default '',
  ip_address varchar(15) NOT NULL default '',
  time_entry varchar(14) NOT NULL default '',
  time_last_click varchar(14) NOT NULL default '',
  last_page_url text NOT NULL
) ENGINE=MyISAM;

DROP TABLE IF EXISTS zones;
CREATE TABLE zones (
  zone_id int(11) NOT NULL auto_increment,
  zone_country_id int(11) NOT NULL default '0',
  zone_code varchar(32) NOT NULL default '',
  zone_name varchar(32) NOT NULL default '',
  PRIMARY KEY  (zone_id),
  KEY idx_zones_to_geo_zones_country_id (zone_country_id)
) ENGINE=MyISAM;



INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (1, 223, 'AL', 'Alabama');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (2, 223, 'AK', 'Alaska');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (3, 223, 'AS', 'American Samoa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (4, 223, 'AZ', 'Arizona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (5, 223, 'AR', 'Arkansas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (6, 223, 'AF', 'Armed Forces Africa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (7, 223, 'AA', 'Armed Forces Americas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (8, 223, 'AC', 'Armed Forces Canada');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (9, 223, 'AE', 'Armed Forces Europe');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (10, 223, 'AM', 'Armed Forces Middle East');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (11, 223, 'AP', 'Armed Forces Pacific');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (12, 223, 'CA', 'California');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (13, 223, 'CO', 'Colorado');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (14, 223, 'CT', 'Connecticut');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (15, 223, 'DE', 'Delaware');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (16, 223, 'DC', 'District of Columbia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (17, 223, 'FM', 'Federated States Of Micronesia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (18, 223, 'FL', 'Florida');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (19, 223, 'GA', 'Georgia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (20, 223, 'GU', 'Guam');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (21, 223, 'HI', 'Hawaii');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (22, 223, 'ID', 'Idaho');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (23, 223, 'IL', 'Illinois');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (24, 223, 'IN', 'Indiana');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (25, 223, 'IA', 'Iowa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (26, 223, 'KS', 'Kansas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (27, 223, 'KY', 'Kentucky');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (28, 223, 'LA', 'Louisiana');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (29, 223, 'ME', 'Maine');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (30, 223, 'MH', 'Marshall Islands');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (31, 223, 'MD', 'Maryland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (32, 223, 'MA', 'Massachusetts');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (33, 223, 'MI', 'Michigan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (34, 223, 'MN', 'Minnesota');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (35, 223, 'MS', 'Mississippi');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (36, 223, 'MO', 'Missouri');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (37, 223, 'MT', 'Montana');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (38, 223, 'NE', 'Nebraska');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (39, 223, 'NV', 'Nevada');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (40, 223, 'NH', 'New Hampshire');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (41, 223, 'NJ', 'New Jersey');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (42, 223, 'NM', 'New Mexico');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (43, 223, 'NY', 'New York');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (44, 223, 'NC', 'North Carolina');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (45, 223, 'ND', 'North Dakota');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (46, 223, 'MP', 'Northern Mariana Islands');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (47, 223, 'OH', 'Ohio');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (48, 223, 'OK', 'Oklahoma');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (49, 223, 'OR', 'Oregon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (50, 223, 'PW', 'Palau');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (51, 223, 'PA', 'Pennsylvania');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (52, 223, 'PR', 'Puerto Rico');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (53, 223, 'RI', 'Rhode Island');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (54, 223, 'SC', 'South Carolina');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (55, 223, 'SD', 'South Dakota');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (56, 223, 'TN', 'Tennessee');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (57, 223, 'TX', 'Texas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (58, 223, 'UT', 'Utah');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (59, 223, 'VT', 'Vermont');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (60, 223, 'VI', 'Virgin Islands');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (61, 223, 'VA', 'Virginia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (62, 223, 'WA', 'Washington');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (63, 223, 'WV', 'West Virginia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (64, 223, 'WI', 'Wisconsin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (65, 223, 'WY', 'Wyoming');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (66, 38, 'AB', 'Alberta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (67, 38, 'BC', 'British Columbia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (68, 38, 'MB', 'Manitoba');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (69, 38, 'NF', 'Newfoundland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (70, 38, 'NB', 'New Brunswick');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (71, 38, 'NS', 'Nova Scotia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (72, 38, 'NT', 'Northwest Territories');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (73, 38, 'NU', 'Nunavut');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (74, 38, 'ON', 'Ontario');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (75, 38, 'PE', 'Prince Edward Island');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (76, 38, 'QC', 'Quebec');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (77, 38, 'SK', 'Saskatchewan');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (78, 38, 'YT', 'Yukon Territory');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (79, 81, 'NDS', 'Niedersachsen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (81, 81, 'BAY', 'Bayern');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (82, 81, 'BER', 'Berlin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (83, 81, 'BRG', 'Brandenburg');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (84, 81, 'BRE', 'Bremen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (85, 81, 'HAM', 'Hamburg');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (86, 81, 'HES', 'Hessen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (87, 81, 'MEC', 'Mecklenburg-Vorpommern');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (88, 81, 'NRW', 'Nordrhein-Westfalen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (89, 81, 'RHE', 'Rheinland-Pfalz');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (90, 81, 'SAR', 'Saarland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (91, 81, 'SAS', 'Sachsen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (92, 81, 'SAC', 'Sachsen-Anhalt');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (93, 81, 'SCN', 'Schleswig-Holstein');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (95, 14, 'WI', 'Wien');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (98, 14, 'SB', 'Salzburg');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (100, 14, 'ST', 'Steiermark');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (101, 14, 'TI', 'Tirol');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (102, 14, 'BL', 'Burgenland');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (103, 14, 'VB', 'Voralberg');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (104, 204, 'AG', 'Aargau');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (105, 204, 'AI', 'Appenzell Innerrhoden');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (106, 204, 'AR', 'Appenzell Ausserrhoden');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (107, 204, 'BE', 'Bern');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (108, 204, 'BL', 'Basel-Landschaft');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (109, 204, 'BS', 'Basel-Stadt');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (110, 204, 'FR', 'Freiburg');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (111, 204, 'GE', 'Genf');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (112, 204, 'GL', 'Glarus');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (114, 204, 'JU', 'Jura');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (115, 204, 'LU', 'Luzern');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (116, 204, 'NE', 'Neuenburg');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (117, 204, 'NW', 'Nidwalden');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (118, 204, 'OW', 'Obwalden');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (119, 204, 'SG', 'St. Gallen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (120, 204, 'SH', 'Schaffhausen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (121, 204, 'SO', 'Solothurn');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (122, 204, 'SZ', 'Schwyz');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (123, 204, 'TG', 'Thurgau');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (124, 204, 'TI', 'Tessin');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (125, 204, 'UR', 'Uri');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (126, 204, 'VD', 'Waadt');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (127, 204, 'VS', 'Wallis');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (128, 204, 'ZG', 'Zug');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (131, 195, 'Alava', 'Alava');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (132, 195, 'Albacete', 'Albacete');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (133, 195, 'Alicante', 'Alicante');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (134, 195, 'Almeria', 'Almeria');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (135, 195, 'Asturias', 'Asturias');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (136, 195, 'Avila', 'Avila');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (137, 195, 'Badajoz', 'Badajoz');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (138, 195, 'Baleares', 'Baleares');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (139, 195, 'Barcelona', 'Barcelona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (140, 195, 'Burgos', 'Burgos');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (141, 195, 'Caceres', 'Caceres');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (142, 195, 'Cadiz', 'Cadiz');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (143, 195, 'Cantabria', 'Cantabria');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (144, 195, 'Castellon', 'Castellon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (145, 195, 'Ceuta', 'Ceuta');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (146, 195, 'Ciudad Real', 'Ciudad Real');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (147, 195, 'Cordoba', 'Cordoba');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (148, 195, 'Cuenca', 'Cuenca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (149, 195, 'Girona', 'Girona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (150, 195, 'Granada', 'Granada');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (151, 195, 'Guadalajara', 'Guadalajara');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (152, 195, 'Guipuzcoa', 'Guipuzcoa');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (153, 195, 'Huelva', 'Huelva');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (154, 195, 'Huesca', 'Huesca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (155, 195, 'Jaen', 'Jaen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (156, 195, 'La Rioja', 'La Rioja');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (157, 195, 'Las Palmas', 'Las Palmas');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (158, 195, 'Leon', 'Leon');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (159, 195, 'Lleida', 'Lleida');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (160, 195, 'Lugo', 'Lugo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (161, 195, 'Madrid', 'Madrid');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (162, 195, 'Malaga', 'Malaga');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (163, 195, 'Melilla', 'Melilla');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (164, 195, 'Murcia', 'Murcia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (165, 195, 'Navarra', 'Navarra');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (166, 195, 'Ourense', 'Ourense');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (167, 195, 'Palencia', 'Palencia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (168, 195, 'Pontevedra', 'Pontevedra');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (169, 195, 'Salamanca', 'Salamanca');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (170, 195, 'Santa Cruz de Tenerife', 'Santa Cruz de Tenerife');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (171, 195, 'Segovia', 'Segovia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (172, 195, 'Sevilla', 'Sevilla');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (173, 195, 'Soria', 'Soria');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (174, 195, 'Tarragona', 'Tarragona');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (175, 195, 'Teruel', 'Teruel');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (176, 195, 'Toledo', 'Toledo');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (177, 195, 'Valencia', 'Valencia');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (178, 195, 'Valladolid', 'Valladolid');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (179, 195, 'Vizcaya', 'Vizcaya');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (180, 195, 'Zamora', 'Zamora');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (181, 195, 'Zaragoza', 'Zaragoza');
/*
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (80, 81, 'BAW', 'Baden-Württemberg');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (94, 81, 'THE', 'Thüringen');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (96, 14, 'NO', 'Niederösterreich');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (97, 14, 'OO', 'Oberösterreich');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (99, 14, 'KN', 'Kärnten');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (113, 204, 'JU', 'Graubünden');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (129, 204, 'ZH', 'Zürich');
INSERT INTO zones (zone_id, zone_country_id, zone_code, zone_name) VALUES (130, 195, 'A Coruña', 'A Coruña');
*/


DROP TABLE IF EXISTS zones_to_geo_zones;
CREATE TABLE zones_to_geo_zones (
  association_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '1',
  zone_country_id int(11) NOT NULL default '0',
  zone_id int(11) default NULL,
  geo_zone_id int(11) default NULL,
  last_modified datetime default NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (association_id,store_id)
) ENGINE=MyISAM;



INSERT INTO zones_to_geo_zones (association_id, store_id, zone_country_id, zone_id, geo_zone_id, last_modified, date_added) VALUES (1, 1, 223, 18, 1, NULL, '2003-08-14 18:07:14');
