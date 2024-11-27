-- termmeta
CREATE TABLE termmeta (
	meta_id bigint(20) unsigned NOT NULL auto_increment,
	term_id bigint(20) unsigned NOT NULL default '0',
	meta_key varchar(255) default NULL,
	meta_value longtext,
	PRIMARY KEY  (meta_id),
) $charset_collate;

-- terms
CREATE TABLE terms (
 term_id bigint(20) unsigned NOT NULL auto_increment,
 name varchar(200) NOT NULL default '',
 slug varchar(200) NOT NULL default '',
 PRIMARY KEY  (term_id),
) $charset_collate;

-- term_taxonomy
CREATE TABLE term_taxonomy (
 term_taxonomy_id bigint(20) unsigned NOT NULL auto_increment,
 term_id bigint(20) unsigned NOT NULL default 0,
 taxonomy varchar(32) NOT NULL default '',
 description longtext NOT NULL,
 count bigint(20) NOT NULL default 0,
 PRIMARY KEY  (term_taxonomy_id),
 UNIQUE KEY term_id_taxonomy (term_id,taxonomy),
) $charset_collate;


-- commentmeta
CREATE TABLE commentmeta (
	meta_id bigint(20) unsigned NOT NULL auto_increment,
	comment_id bigint(20) unsigned NOT NULL default '0',
	meta_key varchar(255) default NULL,
	meta_value longtext,
	PRIMARY KEY  (meta_id),
	KEY comment_id (comment_id),
	KEY meta_key (meta_key($max_index_length))
) $charset_collate;


-- comments
CREATE TABLE comments (
	comment_ID bigint(20) unsigned NOT NULL auto_increment,
	comment_post_ID bigint(20) unsigned NOT NULL default '0',
	comment_author tinytext NOT NULL,
	comment_author_email varchar(100) NOT NULL default '',
	comment_author_url varchar(200) NOT NULL default '',
	comment_author_IP varchar(100) NOT NULL default '',
	comment_date datetime NOT NULL default '0000-00-00 00:00:00',
	comment_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',
	comment_content text NOT NULL,
	comment_agent varchar(255) NOT NULL default '',
	comment_type varchar(20) NOT NULL default 'comment',
	comment_parent bigint(20) unsigned NOT NULL default '0',
	user_id bigint(20) unsigned NOT NULL default '0',
	PRIMARY KEY  (comment_ID),
) $charset_collate;

-- options
CREATE TABLE options (
	option_id bigint(20) unsigned NOT NULL auto_increment,
	option_name varchar(191) NOT NULL default '',
	option_value longtext NOT NULL,
	autoload varchar(20) NOT NULL default 'yes',
	PRIMARY KEY  (option_id),
	UNIQUE KEY option_name (option_name),
) $charset_collate;


-- postmeta
CREATE TABLE postmeta (
	meta_id bigint(20) unsigned NOT NULL auto_increment,
	post_id bigint(20) unsigned NOT NULL default '0',
	meta_key varchar(255) default NULL,
	meta_value longtext,
	PRIMARY KEY  (meta_id),
) $charset_collate;


-- Posts
CREATE TABLE posts (
	ID bigint(20) unsigned NOT NULL auto_increment,
	post_author bigint(20) unsigned NOT NULL default '0',
	post_date_gmt datetime NOT NULL default '0000-00-00 00:00:00',
	post_content longtext NOT NULL,
	post_title text NOT NULL,
	post_excerpt text NOT NULL,
	post_status varchar(20) NOT NULL default 'publish',
	comment_status varchar(20) NOT NULL default 'open',
	post_name varchar(200) NOT NULL default '',
	post_modified_gmt datetime NOT NULL default '0000-00-00 00:00:00',
	slug varchar(255) NOT NULL default '',
	comment_count bigint(20) NOT NULL default '0',
	PRIMARY KEY  (ID),
    FOREIGN KEY () REFERENCES ()
) $charset_collate;


-- users
CREATE TABLE users (
	ID bigint(20) unsigned NOT NULL auto_increment,
	user_login varchar(60) NOT NULL default '',
	user_pass varchar(255) NOT NULL default '',
	user_nicename varchar(50) NOT NULL default '',
	user_email varchar(100) NOT NULL default '',
	user_url varchar(100) NOT NULL default '',
	user_registered datetime NOT NULL default '0000-00-00 00:00:00',
	user_activation_key varchar(255) NOT NULL default '',
	user_status int(11) NOT NULL default '0',
	display_name varchar(250) NOT NULL default '',
	PRIMARY KEY  (ID),
	KEY user_login_key (user_login),
	KEY user_nicename (user_nicename),
	KEY user_email (user_email)
) $charset_collate;


-- usermeta
CREATE TABLE usermeta (
	umeta_id bigint(20) unsigned NOT NULL auto_increment,
	user_id bigint(20) unsigned NOT NULL default '0',
	meta_key varchar(255) default NULL,
	meta_value longtext,
	PRIMARY KEY  (umeta_id),
	KEY user_id (user_id),
	KEY meta_key (meta_key($max_index_length))
) $charset_collate;