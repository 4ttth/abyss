# Just another README file for updates
## April 2, 2025 : 9:52 AM
> searchResultsPage.php & scheduleScrim.php: updated both to adapt PDO from dbh.inc.php instead of $conn (previously mitigating its own DB connection)

## April 2, 2025 : 11:18 AM
> Enabled verification for squadCreation.php
> You may now upload verifications for squadCreation.php

## Minor Bug Fixes:
> * When clicking on 'verify' after the modal, the fields on the squad profile were left on blank
> * Upon clicking on adding heroes per player, the backdrop seems to replicate itself.

## April 2, 2025 : 1:00 PM
New SQL Statements for tbl_heroimages:
>
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Franco','Tank','IMG/hero/Tank/tnk-3.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Akai','Tank','IMG/hero/Tank/tnk-2.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Hylos','Tank','IMG/hero/Tank/tnk-4.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Uranus','Tank','IMG/hero/Tank/tnk-5.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Belerick','Tank','IMG/hero/Tank/tnk-6.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Khufra','Tank','IMG/hero/Tank/tnk-7.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Baxia','Tank','IMG/hero/Tank/tnk-8.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Cyclops','Tank','IMG/hero/Tank/tnk-9.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Gloo','Tank','IMG/hero/Tank/tnk-10.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Ghatotkacha','Tank','IMG/hero/Tank/tnk-11.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Grock','Tank','IMG/hero/Tank/tnk-12.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Minotaur','Tank','IMG/hero/Tank/tnk-13.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Johnson','Tank','IMG/hero/Tank/tnk-14.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Esmeralda','Tank','IMG/hero/Tank/tnk-15.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Barats','Tank','IMG/hero/Tank/tnk-16.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Edith','Tank','IMG/hero/Tank/tnk-17.png');
> 
> -- Fighters
>
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Balmond','Fighter','IMG/hero/Fighter/ft-1.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Freya','Fighter','IMG/hero/Fighter/ft-2.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Chou','Fighter','IMG/hero/Fighter/ft-3.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Sun','Fighter','IMG/hero/Fighter/ft-4.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Alpha','Fighter','IMG/hero/Fighter/ft-5.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Ruby','Fighter','IMG/hero/Fighter/ft-6.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Lapu-Lapu','Fighter','IMG/hero/Fighter/ft-7.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Argus','Fighter','IMG/hero/Fighter/ft-8.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Jawhead','Fighter','IMG/hero/Fighter/ft-9.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Martis','Fighter','IMG/hero/Fighter/ft-10.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Aldous','Fighter','IMG/hero/Fighter/ft-11.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Leomord','Fighter','IMG/hero/Fighter/ft-12.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Thamuz','Fighter','IMG/hero/Fighter/ft-13.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Minsitthar','Fighter','IMG/hero/Fighter/ft-14.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Badang','Fighter','/IMG/hero/Fighter/ft-15.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Guinevere','Fighter','/IMG/hero/Fighter/ft-16.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('X.Borg','Fighter','IMG/hero/Fighter/ft-17.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Dyrroth','Fighter','IMG/hero/Fighter/ft-18.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Masha','Fighter','IMG/hero/Fighter/ft-19.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Silvanna','Fighter','IMG/hero/Fighter/ft-20.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Yu Zhong','Fighter','IMG/hero/Fighter/ft-21.png');
> 
> -- Assassin
>
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Saber','Assassin','IMG/hero/Assassin/ass-1.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Karina','Assassin','IMG/hero/Assassin/ass-2.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Fanny','Assassin','IMG/hero/Assassin/ass-3.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Hayabusa','Assassin','IMG/hero/Assassin/ass-4.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Natalia','Assassin','IMG/hero/Assassin/ass-5.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Lancelot','Assassin','IMG/hero/Assassin/ass-6.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Helcurt','Assassin','IMG/hero/Assassin/ass-7.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Gusion','Assassin','IMG/hero/Assassin/ass-8.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Hanzo','Assassin','IMG/hero/Assassin/ass-9.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Ling','Assassin','IMG/hero/Assassin/ass-10.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Aamon','Assassin','IMG/hero/Assassin/ass-11.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Joy','Assassin','IMG/hero/Assassin/ass-12.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Nolan','Assassin','IMG/hero/Assassin/ass-13.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Yi Sun-shin','Assassin','IMG/hero/Assassin/ass-14.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Harley','Assassin','IMG/hero/Assassin/ass-15.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Selena','Assassin','IMG/hero/Assassin/ass-16.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Benedetta','Assassin','IMG/hero/Assassin/ass-17.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Suyou','Assassin','IMG/hero/Assassin/ass-18.png');
> 
> -- Mage
>
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Nana','Mage','IMG/hero/Mage/mg-1.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Eudora','Mage','IMG/hero/Mage/mg-2.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Gord','Mage','IMG/hero/Mage/mg-3.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Kagura','Mage','IMG/hero/Mage/mg-4.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Cyclops','Mage','IMG/hero/Mage/mg-5.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Aurora','Mage','IMG/hero/Mage/mg-6.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Vexana','Mage','IMG/hero/Mage/mg-7.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Odette','Mage','IMG/hero/Mage/mg-8.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Zhask','Mage','IMG/hero/Mage/mg-9.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Pharsa','Mage','IMG/hero/Mage/mg-10.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Valir','Mage','IMG/hero/Mage/mg-11.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ("Chang'e","Mage",'IMG/hero/Mage/mg-12.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Vale','Mage','IMG/hero/Mage/mg-13.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Lunox','Mage','IMG/hero/Mage/mg-14.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Harith','Mage','IMG/hero/Mage/mg-15.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Lylia','Mage','IMG/hero/Mage/mg-16.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Cecilion','Mage','IMG/hero/Mage/mg-17.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Luo Yi','Mage','IMG/hero/Mage/mg-18.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Yve','Mage','IMG/hero/Mage/mg-19.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Valentina','Mage','IMG/hero/Mage/mg-20.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Xavier','Mage','IMG/hero/Mage/mg-21.png');
> 
> -- Marksman
>
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Miya','Marksman','IMG/hero/Marksman/mm-1.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Bruno','Marksman','IMG/hero/Marksman/mm-2.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Clint','Marksman','IMG/hero/Marksman/mm-3.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Layla','Marksman','IMG/hero/Marksman/mm-4.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Moskov','Marksman','IMG/hero/Marksman/mm-5.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Karrie','Marksman','IMG/hero/Marksman/mm-6.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Irithel','Marksman','IMG/hero/Marksman/mm-7.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Hanabi','Marksman','IMG/hero/Marksman/mm-8.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Claude','Marksman','IMG/hero/Marksman/mm-9.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Granger','Marksman','IMG/hero/Marksman/mm-10.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Wanwan','Marksman','IMG/hero/Marksman/mm-11.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Popol and Kupa','Marksman','IMG/hero/Marksman/mm-12.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Brody','Marksman','IMG/hero/Marksman/mm-13.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Beatrix','Marksman','IMG/hero/Marksman/mm-14.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Natan','Marksman','IMG/hero/Marksman/mm-15.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Melissa','Marksman','IMG/hero/Marksman/mm-16.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Ixia','Marksman','IMG/hero/Marksman/mm-17.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Lesley','Marksman','IMG/hero/Marksman/mm-18.png');
> INSERT INTO `tbl_heroimages`(`Hero_Name`, `Hero_Role`, `Path`) VALUES ('Kimmy','Marksman','IMG/hero/Marksman/mm-19.png');
> 
> -- Support
>
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Rafaela','Support','IMG/hero/Support/sp-1.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Estes','Support','IMG/hero/Support/sp-2.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Diggie','Support','IMG/hero/Support/sp-3.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Angela','Support','IMG/hero/Support/sp-4.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Floryn','Support','IMG/hero/Support/sp-5.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Lolita','Support','IMG/hero/Support/sp-6.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Kaja','Support','IMG/hero/Support/sp-7.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Faramis','Support','IMG/hero/Support/sp-8.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Carmilla','Support','IMG/hero/Support/sp-9.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Mathilda','Support','IMG/hero/Support/sp-10.png');
> INSERT INTO tbl_heroimages(Hero_Name, Hero_Role, Path) VALUES ('Chip','Support','IMG/hero/Support/sp-11.png');

Also modified the sample code in all iterations for squadCreation.php:
```<img src="IMG/hero/Tank/tnk-1.png" class="hero-icon" onclick="selectHero(this)">``` 
to:
```<img src="IMG/hero/Tank/tnk-1.png" class="hero-icon" data-hero-name="Tigreal" onclick="selectHero(this)">```