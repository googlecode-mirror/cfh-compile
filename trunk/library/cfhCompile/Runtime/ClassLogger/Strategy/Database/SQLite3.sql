--
-- cfhCompile
--
-- Copyright (c) 2007 - 2008 William Bailey <william.bailey@cowboysfromhell.co.uk>.
--
-- http://www.gnu.org/licenses/lgpl.html     Lesser GPL
--
-- $Id: Null.php 35 2008-01-02 19:32:27Z william.bailey@cowboysfromhell.co.uk $
--

CREATE TABLE IF NOT EXISTS application (
  application_id    INTEGER PRIMARY KEY AUTOINCREMENT,
  application_name  STRING
);

CREATE TABLE IF NOT EXISTS source_file (
  source_file_id    INTEGER PRIMARY KEY AUTOINCREMENT,
  source_file_name  STRING
);

CREATE TABLE IF NOT EXISTS class (
  class_id          INTEGER PRIMARY KEY AUTOINCREMENT,
  class_name        STRING,
  source_file_id    INTEGER
);

CREATE TABLE IF NOT EXISTS occurance (
  occurance_id      INTEGER PRIMARY KEY AUTOINCREMENT,
  application_id    INTEGER,
  instance_id       STRING,
  class_id          INTEGER,
  timestamp         INTEGER
);
