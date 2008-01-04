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

CREATE TABLE IF NOT EXISTS file (
  file_id           INTEGER PRIMARY KEY AUTOINCREMENT,
  file_name         STRING
);

CREATE TABLE IF NOT EXISTS class (
  class_id          INTEGER PRIMARY KEY AUTOINCREMENT,
  class_name        STRING,
  file_id           INTEGER
);

CREATE TABLE IF NOT EXISTS occurance (
  occurance_id      INTEGER PRIMARY KEY AUTOINCREMENT,
  application_id    INTEGER,
  instance_id       INTEGER,
  class_id          INTEGER,
  timestamp         INTEGER
);

CREATE TABLE IF NOT EXISTS instance (
  instance_id       INTEGER PRIMARY KEY AUTOINCREMENT,
  timestamp         INTEGER
);