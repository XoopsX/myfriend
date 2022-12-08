[![UTD powered-by-electricity](http://ForTheBadge.com/images/badges/powered-by-electricity.svg)](https://github.com/xoopscube)
[![UTD](https://forthebadge.com/images/badges/built-with-love.svg)](https://github.com/xoopscube/myfriend)

[![Project Status: Active – The project has reached a stable, usable state and is being actively developed.](https://www.repostatus.org/badges/2.0.0/active.svg)](https://github.com/xoopscube/)
![License GPL](https://img.shields.io/badge/License-GPL-green)
![X-Updare Store](https://img.shields.io/badge/X--Update%20Store-Pending-red)

## ///// — MyFriend :: module for handling invitations and list of friends

![alt text](https://repository-images.githubusercontent.com/347963527/8c04d798-5562-4443-8e55-656298649231)


MODULE | MyFriend
------------ | -------------
Description | This module allows users to register an account using an invite
Render Engine | Smarty v2 and XCube Layout
Version | 2.3.1
Update | Naoki Okino @naao - Nuno Luciano @gigamaster XCL23
Author | Original by Marijuana and XOOPSCube Team
Copyright | 2012-2022 Authors
License | GPL


##### :computer: The Minimum Requirements



          Apache, Nginx, etc. PHP 7.2.x
          MySQL 5.6, MariaDB  InnoDB utf8 / utf8mb4
          XCL version 2.3.+



-----


## Module MyFriend

### Description  

The module implements an invitation feature, and a list of friends.  
Since you can select the group to register with the invitation function, 
it is possible to separate the invitation group from the normal registration of XCube.
You can prevent XCube user registration unless there is an invitation.

### Custom User Template  

A template of userinfo.php is also available that implements MyFriend features.  
The XCube default template can be replaced with _"templates/myfriend_userinfo.html"_

### Custom Email Template  

The module also features a template to send email invitations :  
_language/language/invitation.tpl_
So, you can edit and rewrite it appropriately.

### Integration  

- Module Private Message  
- Module Pico  

---
### Changelog  

ver2.30: Refactor code to XCL - PHP7 and MySQL ENGINE=InnoDB  

---
Ver0.44: Fixed a bug that the approval of friend application is not reflected in the friend list of the applicant.

Ver0.42: Fixed that the delete link was not displayed even if the user allowed to delete  

Ver0.41: Modified to delete data from myfriend_friendlist when deleting users

Ver0.40: Set the number of days to automatically delete invitations on the management screen
        Invited users can be arbitrarily deleted
        Fixed typo of block file name
        Fixed block disappeared in PHP4

Ver0.32: Invitation automatically deleted after 30 days
        Using Module.class.php

Ver0.31: Abolition of meaningless references
        Changed some require to require_once

Ver0.30: Supports favorite users

Ver0.20: Supports Usersearch module

Ver0.13: Changed to give access right to all groups at installation
        Changed not to register delegate except registered user
        Other minor changes


### ToDo  

- Modify and add blocks
- Modify templates to XCL default UI
