CREATE TABLE `mod_lang_dict` (
  `word_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` TEXT ,
  `tr` TEXT ,
  `en` TEXT ,
  `ru` TEXT ,
  PRIMARY KEY (`word_id`)
)
ENGINE = InnoDB
CHARACTER SET utf8 COLLATE utf8_general_ci;

